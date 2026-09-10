#!/usr/bin/env python3
"""Shared reassessment-workshop contract for the site builder and checker.

Both scripts derive module inventory from the active source directory instead of
assuming a retired twenty-module format.
"""
from pathlib import Path
import re

ROOT = Path(__file__).resolve().parents[1]
WORKSHOP_DIR = ROOT / '07 Coordination/Story Completion Workflow/Reassessment Workshop'
MODULE_GLOB = '[0-9][0-9] - *.md'
REQUIRED_HEADINGS = (
    'Purpose',
    'Established',
    'Central author gate',
    'Scene test',
    'Adversarial test',
)
MIN_OPTIONS = 3
MAX_OPTIONS = 5
MODULE_ID_RE = re.compile(r'^RW-\d{2}$')
WIKI_TARGET_RE = re.compile(r'\[\[([^\]|#]+)')
OPTION_RE = re.compile(r'^\d+\. ', re.M)


def module_paths():
    return sorted(WORKSHOP_DIR.glob(MODULE_GLOB))


def expected_module_count():
    return len(module_paths())


def parse_frontmatter(text):
    match = re.match(r'^---\n(.*?)\n---\n', text, re.S)
    if not match:
        return {}
    return dict(line.split(': ', 1) for line in match[1].splitlines() if ': ' in line)


def option_count(text):
    return len(OPTION_RE.findall(text))


def wiki_targets(text):
    targets = []
    for raw in WIKI_TARGET_RE.findall(text):
        target = raw.split('|', 1)[0].strip()
        if target:
            targets.append(target.removesuffix('.md') + '.md')
    return targets


def module_prerequisites(raw):
    value = (raw or '').strip()
    if value in ('', 'none'):
        return []
    return [part.strip() for part in value.split(',') if MODULE_ID_RE.match(part.strip())]


def resolve_wiki_path(target):
    return ROOT / target
