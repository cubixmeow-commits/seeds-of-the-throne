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
    load_workshop_modules,
    validate_generated_modules,
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
        errors.append('generated workshop IDs do not match the RW-01 through RW-10 source set')
if len(data.get('modules', [])) != EXPECTED_MODULE_COUNT:
    errors.append(f'Expected {EXPECTED_MODULE_COUNT} current reassessment modules RW-01 through RW-10, found {len(data.get("modules", []))}')
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
for p in (ROOT/'05 Public/Atlas').glob('*.md'):
    s=p.read_text()
    for target in wiki_targets(s):
        if not resolve_wiki_path(target).exists():errors.append(f'{p.name}: missing source {target}')
    for pattern in ['Humanity has already crossed the stars using','Humanity colonizes multiple worlds with','Luminai names the successor generation','The attempt fails because the bond']:
        if pattern in s:errors.append(f'{p.name}: stale claim {pattern}')
if errors:
    print('\n'.join(errors));sys.exit(1)
print(f'PASS: local HTML links/assets/anchors; generated hashes; {EXPECTED_MODULE_COUNT} current source-linked reassessment modules RW-01 through RW-10; curated canon checks.')
