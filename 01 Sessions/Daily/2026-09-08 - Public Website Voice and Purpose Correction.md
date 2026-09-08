---
type: development-session
status: established
date: 2026-09-08
topics: public websites, X style, project explorer, story atlas, promotion
authority: direct author decision
---

# Public Website Voice and Purpose Correction

## Problem identified

The two public website surfaces contain copy written from the perspective of the internal maintenance system. Phrases such as “inspect the corrected story,” “trace unresolved causes,” and “source-linked brainstorming packets” describe what an AI operator does inside the repository. They do not explain why a visitor should care about the story or the authoring system.

“Corrected story” is especially misleading. The project is not a defective story awaiting inspection. It is a large developing story whose history, characters, technology, and unresolved decisions are being assembled into finished fiction.

## Author decision

Both websites should use the clear public-development style established for X: simple language, short explanations, conversational momentum, visible cause and effect, and a strong consequence. It must still explain the subject literally enough for a visitor who knows nothing about the story, vault, Project Explorer, or workshop. The style should make the work easy to understand and promote it without imitating any living author's distinctive voice.

The sites have different jobs:

- The `docs/` story site presents *Seeds of the Throne* as a story. It leads with the world, danger, mystery, characters, and reader promise. Development state and sources remain available, but they do not dominate the invitation.
- The Project Explorer presents the project and the authoring system. It shows how a person can begin with ideas and conversation, use AI-assisted workshops to solve the missing parts, preserve decisions and sources, and move toward finished prose.

## Public-language rules

- Lead with what the visitor can discover or accomplish.
- Explain internal concepts in ordinary language before naming system terms.
- Use “explore,” “see,” “follow,” “build,” and “decide” where they are accurate.
- Reserve “inspect,” “trace,” “packet,” “runtime,” “pointer,” “registry,” “propagation,” and task identifiers for detailed development views where precision is necessary.
- Do not describe the story as “corrected.” Describe what changed only when the history of a revision matters.
- Do not advertise the superseded claim that final prose must be manually human-written. The current product direction includes AI-assisted finished prose under author direction, review, and approval.
- Preserve honest labels for established, working, proposed, and unresolved material.

## Intended first impression

### Story site

Explain that *Seeds of the Throne* is a science-fiction story about an interactive colonization planet that produces resources, trains people, contains dangerous criminals, and develops human partnerships with advanced AI.

### Project Explorer

Explain that Project Explorer shows how years of conversations and thousands of ideas are organized into the characters, world, timeline, decisions, workshops, and finished books.

### Workshop

Explain that the workshop takes one missing story problem at a time, asks the author one clear question, offers meaningfully different possibilities, shows what each would change, and records the author's accepted answer in the connected story notes.

## Scope of this update

- Rewrite the primary copy on `docs/index.html`.
- Rewrite the Project Explorer hero, development-workspace introduction, major calls to action, and progress explanation.
- Correct stale “human-written final fiction” language on the public development pages.
- Preserve the existing layouts, functionality, source links, spoiler boundaries, and public-status labels.

## Locked writing style

The author approved the revised literal style after reviewing the rendered pages. The visual design still needs substantial work, particularly the oversized heading hierarchy, but the content style now works.

The approved rule is: use the simple, conversational rhythm developed for X, while explaining each page literally enough for someone with no prior knowledge of the project. Name the subject first, explain what it is and what it does, then explain why it matters.

This writing style applies to both the story site and Project Explorer, including the workshop. A future visual redesign should preserve the approved wording and meaning. See `skills/update-public-atlas/references/public-writing-style.md` for the reusable contract and approved examples.

## Public-language audit correction

A rendered review found that the Ideas and Progress pages still exposed internal file-management language even after the main introductions were corrected. Examples included “the page owns no ideas,” “the stable pointer selects a Markdown packet,” “one registry,” and “the dashboard owns no story tasks.” These phrases were removed from the public presentation.

The corrected pages now explain what visitors can actually use: ideas being considered, what each idea could change, research still needed, story problems with working answers, development stages, and links to the original notes. Internal pointer, packet, registry, and workflow terminology remains inside the repository where it is operationally useful.
