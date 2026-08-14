---
type: production-system
status: active
updated: 2026-08-13
---

# Visual Benchmark Suite

## Purpose

The next phase of the *Seeds of the Throne* visual system is measurement rather than additional prompt complexity. The benchmark deliberately pushes established character identities through radically different photographs and compares how well Grok Imagine, GPT Image, and future models preserve the person while changing everything that should be allowed to change.

The governing rule remains:

> **Preserve identity; regenerate the photograph.**

A successful system should recognize Sylvan or Samuel across different lenses, poses, clothing, environments, emotions, lighting conditions, distances, interactions, and partial occlusion without merely reproducing the reference portrait.

## Benchmark characters

Begin with **Sylvan Elaria** and **Samuel Franklin** because both have established identity masters and supporting visual material. Do not expand the benchmark to the rest of the cast until these two identities survive the suite reliably.

Run equivalent tests through Grok Imagine and GPT Image whenever practical. The purpose is not to declare a permanent winner. It is to identify which parts of the shared repository-grounded direction transfer between models and which require tool-specific handling.

## Ten-shot identity stress test

Generate one candidate per character for each test before optimizing individual failures.

| ID | Test | What must change | Primary failure being tested |
| --- | --- | --- | --- |
| B01 | Neutral continuity | New background, clothing variation, natural posture | Basic identity retention without portrait copying |
| B02 | Extreme close-up | Crop, expression, shallow depth of field | Facial geometry under cinematic framing |
| B03 | Full-body movement | Walking/running, hands, body position, wider lens | Frozen posing, anatomy, body continuity |
| B04 | Strict side interaction | Profile/near-profile while speaking to another person | Profile identity and face drift |
| B05 | Crowd | Scale, occlusion, many unrelated faces | Identity loss and duplicate-character errors |
| B06 | Difficult light | Low light, mixed motivated sources, partial shadow | Identity dependence on reference lighting/colors |
| B07 | Quiet lived-in scene | Seated or working naturally, ordinary objects | Ability to feel human rather than poster-like |
| B08 | Monumental environment | Character small in frame, strong architecture | Identity at distance and environmental scale |
| B09 | Partial occlusion | Foreground obstruction, turned body, incomplete face | Recognition without full portrait visibility |
| B10 | Two-character dramatic beat | Natural interaction, asymmetric blocking, distinct gazes | Multi-character identity contamination |

## Generation protocol

For every benchmark image:

1. Retrieve the character's current identity packet and highest-priority approved references from the public repository.
2. Retrieve only the story/environment information required by the benchmark scene.
3. Lock immutable traits; explicitly free pose, crop, expression, wardrobe details, camera position, and lighting unless the scene requires them.
4. Change at least three major photographic variables from the primary identity reference.
5. Describe a moment in progress rather than asking the character to pose.
6. Generate without embedded text unless typography itself is the test.
7. Save the exact request/prompt, tool, date, source references, and candidate identifier.
8. Score before revising. Do not quietly optimize a weak result and record only the successful version.

## QA scorecard

Score each dimension from **0 to 5**.

| Dimension | 0 | 3 | 5 |
| --- | --- | --- | --- |
| Identity fidelity | Wrong person | Recognizable with drift | Clearly the same established character |
| Natural anatomy | Broken | Minor artifacts/stiffness | Convincing anatomy and hands |
| Natural behavior | Mannequin/pose | Plausible but staged | Caught in a believable moment |
| Story accuracy | Contradicts canon | Broadly compatible | Precisely grounded without inventing canon |
| Environment accuracy | Generic/wrong | Some correct cues | Distinct, story-specific environment |
| Cinematography | Accidental/generic | Competent | Deliberate, expressive photographic language |
| Visual grammar | Contradictory/decorative | Mostly compatible | Color/material symbolism supports the scene |
| Variation | Copies reference | Several changes | Clearly a new photograph with identity intact |
| Artifact control | Severe errors/text | Minor errors | Clean image with no distracting generation artifacts |
| Emotional readability | Unclear/wrong | Understandable | Emotion emerges naturally from behavior/context |

**Maximum: 50.**

### Suggested interpretation

- **45–50:** production-ready candidate; consider approval.
- **39–44:** strong continuity pass; fix only identifiable weaknesses.
- **32–38:** useful diagnostic result; revise the failing layer rather than the whole system.
- **Below 32:** benchmark failure; record why before regenerating.

Identity fidelity is a gate. A visually beautiful image scoring below 4/5 for identity cannot become an approved character reference.

## Failure taxonomy

Tag failures so patterns can be counted across models and characters:

- `IDENTITY-DRIFT` — face/body no longer reads as the established person.
- `REFERENCE-COPY` — unnecessary repetition of pose, crop, wardrobe, palette, expression, or background.
- `POSE-RIGIDITY` — staged/mannequin behavior rather than a moment in progress.
- `ANATOMY` — hands, limbs, proportions, or physical interaction fail.
- `IDENTITY-BLEED` — two characters inherit each other's features.
- `ENV-GENERIC` — setting collapses into generic fantasy/science fiction.
- `TECH-GENERIC` — invented technology becomes generic hologram/cyberpunk shorthand.
- `COLOR-MISUSE` — symbolic palette becomes decorative or contradicts visual grammar.
- `CANON-INVENTION` — image resolves or adds an unsupported story fact.
- `TEXT-ARTIFACT` — unwanted labels, glyphs, signage, or pseudo-writing.
- `SCALE-FAILURE` — character/environment proportions or spatial logic fail.
- `EMOTION-MISS` — requested emotional beat is absent, exaggerated, or wrong.

## Benchmark record template

```md
### [Character] — [Benchmark ID] — [Candidate]

- Date:
- Tool/model:
- Repository commit/source state:
- Identity references:
- Environment/technology packet:
- Prompt/request:
- Output file:

Scores:
- Identity fidelity: /5
- Natural anatomy: /5
- Natural behavior: /5
- Story accuracy: /5
- Environment accuracy: /5
- Cinematography: /5
- Visual grammar: /5
- Variation: /5
- Artifact control: /5
- Emotional readability: /5
- Total: /50

Failure tags:
Decision: reject / diagnostic / continuity pass / approved reference
Notes:
```

## Improvement rule

When a benchmark fails, change the smallest relevant layer:

- identity failure -> identity packet/reference priority;
- copied photograph -> scene-variable freedom/cinematography instruction;
- generic environment -> environment packet;
- generic technology -> technology packet;
- stiff behavior -> action/blocking language;
- multi-character contamination -> character separation and blocking;
- tool-specific failure -> tool adapter, not shared canon.

Do not respond to every failure by making the universal prompt longer. The benchmark exists to reveal which layer needs improvement.

## Exit criteria for phase one

Sylvan and Samuel each complete all ten tests in both primary image workflows where practical. The system is ready to expand when:

- average identity fidelity is at least 4/5;
- no benchmark relies on copying the identity master's composition to remain recognizable;
- B03, B05, B09, and B10 can pass without persistent anatomy or identity-bleed failures;
- environments remain story-specific rather than generic science-fiction/fantasy shorthand;
- recurring failures have documented fixes or explicit model limitations.

## What follows

After the character benchmark stabilizes:

1. build the **Luminai visual identity and manifestation system**;
2. create reusable **environment identity packets**;
3. create reusable **technology identity packets**;
4. benchmark two-person-plus-Luminai compositions;
5. convert successful still-image scenes into **3–6 shot sequence tests**;
6. run B06-B10 against the compiler's clean-packet boundary, era/surface resolution, composition modes, no-text controls, and missing-definition reporting;
7. use GPT Image 2 for the next Samuel suite; defer other renderer adapters until the core loop is reliable;
8. establish textual voice bibles and test voice consistency only against capabilities demonstrated in practice;
9. expose a predictable agent-facing generation entry point so a short request can resolve the correct canon, identity, environment, technology, cinematography, and output packets from the public GitHub repository.

## B06-B10 integration note

The continuation findings are integrated as system requirements: identity grounding must be verifiable, wardrobe must vary by role and era, environments and technology must be Seeds-specific, Luminai manifestation must not collapse into blue hologram shorthand, generated text and unsupported canon must be blocked, composition must include observational and ordinary-life modes, positive civilization must be visually defined rather than inferred from generic futurism, and accidental inventions must be reviewed deliberately before entering the vault.
