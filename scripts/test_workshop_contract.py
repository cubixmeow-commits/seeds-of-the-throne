#!/usr/bin/env python3
"""Regression tests for the reassessment-workshop contract."""
import sys
import tempfile
import unittest
from pathlib import Path

sys.path.insert(0, str(Path(__file__).resolve().parent))
import workshop_contract as workshop


MINIMAL_BODY = """
## Purpose

Purpose.

## Established

Established.

## Four possibilities

1. **One:** a
2. **Two:** b
3. **Three:** c
4. **Four:** d

## Central author gate

Gate.

## Scene test

Scene.

## Adversarial test

Adversarial.
"""


def module_text(ident, prerequisites='none', number=None):
    number = number or ident.split('-')[1]
    return (
        '---\n'
        'type: workshop-module\n'
        'status: open\n'
        f'module: {ident}\n'
        f'title: Module {ident}\n'
        'gate: A test gate?\n'
        f'prerequisites: {prerequisites}\n'
        '---\n'
        f'# {ident}: Module {ident}\n'
        f'{MINIMAL_BODY}'
    )


def write_set(directory, specs):
    """specs: list of (ident, prerequisites, filename_number or None)."""
    for ident, prerequisites, filename_number in specs:
        number = filename_number or ident.split('-')[1]
        path = Path(directory) / f'{number} - {ident}.md'
        path.write_text(module_text(ident, prerequisites, number))


def complete_set(overrides=None):
    specs = []
    for index in range(1, 11):
        ident = f'RW-{index:02d}'
        prerequisites = 'current ending macro' if ident == 'RW-01' else ('RW-01' if ident != 'RW-10' else 'RW-01 through RW-09')
        specs.append([ident, prerequisites, f'{index:02d}'])
    overrides = overrides or {}
    for ident, fields in overrides.items():
        for spec in specs:
            if spec[0] == ident:
                spec[1] = fields.get('prerequisites', spec[1])
                spec[0] = fields.get('id', spec[0])
                spec[2] = fields.get('number', spec[2])
    return specs


class WorkshopContractTests(unittest.TestCase):
    def test_live_workshop_matches_required_set(self):
        records, errors = workshop.validate_workshop_sources()
        self.assertEqual(errors, [])
        self.assertEqual([record['id'] for record in records], list(workshop.REQUIRED_MODULE_IDS))

    def test_expected_count_is_fixed(self):
        self.assertEqual(workshop.expected_module_count(), 10)
        self.assertEqual(workshop.REQUIRED_MODULE_IDS, tuple(f'RW-{index:02d}' for index in range(1, 11)))

    def test_supported_prerequisites_pass(self):
        resolved, errors = workshop.parse_prerequisites('current ending macro')
        self.assertEqual(errors, [])
        self.assertEqual(resolved, ['current ending macro'])
        resolved, errors = workshop.parse_prerequisites('RW-01 through RW-09')
        self.assertEqual(errors, [])
        self.assertEqual(resolved, [f'RW-{index:02d}' for index in range(1, 10)])
        resolved, errors = workshop.parse_prerequisites('RW-01, RW-03')
        self.assertEqual(errors, [])
        self.assertEqual(resolved, ['RW-01', 'RW-03'])

    def test_missing_module_fails(self):
        with tempfile.TemporaryDirectory() as tmp:
            write_set(tmp, complete_set()[:-1])
            _, errors = workshop.validate_workshop_sources(Path(tmp))
            joined = '\n'.join(errors)
            self.assertTrue(errors)
            self.assertIn('missing required module: RW-10', joined)
            self.assertIn('expected 10 unique sequential modules RW-01 through RW-10, found 9', joined)

    def test_duplicate_id_fails(self):
        with tempfile.TemporaryDirectory() as tmp:
            write_set(tmp, complete_set())
            Path(tmp).joinpath('01 - RW-01 duplicate.md').write_text(module_text('RW-01', 'current ending macro'))
            _, errors = workshop.validate_workshop_sources(Path(tmp))
            joined = '\n'.join(errors)
            self.assertTrue(errors)
            self.assertIn('duplicate module ID: RW-01', joined)

    def test_malformed_id_fails(self):
        with tempfile.TemporaryDirectory() as tmp:
            specs = complete_set({'RW-10': {'id': 'RW-1', 'number': '10'}})
            write_set(tmp, specs)
            _, errors = workshop.validate_workshop_sources(Path(tmp))
            joined = '\n'.join(errors)
            self.assertTrue(errors)
            self.assertIn("malformed module ID 'RW-1'", joined)

    def test_invalid_prerequisite_fails(self):
        _, errors = workshop.parse_prerequisites('not-a-module')
        self.assertTrue(errors)
        self.assertIn("malformed or unsupported prerequisite 'not-a-module'", errors)
        _, errors = workshop.parse_prerequisites('RW-99')
        self.assertTrue(errors)
        self.assertIn('unknown prerequisite RW-99', errors)
        with tempfile.TemporaryDirectory() as tmp:
            write_set(tmp, complete_set({'RW-02': {'prerequisites': 'SC-001'}}))
            _, errors = workshop.validate_workshop_sources(Path(tmp))
            joined = '\n'.join(errors)
            self.assertIn("malformed or unsupported prerequisite 'SC-001'", joined)

    def test_generated_payload_missing_module_fails(self):
        payload = [{'id': f'RW-{index:02d}'} for index in range(1, 10)]
        errors = workshop.validate_generated_modules(payload)
        joined = '\n'.join(errors)
        self.assertTrue(errors)
        self.assertIn('RW-01 through RW-10', joined)

    def test_complete_temp_set_passes(self):
        with tempfile.TemporaryDirectory() as tmp:
            write_set(tmp, complete_set())
            records, errors = workshop.validate_workshop_sources(Path(tmp))
            self.assertEqual(errors, [])
            self.assertEqual([record['id'] for record in records], list(workshop.REQUIRED_MODULE_IDS))


if __name__ == '__main__':
    unittest.main()
