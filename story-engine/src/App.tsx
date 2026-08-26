import { useEffect, useRef, useState } from "react";
import { invoke } from "@tauri-apps/api/core";
import "./App.css";

type EnvironmentStatus = {
  ollamaInstalled: boolean;
  ollamaRunning: boolean;
  ollamaVersion: string | null;
  models: string[];
  defaultModel: string;
};

type VaultAnswer = {
  answer: string;
  sources: string[];
  model: string;
  mode: string;
};

const TEST_VAULT_PATH = "/Users/realiainreid/Documents/sotr app development/seeds-vault-test";

type IconName = "focus" | "map" | "canon" | "search" | "draft" | "check" | "settings";

const navigation: Array<{ label: string; icon: IconName; count?: string }> = [
  { label: "Current run", icon: "focus" },
  { label: "Story map", icon: "map" },
  { label: "Canon", icon: "canon", count: "47" },
  { label: "Research", icon: "search", count: "12" },
  { label: "Prototypes", icon: "draft", count: "6" },
  { label: "Continuity", icon: "check", count: "3" },
];

const stages = [
  { label: "Scope", state: "complete" },
  { label: "Retrieve", state: "complete" },
  { label: "Gaps", state: "complete" },
  { label: "Develop", state: "complete" },
  { label: "Critics", state: "complete" },
  { label: "Author gate", state: "paused" },
];

function Icon({ name }: { name: IconName }) {
  const paths: Record<IconName, React.ReactNode> = {
    focus: <><circle cx="12" cy="12" r="7"/><circle cx="12" cy="12" r="2"/><path d="M12 2v3M12 19v3M2 12h3M19 12h3"/></>,
    map: <><path d="m3 6 5-3 8 3 5-3v15l-5 3-8-3-5 3Z"/><path d="M8 3v15M16 6v15"/></>,
    canon: <><path d="M5 4.5A2.5 2.5 0 0 1 7.5 2H20v17H7.5A2.5 2.5 0 0 0 5 21.5Z"/><path d="M5 4.5v17M9 7h7M9 11h5"/></>,
    search: <><circle cx="10.5" cy="10.5" r="6.5"/><path d="m15.5 15.5 5 5"/></>,
    draft: <><path d="M5 3h10l4 4v14H5Z"/><path d="M15 3v5h4M8 12h8M8 16h6"/></>,
    check: <><path d="M20 11.2V12a8 8 0 1 1-4.7-7.3"/><path d="m9 11 2 2 9-9"/></>,
    settings: <><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.7 1.7 0 0 0 .3 1.9l.1.1-2.8 2.8-.1-.1a1.7 1.7 0 0 0-1.9-.3 1.7 1.7 0 0 0-1 1.6v.2h-4V21a1.7 1.7 0 0 0-1-1.6 1.7 1.7 0 0 0-1.9.3l-.1.1L4.2 17l.1-.1a1.7 1.7 0 0 0 .3-1.9A1.7 1.7 0 0 0 3 14H2.8v-4H3a1.7 1.7 0 0 0 1.6-1 1.7 1.7 0 0 0-.3-1.9L4.2 7 7 4.2l.1.1a1.7 1.7 0 0 0 1.9.3A1.7 1.7 0 0 0 10 3V2.8h4V3a1.7 1.7 0 0 0 1 1.6 1.7 1.7 0 0 0 1.9-.3l.1-.1L19.8 7l-.1.1a1.7 1.7 0 0 0-.3 1.9 1.7 1.7 0 0 0 1.6 1h.2v4H21a1.7 1.7 0 0 0-1.6 1Z"/></>,
  };

  return <svg className="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" aria-hidden="true">{paths[name]}</svg>;
}

function App() {
  const [environment, setEnvironment] = useState<EnvironmentStatus>({
    ollamaInstalled: true,
    ollamaRunning: false,
    ollamaVersion: "0.32.15",
    models: ["qwen3:4b"],
    defaultModel: "qwen3:4b",
  });
  const [announcement, setAnnouncement] = useState("");
  const [vaultPath, setVaultPath] = useState(TEST_VAULT_PATH);
  const [question, setQuestion] = useState("Give me a six-bullet briefing covering the current story spine, established canon, active workflow, paused gate, safe next development actions, and missing context. Do not propose or accept an SC-010 answer.");
  const [vaultAnswer, setVaultAnswer] = useState<VaultAnswer | null>(null);
  const [vaultError, setVaultError] = useState("");
  const [isAsking, setIsAsking] = useState(false);
  const questionRef = useRef<HTMLTextAreaElement>(null);

  async function askVault(event: React.FormEvent<HTMLFormElement>) {
    event.preventDefault();
    setVaultError("");
    if (!vaultPath.trim() || !question.trim()) {
      setVaultError("Enter the vault path and a question.");
      questionRef.current?.focus();
      return;
    }

    setIsAsking(true);
    setAnnouncement("Qwen is reading the selected vault packet.");
    try {
      const response = await invoke<VaultAnswer>("ask_vault", { vaultPath, question });
      setVaultAnswer(response);
      setAnnouncement(`Answer ready from ${response.model}.`);
    } catch (error) {
      const message = typeof error === "string" ? error : "Unable to ask the vault. Check Ollama and try again.";
      setVaultError(message);
      setAnnouncement(message);
    } finally {
      setIsAsking(false);
    }
  }

  useEffect(() => {
    invoke<EnvironmentStatus>("environment_status")
      .then(setEnvironment)
      .catch(() => setAnnouncement("Browser preview is using the saved local environment snapshot."));
  }, []);

  return (
    <div className="app-shell">
      <a className="skip-link" href="#workspace">Skip to workspace</a>
      <aside className="sidebar" aria-label="Project navigation">
        <div className="brand">
          <span className="brand-mark" aria-hidden="true">S</span>
          <div><strong>Story Engine</strong><span>Seeds of the Throne</span></div>
        </div>

        <nav aria-label="Workspace">
          <p className="nav-label">Workspace</p>
          <ul>
            {navigation.map((item, index) => (
              <li key={item.label}>
                <button className={index === 0 ? "nav-item active" : "nav-item"} type="button" aria-current={index === 0 ? "page" : undefined} disabled={index !== 0}>
                  <Icon name={item.icon} /><span>{item.label}</span>{item.count && <span className="nav-count">{item.count}</span>}
                </button>
              </li>
            ))}
          </ul>
        </nav>

        <div className="sidebar-footer">
          <div className="provider-status">
            <span className={environment.ollamaRunning ? "status-dot online" : "status-dot"} aria-hidden="true" />
            <div><strong>{environment.defaultModel}</strong><span>{environment.ollamaRunning ? "Ollama ready" : "Ollama installed"}</span></div>
          </div>
          <button className="icon-button" type="button" aria-label="Settings are not available in this scaffold" disabled><Icon name="settings" /></button>
        </div>
      </aside>

      <main id="workspace" className="workspace" tabIndex={-1}>
        <header className="workspace-header">
          <div>
            <p className="eyebrow">Macro shape · 9 of 27 complete</p>
            <h1>Endgame setup coverage</h1>
          </div>
          <div className="header-actions">
            <span className="pause-badge"><span aria-hidden="true">Ⅱ</span> Development pause</span>
            <button className="secondary-button" type="button" onClick={() => setAnnouncement("Vault sync is current. No author gate was advanced.")}>Check project</button>
          </div>
        </header>

        <section className="pipeline" aria-labelledby="pipeline-heading">
          <div className="section-heading">
            <div><p className="eyebrow">Development orchestrator</p><h2 id="pipeline-heading">Current run</h2></div>
            <span className="run-id">SC-010</span>
          </div>
          <ol className="stage-list">
            {stages.map((stage, index) => (
              <li className={stage.state} key={stage.label}>
                <span className="stage-marker">{stage.state === "complete" ? "✓" : index + 1}</span>
                <span>{stage.label}</span>
              </li>
            ))}
          </ol>
        </section>

        <div className="content-grid">
          <section className="gate-panel" aria-labelledby="gate-heading">
            <div className="section-heading">
              <div><p className="eyebrow">Protected author decision</p><h2 id="gate-heading">Question 5 is waiting</h2></div>
              <span className="lock-state">Locked</span>
            </div>
            <p className="gate-question">What is the next major endgame-relevant capability, rule, or information skill that must be demonstrated before the final conflict depends on it?</p>
            <p className="supporting-copy">The development task has paused this workflow. Story Engine may retrieve and analyze context, but it cannot accept an answer or advance this gate without the author.</p>
            <div className="gate-actions">
              <button className="primary-button" type="button" disabled>Resume author gate</button>
              <span>Resume only when story development continues.</span>
            </div>
          </section>

          <aside className="context-panel" aria-labelledby="context-heading">
            <div className="section-heading"><div><p className="eyebrow">Retrieved context</p><h2 id="context-heading">Run packet</h2></div></div>
            <dl className="context-list">
              <div><dt>Task packet</dt><dd>SC-010.md</dd></div>
              <div><dt>Authority</dt><dd>Author gate</dd></div>
              <div><dt>Depth</dt><dd>Macro shape</dd></div>
              <div><dt>Model</dt><dd>{environment.defaultModel}</dd></div>
            </dl>
            <button className="text-button" type="button" onClick={() => setAnnouncement("Run packet preview is part of the next filesystem integration milestone.")}>View retrieved sources <span aria-hidden="true">→</span></button>
          </aside>
        </div>

        <section className="vault-chat-section" aria-labelledby="vault-chat-heading">
          <div className="section-heading">
            <div><p className="eyebrow">Local vault test</p><h2 id="vault-chat-heading">Ask Qwen about Seeds</h2></div>
            <span className="read-only-badge">Read-only</span>
          </div>
          <p className="supporting-copy">Story Engine sends a bounded packet from the test copy to Qwen through local Ollama. Answers are not canon and cannot change the vault.</p>

          <form className="vault-chat-form" onSubmit={askVault}>
            <label htmlFor="vault-path">Test vault folder</label>
            <input id="vault-path" name="vaultPath" value={vaultPath} onChange={(event) => setVaultPath(event.currentTarget.value)} autoComplete="off" spellCheck={false} />
            <label htmlFor="vault-question">Question</label>
            <textarea ref={questionRef} id="vault-question" name="question" value={question} onChange={(event) => setQuestion(event.currentTarget.value)} rows={4} aria-invalid={vaultError ? "true" : undefined} aria-describedby={vaultError ? "vault-error" : "vault-question-hint"} />
            <span id="vault-question-hint" className="field-hint">Try a story briefing, continuity question, or workflow question.</span>
            {vaultError && <p id="vault-error" className="field-error" role="alert">{vaultError}</p>}
            <button className="ask-button" type="submit" disabled={isAsking}>{isAsking ? "Reading vault…" : "Ask Qwen"}</button>
          </form>

          {vaultAnswer && (
            <article className="vault-answer" aria-labelledby="vault-answer-heading">
              <div className="answer-meta"><h3 id="vault-answer-heading">Qwen response</h3><span>{vaultAnswer.model} · {vaultAnswer.mode}</span></div>
              <p className="answer-content">{vaultAnswer.answer}</p>
              <details>
                <summary>{vaultAnswer.sources.length} vault files supplied</summary>
                <ul>{vaultAnswer.sources.map((source) => <li key={source}>{source}</li>)}</ul>
              </details>
            </article>
          )}
        </section>

        <section className="next-section" aria-labelledby="next-heading">
          <div><p className="eyebrow">V1 foundation</p><h2 id="next-heading">Local-first, portable by contract</h2></div>
          <div className="principles">
            <div><strong>Plain project files</strong><span>Markdown and versioned JSON stay readable outside the app.</span></div>
            <div><strong>Engine boundary</strong><span>Workflow rules live outside React and Tauri-specific commands.</span></div>
            <div><strong>Mobile-ready</strong><span>Flutter can implement the same schemas without inheriting this UI.</span></div>
          </div>
        </section>
        <div className="sr-status" role="status" aria-live="polite">{announcement}</div>
      </main>
    </div>
  );
}

export default App;
