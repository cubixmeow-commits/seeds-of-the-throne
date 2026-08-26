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
