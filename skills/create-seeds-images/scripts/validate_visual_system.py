#!/usr/bin/env python3
"""Validate registry fields, reference existence, and reference checksums."""

from __future__ import annotations

import hashlib
import json
from pathlib import Path


ROOT = Path(__file__).resolve().parents[1]
REGISTRY_PATH = ROOT / "references" / "visual-registry.json"
REQUIRED_IDENTITY = {
    "apparent_age",
    "build_and_silhouette",
    "face",
    "hair",
    "facial_hair",
    "eyes_and_expression",
    "skin_and_distinguishing_features",
}


def sha256(path: Path) -> str:
    digest = hashlib.sha256()
    with path.open("rb") as handle:
        for chunk in iter(lambda: handle.read(1024 * 1024), b""):
            digest.update(chunk)
    return digest.hexdigest()


def resolve_payload(registry: object, payload_ref: str) -> object:
    value = registry
    for part in payload_ref.split("."):
        if isinstance(value, list):
            value = value[int(part)]
        elif isinstance(value, dict):
            value = value[part]
        else:
            raise KeyError(part)
    return value


def main() -> int:
    registry = json.loads(REGISTRY_PATH.read_text(encoding="utf-8"))
    errors: list[str] = []
    if registry.get("schema_version") != 2:
        errors.append("schema_version must be 2")
    compiler = registry.get("compiler", {})
    if compiler.get("id") != "seeds-visual-world-compiler-v2":
        errors.append("compiler id must be seeds-visual-world-compiler-v2")
    if compiler.get("renderer", {}).get("model") != "gpt-image-2":
        errors.append("compiler renderer must be gpt-image-2")
    if compiler.get("renderer", {}).get("qa_context_isolated") is not True:
        errors.append("compiler must isolate QA context")
    renderer = compiler.get("renderer", {})
    if renderer.get("image_input_fidelity") != "automatic-high":
        errors.append("GPT Image 2 input fidelity must be automatic-high")
    if set(renderer.get("generation_intents", [])) != {"new-with-references", "edit", "iterative-edit"}:
        errors.append("renderer generation intents are incomplete")
    expected_routes = {
        "new-with-references": "image-api",
        "edit": "image-api",
        "iterative-edit": "responses-api",
    }
    if renderer.get("execution_routes") != expected_routes:
        errors.append("renderer execution routes are incomplete")
    required_output_defaults = {"size", "quality", "format", "background"}
    if set(renderer.get("output_defaults", {})) != required_output_defaults:
        errors.append("renderer output defaults are incomplete")
    required_modes = {"KEY-ART", "NARRATIVE-CINEMA", "OBSERVATIONAL", "ORDINARY-LIFE"}
    if set(compiler.get("composition_modes", {})) != required_modes:
        errors.append("compiler composition modes are incomplete")
    if set(compiler.get("render_styles", [])) != set(compiler.get("render_style_instructions", {})):
        errors.append("render style instructions do not match render styles")
    required_eras = {f"{decade}s" for decade in range(1940, 2030, 10)}
    if set(compiler.get("era_resolution", {}).get("supported_packets", [])) != required_eras:
        errors.append("surface era packets are incomplete")
    if set(compiler.get("era_packets", {})) != required_eras:
        errors.append("era packet payloads are incomplete")
    for era_id, era_packet in compiler.get("era_packets", {}).items():
        required_era_fields = {"visible_life", "technology_media", "transport_infrastructure", "guardrails"}
        if set(era_packet) != required_era_fields:
            errors.append(f"{era_id} era packet fields are incomplete")
    for manifestation_id in ("luminai", "daemon"):
        manifestation = compiler.get("manifestations", {}).get(manifestation_id, {})
        if manifestation.get("status") != "authoritative-visual-definition":
            errors.append(f"{manifestation_id} manifestation is not authoritative")
        if set(manifestation.get("concentration", [])) != {"head and brain", "chest"}:
            errors.append(f"{manifestation_id} manifestation concentration is incomplete")
        controls = manifestation.get("controls", {})
        for field in ("allowed_colors", "allowed_intensities", "allowed_reach", "allowed_particle_density", "coherence"):
            if not controls.get(field):
                errors.append(f"{manifestation_id} manifestation controls missing {field}")
    beach = compiler.get("environment_overlays", {}).get("coastal-public-beach", {})
    if beach.get("kind") != "generic-place-overlay" or not beach.get("visible_evidence"):
        errors.append("coastal-public-beach environment overlay is incomplete")
    workspace = compiler.get("scene_workspace", {})
    if workspace.get("schema_version") != 1:
        errors.append("scene workspace schema_version must be 1")
    if set(workspace.get("reference_roles", [])) != {"identity", "appearance", "wardrobe", "movement", "environment", "composition", "edit-source"}:
        errors.append("scene workspace reference roles are incomplete")
    required_feedback = {"identity", "apparent-age", "wardrobe", "action-anatomy", "expression", "environment", "manifestation", "camera", "lighting", "composition", "render-style", "canon-safety"}
    if set(workspace.get("feedback_categories", [])) != required_feedback:
        errors.append("scene workspace feedback categories are incomplete")
    rejuvenation = compiler.get("rejuvenation_system", {})
    if rejuvenation.get("status") != "authoritative-working-definition":
        errors.append("rejuvenation system is not defined")
    if len(rejuvenation.get("modalities", [])) < 2:
        errors.append("rejuvenation system modalities are incomplete")
    if registry.get("terminology", {}).get("human_ai_light_partner") != "Luminai":
        errors.append("current terminology must use Luminai")

    for char_id, character in registry.get("characters", {}).items():
        missing = REQUIRED_IDENTITY - set(character.get("identity_lock", {}))
        if missing:
            errors.append(f"{char_id} missing identity fields: {', '.join(sorted(missing))}")
        if not character.get("references"):
            errors.append(f"{char_id} has no reference images")
        if char_id == "sylvan-elaria" and character.get("wardrobe_profile", {}).get("status") != "authoritative-working-definition":
            errors.append("sylvan-elaria wardrobe profile is not defined")
        timeline = character.get("appearance_timeline", [])
        if not timeline:
            errors.append(f"{char_id} has no appearance timeline")
        for state in timeline:
            for field in ("role_id", "era_equivalent", "apparent_age", "rejuvenation_stage", "identity_reference"):
                if field not in state:
                    errors.append(f"{char_id} appearance state missing {field}")
            if not isinstance(state.get("renderable"), bool):
                errors.append(f"{char_id} appearance state must declare renderable")
        for ref in character.get("references", []):
            path = ROOT / ref["path"]
            if not path.is_file():
                errors.append(f"{char_id} missing reference: {ref['path']}")
                continue
            expected = ref.get("sha256")
            if expected and sha256(path) != expected:
                errors.append(f"{char_id} checksum mismatch: {ref['path']}")

    repository_root = ROOT.parents[1]
    graph = registry.get("visual_entity_graph", {})
    if graph.get("schema_version") != 1:
        errors.append("visual entity graph schema_version must be 1")
    node_types = set(graph.get("node_types", []))
    edge_types = set(graph.get("edge_types", []))
    allowed_statuses = set(graph.get("allowed_statuses", []))
    source_catalog = graph.get("source_catalog", {})
    graph_nodes = graph.get("nodes", {})
    for source_id, source in source_catalog.items():
        if source.get("source_class") not in graph.get("authority_order", []):
            errors.append(f"graph source {source_id} has unknown source_class")
        if source.get("location_type") == "vault-file":
            source_path = repository_root / source.get("location", "")
            if not source_path.is_file():
                errors.append(f"graph source {source_id} missing vault file: {source.get('location')}")
        elif source.get("location_type") != "external-url":
            errors.append(f"graph source {source_id} has unknown location_type")
    for node_id, node in graph_nodes.items():
        if node.get("type") not in node_types:
            errors.append(f"graph node {node_id} has unknown type")
        if node.get("status") not in allowed_statuses:
            errors.append(f"graph node {node_id} has unknown status")
        try:
            resolve_payload(registry, node.get("payload_ref", ""))
        except (KeyError, IndexError, ValueError):
            errors.append(f"graph node {node_id} has invalid payload_ref: {node.get('payload_ref')}")
        for source_id in node.get("source_refs", []):
            if source_id not in source_catalog:
                errors.append(f"graph node {node_id} references unknown source: {source_id}")
    for index, edge in enumerate(graph.get("edges", [])):
        if edge.get("type") not in edge_types:
            errors.append(f"graph edge {index} has unknown type")
        if edge.get("from") not in graph_nodes:
            errors.append(f"graph edge {index} has unknown from node")
        if edge.get("to") not in graph_nodes:
            errors.append(f"graph edge {index} has unknown to node")

    for sequence_id, sequence in registry.get("story_sequences", {}).items():
        frames = sequence.get("frames", [])
        orders = [frame.get("order") for frame in frames]
        if not frames:
            errors.append(f"{sequence_id} has no frames")
        if orders != list(range(1, len(frames) + 1)):
            errors.append(f"{sequence_id} frame order must be consecutive from 1")
        for frame in frames:
            for path_key, hash_key, base in (
                ("source_path", "source_sha256", ROOT),
                ("public_path", "public_sha256", repository_root),
            ):
                path = base / frame[path_key]
                if not path.is_file():
                    errors.append(f"{sequence_id} missing {path_key}: {frame[path_key]}")
                    continue
                expected = frame.get(hash_key)
                if expected and sha256(path) != expected:
                    errors.append(f"{sequence_id} checksum mismatch: {frame[path_key]}")

    if errors:
        for error in errors:
            print(f"ERROR: {error}")
        return 1
    print(f"OK: visual registry valid with {len(registry['characters'])} characters")
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
