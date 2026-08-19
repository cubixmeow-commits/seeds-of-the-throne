# Customization and Learning Controls

This file makes the prose system adjustable without rewriting the entire skill. Direct author instruction always overrides these defaults.

## Style controls

Use each as a 1–5 working scale. These are calibration aids, not mandatory metadata in outputs.

| Control | 1 | 3 default | 5 |
| --- | --- | --- | --- |
| Compression | spacious | controlled | highly compressed |
| Psychic distance | observational | selective close | intensely interior |
| Exposition density | minimal | necessary | explanation-forward |
| Documentary register | rare | mixed by need | dominant reconstruction |
| Dialogue density | sparse | balanced | dialogue-led |
| Ambiguity retention | resolve quickly | preserve useful gaps | strongly withhold |
| Physical specificity | selective | concrete | highly granular |
| Metaphor level | almost none | restrained | conspicuous |
| Political grotesque | subtle | situational | strongly satirical |
| Turn frequency | rare | occasional | frequent |
| Fragment tolerance | almost none | rare emphasis | frequent |
| Sensory saturation | lean | selected senses | immersive |

### Current recommended baseline

- Compression: 4
- Psychic distance: 3, adjusted by scene
- Exposition density: 2
- Documentary register: 3
- Dialogue density: 3
- Ambiguity retention: 4
- Physical specificity: 4
- Metaphor level: 2
- Political grotesque: 3 when relevant, 1 otherwise
- Turn frequency: 2
- Fragment tolerance: 1
- Sensory saturation: 2

These defaults remain subordinate to `03 Context/WRITING-STYLE.md`.

## Per-scene override packet

A scene may temporarily specify:

- target register;
- POV and psychic distance;
- pace: slow / medium / fast;
- dominant pressure type;
- exposition budget: low / medium / high;
- dialogue ratio target;
- ambiguity to preserve;
- reveal ceiling: what must not be disclosed;
- ending type: consequence / decision / question / transition / turn / aftermath;
- any temporary banned habits.

Do not save a per-scene preference as a global style rule.

## Approved examples

Author-approved prose is stronger calibration evidence than abstract style labels. When examples are added, record:

- source/path;
- register demonstrated;
- what specifically works;
- what should *not* be generalized from it;
- approval date/status.

Prefer a small set of clearly annotated examples over a large undifferentiated corpus.

Suggested future location:

`references/examples/`

with an `INDEX.md` explaining why each passage is useful.

## Rule lifecycle

A new prose rule should move through:

1. **Observed**: feedback suggests a preference.
2. **Proposed**: preference seems reusable across more than one passage.
3. **Tested**: benchmark or real scene confirms it improves intended output without harming another register.
4. **Active**: add to the relevant reference or voice profile.
5. **Retired**: keep a short record when a former rule is superseded, so old behavior does not silently return.

One isolated reaction should normally remain observed rather than becoming a global rule.

## Feedback extraction

When the author says a version is better or worse, identify the smallest transferable reason. Examples:

- "Better because Samuel sounds irritated rather than theatrical" -> possible dialogue/political-grotesque rule.
- "Worse because it explained the clue immediately" -> suspense/information-control rule.
- "Better because the room feels real now" -> physical-specificity calibration.
- "Too many dramatic endings" -> lower turn frequency rather than banning turns.

Separate story preference from prose preference. "Samuel would never do this" is primarily story/character authority, not a sentence-style rule.

## Regression principle

Every active rule should survive contact with at least one different scene type. A rule that improves archival reconstruction but harms close psychological prose should become register-specific rather than global.
