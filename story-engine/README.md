# Story Engine

Local-first story-development workspace for *Seeds of the Throne*.

## Stack

- Tauri 2 desktop shell
- React 19 + TypeScript + Vite interface
- Rust platform adapters
- Ollama default local model provider
- `qwen3:4b` initial model for the 8 GB MacBook Neo

## Architecture

React and Tauri sit outside the story engine. Durable project state is Markdown plus versioned JSON, and the contracts in `contracts/` do not depend on a UI framework. See `docs/ARCHITECTURE.md`.

## Development

```sh
npm install
npm run dev
npm run build
npm run tauri dev
```

The `tauri` script explicitly uses the installed Xcode Command Line Tools on macOS. A preinstalled full Xcode currently exists on the Neo but is not needed for desktop development.

The native layer can be checked separately:

```sh
cd src-tauri
DEVELOPER_DIR=/Library/Developer/CommandLineTools cargo check
DEVELOPER_DIR=/Library/Developer/CommandLineTools cargo clippy --all-targets -- -D warnings
```

## Current vertical slice

- Story workflow workspace shell
- Protected SC-010 author gate shown as paused
- Current run and retrieved-context presentation
- Native Ollama installation, service, and model discovery
- Read-only Qwen chat over a bounded, question-specific packet from a selected Seeds vault copy
- Visible disclosure of every vault file supplied to the model
- Portable project and workflow-state schemas
- TypeScript provider and engine boundary contracts

Semantic retrieval, reusable project selection, and atomic proposed-artifact writes are the next implementation milestone.
