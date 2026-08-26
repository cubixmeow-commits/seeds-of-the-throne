use serde::Serialize;
use std::path::Path;
use std::process::Command;

const DEFAULT_MODEL: &str = "qwen3:4b";

#[derive(Serialize)]
#[serde(rename_all = "camelCase")]
struct EnvironmentStatus {
    ollama_installed: bool,
    ollama_running: bool,
    ollama_version: Option<String>,
    models: Vec<String>,
    default_model: String,
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

#[cfg_attr(mobile, tauri::mobile_entry_point)]
pub fn run() {
    tauri::Builder::default()
        .plugin(tauri_plugin_opener::init())
        .invoke_handler(tauri::generate_handler![environment_status])
        .run(tauri::generate_context!())
        .expect("error while running Story Engine");
}
