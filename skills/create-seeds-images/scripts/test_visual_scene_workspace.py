#!/usr/bin/env python3
"""End-to-end tests for the feedback-driven Visual World Compiler v2 workspace."""

from __future__ import annotations

import json
import subprocess
import sys
import tempfile
import unittest
from pathlib import Path


SCRIPT = Path(__file__).with_name("visual_scene_workspace.py")


class VisualSceneWorkspaceTests(unittest.TestCase):
    def setUp(self) -> None:
        self.temporary = tempfile.TemporaryDirectory()
        self.root = Path(self.temporary.name)
        self.candidate = self.root / "candidate.png"
        self.candidate.write_bytes(b"test candidate image bytes")

    def tearDown(self) -> None:
        self.temporary.cleanup()

    def run_workspace(self, *args: str) -> subprocess.CompletedProcess[str]:
        return subprocess.run(
            [sys.executable, str(SCRIPT), *args, "--workspace-root", str(self.root / "workspaces")],
            check=False,
            capture_output=True,
            text=True,
        )

    def create_beach_scene(self, scene_id: str = "sylvan-beach-running-v2") -> subprocess.CompletedProcess[str]:
        return self.run_workspace(
            "create",
            "--scene-id", scene_id,
            "--request", "Sylvan runs naturally along a public beach while his Luminai manifests in blue",
            "--character", "sylvan-elaria",
            "--birth-year", "1985",
            "--age", "40",
            "--location", "surface-civilization",
            "--environment-overlay", "coastal-public-beach",
            "--manifestation", "luminai",
            "--manifestation-color", "blue",
            "--manifestation-intensity", "moderate",
            "--manifestation-reach", "body-scale",
            "--manifestation-particle-density", "sparse",
            "--image-type", "narrative-scene",
            "--render-style", "cinematic-photorealism",
            "--composition", "NARRATIVE-CINEMA",
            "--camera", "natural low tracking camera, medium-wide",
        )

    def test_scene_card_resolves_character_beach_and_blue_luminai(self) -> None:
        result = self.create_beach_scene()
        self.assertEqual(result.returncode, 0, result.stderr)
        self.assertIn("Generation: READY", result.stdout)
        self.assertIn("surface-civilization + coastal-public-beach", result.stdout)
        self.assertIn("luminai; blue; moderate; body-scale", result.stdout)
        scene_dir = self.root / "workspaces" / "sylvan-beach-running-v2"
        scene = json.loads((scene_dir / "scene.json").read_text())
        self.assertEqual(scene["schema_version"], 2)
        self.assertEqual(scene["resolution"]["appearances"][0]["role_id"], "sylvan-modern")
        self.assertEqual(scene["resolution"]["manifestation"]["color"], "blue")
        self.assertGreaterEqual(len(scene["reference_assignments"]), 3)
        packet = (scene_dir / "renderer-packet.txt").read_text()
        self.assertIn("environment overlay: coastal-public-beach", packet)
        self.assertIn("color=blue; intensity=moderate; reach=body-scale; particle_density=sparse", packet)
        self.assertIn("never random lightning or a separate figure", packet)

    def test_feedback_locks_passes_and_structural_changes_regenerate(self) -> None:
        self.assertEqual(self.create_beach_scene().returncode, 0)
        added = self.run_workspace(
            "add-candidate",
            "--scene-id", "sylvan-beach-running-v2",
            "--image", str(self.candidate),
        )
        self.assertEqual(added.returncode, 0, added.stderr)
        reviewed = self.run_workspace(
            "review",
            "--scene-id", "sylvan-beach-running-v2",
            "--candidate-id", "candidate-001",
            "--feedback",
            "Keep Sylvan identity, the natural beach light, and the ordinary contemporary clothing. Change the standing pose into a natural running stride, use a lower tracking camera, make the energy clearly blue and tighter around his head and chest, with fewer sparks.",
        )
        self.assertEqual(reviewed.returncode, 0, reviewed.stderr)
        self.assertIn("Preserve: environment, identity, lighting, wardrobe", reviewed.stdout)
        self.assertIn("Change: action-anatomy, camera, manifestation", reviewed.stdout)
        revised = self.run_workspace("revise", "--scene-id", "sylvan-beach-running-v2")
        self.assertEqual(revised.returncode, 0, revised.stderr)
        self.assertIn("Method: regenerate", revised.stdout)
        scene_dir = self.root / "workspaces" / "sylvan-beach-running-v2"
        revision = json.loads((scene_dir / "revisions" / "revision-001.json").read_text())
        self.assertEqual(revision["method"], "regenerate")
        self.assertEqual(revision["preserve_categories"], ["environment", "identity", "lighting", "wardrobe"])
        self.assertEqual(set(revision["change_directives"]), {"action-anatomy", "camera", "manifestation"})
        directive = (scene_dir / "revisions" / "revision-001-renderer-directive.txt").read_text()
        self.assertNotIn("FEEDBACK RECEIPT", directive)
        self.assertNotIn("is right", directive)
        self.assertIn("identity images control identity", directive)

    def test_local_manifestation_change_uses_edit(self) -> None:
        self.assertEqual(self.create_beach_scene("sylvan-energy-edit").returncode, 0)
        self.assertEqual(
            self.run_workspace(
                "add-candidate",
                "--scene-id", "sylvan-energy-edit",
                "--image", str(self.candidate),
            ).returncode,
            0,
        )
        review = self.run_workspace(
            "review",
            "--scene-id", "sylvan-energy-edit",
            "--candidate-id", "candidate-001",
            "--feedback", "Keep the face and beach. Make the Luminai glow less intense with fewer sparks.",
        )
        self.assertEqual(review.returncode, 0, review.stderr)
        revision = self.run_workspace("revise", "--scene-id", "sylvan-energy-edit")
        self.assertEqual(revision.returncode, 0, revision.stderr)
        self.assertIn("Method: edit", revision.stdout)

    def test_scene_local_review_never_promotes_canon(self) -> None:
        self.assertEqual(self.create_beach_scene("sylvan-scene-local").returncode, 0)
        self.assertEqual(
            self.run_workspace(
                "add-candidate",
                "--scene-id", "sylvan-scene-local",
                "--image", str(self.candidate),
            ).returncode,
            0,
        )
        review = self.run_workspace(
            "review",
            "--scene-id", "sylvan-scene-local",
            "--candidate-id", "candidate-001",
            "--feedback", "Keep the face. Make the blue energy more coherent.",
            "--promotion", "scene-local",
        )
        self.assertEqual(review.returncode, 0, review.stderr)
        record = json.loads((self.root / "workspaces" / "sylvan-scene-local" / "reviews" / "review-001.json").read_text())
        self.assertEqual(record["canon_effect"], "none")

    def test_candidate_records_scene_and_packet_provenance(self) -> None:
        self.assertEqual(self.create_beach_scene("sylvan-provenance").returncode, 0)
        result = self.run_workspace(
            "add-candidate",
            "--scene-id", "sylvan-provenance",
            "--image", str(self.candidate),
        )
        self.assertEqual(result.returncode, 0, result.stderr)
        record = json.loads((self.root / "workspaces" / "sylvan-provenance" / "candidates" / "candidate-001.json").read_text())
        self.assertEqual(record["renderer"], "openai/gpt-image-2")
        self.assertEqual(len(record["source_state"]["scene_sha256"]), 64)
        self.assertEqual(len(record["source_state"]["base_renderer_packet_sha256"]), 64)


if __name__ == "__main__":
    unittest.main()
