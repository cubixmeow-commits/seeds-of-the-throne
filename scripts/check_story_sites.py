#!/usr/bin/env python3
"""Check generated projections, local assets, and workshop completeness."""
from pathlib import Path
from html.parser import HTMLParser
from urllib.parse import unquote, urlsplit
import json, hashlib, sys

sys.path.insert(0, str(Path(__file__).resolve().parent))
from workshop_contract import (
    ROOT,
    REQUIRED_HEADINGS,
    MIN_OPTIONS,
    MAX_OPTIONS,
    EXPECTED_MODULE_COUNT,
    ENDGAME_EXPECTED_MODULE_COUNT,
    ENDGAME_REQUIRED_MODULE_IDS,
    ENDGAME_MODULE_PREFIX,
    ENDGAME_WORKSHOP_LABEL,
    load_workshop_modules,
    load_endgame_workshop_modules,
    load_dynamic_workshop,
    validate_generated_modules,
    validate_generated_endgame_modules,
    validate_generated_dynamic_modules,
    parse_prerequisites,
    option_count,
    wiki_targets,
    resolve_wiki_path,
)

errors=[]
class Page(HTMLParser):
    def __init__(self,text):
        super().__init__();self.links=[];self.ids=[];self.h1=0;self.feed(text)
    def handle_starttag(self,tag,attrs):
        a=dict(attrs)
        if 'id' in a:self.ids.append(a['id'])
        if tag=='h1':self.h1+=1
        for key in ('src','href'):
            if key in a:self.links.append(a[key])
        if tag=='img' and not a.get('alt'):errors.append('Image without meaningful alt')
for p in sorted((ROOT/'docs').glob('*.html')):
    page=Page(p.read_text())
    if len(page.ids)!=len(set(page.ids)):errors.append(f'{p.name}: duplicate IDs')
    if page.h1!=1:errors.append(f'{p.name}: expected one h1, got {page.h1}')
    for link in page.links:
        u=urlsplit(link)
        if u.scheme or u.netloc:continue
        target=(p.parent/unquote(u.path)).resolve() if u.path else p
        if not target.exists():errors.append(f'{p.name}: missing {link}');continue
        if u.fragment and target.suffix=='.html' and unquote(u.fragment) not in Page(target.read_text()).ids:
            errors.append(f'{p.name}: missing anchor {link}')
manifest=json.loads((ROOT/'docs/assets/story-build.json').read_text())
for p,h in manifest.items():
    if hashlib.sha256((ROOT/p).read_bytes()).hexdigest()!=h:errors.append(f'Stale generated file: {p}')
source_modules, source_errors = load_workshop_modules()
errors.extend(source_errors)
data=json.loads((ROOT/'docs/assets/story-workshop.json').read_text())
errors.extend(validate_generated_modules(data.get('modules')))
if source_modules:
    source_ids=[item['id'] for item in source_modules]
    generated_ids=[item.get('id') for item in data.get('modules', [])]
    if source_ids!=generated_ids:
        errors.append('generated workshop IDs do not match the BA-01 through BA-10 source set')
if len(data.get('modules', [])) != EXPECTED_MODULE_COUNT:
    errors.append(f'Expected {EXPECTED_MODULE_COUNT} current Book One architecture modules BA-01 through BA-10, found {len(data.get("modules", []))}')
for m in data.get('modules', []):
    text=(ROOT/m['path']).read_text()
    if text!=m['markdown']:errors.append('Workshop drift: '+m['id'])
    for heading in REQUIRED_HEADINGS:
        if '## '+heading not in text:errors.append(f'{m["id"]}: missing {heading}')
    count=option_count(text)
    if not MIN_OPTIONS<=count<=MAX_OPTIONS:
        errors.append(f'{m["id"]}: {count} options')
    for target in wiki_targets(text):
        if not resolve_wiki_path(target).exists():errors.append(f'{m["id"]}: missing source {target}')
    _, prereq_errors = parse_prerequisites(m.get('prerequisites', ''))
    for error in prereq_errors:
        errors.append(f'{m["id"]}: {error}')
endgame_source_modules, endgame_source_errors = load_endgame_workshop_modules()
errors.extend(endgame_source_errors)
endgame_data=json.loads((ROOT/'docs/assets/story-endgame-workshop.json').read_text())
errors.extend(validate_generated_endgame_modules(endgame_data.get('modules')))
if endgame_source_modules:
    source_ids=[item['id'] for item in endgame_source_modules]
    generated_ids=[item.get('id') for item in endgame_data.get('modules', [])]
    if source_ids!=generated_ids:
        errors.append(f'generated workshop IDs do not match the {ENDGAME_WORKSHOP_LABEL} source set')
if len(endgame_data.get('modules', [])) != ENDGAME_EXPECTED_MODULE_COUNT:
    errors.append(f'Expected {ENDGAME_EXPECTED_MODULE_COUNT} focused Endgame modules {ENDGAME_WORKSHOP_LABEL}, found {len(endgame_data.get("modules", []))}')
for m in endgame_data.get('modules', []):
    text=(ROOT/m['path']).read_text()
    if text!=m['markdown']:errors.append('Workshop drift: '+m['id'])
    for heading in REQUIRED_HEADINGS:
        if '## '+heading not in text:errors.append(f'{m["id"]}: missing {heading}')
    count=option_count(text)
    if not MIN_OPTIONS<=count<=MAX_OPTIONS:
        errors.append(f'{m["id"]}: {count} options')
    for target in wiki_targets(text):
        if not resolve_wiki_path(target).exists():errors.append(f'{m["id"]}: missing source {target}')
    _, prereq_errors = parse_prerequisites(
        m.get('prerequisites', ''),
        ENDGAME_REQUIRED_MODULE_IDS,
        ENDGAME_MODULE_PREFIX,
        ENDGAME_WORKSHOP_LABEL,
    )
    for error in prereq_errors:
        errors.append(f'{m["id"]}: {error}')
dynamic_source_modules, dynamic_source_errors = load_dynamic_workshop()
errors.extend(dynamic_source_errors)
dynamic_data=json.loads((ROOT/'docs/assets/story-dynamic-workshop.json').read_text())
errors.extend(validate_generated_dynamic_modules(dynamic_data.get('modules')))
if dynamic_source_modules:
    generated_dynamic=dynamic_data.get('modules', [])
    if not generated_dynamic or generated_dynamic[0].get('markdown') != dynamic_source_modules[0]['markdown']:
        errors.append('Dynamic workshop drift: generated module does not match DYNAMIC-WORKSHOP.md')
    if generated_dynamic and generated_dynamic[0].get('gate') != dynamic_source_modules[0]['gate']:
        errors.append('Dynamic workshop drift: generated gate does not match Next Assessment Pass')
for p in (ROOT/'05 Public/Atlas').glob('*.md'):
    s=p.read_text()
    for target in wiki_targets(s):
        if not resolve_wiki_path(target).exists():errors.append(f'{p.name}: missing source {target}')
    for pattern in ['Humanity has already crossed the stars using','Humanity colonizes multiple worlds with','Luminai names the successor generation','The attempt fails because the bond']:
        if pattern in s:errors.append(f'{p.name}: stale claim {pattern}')

# Keep the current dynamic assessment and Resistance update connected across
# source, workshop, Project Explorer, and reader-facing projections.
curated_markers = {
    '02 Story/Groups/The Resistance.md': [
        'The movement is separate from Sylvan',
        "The Resistance's current Book One function",
    ],
    '07 Coordination/Story Completion Workflow/DYNAMIC-WORKSHOP.md': [
        'Current Canon Baseline',
        'Next Assessment Pass',
        'resistance-ark-infographic-v1.png',
    ],
    '07 Coordination/PUBLIC-SITE-UPDATE-SYSTEM.md': ['Projection decision', 'Desktop assessment checklist'],
    'docs/faction.html': ['one throne promised twice', 'resistance-ark-infographic-v1.webp'],
    'docs/archive.html': ['The project now uses one'],
    'docs/index.html': ['Open the Dynamic Story Workshop', 'resistance-ark-infographic-v1.webp'],
    'docs/workshop.html': ['Dynamic Story Workshop', 'story-dynamic-workshop.json'],
    'iainreiddotdev/project-explorer/workbench.php': [
        'story-dynamic-workshop.json',
        'Open the current assessment',
    ],
    'iainreiddotdev/project-explorer/index.php': [
        '2026-09-21 - Resistance Identity and Dynamic Endgame Workshop.md',
        'resistance-ark-infographic-v1.webp',
        'altered-reality-prophecy-target-diagram-v1.webp',
    ],
    'iainreiddotdev/analytics/collect.php': [
        'analytics_site_for_path',
        'INSERT INTO analytics_visits',
    ],
    'iainreiddotdev/admin/analytics.php': [
        'require_admin()',
        'Visitor analytics',
    ],
    'iainreiddotdev/privacy.php': [
        'Privacy and visitor analytics',
        'first-party analytics system operated by Iain Reid',
        'data-analytics-opt-out',
        'data-analytics-opt-in',
    ],
    'iainreiddotdev/setup-admin.php': [
        "SELECT COUNT(*) FROM users WHERE role = 'admin'",
        '.admin-setup-code',
        'csrf_validate()',
        "':role' => 'admin'",
        "redirect(url('admin/analytics.php'))",
    ],
    'docs/app.js': [
        '/devsite/iainreiddotdev/assets/js/analytics.js?v=20260918a',
    ],
}
for relative_path, markers in curated_markers.items():
    path = ROOT/relative_path
    if not path.exists():
        errors.append(f'Missing curated projection: {relative_path}')
        continue
    contents = path.read_text()
    for marker in markers:
        if marker not in contents:
            errors.append(f'{relative_path}: missing curated marker {marker}')
if errors:
    print('\n'.join(errors));sys.exit(1)
print(f'PASS: local HTML links/assets/anchors; generated hashes; 1 live Dynamic module; {EXPECTED_MODULE_COUNT + ENDGAME_EXPECTED_MODULE_COUNT} historical BA/EG modules; curated canon checks.')
