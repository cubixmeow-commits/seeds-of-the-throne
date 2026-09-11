#!/usr/bin/env python3
"""Shared active-workshop contract for the site builder and checker.

The active workshop is the fixed BA-01 through BA-10 set. Inventory is not
whatever files happen to be present.
"""
from pathlib import Path
import re

ROOT = Path(__file__).resolve().parents[1]
WORKSHOP_DIR = ROOT / '07 Coordination/Story Completion Workflow/Book One Architecture Workshop'
MODULE_GLOB = '[0-9][0-9] - *.md'
MODULE_PREFIX = 'BA'
WORKSHOP_LABEL = 'BA-01 through BA-10'
REQUIRED_MODULE_IDS = tuple(f'{MODULE_PREFIX}-{index:02d}' for index in range(1, 11))
EXPECTED_MODULE_COUNT = len(REQUIRED_MODULE_IDS)
REQUIRED_HEADINGS = (
    'Purpose',
    'Established',
    'Central author gate',
    'Scene test',
    'Adversarial test',
)
MIN_OPTIONS = 3
MAX_OPTIONS = 5
MODULE_ID_RE = re.compile(r'^BA-\d{2}$')
REQUIRED_ID_RE = re.compile(r'^BA-(0[1-9]|10)$')
RANGE_RE = re.compile(r'^(BA-\d{2}) through (BA-\d{2})$')
FILENAME_RE = re.compile(r'^(\d{2}) - .+\.md$')
WIKI_TARGET_RE = re.compile(r'\[\[([^\]|#]+)')
OPTION_RE = re.compile(r'^\d+\. ', re.M)
ALLOWED_PREREQUISITE_LABELS = frozenset({
    'none',
    'accepted ending macro',
})


def module_paths(workshop_dir=WORKSHOP_DIR):
    return sorted(workshop_dir.glob(MODULE_GLOB))


def expected_module_count():
    return EXPECTED_MODULE_COUNT


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


def resolve_wiki_path(target):
    return ROOT / target


def expand_prerequisite_range(start, end):
    if not REQUIRED_ID_RE.match(start) or not REQUIRED_ID_RE.match(end):
        return None, f'prerequisite range {start} through {end} is outside {WORKSHOP_LABEL}'
    start_n = int(start.split('-')[1])
    end_n = int(end.split('-')[1])
    if start_n >= end_n:
        return None, f'prerequisite range {start} through {end} is not sequential'
    return [f'{MODULE_PREFIX}-{index:02d}' for index in range(start_n, end_n + 1)], None


def parse_prerequisites(raw):
    """Parse a prerequisites field. Unknown or malformed values are errors."""
    value = (raw or '').strip()
    if value in ('', 'none'):
        return [], []
    tokens = [part.strip() for part in value.split(',') if part.strip()]
    if not tokens:
        return [], ['prerequisites field is empty after splitting']
    resolved = []
    errors = []
    for token in tokens:
        if token in ALLOWED_PREREQUISITE_LABELS and token != 'none':
            resolved.append(token)
            continue
        if REQUIRED_ID_RE.match(token):
            resolved.append(token)
            continue
        range_match = RANGE_RE.match(token)
        if range_match:
            expanded, error = expand_prerequisite_range(range_match[1], range_match[2])
            if error:
                errors.append(error)
                continue
            resolved.extend(expanded)
            continue
        if MODULE_ID_RE.match(token):
            errors.append(f'unknown prerequisite {token}')
        else:
            errors.append(f'malformed or unsupported prerequisite {token!r}')
    return resolved, errors


def validate_module_id(ident, filename=None):
    errors = []
    if not MODULE_ID_RE.match(ident or ''):
        errors.append(f'malformed module ID {ident!r}')
        return errors
    if ident not in REQUIRED_MODULE_IDS:
        errors.append(f'module ID {ident} is outside the required {WORKSHOP_LABEL} set')
    if filename:
        name_match = FILENAME_RE.match(filename)
        if not name_match:
            errors.append(f'{filename}: workshop module filenames must match NN - name.md')
        elif f'{MODULE_PREFIX}-{name_match[1]}' != ident:
            errors.append(f'{filename}: filename number does not match module ID {ident}')
    return errors


def validate_workshop_sources(workshop_dir=WORKSHOP_DIR):
    """Validate the active BA-01 through BA-10 source set. Returns (records, errors)."""
    records = []
    errors = []
    ids = []
    for path in module_paths(workshop_dir):
        text = path.read_text()
        meta = parse_frontmatter(text)
        ident = (meta.get('module') or '').strip()
        id_errors = validate_module_id(ident, path.name)
        for error in id_errors:
            errors.append(error if error.startswith(path.name) else f'{path.name}: {error}')
        if id_errors:
            if ident:
                ids.append(ident)
            continue
        ids.append(ident)
        _, prereq_errors = parse_prerequisites(meta.get('prerequisites', ''))
        for error in prereq_errors:
            errors.append(f'{ident}: {error}')
        records.append({
            'id': ident,
            'title': meta.get('title', ''),
            'gate': meta.get('gate', ''),
            'status': meta.get('status', 'unknown'),
            'prerequisites': meta.get('prerequisites', ''),
            'path': path,
            'text': text,
            'meta': meta,
        })

    found = [ident for ident in ids if ident]
    unique = set(found)
    if len(found) != len(unique):
        duplicates = sorted({ident for ident in found if found.count(ident) > 1})
        errors.append('duplicate module ID: ' + ', '.join(duplicates))

    missing = [ident for ident in REQUIRED_MODULE_IDS if ident not in unique]
    extra = [ident for ident in unique if ident not in REQUIRED_MODULE_IDS]
    if missing:
        errors.append('missing required module: ' + ', '.join(missing))
    if extra:
        errors.append(f'unknown module outside {WORKSHOP_LABEL}: ' + ', '.join(sorted(extra)))
    if len(unique) != EXPECTED_MODULE_COUNT or missing or extra:
        errors.append(
            f'expected {EXPECTED_MODULE_COUNT} unique sequential modules {WORKSHOP_LABEL}, found {len(unique)}'
        )
    return records, errors


def load_workshop_modules(workshop_dir=WORKSHOP_DIR, root=ROOT):
    records, errors = validate_workshop_sources(workshop_dir)
    if errors:
        return [], errors
    modules = []
    for record in sorted(records, key=lambda item: item['id']):
        path = record['path']
        modules.append({
            'id': record['id'],
            'title': record['title'],
            'gate': record['gate'],
            'status': record['status'],
            'prerequisites': record['prerequisites'],
            'path': str(path.relative_to(root)),
            'markdown': record['text'],
        })
    return modules, []


def validate_generated_modules(modules):
    errors = []
    ids = [item.get('id') for item in modules or []]
    if ids != list(REQUIRED_MODULE_IDS):
        errors.append(
            f'generated workshop must contain unique sequential IDs {WORKSHOP_LABEL}, found {ids}'
        )
    seen = set()
    for ident in ids:
        if ident in seen:
            errors.append(f'duplicate generated module ID {ident}')
        seen.add(ident)
        errors.extend(validate_module_id(ident or ''))
    return errors
