#!/usr/bin/env python3
"""Create and revise persistent, feedback-driven Seeds visual scene workspaces."""

from __future__ import annotations

import argparse
import hashlib
import json
import re
import subprocess
import sys
from datetime import datetime, timezone
from pathlib import Path


SKILL_ROOT = Path(__file__).resolve().parents[1]
REPOSITORY_ROOT = SKILL_ROOT.parents[1]
REGISTRY_PATH = SKILL_ROOT / "references" / "visual-registry.json"
PACKET_COMPILER = Path(__file__).with_name("build_prompt_packet.py")
DEFAULT_WORKSPACE_ROOT = REPOSITORY_ROOT / ".visual-workspaces"
SCENE_ID_RE = re.compile(r"^[a-z0-9][a-z0-9-]{2,79}$")

REFERENCE_ROLES = {
    "identity",
    "appearance",
    "wardrobe",
    "movement",
    "environment",
    "composition",
    "edit-source",
}
FEEDBACK_CATEGORIES = {
    "identity": ("face", "identity", "same person", "facial"),
    "apparent-age": ("age", "older", "younger", "rejuvenation"),
    "wardrobe": ("clothing", "clothes", "wardrobe", "coat", "shirt", "pants", "shoes"),
    "action-anatomy": ("stride", "running", "run", "walking", "pose", "anatomy", "hands", "legs", "movement"),
    "expression": ("expression", "gaze", "emotion", "smile", "eyes"),
    "environment": ("beach", "background", "environment", "shore", "ocean", "setting", "location"),
    "manifestation": ("energy", "luminai", "daemon", "glow", "sparks", "head", "chest", "blue", "gold", "crimson"),
    "camera": ("camera", "lens", "angle", "shot", "crop", "lower", "higher"),
    "lighting": ("light", "lighting", "sunset", "dawn", "exposure", "shadow"),
    "composition": ("composition", "framing", "foreground", "off-center", "centered"),
    "render-style": ("style", "photoreal", "painterly", "cinematic", "documentary"),
    "canon-safety": ("canon", "invented", "unsupported", "contradiction"),
}
KEEP_CUES = ("keep", "preserve", "is right", "looks right", "i like", "love", "works", "do not change", "don't change")
CHANGE_CUES = ("make", "change", "fix", "more", "less", "fewer", "wrong", "instead", "remove", "add", "lower", "raise", "tighter")
STRUCTURAL_REGENERATION = {"identity", "apparent-age", "action-anatomy", "environment", "camera", "composition"}


def timestamp() -> str:
    return datetime.now(timezone.utc).replace(microsecond=0).isoformat()


def sha256(path: Path) -> str:
    digest = hashlib.sha256()
    with path.open("rb") as handle:
        for chunk in iter(lambda: handle.read(1024 * 1024), b""):
            digest.update(chunk)
    return digest.hexdigest()


def load_json(path: Path) -> dict:
    return json.loads(path.read_text(encoding="utf-8"))


def write_json(path: Path, value: dict) -> None:
    path.parent.mkdir(parents=True, exist_ok=True)
    temporary = path.with_suffix(path.suffix + ".tmp")
    temporary.write_text(json.dumps(value, indent=2, ensure_ascii=False) + "\n", encoding="utf-8")
    temporary.replace(path)


def workspace_root(value: str | None) -> Path:
    return Path(value).expanduser().resolve() if value else DEFAULT_WORKSPACE_ROOT


def scene_directory(root: Path, scene_id: str) -> Path:
    if SCENE_ID_RE.fullmatch(scene_id) is None:
        raise ValueError("scene id must use 3-80 lowercase letters, numbers, and hyphens")
    return root / scene_id


def scene_path(root: Path, scene_id: str) -> Path:
    return scene_directory(root, scene_id) / "scene.json"


def load_scene(root: Path, scene_id: str) -> tuple[Path, dict]:
    directory = scene_directory(root, scene_id)
    path = directory / "scene.json"
    if not path.is_file():
        raise FileNotFoundError(f"scene workspace does not exist: {path}")
    return directory, load_json(path)


def parse_reference(value: str) -> dict:
    if "=" not in value:
        raise ValueError("reference must be ROLE=PATH")
    role, raw_path = value.split("=", 1)
    if role not in REFERENCE_ROLES:
        raise ValueError(f"reference role must be one of: {', '.join(sorted(REFERENCE_ROLES))}")
    path = Path(raw_path).expanduser().resolve()
    if not path.is_file():
        raise FileNotFoundError(f"reference image does not exist: {path}")
    return {
        "role": role,
        "path": str(path),
        "sha256": sha256(path),
        "authority": "author-supplied-scene-reference",
        "scope": "scene-only unless explicitly promoted",
    }


def registry_references(registry: dict, character_ids: list[str]) -> list[dict]:
    assignments: list[dict] = []
    for character_id in character_ids:
        character = registry["characters"][character_id]
        for reference in character["references"]:
            status = reference["status"]
            if status not in {"canonical-angle", "canonical-primary", "canonical"}:
                continue
            path = (SKILL_ROOT / reference["path"]).resolve()
            assignments.append(
                {
                    "role": "identity",
                    "character_id": character_id,
                    "path": str(path),
                    "sha256": reference.get("sha256") or sha256(path),
                    "authority": status,
                    "scope": "identity geometry only",
                }
            )
    return assignments


def normalized_era(value: str) -> str:
    return value.lower().replace("-equivalent", "").replace(" ", "")


def resolve_scene(args: argparse.Namespace, registry: dict) -> tuple[dict, list[str]]:
    compiler = registry["compiler"]
    missing: list[str] = []
    if args.era:
        era = args.era
        era_source = "explicit"
    elif args.birth_year is not None and args.age is not None:
        year = args.birth_year + args.age
        era = f"{(year // 10) * 10}s"
        era_source = "birth-year-plus-age"
    else:
        era = None
        era_source = "missing"
        missing.append("era: provide an explicit era or birth year plus chronological age")

    if era and normalized_era(era) not in compiler["era_resolution"]["supported_packets"]:
        missing.append(f"era packet '{era}' is not defined")
    environment = compiler["environment_masters"].get(args.location)
    if not environment:
        missing.append(f"environment master '{args.location}' is not defined")
    elif environment.get("status") == "required-definition":
        missing.append(f"environment master '{args.location}' requires definition")

    overlays: list[dict] = []
    for overlay_id in args.environment_overlay:
        overlay = compiler.get("environment_overlays", {}).get(overlay_id)
        if not overlay:
            missing.append(f"environment overlay '{overlay_id}' is not defined")
        else:
            overlays.append({"id": overlay_id, **overlay})

    appearances: list[dict] = []
    for character_id in args.character:
        character = registry["characters"].get(character_id)
        if not character:
            missing.append(f"character '{character_id}' is not defined")
            continue
        timeline = character.get("appearance_timeline", [])
        state = None
        if args.role:
            state = next((item for item in timeline if item["role_id"] == args.role), None)
        elif era:
            target = normalized_era(era)
            candidates = [item for item in timeline if target in normalized_era(item["era_equivalent"])]
            if len(candidates) == 1:
                state = candidates[0]
        if state is None and len(timeline) == 1:
            state = timeline[0]
        if state is None:
            missing.append(f"appearance state for {character['display_name']} at {args.role or era} is not defined")
        elif state.get("renderable") is not True:
            missing.append(f"appearance state '{state['role_id']}' is not renderable")
        else:
            appearances.append(
                {
                    "character_id": character_id,
                    "display_name": character["display_name"],
                    "role_id": state["role_id"],
                    "era_equivalent": state["era_equivalent"],
                    "apparent_age": state["apparent_age"],
                    "rejuvenation_stage": state["rejuvenation_stage"],
                }
            )

    manifestation_id = args.manifestation
    manifestation = None if manifestation_id == "none" else compiler["manifestations"].get(manifestation_id)
    manifestation_resolution = None
    if manifestation_id != "none" and not manifestation:
        missing.append(f"manifestation '{manifestation_id}' is not defined")
    elif manifestation:
        controls = manifestation["controls"]
        values = {
            "color": args.manifestation_color or controls["default_color"],
            "intensity": args.manifestation_intensity or controls["default_intensity"],
            "reach": args.manifestation_reach or controls["default_reach"],
            "particle_density": args.manifestation_particle_density or controls["default_particle_density"],
        }
        allowed = {
            "color": controls["allowed_colors"],
            "intensity": controls["allowed_intensities"],
            "reach": controls["allowed_reach"],
            "particle_density": controls["allowed_particle_density"],
        }
        for field, value in values.items():
            if value not in allowed[field]:
                missing.append(f"manifestation {field} '{value}' is not approved for {manifestation_id}")
        manifestation_resolution = {
            "id": manifestation_id,
            "form": manifestation["form"],
            "concentration": manifestation["concentration"],
            "behavior": manifestation["behavior"],
            "coherence": controls["coherence"],
            **values,
            "observer_status": "unresolved; visual-production representation only",
        }

    return {
        "era": {"value": era, "source": era_source},
        "appearances": appearances,
        "environment_master": {"id": args.location, **(environment or {})},
        "environment_overlays": overlays,
        "manifestation": manifestation_resolution,
        "surface_layer": args.surface_layer,
        "advanced_colony_visibility": args.advanced_colony_visibility,
    }, missing


def compile_packet(args: argparse.Namespace) -> subprocess.CompletedProcess[str]:
    command = [
        sys.executable,
        str(PACKET_COMPILER),
        "--scene", args.request,
        "--image-type", args.image_type,
        "--render-style", args.render_style,
        "--composition", args.composition,
        "--aspect-ratio", args.aspect_ratio,
        "--camera", args.camera,
        "--location", args.location,
        "--surface-layer", args.surface_layer,
        "--advanced-colony-visibility", args.advanced_colony_visibility,
        "--manifestation", args.manifestation,
        "--trace",
    ]
    for character_id in args.character:
        command.extend(["--character", character_id])
    for overlay_id in args.environment_overlay:
        command.extend(["--environment-overlay", overlay_id])
    if args.era:
        command.extend(["--era", args.era])
    if args.birth_year is not None:
        command.extend(["--birth-year", str(args.birth_year)])
    if args.age is not None:
        command.extend(["--age", str(args.age)])
    if args.role:
        command.extend(["--role", args.role])
    for option, value in (
        ("--manifestation-color", args.manifestation_color),
        ("--manifestation-intensity", args.manifestation_intensity),
        ("--manifestation-reach", args.manifestation_reach),
        ("--manifestation-particle-density", args.manifestation_particle_density),
    ):
        if value:
            command.extend([option, value])
    return subprocess.run(command, check=False, capture_output=True, text=True)


def print_preflight(scene: dict) -> None:
    resolution = scene["resolution"]
    print(f"SCENE CARD: {scene['scene_id']}")
    print(f"Status: {scene['status']}")
    print(f"Request: {scene['request']}")
    print("Characters: " + ", ".join(item["display_name"] for item in resolution["appearances"]))
    print(f"Era: {resolution['era']['value']} ({resolution['era']['source']})")
    print("Apparent age: " + "; ".join(f"{item['display_name']}={item['apparent_age']}" for item in resolution["appearances"]))
    overlays = resolution["environment_overlays"]
    environment_text = resolution["environment_master"]["id"]
    if overlays:
        environment_text += " + " + " + ".join(item["id"] for item in overlays)
    print(f"Environment: {environment_text}")
    manifestation = resolution["manifestation"]
    if manifestation:
        print(
            "Manifestation: "
            f"{manifestation['id']}; {manifestation['color']}; {manifestation['intensity']}; "
            f"{manifestation['reach']}; particles={manifestation['particle_density']}; "
            f"concentrated at {', '.join(manifestation['concentration'])}"
        )
    else:
        print("Manifestation: none")
    print(f"Image: {scene['image_type']} / {scene['render_style']} / {scene['composition_mode']}")
    print(f"References: {len(scene['reference_assignments'])} assigned by role")
    if scene["missing_definitions"]:
        print("Generation: BLOCKED")
        for item in scene["missing_definitions"]:
            print(f"- {item}")
    else:
        print("Generation: READY (candidate only; no canon promotion)")


def command_create(args: argparse.Namespace) -> int:
    registry = load_json(REGISTRY_PATH)
    root = workspace_root(args.workspace_root)
    directory = scene_directory(root, args.scene_id)
    if directory.exists():
        raise FileExistsError(f"scene workspace already exists: {directory}")
    resolution, missing = resolve_scene(args, registry)
    assignments = registry_references(registry, args.character)
    assignments.extend(parse_reference(value) for value in args.reference)
    now = timestamp()
    scene = {
        "schema_version": 2,
        "record_type": "visual-scene-workspace",
        "scene_id": args.scene_id,
        "created": now,
        "updated": now,
        "status": "blocked" if missing else "ready",
        "request": args.request,
        "purpose": args.purpose,
        "image_type": args.image_type,
        "render_style": args.render_style,
        "composition_mode": args.composition,
        "camera": args.camera,
        "aspect_ratio": args.aspect_ratio,
        "resolution": resolution,
        "reference_assignments": assignments,
        "revision_locks": {},
        "missing_definitions": missing,
        "candidate_ids": [],
        "review_ids": [],
        "revision_ids": [],
        "promotion_state": "none",
        "canon_effect": "none",
    }
    directory.mkdir(parents=True)
    write_json(directory / "scene.json", scene)
    packet = compile_packet(args)
    (directory / "renderer-packet.txt").write_text(packet.stdout, encoding="utf-8")
    (directory / "source-trace.txt").write_text(packet.stderr, encoding="utf-8")
    if packet.returncode != 0 and not missing:
        scene["status"] = "blocked"
        scene["missing_definitions"].append("base packet compiler rejected the scene; inspect renderer-packet.txt")
        write_json(directory / "scene.json", scene)
    print_preflight(scene)
    print(f"Workspace: {directory}")
    return 0 if scene["status"] == "ready" else 2


def command_show(args: argparse.Namespace) -> int:
    _directory, scene = load_scene(workspace_root(args.workspace_root), args.scene_id)
    print_preflight(scene)
    if scene["revision_locks"]:
        print("Revision locks: " + ", ".join(sorted(scene["revision_locks"])))
    print(f"Candidates: {len(scene['candidate_ids'])}; reviews: {len(scene['review_ids'])}; revisions: {len(scene['revision_ids'])}")
    return 0


def next_id(existing: list[str], prefix: str) -> str:
    return f"{prefix}-{len(existing) + 1:03d}"


def command_add_candidate(args: argparse.Namespace) -> int:
    root = workspace_root(args.workspace_root)
    directory, scene = load_scene(root, args.scene_id)
    image_path = Path(args.image).expanduser().resolve()
    if not image_path.is_file():
        raise FileNotFoundError(f"candidate image does not exist: {image_path}")
    candidate_id = args.candidate_id or next_id(scene["candidate_ids"], "candidate")
    target = directory / "candidates" / f"{candidate_id}.json"
    if target.exists() or candidate_id in scene["candidate_ids"]:
        raise FileExistsError(f"candidate already exists: {candidate_id}")
    revision_path = None
    if args.revision_id:
        revision_path = directory / "revisions" / f"{args.revision_id}.json"
        if not revision_path.is_file():
            raise FileNotFoundError(f"revision does not exist: {args.revision_id}")
    packet_path = directory / "renderer-packet.txt"
    record = {
        "schema_version": 1,
        "record_type": "visual-candidate",
        "candidate_id": candidate_id,
        "scene_id": args.scene_id,
        "created": timestamp(),
        "image_path": str(image_path),
        "image_sha256": sha256(image_path),
        "parent_candidate_id": args.parent_candidate,
        "source_revision_id": args.revision_id,
        "generation_route": args.generation_route,
        "renderer": args.renderer,
        "source_state": {
            "scene_sha256": sha256(directory / "scene.json"),
            "base_renderer_packet_path": str(packet_path),
            "base_renderer_packet_sha256": sha256(packet_path),
            "revision_record_path": str(revision_path) if revision_path else None,
            "revision_record_sha256": sha256(revision_path) if revision_path else None,
        },
        "status": "candidate",
        "canon_effect": "none",
    }
    write_json(target, record)
    scene["candidate_ids"].append(candidate_id)
    scene["updated"] = timestamp()
    write_json(directory / "scene.json", scene)
    print(f"Registered {candidate_id}: {image_path}")
    return 0


def feedback_scope(text: str) -> str:
    lowered = text.lower()
    if any(value in lowered for value in ("every scene", "all scenes", "always for this character", "character default")):
        return "character"
    if any(value in lowered for value in ("world rule", "everywhere", "all luminai", "all daemon")):
        return "world-system"
    if any(value in lowered for value in ("this candidate", "this image only")):
        return "candidate"
    return "scene"


def parse_feedback(text: str, explicit_keep: list[str], explicit_change: list[str]) -> dict:
    keep: dict[str, list[str]] = {category: [] for category in explicit_keep}
    change: dict[str, list[str]] = {category: [] for category in explicit_change}
    sentences = [value.strip() for value in re.split(r"(?<=[.!?])\s+", text) if value.strip()]
    for sentence in sentences:
        sentence_lowered = sentence.lower()
        sentence_keep = any(cue in sentence_lowered for cue in KEEP_CUES)
        sentence_change = any(cue in sentence_lowered for cue in CHANGE_CUES)
        segments = [value.strip() for value in re.split(r",\s+", sentence) if value.strip()]
        inherited_destination = keep if sentence_keep and not sentence_change else change
        for segment in segments:
            lowered = segment.lower()
            categories = [category for category, terms in FEEDBACK_CATEGORIES.items() if any(term in lowered for term in terms)]
            if not categories:
                continue
            has_keep = any(cue in lowered for cue in KEEP_CUES)
            has_change = any(cue in lowered for cue in CHANGE_CUES)
            if has_keep and not has_change:
                destination = keep
            elif has_change and not has_keep:
                destination = change
            else:
                destination = inherited_destination
            for category in categories:
                destination.setdefault(category, []).append(segment)
    return {
        "scope": feedback_scope(text),
        "preserve": keep,
        "change": change,
        "unclassified": [] if keep or change else [text],
    }


def command_review(args: argparse.Namespace) -> int:
    root = workspace_root(args.workspace_root)
    directory, scene = load_scene(root, args.scene_id)
    if args.candidate_id not in scene["candidate_ids"]:
        raise ValueError(f"candidate is not registered in scene: {args.candidate_id}")
    valid_categories = set(load_json(REGISTRY_PATH)["compiler"]["scene_workspace"]["feedback_categories"])
    invalid = (set(args.keep) | set(args.change)) - valid_categories
    if invalid:
        raise ValueError("unknown feedback categories: " + ", ".join(sorted(invalid)))
    parsed = parse_feedback(args.feedback, args.keep, args.change)
    review_id = next_id(scene["review_ids"], "review")
    record = {
        "schema_version": 1,
        "record_type": "visual-review",
        "review_id": review_id,
        "scene_id": args.scene_id,
        "candidate_id": args.candidate_id,
        "created": timestamp(),
        "author_feedback": args.feedback,
        "parsed_feedback": parsed,
        "promotion_state": args.promotion,
        "canon_effect": "none" if args.promotion in {"none", "scene-local", "reusable-guidance", "approved-reference"} else "requires-separate-author-decision",
    }
    write_json(directory / "reviews" / f"{review_id}.json", record)
    scene["review_ids"].append(review_id)
    for category, evidence in parsed["preserve"].items():
        scene["revision_locks"][category] = {
            "source_candidate_id": args.candidate_id,
            "review_id": review_id,
            "evidence": evidence,
            "scope": parsed["scope"],
        }
    for category in parsed["change"]:
        scene["revision_locks"].pop(category, None)
    scene["updated"] = timestamp()
    write_json(directory / "scene.json", scene)
    print(f"FEEDBACK RECEIPT: {review_id}")
    print("Preserve: " + (", ".join(sorted(parsed["preserve"])) or "none identified"))
    print("Change: " + (", ".join(sorted(parsed["change"])) or "none identified"))
    print(f"Scope: {parsed['scope']}")
    print(f"Promotion: {args.promotion}; canon effect: {record['canon_effect']}")
    return 0


def clean_direction(category: str, evidence: list[str]) -> str:
    defaults = {
        "identity": "Re-establish the character from the authoritative identity references; do not inherit facial geometry from the candidate.",
        "apparent-age": "Use the resolved apparent-age state from the scene record.",
        "action-anatomy": "Create convincing weight-bearing anatomy and an unstaged moment in progress.",
        "environment": "Rebuild the environment from the resolved master and overlays.",
        "camera": "Recompose the camera according to the current scene direction.",
        "composition": "Rebuild the composition while preserving only explicitly locked properties.",
        "manifestation": "Render the resolved embodied manifestation controls, continuous with the person and concentrated at the head and chest.",
    }
    safe = []
    for item in evidence:
        value = re.sub(r"\b(wrong|failed|failure|bad|fix|don't like|do not like)\b", "", item, flags=re.IGNORECASE)
        value = re.sub(r"\s+", " ", value).strip(" .")
        if value:
            safe.append(value)
    if category in defaults:
        return defaults[category] + ((" Author direction: " + "; ".join(safe)) if safe else "")
    return ("Author direction: " + "; ".join(safe)) if safe else f"Regenerate the {category} layer from the scene record."


def command_revise(args: argparse.Namespace) -> int:
    root = workspace_root(args.workspace_root)
    directory, scene = load_scene(root, args.scene_id)
    if not scene["review_ids"]:
        raise ValueError("scene has no review to revise from")
    review_id = args.review_id or scene["review_ids"][-1]
    review_path = directory / "reviews" / f"{review_id}.json"
    if not review_path.is_file():
        raise FileNotFoundError(f"review does not exist: {review_id}")
    review = load_json(review_path)
    changes = review["parsed_feedback"]["change"]
    if not changes:
        raise ValueError("review contains no requested changes")
    candidate_id = review["candidate_id"]
    candidate = load_json(directory / "candidates" / f"{candidate_id}.json")
    method = "regenerate" if STRUCTURAL_REGENERATION.intersection(changes) else "edit"
    revision_id = next_id(scene["revision_ids"], "revision")
    locked = sorted(scene["revision_locks"])
    clean_changes = {category: clean_direction(category, evidence) for category, evidence in changes.items()}
    reference_assignments = list(scene["reference_assignments"])
    reference_assignments.append(
        {
            "role": "edit-source" if method == "edit" else "composition",
            "path": candidate["image_path"],
            "sha256": candidate["image_sha256"],
            "authority": "candidate",
            "scope": "preserve only reviewed and locked properties; never identity or canon authority",
        }
    )
    record = {
        "schema_version": 1,
        "record_type": "visual-revision",
        "revision_id": revision_id,
        "scene_id": args.scene_id,
        "source_candidate_id": candidate_id,
        "source_review_id": review_id,
        "created": timestamp(),
        "method": method,
        "preserve_categories": locked,
        "change_directives": clean_changes,
        "reference_assignments": reference_assignments,
        "generation_intent": "edit" if method == "edit" else "new-with-references",
        "canon_effect": "none",
    }
    write_json(directory / "revisions" / f"{revision_id}.json", record)
    lines = [
        "SEEDS OF THE THRONE CLEAN REVISION DIRECTIVE",
        f"Scene: {scene['request']}",
        f"Revision method: {method}",
        "Preserve from the reviewed candidate: " + (", ".join(locked) if locked else "no candidate properties; use authoritative scene references"),
        "Requested visible changes:",
    ]
    lines.extend(f"- {category}: {direction}" for category, direction in clean_changes.items())
    lines.extend(
        [
            "Reference rule: identity images control identity; the candidate controls only explicitly preserved scene properties.",
            "Canon rule: this revision is a candidate and establishes no story or visual canon.",
            "Context rule: do not include scores, failure tags, review metadata, or author-evaluation language in the image.",
        ]
    )
    (directory / "revisions" / f"{revision_id}-renderer-directive.txt").write_text("\n".join(lines) + "\n", encoding="utf-8")
    scene["revision_ids"].append(revision_id)
    scene["updated"] = timestamp()
    write_json(directory / "scene.json", scene)
    print(f"REVISION PLAN: {revision_id}")
    print(f"Method: {method}")
    print("Preserve: " + (", ".join(locked) if locked else "authoritative references only"))
    print("Change: " + ", ".join(sorted(changes)))
    print(f"Renderer directive: {directory / 'revisions' / f'{revision_id}-renderer-directive.txt'}")
    return 0


def add_shared_options(parser: argparse.ArgumentParser) -> None:
    parser.add_argument("--workspace-root", help="Override the ignored local workspace root")


def build_parser() -> argparse.ArgumentParser:
    parser = argparse.ArgumentParser(description="Manage feedback-driven Seeds visual scene workspaces.")
    subparsers = parser.add_subparsers(dest="command", required=True)

    create = subparsers.add_parser("create", help="Resolve and store a new scene workspace")
    add_shared_options(create)
    create.add_argument("--scene-id", required=True)
    create.add_argument("--request", required=True)
    create.add_argument("--character", action="append", required=True)
    create.add_argument("--purpose", default="cinematic story image")
    create.add_argument("--image-type", default="narrative-scene")
    create.add_argument("--render-style", default="cinematic-photorealism")
    create.add_argument("--composition", default="NARRATIVE-CINEMA")
    create.add_argument("--camera", default="cinematic medium-wide composition")
    create.add_argument("--aspect-ratio", default="16:9")
    create.add_argument("--era")
    create.add_argument("--birth-year", type=int)
    create.add_argument("--age", type=int)
    create.add_argument("--role")
    create.add_argument("--location", default="surface-civilization")
    create.add_argument("--environment-overlay", action="append", default=[])
    create.add_argument("--surface-layer", default="ordinary")
    create.add_argument("--advanced-colony-visibility", default="none")
    create.add_argument("--manifestation", choices=("none", "luminai", "daemon"), default="none")
    create.add_argument("--manifestation-color")
    create.add_argument("--manifestation-intensity", choices=("subtle", "moderate", "strong"))
    create.add_argument("--manifestation-reach", choices=("skin-close", "body-scale", "extended"))
    create.add_argument("--manifestation-particle-density", choices=("none", "sparse", "moderate"))
    create.add_argument("--reference", action="append", default=[], help="Add ROLE=PATH scene reference")
    create.set_defaults(func=command_create)

    show = subparsers.add_parser("show", help="Show a compact scene card")
    add_shared_options(show)
    show.add_argument("--scene-id", required=True)
    show.set_defaults(func=command_show)

    candidate = subparsers.add_parser("add-candidate", help="Register an external candidate without copying it into Git")
    add_shared_options(candidate)
    candidate.add_argument("--scene-id", required=True)
    candidate.add_argument("--candidate-id")
    candidate.add_argument("--image", required=True)
    candidate.add_argument("--parent-candidate")
    candidate.add_argument("--revision-id")
    candidate.add_argument("--generation-route", default="in-app-tool")
    candidate.add_argument("--renderer", default="openai/gpt-image-2")
    candidate.set_defaults(func=command_add_candidate)

    review = subparsers.add_parser("review", help="Record author feedback and revision locks")
    add_shared_options(review)
    review.add_argument("--scene-id", required=True)
    review.add_argument("--candidate-id", required=True)
    review.add_argument("--feedback", required=True)
    review.add_argument("--keep", action="append", default=[])
    review.add_argument("--change", action="append", default=[])
    review.add_argument(
        "--promotion",
        choices=("none", "scene-local", "reusable-guidance", "approved-reference", "proposed-world-definition", "canon-decision"),
        default="none",
    )
    review.set_defaults(func=command_review)

    revise = subparsers.add_parser("revise", help="Compile the latest feedback into a clean revision directive")
    add_shared_options(revise)
    revise.add_argument("--scene-id", required=True)
    revise.add_argument("--review-id")
    revise.set_defaults(func=command_revise)
    return parser


def main() -> int:
    parser = build_parser()
    args = parser.parse_args()
    try:
        return args.func(args)
    except (FileExistsError, FileNotFoundError, KeyError, ValueError, json.JSONDecodeError) as error:
        parser.error(str(error))
    return 2


if __name__ == "__main__":
    raise SystemExit(main())
