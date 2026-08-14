# Recovery Notes

Temporary notes awaiting later review.

## Pending

B06-B10 visual benchmark
The Sylvan exploratory suite is complete. Preserve the existing findings from this 2026-08-13 project conversation for desktop integration: identity grounding, context isolation, wardrobe variation, Seeds-specific architecture/technology, Luminai manifestation, no-text/canon controls, composition modes, positive-civilization definition, and controlled review of useful accidental inventions. After v2, run the equivalent suite with Samuel.

## Era / character chronology
Sylvan Elaria is born at approximately the surface-civilization equivalent of 1985. For ordinary mortal chronology, scene year can be derived from birth-equivalent year plus age and used to retrieve the appropriate surface-civilization era packet.

## Role-specific apparent age / rejuvenation
Long-lived participants can undergo a healing/rejuvenation process at certain transitions into new identities and roles. Therefore chronological age and apparent biological age must be stored separately.

Visual World Compiler requirement: each important identity/role can have an appearance state containing `apparent_age`, `rejuvenation_stage`, `identity_reference`, stable identity traits to preserve, and age/era/role-dependent traits that may transform. Historical era determines the surrounding world; identity/role state determines apparent age; the underlying character identity determines facial continuity.

For characters with multiple long-lived roles, create an Appearance Timeline recording role/identity, era, apparent age at role entry, apparent aging through the role, rejuvenation/healing events, and appearance at role exit. Interpolation between approved anchor states may be used for scenes between anchors.

Samuel: during the Great War-equivalent era, use Samuel's authoritative identity reference but age-regress/rejuvenate him to an apparent age of approximately 40. Do not substitute Sylvan's identity. The Great War environment should use the established 1930s-1940s-equivalent surface civilization envelope unless a scene specifies otherwise.

## Samuel / Conrad leverage arc — development, refine later
Samuel's obsession with Conrad's group and breeding project is connected to resentment toward their bloodline-purity ideology and the consequences Samuel experienced from his parents after an earlier prohibited relationship produced a child outside the lineage expectations imposed on him. Samuel develops an additional concealed personal reason for viewing Conrad's ideology as hostile to him; the exact nature of that reason remains intentionally undefined for later development.

Samuel presents himself to Conrad as possessing medical/scientific expertise capable of solving problems Conrad is trying to overcome within the breeding program. This gives Samuel privileged influence or access. Samuel then secretly subverts the program in a way Conrad's ideology regards as catastrophic. The specific biological and genealogical mechanics should be refined later rather than over-defined here.

The concealment becomes political leverage. Samuel threatens exposure of what happened to Conrad's followers/group, leaving Conrad and his fanatic partner trapped by their own ideology and by the reputational consequences of admitting the program was compromised. Their concealment/complacency allows Samuel to convert private leverage into influence and attempted control during a revolution.

The revolution does not need a clean path to victory. Samuel can possess enormous coercive leverage while simultaneously flailing strategically, trying both to seize control of Conrad's group and to punish/damage the group he hates. This contradiction is part of his characterization.

Potential staged Sylvan discovery structure:
1. Something is wrong with Conrad's lineage/program.
2. Conrad and his partner are concealing something.
3. Samuel caused or engineered the compromise.
4. Conrad is being controlled through the secret.
5. The leverage is connected to Samuel's attempted revolution/seizure of control.
6. Samuel's actions were deliberate retaliation, not merely opportunism.
7. The deeper personal reason for Samuel's hatred is revealed later.

Treat this section as development material requiring refinement, not fully locked canon.

## Image generation / Visual World Compiler direction
Tonight's primary build target after integration is the GPT-based visual generation system. Keep v2 inside one ecosystem for now: use GPT image generation first; defer Grok and other renderer adapters until the core system is reliable.

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
