# Recovery Notes

Status: integrated through 2026-08-17

Desktop integration completed after fast-forwarding to `origin/main` and reconciling the queued material with the permanent vault.

## Integrated destinations

- B01-B10 benchmark findings and backlog: [[02 Story/Systems/Visual Generation/VISUAL-BENCHMARK-SUITE]], [[02 Story/Systems/Visual Generation/PROMPT-SYSTEM]], and [[01 Sessions/Daily/2026-08-13 - Conversation to Vault Audit]].
- Surface/hidden civilization and decade grounding: [[02 Story/Systems/Visual Generation/ERA-SURFACE-CIVILIZATION-REFERENCE]] and [[02 Story/Systems/Visual Generation/VISUAL-WORLD-COMPILER]].
- Sylvan chronology, appearance timelines, and Samuel's Great War apparent age: [[02 Story/Timeline/Timeline]] and `skills/create-seeds-images/references/visual-registry.json`.
- Samuel/Conrad leverage arc: [[02 Story/Systems/The Breeding Program and Lineage Blackmail]] as development material requiring later refinement.
- Daily-chat integration workflow: [[07 Coordination/DESKTOP-QUEUE.md]] and [[07 Coordination/device-workflow.md]].

## Preserved unresolved / deferred

B06-B10 visual benchmark
The Sylvan exploratory suite is complete. Preserve the existing findings from this 2026-08-13 project conversation for desktop integration: identity grounding, context isolation, wardrobe variation, Seeds-specific architecture/technology, Luminai manifestation, no-text/canon controls, composition modes, positive-civilization definition, and controlled review of useful accidental inventions. After v2, run the equivalent suite with Samuel.

Integrated follow-up: Luminai/Daemon manifestation, Sylvan's 1985-present Los Angeles/United States middle-class wardrobe reference, and the societal nutrition-plus-energy basis of rejuvenation are now permanent visual/system definitions. Observer perception, detailed treatment protocols, and intermediate appearance anchors remain explicit open questions.

## Era / character chronology
Sylvan Elaria is born at approximately the surface-civilization equivalent of 1985. For ordinary mortal chronology, scene year can be derived from birth-equivalent year plus age and used to retrieve the appropriate surface-civilization era packet.

## Role-specific apparent age / rejuvenation
Long-lived participants can undergo a healing/rejuvenation process at certain transitions into new identities and roles. Therefore chronological age and apparent biological age must be stored separately.

Visual World Compiler requirement: each important identity/role can have an appearance state containing `apparent_age`, `rejuvenation_stage`, `identity_reference`, stable identity traits to preserve, and age/era/role-dependent traits that may transform. Historical era determines the surrounding world; identity/role state determines apparent age; the underlying character identity determines facial continuity.

For characters with multiple long-lived roles, create an Appearance Timeline recording role/identity, era, apparent age at role entry, apparent aging through the role, rejuvenation/healing events, and appearance at role exit. Interpolation between approved anchor states may be used for scenes between anchors.

Samuel: during the Great War-equivalent era, use Samuel's authoritative identity reference but age-regress/rejuvenate him to an apparent age of approximately 40. Do not substitute Sylvan's identity. The Great War environment should use the established 1930s-1940s-equivalent surface civilization envelope unless a scene specifies otherwise.

## Samuel / Konrad rewrite — current recovery state

The earlier leverage note is superseded where it suggested a child from the underage relationship, a separate concealed allegiance, or Samuel's ownership of a revolution and conquest regime.

Current direction:

- Samuel's wealthy parents are senior members of Konrad Fitzgerald's fascist purity and bloodline organization.
- They and the organization exile Samuel approximately thirty years before the Great War after serious misconduct, including a sexual relationship with an underage girl. Additional abuses and the exact circumstances remain unresolved.
- During that interval, Samuel and George enter an important-seeming situation inside the largest government. George appears highly successful before private joint wrongdoing and a horribly planned takeover collapse in an extremely humiliating exposure that busts George into real containment.
- Konrad's faction owns the original political expansion, world-conquest attempt, and Great War.
- Samuel maintains contact with his parents, performs reconciliation, and covertly sabotages the campaign from inside the future victor.
- Defeat brings Konrad, Samuel's parents, and the surviving leadership into Samuel's containment environment.
- Samuel uses superior familiarity to become indispensable, interpret defeat, construct the False Victory, and capture Konrad's breeding and genealogy systems.
- His revenge targets bloodline, pedigree, purity, succession, inheritance, descendants, and replacement heirs, then evolves into an attempt to become Konrad's functional replacement.
- Who placed Samuel and George, their private wrongdoing, takeover mechanics, Samuel's status and consequences, the prewar role's relationship to George's later roles, Samuel's sabotage operations, Samuel's age, and the transition from revenge to replacement remain open.

See [[01 Sessions/Daily/2026-08-17 - Samuel Franklin Konrad Rewrite Reconciliation]], [[01 Sessions/Daily/2026-08-17 - George Prewar Success and Humiliating Bust]], and [[07 QA/Contradictions]].

## Image generation / Visual World Compiler direction
The GPT-first Visual World Compiler is now implemented as the next production layer. Keep v2 inside one ecosystem for now: use GPT Image 2 first; defer Grok and other renderer adapters until the core system is reliable.

The visual generator should also function as a worldbuilding completeness test. Pipeline concept:

`Vault canon -> visual graph -> scene compiler -> GPT Image -> visual QA -> missing-definition report -> author decisions -> richer vault`

If an image request requires an undefined visual fact, the compiler should prefer a `NEEDS DEFINITION` item over silently inventing a load-bearing world detail. These missing-definition reports become checklists for future story-development sessions.

Separate `image_type` from `render_style`. Candidate image types include observational scene, narrative scene, historical reconstruction, environment establishing shot, character portrait, relationship scene, documentary-style photograph, key art, technology visualization, and worldbuilding concept. Render style can independently specify photorealistic/cinematic or another approved visual treatment.

Generation should resolve entities, apparent ages, era packets, locations, wardrobe, technology, relationships, composition mode, authoritative references and canon constraints from the vault. The final GPT Image call should receive only a clean compiled generation packet, isolated from benchmark/evaluation chatter.

Target interaction: a simple request such as `Generate an observational image of Sylvan discovering evidence of Samuel's Great War activities` should be sufficient for the system to retrieve and assemble the relevant visual truth without the user manually rewriting the world into the prompt.

## Daily-chat integration workflow
Adopt one primary project-development chat per day when practical. Treat that day's chat as a development journal and integration unit rather than assuming every brainstorm is immediately permanent canon.

End-of-day desktop procedure:
1. Review the day's project chat.
2. Extract decisions, development ideas, unresolved questions, visual findings and workflow changes.
3. Reconcile them with `RECOVERY.md` and the existing vault.
4. Promote appropriate material into permanent canon/development/system files.
5. Preserve unresolved items as explicit questions rather than silently resolving them.
6. Update visual-generation/worldbuilding systems where relevant.
7. Mark recovered items integrated only after verifying their permanent destinations.

## Desktop handoff pointer
Use the current 2026-08-13 project conversation as the detailed source of truth. It contains the B01-B10 benchmark sequence, Visual World Compiler research, decade-by-decade surface-civilization research, Sylvan's 1985-equivalent chronology, role-specific apparent-age/rejuvenation rules, Samuel/Conrad leverage brainstorming, and the GPT-first image-generation/worldbuilding workflow.

Tonight: first reconcile this recovery file against the latter portion of today's chat and permanent vault so nothing important is missed. Then focus on implementing the Visual World Compiler / GPT image-generation capabilities before Visual Generation System v2 and the Samuel benchmark suite.
