#!/usr/bin/env python3
"""Store an approved source image and build a compressed public WebP derivative."""

from __future__ import annotations

import argparse
import hashlib
import json
import shutil
import subprocess
from pathlib import Path


SKILL_ROOT = Path(__file__).resolve().parents[1]
REPOSITORY_ROOT = SKILL_ROOT.parents[1]


def sha256(path: Path) -> str:
    digest = hashlib.sha256()
    with path.open("rb") as handle:
        for chunk in iter(lambda: handle.read(1024 * 1024), b""):
            digest.update(chunk)
    return digest.hexdigest()


def dimensions(path: Path) -> str:
    identify = shutil.which("magick")
    if identify:
        result = subprocess.run(
            [identify, "identify", "-format", "%wx%h", str(path)],
            check=True,
            capture_output=True,
            text=True,
        )
        return result.stdout.strip()
    sips = shutil.which("sips")
    if sips:
        result = subprocess.run(
            [sips, "-g", "pixelWidth", "-g", "pixelHeight", str(path)],
            check=True,
            capture_output=True,
            text=True,
        )
        values = {}
        for line in result.stdout.splitlines():
            if ":" in line:
                key, value = line.strip().split(":", 1)
                values[key] = value.strip()
        return f"{values['pixelWidth']}x{values['pixelHeight']}"
    return "unknown"


def main() -> int:
    parser = argparse.ArgumentParser()
    parser.add_argument("--source", type=Path, required=True)
    parser.add_argument("--character", required=True)
    parser.add_argument("--slug", required=True, help="Stable filename without extension")
    parser.add_argument("--quality", type=int, default=82)
    args = parser.parse_args()

    source = args.source.expanduser().resolve()
    if not source.is_file():
        parser.error(f"source does not exist: {source}")
    if not 1 <= args.quality <= 100:
        parser.error("quality must be between 1 and 100")

    cwebp = shutil.which("cwebp")
    if not cwebp:
        parser.error("cwebp is required to create the public derivative")

    source_dir = SKILL_ROOT / "assets" / "approved-images" / args.character
    public_dir = REPOSITORY_ROOT / "docs" / "assets" / "images"
    source_dir.mkdir(parents=True, exist_ok=True)
    public_dir.mkdir(parents=True, exist_ok=True)

    approved = source_dir / f"{args.slug}{source.suffix.lower()}"
    public = public_dir / f"{args.slug}.webp"
    for destination in (approved, public):
        if destination.exists():
            parser.error(f"refusing to overwrite: {destination}")

    shutil.copy2(source, approved)
    try:
        subprocess.run(
            [cwebp, "-quiet", "-q", str(args.quality), "-m", "6", "-metadata", "none", str(approved), "-o", str(public)],
            check=True,
        )
    except Exception:
        approved.unlink(missing_ok=True)
        public.unlink(missing_ok=True)
        raise

    metadata = {
        "source_path": str(approved.relative_to(SKILL_ROOT)),
        "public_path": str(public.relative_to(REPOSITORY_ROOT)),
        "dimensions": dimensions(approved),
        "source_bytes": approved.stat().st_size,
        "public_bytes": public.stat().st_size,
        "source_sha256": sha256(approved),
        "public_sha256": sha256(public),
        "webp_quality": args.quality,
    }
    print(json.dumps(metadata, indent=2))
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
