#!/usr/bin/env python3
"""Shared contracts for the live dynamic workshop and historical workshop sets."""
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

ENDGAME_WORKSHOP_DIR = ROOT / '07 Coordination/Story Completion Workflow/Endgame Workshop'
ENDGAME_MODULE_PREFIX = 'EG'
ENDGAME_WORKSHOP_LABEL = 'EG-01 through EG-12'
ENDGAME_REQUIRED_MODULE_IDS = tuple(f'{ENDGAME_MODULE_PREFIX}-{index:02d}' for index in range(1, 13))
ENDGAME_EXPECTED_MODULE_COUNT = len(ENDGAME_REQUIRED_MODULE_IDS)

DYNAMIC_WORKSHOP_PATH = ROOT / '07 Coordination/Story Completion Workflow/DYNAMIC-WORKSHOP.md'
DYNAMIC_REQUIRED_HEADINGS = (
    'Current Canon Baseline',
    'Newly Integrated Decisions',
    'Open Questions',
    'Conflicts/Compatibility Checks',
    'Next Assessment Pass',
    'Change Log',
)


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


def expand_prerequisite_range(start, end, required_ids=REQUIRED_MODULE_IDS, module_prefix=MODULE_PREFIX, workshop_label=WORKSHOP_LABEL):
    if start not in required_ids or end not in required_ids:
        return None, f'prerequisite range {start} through {end} is outside {workshop_label}'
    start_n = int(start.split('-')[1])
    end_n = int(end.split('-')[1])
    if start_n >= end_n:
        return None, f'prerequisite range {start} through {end} is not sequential'
    return [f'{module_prefix}-{index:02d}' for index in range(start_n, end_n + 1)], None


def parse_prerequisites(raw, required_ids=REQUIRED_MODULE_IDS, module_prefix=MODULE_PREFIX, workshop_label=WORKSHOP_LABEL):
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
        if token in required_ids:
            resolved.append(token)
            continue
        range_match = re.match(rf'^({re.escape(module_prefix)}-\d{{2}}) through ({re.escape(module_prefix)}-\d{{2}})$', token)
        if range_match:
            expanded, error = expand_prerequisite_range(
                range_match[1], range_match[2], required_ids, module_prefix, workshop_label
            )
            if error:
                errors.append(error)
                continue
            resolved.extend(expanded)
            continue
        if re.match(rf'^{re.escape(module_prefix)}-\d{{2}}$', token):
            errors.append(f'unknown prerequisite {token}')
        else:
            errors.append(f'malformed or unsupported prerequisite {token!r}')
    return resolved, errors


def validate_module_id(ident, filename=None, required_ids=REQUIRED_MODULE_IDS, module_prefix=MODULE_PREFIX, workshop_label=WORKSHOP_LABEL):
    errors = []
    if not re.match(rf'^{re.escape(module_prefix)}-\d{{2}}$', ident or ''):
        errors.append(f'malformed module ID {ident!r}')
        return errors
    if ident not in required_ids:
        errors.append(f'module ID {ident} is outside the required {workshop_label} set')
    if filename:
        name_match = FILENAME_RE.match(filename)
        if not name_match:
            errors.append(f'{filename}: workshop module filenames must match NN - name.md')
        elif f'{module_prefix}-{name_match[1]}' != ident:
            errors.append(f'{filename}: filename number does not match module ID {ident}')
    return errors


def validate_workshop_sources(
    workshop_dir=WORKSHOP_DIR,
    required_ids=REQUIRED_MODULE_IDS,
    module_prefix=MODULE_PREFIX,
    workshop_label=WORKSHOP_LABEL,
):
    """Validate one fixed workshop source set. Returns (records, errors)."""
    records = []
    errors = []
    ids = []
    for path in module_paths(workshop_dir):
        text = path.read_text()
        meta = parse_frontmatter(text)
        ident = (meta.get('module') or '').strip()
        id_errors = validate_module_id(ident, path.name, required_ids, module_prefix, workshop_label)
        for error in id_errors:
            errors.append(error if error.startswith(path.name) else f'{path.name}: {error}')
        if id_errors:
            if ident:
                ids.append(ident)
            continue
        ids.append(ident)
        _, prereq_errors = parse_prerequisites(
            meta.get('prerequisites', ''), required_ids, module_prefix, workshop_label
        )
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

    missing = [ident for ident in required_ids if ident not in unique]
    extra = [ident for ident in unique if ident not in required_ids]
    if missing:
        errors.append('missing required module: ' + ', '.join(missing))
    if extra:
        errors.append(f'unknown module outside {workshop_label}: ' + ', '.join(sorted(extra)))
    if len(unique) != len(required_ids) or missing or extra:
        errors.append(
            f'expected {len(required_ids)} unique sequential modules {workshop_label}, found {len(unique)}'
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


def load_endgame_workshop_modules(root=ROOT):
    records, errors = validate_workshop_sources(
        ENDGAME_WORKSHOP_DIR,
        ENDGAME_REQUIRED_MODULE_IDS,
        ENDGAME_MODULE_PREFIX,
        ENDGAME_WORKSHOP_LABEL,
    )
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


def load_dynamic_workshop(path=DYNAMIC_WORKSHOP_PATH, root=ROOT):
    """Project the canonical dynamic workshop as one current interactive module."""
    if not path.exists():
        return [], [f'missing dynamic workshop: {path.relative_to(root)}']
    text = path.read_text()
    errors = []
    meta = parse_frontmatter(text)
    if meta.get('status') != 'active':
        errors.append('dynamic workshop must have status: active')
    for heading in DYNAMIC_REQUIRED_HEADINGS:
        if f'## {heading}' not in text:
            errors.append(f'dynamic workshop missing required section: {heading}')
    section_match = re.search(
        r'^## Next Assessment Pass\s*$\n(.*?)(?=^## |\Z)',
        text,
        re.M | re.S,
    )
    gates = re.findall(r'^>\s+\*\*(.+?)\*\*\s*$', section_match.group(1), re.M) if section_match else []
    if len(gates) != 1:
        errors.append(f'dynamic workshop must contain exactly one bold quoted gate in Next Assessment Pass, found {len(gates)}')
    if errors:
        return [], errors
    return [{
        'id': 'DW-01',
        'title': 'Current assessment pass',
        'gate': gates[0],
        'status': 'active-author-gate',
        'prerequisites': 'current canon baseline',
        'path': str(path.relative_to(root)),
        'markdown': text,
        'updated': meta.get('updated', ''),
    }], []


def validate_generated_dynamic_modules(modules):
    errors = []
    if not isinstance(modules, list) or len(modules) != 1:
        return [f'generated dynamic workshop must contain exactly one current module, found {len(modules or [])}']
    module = modules[0]
    if module.get('id') != 'DW-01':
        errors.append(f'generated dynamic workshop module must be DW-01, found {module.get("id")}')
    if not module.get('gate'):
        errors.append('generated dynamic workshop module has no gate')
    if module.get('path') != str(DYNAMIC_WORKSHOP_PATH.relative_to(ROOT)):
        errors.append('generated dynamic workshop points to the wrong source')
    return errors


def validate_generated_modules(
    modules,
    required_ids=REQUIRED_MODULE_IDS,
    module_prefix=MODULE_PREFIX,
    workshop_label=WORKSHOP_LABEL,
):
    errors = []
    ids = [item.get('id') for item in modules or []]
    if ids != list(required_ids):
        errors.append(
            f'generated workshop must contain unique sequential IDs {workshop_label}, found {ids}'
        )
    seen = set()
    for ident in ids:
        if ident in seen:
            errors.append(f'duplicate generated module ID {ident}')
        seen.add(ident)
        errors.extend(validate_module_id(ident or '', required_ids=required_ids, module_prefix=module_prefix, workshop_label=workshop_label))
    return errors


def validate_generated_endgame_modules(modules):
    return validate_generated_modules(
        modules,
        ENDGAME_REQUIRED_MODULE_IDS,
        ENDGAME_MODULE_PREFIX,
        ENDGAME_WORKSHOP_LABEL,
    )
