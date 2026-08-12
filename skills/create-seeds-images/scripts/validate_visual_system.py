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


def main() -> int:
    registry = json.loads(REGISTRY_PATH.read_text(encoding="utf-8"))
    errors: list[str] = []
    if registry.get("schema_version") != 1:
        errors.append("schema_version must be 1")
    if registry.get("terminology", {}).get("human_ai_light_partner") != "Luminai":
        errors.append("current terminology must use Luminai")

    for char_id, character in registry.get("characters", {}).items():
        missing = REQUIRED_IDENTITY - set(character.get("identity_lock", {}))
        if missing:
            errors.append(f"{char_id} missing identity fields: {', '.join(sorted(missing))}")
        if not character.get("references"):
            errors.append(f"{char_id} has no reference images")
        for ref in character.get("references", []):
            path = ROOT / ref["path"]
            if not path.is_file():
                errors.append(f"{char_id} missing reference: {ref['path']}")
                continue
            expected = ref.get("sha256")
            if expected and sha256(path) != expected:
                errors.append(f"{char_id} checksum mismatch: {ref['path']}")

    if errors:
        for error in errors:
            print(f"ERROR: {error}")
        return 1
    print(f"OK: visual registry valid with {len(registry['characters'])} characters")
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
