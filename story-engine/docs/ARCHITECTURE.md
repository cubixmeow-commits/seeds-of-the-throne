# Story Engine architecture

Story Engine is a local-first desktop client over a portable project format. React is a view layer. Tauri is a desktop adapter. Neither owns story rules.

```text
React desktop UI
        |
Application use cases
        |
Portable engine contracts
   /          |          \
project     workflow     model provider
files       rules        interface
   \          |          /
Rust desktop adapters (filesystem, Ollama, export)
```

## Dependency rule

Dependencies point inward. UI and platform adapters may import engine contracts; engine contracts never import React, Tauri, browser APIs, or macOS APIs.

## Data rule

Markdown and versioned JSON are durable truth. SQLite is allowed later for rebuildable indexes, embeddings, and caches. Provider transcripts do not become canon merely because the app generated or stored them.

## Mobile path

A Flutter client should generate Dart types from the JSON schemas or implement equivalent validated models. If shared logic becomes large or performance-sensitive, the pure Rust engine can later be exposed to Flutter through FFI. That is an optimization, not a V1 dependency.

## First vertical slice

1. Discover Ollama and installed models.
2. Open a local Seeds project copy.
3. Assemble a bounded, explicit source-and-authority packet without changing it.
4. Run local Qwen analysis through Ollama and disclose the supplied files.
5. Reconstruct workflow state from portable contracts.
6. Save a proposed artifact with provenance.
7. Prove that an author gate cannot advance without an explicit author decision.

The first test integration implements steps 1–4 as a read-only path. It combines a fixed allowlist of authority/current-state files with a small set of question-matched Markdown sources, caps the total packet size, and does not expose a filesystem-write command to the model. Model reasoning blocks are removed before display so the interface shows only the final answer.
