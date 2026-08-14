#!/usr/bin/env python3
"""Compile a clean, vault-grounded GPT Image packet and report missing definitions."""

from __future__ import annotations

import argparse
import json
import re
import sys
from pathlib import Path


SKILL_ROOT = Path(__file__).resolve().parents[1]
REGISTRY_PATH = SKILL_ROOT / "references" / "visual-registry.json"
YEAR_RE = re.compile(r"\b(19|20)\d{2}\b")
SIZE_RE = re.compile(r"^\d{2,5}x\d{2,5}$")


def era_for_year(year: int) -> str:
    decade = (year // 10) * 10
    if decade < 1940:
        return "pre-1940s"
    if decade >= 2020:
        return "2020s"
    return f"{decade}s"


def resolve_era(args: argparse.Namespace) -> tuple[str | None, str]:
    if args.era:
        return args.era, "explicit"
    if args.birth_year is not None and args.age is not None:
        return era_for_year(args.birth_year + args.age), "birth-year-plus-age"
    years = [int(match.group()) for match in YEAR_RE.finditer(args.scene)]
    if years:
        return era_for_year(years[0]), "scene-year"
    return None, "missing"


def normalized_era(value: str) -> str:
    return value.lower().replace("-equivalent", "").replace(" ", "")


def resolve_appearance(character: dict, role: str | None, era: str | None) -> dict | None:
    timeline = character.get("appearance_timeline", [])
    if role:
        return next((state for state in timeline if state["role_id"] == role), None)
    if era:
        target = normalized_era(era)
        matches = [state for state in timeline if target in normalized_era(state["era_equivalent"])]
        if len(matches) == 1:
            return matches[0]
    if len(timeline) == 1:
        return timeline[0]
    return None


def resolve_manifestation(explicit: str | None, scene: str) -> str:
    if explicit:
        return explicit
    lowered = scene.lower()
    if "daemon" in lowered:
        return "daemon"
    if "luminai" in lowered:
        return "luminai"
    return "none"


def selected_subgraph_ids(
    args: argparse.Namespace,
    era: str,
    manifestation_id: str,
    appearances: list[tuple[str, dict, dict | None]],
) -> list[str]:
    node_ids = {
        "style:sott-gothic-archive-v1",
        "renderer:gpt-image-2",
        f"composition:{args.composition}",
        f"era:{normalized_era(era)}",
        f"environment:{args.location}",
        "system:rejuvenation",
    }
    if manifestation_id != "none":
        node_ids.add(f"manifestation:{manifestation_id}")
    for overlay_id in args.environment_overlay:
        node_ids.add(f"environment-overlay:{overlay_id}")
    for character_id, character, appearance in appearances:
        node_ids.add(f"character:{character_id}")
        if character.get("wardrobe_profile"):
            node_ids.add(f"wardrobe:{character_id}")
        if appearance:
            node_ids.add(f"appearance:{character_id}:{appearance['role_id']}")
    return sorted(node_ids)


def print_source_trace(registry: dict, selected_node_ids: list[str]) -> None:
    graph = registry["visual_entity_graph"]
    nodes = graph["nodes"]
    sources = graph["source_catalog"]
    selected = set(selected_node_ids)
    print("VAULT SOURCE TRACE (stderr; do not send to renderer)", file=sys.stderr)
    print(f"graph_schema={graph['schema_version']}; graph_status={graph['status']}", file=sys.stderr)
    for node_id in selected_node_ids:
        node = nodes[node_id]
        print(
            f"node={node_id}; type={node['type']}; status={node['status']}; payload_ref={node['payload_ref']}",
            file=sys.stderr,
        )
        for source_id in node["source_refs"]:
            source = sources[source_id]
            print(
                f"  source={source_id}; class={source['source_class']}; location={source['location']}; scope={source['scope']}",
                file=sys.stderr,
            )
    for edge in graph["edges"]:
        if edge["from"] in selected and edge["to"] in selected:
            print(f"edge={edge['from']} --{edge['type']}--> {edge['to']}", file=sys.stderr)


def main() -> int:
    parser = argparse.ArgumentParser(description="Build a clean Seeds GPT Image generation packet.")
    parser.add_argument("--character", action="append", default=[], help="Character id; repeat for group images.")
    parser.add_argument("--scene", required=True, help="New scene, action, and emotional beat.")
    parser.add_argument("--purpose", default="cinematic story image")
    parser.add_argument("--image-type", default="narrative-scene")
    parser.add_argument("--render-style", default="painterly-photorealism")
    parser.add_argument("--composition", default="NARRATIVE-CINEMA")
    parser.add_argument("--aspect-ratio", default="16:9")
    parser.add_argument("--camera", default="cinematic medium-wide composition")
    parser.add_argument("--era", help="Explicit surface-civilization era, such as 1940s or 2020s")
    parser.add_argument("--birth-year", type=int, help="Surface-civilization equivalent birth year")
    parser.add_argument("--age", type=int, help="Chronological age for birth-year-plus-age resolution")
    parser.add_argument("--location", help="Environment master id or location packet id")
    parser.add_argument("--environment-overlay", action="append", default=[], help="Composable environment overlay id; repeat when needed")
    parser.add_argument("--role", help="Appearance timeline role id")
    parser.add_argument("--manifestation", choices=("none", "luminai", "daemon"), help="Explicit cognition manifestation")
    parser.add_argument("--manifestation-color", help="Approved manifestation color control")
    parser.add_argument("--manifestation-intensity", choices=("subtle", "moderate", "strong"))
    parser.add_argument("--manifestation-reach", choices=("skin-close", "body-scale", "extended"))
    parser.add_argument("--manifestation-particle-density", choices=("none", "sparse", "moderate"))
    parser.add_argument("--include-supporting-references", action="store_true", help="Include approved supporting scene references in addition to authoritative identity angles")
    parser.add_argument("--surface-layer", default="ordinary")
    parser.add_argument("--advanced-colony-visibility", default="none")
    parser.add_argument("--generation-intent", choices=("new-with-references", "edit", "iterative-edit"), default="new-with-references")
    parser.add_argument("--api-route", choices=("auto", "image-api", "responses-api", "in-app-tool"), default="auto")
    parser.add_argument("--output-size", default="auto", help="Renderer dimensions as WIDTHxHEIGHT, or auto")
    parser.add_argument("--output-quality", choices=("low", "medium", "high", "auto"), default="high")
    parser.add_argument("--output-format", choices=("png", "jpeg", "webp"), default="png")
    parser.add_argument("--output-compression", type=int, help="JPEG/WebP compression from 0 to 100")
    parser.add_argument("--output-background", choices=("opaque", "transparent", "auto"), default="auto")
    parser.add_argument("--trace", action="store_true", help="Print the selected graph and vault source trace to stderr")
    parser.add_argument("--qa", action="store_true", help="Print external QA metadata separately from the clean packet")
    args = parser.parse_args()

    if args.role and len(args.character) != 1:
        parser.error("--role requires exactly one --character; compile multi-character role states separately")

    registry = json.loads(REGISTRY_PATH.read_text(encoding="utf-8"))
    compiler = registry["compiler"]
    errors: list[str] = []
    missing: list[str] = []
    if not args.character:
        missing.append("identity packet: no character selected")
    unknown = [item for item in args.character if item not in registry["characters"]]
    if unknown:
        parser.error("Unknown character id(s): " + ", ".join(unknown))
    if args.image_type not in compiler["image_types"]:
        errors.append(f"image_type must be one of: {', '.join(compiler['image_types'])}")
    if args.render_style not in compiler["render_styles"]:
        errors.append(f"render_style must be one of: {', '.join(compiler['render_styles'])}")
    if args.composition not in compiler["composition_modes"]:
        errors.append(f"composition must be one of: {', '.join(compiler['composition_modes'])}")
    if args.age is not None and args.age < 0:
        errors.append("age must be zero or greater")
    era, era_source = resolve_era(args)
    if era is None:
        missing.append("era packet: provide --era or both --birth-year and --age")
    elif normalized_era(era) not in compiler["era_resolution"]["supported_packets"]:
        missing.append(f"era packet '{era}' is not defined in the surface-civilization reference")
    if args.location is None:
        missing.append("environment master: provide --location or author a location packet")
    if args.advanced_colony_visibility not in {"none", "subtle", "controlled", "explicit"}:
        errors.append("advanced-colony-visibility must be none, subtle, controlled, or explicit")
    if args.output_size != "auto" and SIZE_RE.fullmatch(args.output_size) is None:
        errors.append("output-size must be auto or WIDTHxHEIGHT")
    if args.output_compression is not None:
        if not 0 <= args.output_compression <= 100:
            errors.append("output-compression must be between 0 and 100")
        if args.output_format == "png":
            errors.append("output-compression is supported only for jpeg or webp")
    expected_route = compiler["renderer"]["execution_routes"][args.generation_intent]
    api_route = expected_route if args.api_route == "auto" else args.api_route
    if args.generation_intent == "iterative-edit" and api_route == "image-api":
        errors.append("iterative-edit requires responses-api or in-app-tool")
    if errors:
        parser.error("; ".join(errors))

    selected = [registry["characters"][item] for item in args.character]
    environment = compiler["environment_masters"].get(args.location) if args.location else None
    if args.location and environment is None:
        missing.append(f"environment master '{args.location}' is not in the registry")
    elif environment and environment.get("status") == "required-definition":
        missing.append(f"environment master '{args.location}' still requires definition")
    environment_overlays: list[tuple[str, dict]] = []
    for overlay_id in args.environment_overlay:
        overlay = compiler.get("environment_overlays", {}).get(overlay_id)
        if overlay is None:
            missing.append(f"environment overlay '{overlay_id}' is not in the registry")
        elif overlay.get("status") == "required-definition":
            missing.append(f"environment overlay '{overlay_id}' still requires definition")
        else:
            environment_overlays.append((overlay_id, overlay))

    manifestation_id = resolve_manifestation(args.manifestation, args.scene)
    manifestation = None if manifestation_id == "none" else compiler.get("manifestations", {}).get(manifestation_id)
    if manifestation_id != "none" and manifestation is None:
        missing.append(f"manifestation packet '{manifestation_id}' is not in the registry")
    manifestation_values: dict[str, str] = {}
    if manifestation:
        controls = manifestation.get("controls", {})
        manifestation_values = {
            "color": args.manifestation_color or controls.get("default_color", "unspecified"),
            "intensity": args.manifestation_intensity or controls.get("default_intensity", "moderate"),
            "reach": args.manifestation_reach or controls.get("default_reach", "body-scale"),
            "particle_density": args.manifestation_particle_density or controls.get("default_particle_density", "sparse"),
        }
        allowed = {
            "color": controls.get("allowed_colors", []),
            "intensity": controls.get("allowed_intensities", []),
            "reach": controls.get("allowed_reach", []),
            "particle_density": controls.get("allowed_particle_density", []),
        }
        for field, value in manifestation_values.items():
            if allowed[field] and value not in allowed[field]:
                errors.append(f"manifestation {field.replace('_', '-')} must be one of: {', '.join(allowed[field])}")

    if errors:
        parser.error("; ".join(errors))

    appearances: list[tuple[str, dict, dict | None]] = []
    for character_id, character in zip(args.character, selected):
        state = resolve_appearance(character, args.role, era)
        appearances.append((character_id, character, state))
        if state is None and (args.role or era):
            qualifier = f"role '{args.role}'" if args.role else f"era '{era}'"
            missing.append(f"appearance state for {character['display_name']} at {qualifier} is not defined")
        elif state and state.get("renderable") is not True:
            missing.append(f"appearance state '{state['role_id']}' for {character['display_name']} has no renderable approved anchor")

    selected_node_ids: list[str] = []
    if era is not None and args.location is not None:
        selected_node_ids = selected_subgraph_ids(args, era, manifestation_id, appearances)
        graph_nodes = registry.get("visual_entity_graph", {}).get("nodes", {})
        for node_id in selected_node_ids:
            if node_id not in graph_nodes:
                missing.append(f"visual graph node '{node_id}' is not defined")

    if missing:
        print("SEEDS OF THE THRONE NEEDS DEFINITION REPORT")
        print(f"Compiler: {compiler['id']}")
        print("Generation status: blocked")
        for item in missing:
            print(f"- {item}")
        print(f"- Policy: {compiler['missing_definition_policy']}")
        return 2

    ordinary_surface = args.surface_layer == "ordinary" and args.advanced_colony_visibility == "none"

    print("SEEDS OF THE THRONE CLEAN GENERATION PACKET")
    print(f"Compiler: {compiler['id']}")
    print(f"Renderer: {compiler['renderer']['provider']} / {compiler['renderer']['model']}")
    print("QA context: excluded from this packet")
    print("\nIDENTITY AUTHORITY")
    for _character_id, character, appearance in appearances:
        print(f"\n{character['display_name']} ({character.get('visual_status', 'working')}):")
        for ref in character["references"]:
            authoritative = ref["status"] in {"canonical-angle", "canonical-primary", "canonical"}
            supporting = args.include_supporting_references and ref["status"] in {"supporting", "approved-supporting"}
            if authoritative:
                print(f"- reference: {ref['path']} (identity geometry only; resolved appearance, role, wardrobe, and scene override the source image)")
            elif supporting:
                print(f"- reference: {ref['path']} ({ref['use']})")
        transformable_fields = set(appearance.get("transformable_identity_fields", [])) if appearance else set()
        stable_identity = [
            value
            for key, value in character["identity_lock"].items()
            if key != "apparent_age" and key not in transformable_fields
        ]
        print("- immutable identity traits: " + "; ".join(stable_identity))
        if appearance:
            print(f"- resolved appearance: role={appearance['role_id']}; era={appearance['era_equivalent']}; apparent_age={appearance['apparent_age']}; rejuvenation={appearance['rejuvenation_stage']}")
            print("- stable appearance traits: " + "; ".join(appearance.get("stable_traits", [])))
        if character.get("wardrobe_profile"):
            wardrobe = character["wardrobe_profile"]
            print(f"- wardrobe reference: {wardrobe['earth_reference_only']}")
            print(f"- wardrobe resolution: {wardrobe['translation_rule']}")
            print(f"- wardrobe anti-default: {wardrobe['anti_default']}")
        print("- wardrobe constraints: " + "; ".join(character["wardrobe_lock"]))
        if not ordinary_surface or manifestation:
            print("- character color and light: " + "; ".join(character["color_and_light"]))
        if not ordinary_surface:
            print("- symbolic language: " + "; ".join(character["symbolic_language"]))

    print("\nWORLD PACKET")
    print(f"- era_equivalent: {era or 'NEEDS DEFINITION'} (resolved by {era_source})")
    print(f"- surface_layer: {args.surface_layer}")
    print(f"- advanced_colony_visibility: {args.advanced_colony_visibility}")
    print(f"- environment_master: {args.location or 'NEEDS DEFINITION'}")
    era_packet = compiler["era_packets"][normalized_era(era)]
    print(f"- era visible life: {era_packet['visible_life']}")
    print(f"- era technology and media: {era_packet['technology_media']}")
    print(f"- era transport and infrastructure: {era_packet['transport_infrastructure']}")
    print(f"- era guardrails: {era_packet['guardrails']}")
    for overlay_id, overlay in environment_overlays:
        print(f"- environment overlay: {overlay_id}; {overlay['scope']}")
        print(f"- overlay development reference: {overlay['earth_development_reference']}")
        print(f"- overlay visible evidence: {'; '.join(overlay['visible_evidence'])}")
        print(f"- overlay guardrails: {overlay['guardrails']}")
    print(f"- rule: {compiler['surface_hidden_rule']}")
    if manifestation:
        print(f"- {manifestation_id}_manifestation: {manifestation['form']}; concentrated at {', '.join(manifestation['concentration'])}; {manifestation['behavior']}")
        print(f"- manifestation palette: {manifestation['palette']}")
        print(f"- manifestation controls: color={manifestation_values['color']}; intensity={manifestation_values['intensity']}; reach={manifestation_values['reach']}; particle_density={manifestation_values['particle_density']}")
        print(f"- manifestation coherence: {manifestation.get('controls', {}).get('coherence', manifestation['behavior'])}")
        print(f"- manifestation epistemic boundary: {manifestation['observer_rule']}")
    else:
        print("- cognition_manifestation: none requested or inferred")
    rejuvenation = compiler["rejuvenation_system"]
    print(f"- rejuvenation system: {rejuvenation['social_role']}; modalities: {', '.join(rejuvenation['modalities'])}")
    print(f"- rejuvenation visual rule: {rejuvenation['visual_rule']}")

    print("\nPROJECT VISUAL GRAMMAR")
    style = registry["style"]
    print(f"- project style: {style['name']} ({style['id']})")
    print(f"- style scope: {style['scope']}")
    print(f"- selected render treatment: {compiler['render_style_instructions'][args.render_style]}")
    if ordinary_surface:
        print(f"- ordinary surface override: {compiler['ordinary_surface_style_rule']}")
    if not ordinary_surface:
        for trait in style["locked_traits"]:
            if "painterly photorealism" not in trait:
                print(f"- {trait}")
        print("- palette: " + ", ".join(f"{name.replace('_', ' ')} {value}" for name, value in style["palette"].items()))
        for rule in style["composition_rules"]:
            print(f"- {rule}")

    print("\nOUTPUT CONTRACT")
    print(f"- image_type: {args.image_type}")
    print(f"- render_style: {args.render_style}")
    print(f"- composition_mode: {args.composition} — {compiler['composition_modes'][args.composition]}")
    print(f"- scene: {args.scene}")
    print(f"- camera: {args.camera}")
    print(f"- purpose: {args.purpose}")
    print(f"- aspect_ratio: {args.aspect_ratio}")
    print("- text policy: no legible text, signage, logos, captions, signatures, or watermarks unless explicitly required")
    print("- identity policy: preserve identity; regenerate the photograph; do not reproduce reference pose or crop")

    print("\nRENDERER EXECUTION PLAN")
    print(f"- generation_intent: {args.generation_intent}")
    print(f"- api_or_tool_route: {api_route}")
    print(f"- renderer_model: {compiler['renderer']['model']}")
    print(f"- documented_snapshot: {compiler['renderer']['documented_snapshot']} (record the observed version at execution)")
    print(f"- reference_input_fidelity: {compiler['renderer']['image_input_fidelity']} (not user-configurable for GPT Image 2)")
    print(f"- output: size={args.output_size}; quality={args.output_quality}; format={args.output_format}; background={args.output_background}")
    if args.output_compression is not None:
        print(f"- output_compression: {args.output_compression}")
    if api_route == "responses-api":
        print("- provenance: capture revised_prompt returned by the Responses API")
    else:
        print("- provenance: preserve the original clean brief and all execution settings")

    print("\nCONTINUITY AND NEGATIVE CONSTRAINTS")
    for _character_id, character, _appearance in appearances:
        print(f"- {character['display_name']}: " + "; ".join(character["drift_to_reject"]))
    for item in registry["style"]["avoid"]:
        print(f"- {item}")
    print("- no blue holographic woman, giant artificial face, decorative cyberpunk shorthand, or hidden colony technology without cause")
    print("- no benchmark ids, scores, findings, QA language, or metadata in the generated image")

    if args.trace:
        print_source_trace(registry, selected_node_ids)
    if args.qa:
        print("EXTERNAL QA METADATA (stderr; do not send to renderer)", file=sys.stderr)
        print(f"image_type={args.image_type}; composition={args.composition}; era={era}; identity_ids={','.join(args.character)}; generation_intent={args.generation_intent}; route={api_route}", file=sys.stderr)
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
