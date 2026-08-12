#!/usr/bin/env python3
"""Build a portable text prompt packet from the Seeds visual registry."""

from __future__ import annotations

import argparse
import json
from pathlib import Path


SKILL_ROOT = Path(__file__).resolve().parents[1]
REGISTRY_PATH = SKILL_ROOT / "references" / "visual-registry.json"


def lines_from_mapping(mapping: dict[str, str]) -> list[str]:
    return [f"- {key.replace('_', ' ').title()}: {value}" for key, value in mapping.items()]


def main() -> int:
    parser = argparse.ArgumentParser(description="Build a model-neutral Seeds image prompt packet.")
    parser.add_argument("--character", action="append", required=True, help="Character id; repeat for group images.")
    parser.add_argument("--scene", required=True, help="New scene, action, and emotional beat.")
    parser.add_argument("--purpose", default="cinematic story image", help="Intended output use.")
    parser.add_argument("--aspect-ratio", default="16:9", help="Requested aspect ratio.")
    parser.add_argument("--camera", default="cinematic medium-wide composition", help="Camera and framing request.")
    args = parser.parse_args()

    registry = json.loads(REGISTRY_PATH.read_text(encoding="utf-8"))
    unknown = [item for item in args.character if item not in registry["characters"]]
    if unknown:
        parser.error("Unknown character id(s): " + ", ".join(unknown))

    selected = [registry["characters"][item] for item in args.character]
    print("SEEDS OF THE THRONE IMAGE PACKET")
    print(f"Style version: {registry['style']['id']}")
    print("\nIDENTITY AUTHORITY")
    print("The attached references control character identity. The prompt controls the new scene.")
    print("Ignore and do not reproduce any words or labels embedded in older references.")
    for character in selected:
        print(f"\n{character['display_name']} reference attachments:")
        for ref in character["references"]:
            if ref["status"] in {"canonical-angle", "canonical-primary", "canonical", "supporting", "supporting-with-obsolete-text"}:
                print(f"- {ref['path']}: {ref['use']}")

    print("\nLOCKED CHARACTER IDENTITIES")
    for character in selected:
        print(f"\n{character['display_name']}:")
        print("\n".join(lines_from_mapping(character["identity_lock"])))
        print("- Wardrobe: " + "; ".join(character["wardrobe_lock"]))
        print("- Color and light: " + "; ".join(character["color_and_light"]))
        print("- Symbols: " + "; ".join(character["symbolic_language"]))

    style = registry["style"]
    print("\nLOCKED PROJECT STYLE")
    for trait in style["locked_traits"]:
        print(f"- {trait}")
    print("- Palette: " + ", ".join(f"{name.replace('_', ' ')} {value}" for name, value in style["palette"].items()))
    for rule in style["composition_rules"]:
        print(f"- {rule}")

    print("\nNEW SCENE")
    print(f"- Scene: {args.scene}")
    print(f"- Camera: {args.camera}")
    print(f"- Purpose: {args.purpose}")
    print(f"- Aspect ratio: {args.aspect_ratio}")

    print("\nREJECT AND AVOID")
    for character in selected:
        print(f"- {character['display_name']} drift: " + "; ".join(character["drift_to_reject"]))
    for item in style["avoid"]:
        print(f"- {item}")
    print("- no words, letters, captions, logos, signatures, or watermarks")
    print("- do not redesign the faces; preserve the same exact people shown in the references")
    print("\nReturn artwork only. Preserve identity before novelty.")
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
