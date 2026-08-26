---
type: development-session
status: active
date: 2026-08-25
topics: story engine, desktop app, local-first, ollama, tauri, mobile portability
---

# Local Story Engine Development Start

## Scope

Begin implementation of a local-first desktop Story Engine around the working systems already proven in this vault. This is a software-development session, not a story-development pass.

## Preserved state

- GitHub changes through commit `32f9c2f` were fast-forwarded into the Neo desktop vault.
- SC-001 through SC-009 remain complete at Macro Shape.
- SC-010 remains at Question 5 with its author gate unanswered.
- This development session must not select an answer, record an acceptance, or advance the story workflow.

## Architecture decision

- Desktop: Tauri 2 + React + TypeScript + Rust.
- Default local model runtime: Ollama.
- Initial hardware-fit model: `qwen3:4b` for the 8 GB MacBook Neo.
- Durable project data: Markdown plus versioned JSON contracts; SQLite may later store disposable indexes and caches only.
- Workflow, authority, canon, retrieval, provider, and export contracts are UI-framework independent.
- A future Flutter/Dart mobile client should implement the same project format and contracts rather than porting React components or Tauri commands.

## V1 direction

The first app surface centers the active run, retrieved authority packet, protected author gate, local-provider status, and workflow progress. The full mapping from vault structures to product scope is in [[07 Coordination/Vault to V1 Feature Matrix]].

## Setup completed

- Xcode Command Line Tools were already installed; full Xcode is not required for desktop-only development.
- Homebrew, Node, npm, and Git were already installed.
- Rust stable, Cargo, rustup, rustfmt, and Clippy were installed through rustup.
- Ollama was installed and `qwen3:4b` downloaded.
- The initial desktop scaffold lives in `story-engine/` inside this repository.

## Non-story product thesis

- **Visual thesis:** a quiet, dark editorial workspace with parchment warmth and one sharp growth accent; dense enough for serious work but calm enough for long sessions.
- **Content plan:** project orientation, current workflow run, protected author decision, retrieved context, and local-model state.
- **Interaction thesis:** restrained staged entry, clear current-state transitions, and tactile button feedback, all disabled or reduced when the operating system requests less motion.

## Read-only vault chat test

- A disposable test copy was created at `/Users/realiainreid/Documents/sotr app development/seeds-vault-test`.
- The copy excludes Git history and the `story-engine/` source tree; it is separate from the canonical working vault.
- Story Engine supplies Qwen a bounded allowlist of orientation, current-state, rules, workflow, and SC-010 files rather than granting the model unrestricted filesystem access.
- The first live pass showed that a 52,000-character packet was too slow for the 8 GB Neo; the tested integration now uses a roughly 24,000-character packet with an 8K model context.
- Retrieval now combines protected orientation/current-state files with up to four Markdown files matched to the question. A Luminai/Daemon definition test correctly retrieved the dedicated Human–Luminai system file.
- Qwen thinking output is stripped before display. The final repeated test returned only a concise definition while preserving the distinction between operational independence and identity independence.

## Additional local models

- Installed `nchapman/dolphin3.0-llama3:3b` (2.0 GB) as the hardware-fit Dolphin option for the 8 GB Neo.
- Installed `huihui_ai/qwen3.5-abliterated:4B` (3.3 GB) as a local exploratory-brainstorming option.
- Both models passed a short fictional succession-brainstorming smoke test with a 4K context cap. Story Engine still defaults to `qwen3:4b`.
- The character-dialogue experiment is paused after establishing character-file routing and structured final-answer handling. Generated dialogue remains non-canon and still needs a dedicated continuity critic before it is trustworthy.
- All Ollama models, the Ollama app, and the local Ollama service were stopped at the end of the session.
- The interface discloses which files were supplied and labels every response as local, read-only, and not canon.
- The test path exposes no vault-write command and cannot accept or advance the paused SC-010 author gate.
