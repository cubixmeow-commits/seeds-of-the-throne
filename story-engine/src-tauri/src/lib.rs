use serde::{Deserialize, Serialize};
use serde_json::json;
use std::fs;
use std::path::{Path, PathBuf};
use std::process::Command;
use std::time::Duration;

const DEFAULT_MODEL: &str = "qwen3:4b";
const MAX_CONTEXT_CHARS: usize = 24_000;

const VAULT_PACKET: &[(&str, usize)] = &[
    ("START HERE.md", 1_800),
    ("03 Context/CURRENT.md", 4_800),
    ("03 Context/STORY.md", 3_000),
    ("03 Context/RULES.md", 2_500),
    ("07 Coordination/CURRENT-PICKUP.md", 2_500),
    (
        "07 Coordination/Story Completion Workflow/WORKFLOW.md",
        2_000,
    ),
    (
        "07 Coordination/Story Completion Workflow/Tasks/SC-010.md",
        3_000,
    ),
    ("08 Story Loop/DEVELOPMENT-ORCHESTRATOR.md", 2_000),
];

#[derive(Serialize)]
#[serde(rename_all = "camelCase")]
struct EnvironmentStatus {
    ollama_installed: bool,
    ollama_running: bool,
    ollama_version: Option<String>,
    models: Vec<String>,
    default_model: String,
}

#[derive(Serialize)]
#[serde(rename_all = "camelCase")]
struct VaultAnswer {
    answer: String,
    sources: Vec<String>,
    model: String,
    mode: String,
}

#[derive(Deserialize)]
struct OllamaMessage {
    content: String,
}

#[derive(Deserialize)]
struct OllamaChatResponse {
    message: OllamaMessage,
}

fn ollama_binary() -> Option<&'static str> {
    [
        "/opt/homebrew/bin/ollama",
        "/usr/local/bin/ollama",
        "ollama",
    ]
    .into_iter()
    .find(|candidate| {
        if candidate.contains('/') {
            Path::new(candidate).is_file()
        } else {
            Command::new(candidate).arg("--version").output().is_ok()
        }
    })
}

fn canonical_vault(vault_path: &str) -> Result<PathBuf, String> {
    let root = fs::canonicalize(vault_path).map_err(|_| {
        "Unable to open that vault folder. Check the path and try again.".to_string()
    })?;
    if !root.is_dir() || !root.join("START HERE.md").is_file() {
        return Err("Choose a Seeds vault folder containing START HERE.md.".into());
    }
    Ok(root)
}

fn take_chars(value: &str, limit: usize) -> String {
    value.chars().take(limit).collect()
}

fn build_vault_packet(root: &Path) -> Result<(String, Vec<String>), String> {
    let mut packet = String::new();
    let mut sources = Vec::new();

    for (relative, per_file_limit) in VAULT_PACKET {
        if packet.chars().count() >= MAX_CONTEXT_CHARS {
            break;
        }
        let path = root.join(relative);
        if !path.is_file() {
            continue;
        }
        let content =
            fs::read_to_string(&path).map_err(|_| format!("Unable to read {relative}."))?;
        let remaining = MAX_CONTEXT_CHARS.saturating_sub(packet.chars().count());
        let limit = (*per_file_limit).min(remaining);
        packet.push_str(&format!("\n\n--- SOURCE: {relative} ---\n"));
        packet.push_str(&take_chars(&content, limit));
        sources.push((*relative).to_string());
    }

    if sources.is_empty() {
        return Err("No supported Seeds context files were found in that folder.".into());
    }
    Ok((packet, sources))
}

#[tauri::command]
fn environment_status() -> EnvironmentStatus {
    let Some(binary) = ollama_binary() else {
        return EnvironmentStatus {
            ollama_installed: false,
            ollama_running: false,
            ollama_version: None,
            models: Vec::new(),
            default_model: DEFAULT_MODEL.into(),
        };
    };

    let version = Command::new(binary)
        .arg("--version")
        .output()
        .ok()
        .and_then(|output| String::from_utf8(output.stdout).ok())
        .map(|value| value.trim().replace("ollama version is ", ""))
        .filter(|value| !value.is_empty());

    let list_output = Command::new(binary).arg("list").output().ok();
    let running = list_output
        .as_ref()
        .is_some_and(|output| output.status.success());
    let models = list_output
        .and_then(|output| String::from_utf8(output.stdout).ok())
        .map(|output| {
            output
                .lines()
                .skip(1)
                .filter_map(|line| line.split_whitespace().next().map(str::to_owned))
                .collect()
        })
        .unwrap_or_default();

    EnvironmentStatus {
        ollama_installed: true,
        ollama_running: running,
        ollama_version: version,
        models,
        default_model: DEFAULT_MODEL.into(),
    }
}

#[tauri::command]
async fn ask_vault(vault_path: String, question: String) -> Result<VaultAnswer, String> {
    if question.trim().is_empty() {
        return Err("Enter a question about the story or vault workflow.".into());
    }

    let root = canonical_vault(&vault_path)?;
    let (packet, sources) = build_vault_packet(&root)?;
    let system = r#"You are the local read-only Story Engine assistant for Seeds of the Throne.
Use only the supplied vault packet. Treat status and authority labels exactly as written.
Never convert proposed, working, or unresolved material into established canon.
SC-010 is paused at an author gate: do not claim to accept an answer, edit state, or advance it.
You may explain options only when asked, and must label them as proposals.
Cite supporting vault files inline using [relative/path.md].
If the packet does not support an answer, say what is missing.
Begin with the answer, never describe your analysis process, and use no more than six concise bullets or 350 words."#;
    let user = format!("VAULT PACKET:\n{packet}\n\nQUESTION:\n{}", question.trim());

    let client = reqwest::Client::builder()
        .timeout(Duration::from_secs(240))
        .build()
        .map_err(|_| "Unable to initialize the local model connection.".to_string())?;
    let response = client
        .post("http://127.0.0.1:11434/api/chat")
        .json(&json!({
            "model": DEFAULT_MODEL,
            "stream": false,
            "think": false,
            "messages": [
                { "role": "system", "content": system },
                { "role": "user", "content": user }
            ],
            "options": {
                "temperature": 0.25,
                "num_ctx": 8192,
                "num_predict": 650
            }
        }))
        .send()
        .await
        .map_err(|error| {
            if error.is_timeout() {
                "Qwen took too long to answer. Try a narrower question and try again.".to_string()
            } else {
                "Unable to reach Ollama. Start Ollama and try again.".to_string()
            }
        })?
        .error_for_status()
        .map_err(|error| {
            error
                .status()
                .map(|status| format!("Ollama returned {status}."))
                .unwrap_or_else(|| "Ollama returned an unexpected response.".to_string())
        })?
        .json::<OllamaChatResponse>()
        .await
        .map_err(|_| "Ollama returned an unreadable response.".to_string())?;

    Ok(VaultAnswer {
        answer: response.message.content.trim().to_string(),
        sources,
        model: DEFAULT_MODEL.into(),
        mode: "Local · read-only · not canon".into(),
    })
}

#[cfg_attr(mobile, tauri::mobile_entry_point)]
pub fn run() {
    tauri::Builder::default()
        .plugin(tauri_plugin_opener::init())
        .invoke_handler(tauri::generate_handler![environment_status, ask_vault])
        .run(tauri::generate_context!())
        .expect("error while running Story Engine");
}

#[cfg(test)]
mod tests {
    use super::*;

    #[test]
    #[ignore = "requires a local Ollama service and STORY_ENGINE_TEST_VAULT"]
    fn live_local_vault_question() {
        let vault_path = std::env::var("STORY_ENGINE_TEST_VAULT")
            .expect("set STORY_ENGINE_TEST_VAULT to a Seeds vault copy");
        let response = tauri::async_runtime::block_on(ask_vault(
            vault_path,
            "Give me a six-bullet briefing covering the current story spine, established canon, active workflow, paused gate, safe next development actions, and missing context. Do not propose or accept an SC-010 answer."
                .into(),
        ))
        .expect("local vault question should succeed");

        assert!(!response.answer.is_empty());
        assert!(!response.sources.is_empty());
        println!(
            "{}\n\nSources: {}",
            response.answer,
            response.sources.join(", ")
        );
    }
}
