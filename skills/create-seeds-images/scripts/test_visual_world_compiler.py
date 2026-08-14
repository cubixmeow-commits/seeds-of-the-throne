#!/usr/bin/env python3
"""Regression tests for the Seeds Visual World Compiler boundary."""

from __future__ import annotations

import subprocess
import sys
import unittest
from pathlib import Path


SCRIPT = Path(__file__).with_name("build_prompt_packet.py")


def run_compiler(*args: str) -> subprocess.CompletedProcess[str]:
    return subprocess.run(
        [sys.executable, str(SCRIPT), *args],
        check=False,
        capture_output=True,
        text=True,
    )


class VisualWorldCompilerTests(unittest.TestCase):
    def test_sylvan_packet_resolves_identity_wardrobe_and_luminai(self) -> None:
        result = run_compiler(
            "--character", "sylvan-elaria",
            "--scene", "Sylvan and his Luminai review authenticated evidence",
            "--image-type", "observational-scene",
            "--render-style", "cinematic-photorealism",
            "--composition", "OBSERVATIONAL",
            "--birth-year", "1985",
            "--age", "40",
            "--location", "surface-civilization",
            "--qa",
        )
        self.assertEqual(result.returncode, 0, result.stderr)
        self.assertIn("role=sylvan-modern", result.stdout)
        self.assertIn("middle-class urban Los Angeles / United States, 1985-present", result.stdout)
        self.assertIn("luminai_manifestation: energy radiating from the integrated human", result.stdout)
        self.assertIn("head and brain, chest", result.stdout)
        self.assertIn("PROJECT VISUAL GRAMMAR", result.stdout)
        self.assertIn("credible cinematic photography", result.stdout)
        self.assertNotIn("tactile painterly photorealism", result.stdout)
        self.assertNotIn("\n- monumental gothic architecture fused", result.stdout)
        self.assertNotIn("\n- near-black cinematic ground", result.stdout)
        self.assertNotIn("sylvan-elaria-private-study-v1.png", result.stdout)
        self.assertNotIn("EXTERNAL QA METADATA", result.stdout)
        self.assertIn("EXTERNAL QA METADATA", result.stderr)
        self.assertIn("RENDERER EXECUTION PLAN", result.stdout)
        self.assertIn("generation_intent: new-with-references", result.stdout)
        self.assertIn("api_or_tool_route: image-api", result.stdout)
        self.assertIn("reference_input_fidelity: automatic-high", result.stdout)
        self.assertIn("output: size=auto; quality=high; format=png; background=auto", result.stdout)
        self.assertIn("era visible life: recognizable contemporary surface life", result.stdout)
        self.assertNotIn("VAULT SOURCE TRACE", result.stdout)

    def test_missing_definitions_never_emit_generation_packet(self) -> None:
        result = run_compiler(
            "--character", "sylvan-elaria",
            "--scene", "Sylvan waits in an undefined place",
        )
        self.assertEqual(result.returncode, 2)
        self.assertTrue(result.stdout.startswith("SEEDS OF THE THRONE NEEDS DEFINITION REPORT"))
        self.assertNotIn("CLEAN GENERATION PACKET", result.stdout)

    def test_required_definition_environment_blocks(self) -> None:
        result = run_compiler(
            "--character", "sylvan-elaria",
            "--scene", "Sylvan crosses an ordinary public square",
            "--era", "2020s",
            "--location", "lived-in-ordinary-life",
        )
        self.assertEqual(result.returncode, 2)
        self.assertIn("still requires definition", result.stdout)

    def test_samuel_great_war_resolves_apparent_age_forty(self) -> None:
        result = run_compiler(
            "--character", "samuel-franklin",
            "--scene", "Samuel directs a Great War-era intervention",
            "--image-type", "historical-reconstruction",
            "--render-style", "archival-documentary",
            "--era", "1940s",
            "--location", "surface-civilization",
        )
        self.assertEqual(result.returncode, 0, result.stdout)
        self.assertIn("role=samuel-great-war", result.stdout)
        self.assertIn("apparent_age=approximately 40", result.stdout)
        self.assertNotIn("immutable identity traits: late 60s", result.stdout)
        self.assertNotIn("receding gray hair", result.stdout)
        self.assertIn("Great War uses the 1940s-equivalent packet", result.stdout)
        self.assertIn("do not repeat the crown", result.stdout)

    def test_undefined_pre_1940_era_blocks(self) -> None:
        result = run_compiler(
            "--character", "sylvan-elaria",
            "--scene", "Sylvan appears in 1935",
            "--location", "surface-civilization",
        )
        self.assertEqual(result.returncode, 2)
        self.assertIn("is not defined in the surface-civilization reference", result.stdout)

    def test_iterative_edit_routes_to_responses_and_captures_revised_prompt(self) -> None:
        result = run_compiler(
            "--character", "sylvan-elaria",
            "--scene", "Preserve Sylvan while refining the natural running stride",
            "--era", "2020s",
            "--location", "surface-civilization",
            "--generation-intent", "iterative-edit",
            "--output-size", "1536x1024",
            "--output-format", "webp",
            "--output-compression", "90",
        )
        self.assertEqual(result.returncode, 0, result.stderr)
        self.assertIn("api_or_tool_route: responses-api", result.stdout)
        self.assertIn("capture revised_prompt", result.stdout)
        self.assertIn("output: size=1536x1024; quality=high; format=webp", result.stdout)
        self.assertIn("output_compression: 90", result.stdout)

    def test_iterative_edit_rejects_image_api_route(self) -> None:
        result = run_compiler(
            "--character", "sylvan-elaria",
            "--scene", "Refine the same image",
            "--era", "2020s",
            "--location", "surface-civilization",
            "--generation-intent", "iterative-edit",
            "--api-route", "image-api",
        )
        self.assertEqual(result.returncode, 2)
        self.assertIn("iterative-edit requires responses-api", result.stderr)

    def test_graph_trace_is_complete_and_excluded_from_renderer_packet(self) -> None:
        result = run_compiler(
            "--character", "sylvan-elaria",
            "--scene", "Sylvan runs along the beach while his Luminai manifests in blue",
            "--birth-year", "1985",
            "--age", "40",
            "--location", "surface-civilization",
            "--manifestation", "luminai",
            "--render-style", "cinematic-photorealism",
            "--trace",
        )
        self.assertEqual(result.returncode, 0, result.stderr)
        self.assertNotIn("VAULT SOURCE TRACE", result.stdout)
        self.assertNotIn("03 Context/", result.stdout)
        self.assertIn("VAULT SOURCE TRACE", result.stderr)
        self.assertIn("node=character:sylvan-elaria", result.stderr)
        self.assertIn("node=appearance:sylvan-elaria:sylvan-modern", result.stderr)
        self.assertIn("node=era:2020s", result.stderr)
        self.assertIn("node=manifestation:luminai", result.stderr)
        self.assertIn("source=timeline", result.stderr)
        self.assertIn("edge=character:sylvan-elaria --HAS_APPEARANCE-->", result.stderr)


if __name__ == "__main__":
    unittest.main()
