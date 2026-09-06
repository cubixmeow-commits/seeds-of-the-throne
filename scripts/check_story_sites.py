#!/usr/bin/env python3
"""Check generated projections, local assets, and workshop completeness."""
from pathlib import Path
from html.parser import HTMLParser
from urllib.parse import unquote, urlsplit
import json, hashlib, re, sys

ROOT=Path(__file__).resolve().parents[1]
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
data=json.loads((ROOT/'docs/assets/story-workshop.json').read_text())
if len(data['modules'])!=20:errors.append('Expected 20 modules')
required=['Purpose','Relevant source notes','Confirmed facts','Unresolved gaps','Prerequisite decisions','Central author gate','Possibilities and tradeoffs','Targeted follow-up','Scene test','Adversarial questions','Completion checklist','Answer and decision record','Notes and website sections affected']
for m in data['modules']:
    text=(ROOT/m['path']).read_text()
    if text!=m['markdown']:errors.append('Workshop drift: '+m['id'])
    for heading in required:
        if '## '+heading not in text:errors.append(f'{m["id"]}: missing {heading}')
    count=len(re.findall(r'^### \d+\.',text,re.M))
    if not 3<=count<=5:errors.append(f'{m["id"]}: {count} options')
    for target in re.findall(r'\[\[([^\]|]+)',text):
        if not (ROOT/(target+'.md')).exists():errors.append(f'{m["id"]}: missing source {target}')
    for raw in re.findall(r'^prerequisites: (.+)',text,re.M):
        if raw!='none':
            for ident in raw.split(', '):
                if ident not in [x['id'] for x in data['modules']]:errors.append('Invalid prerequisite '+ident)
for p in (ROOT/'05 Public/Atlas').glob('*.md'):
    s=p.read_text()
    for target in re.findall(r'\[\[([^\]|]+)',s):
        if not (ROOT/(target+'.md')).exists():errors.append(f'{p.name}: missing source {target}')
    for pattern in ['Humanity has already crossed the stars using','Humanity colonizes multiple worlds with','Luminai names the successor generation','The attempt fails because the bond']:
        if pattern in s:errors.append(f'{p.name}: stale claim {pattern}')
if errors:
    print('\n'.join(errors));sys.exit(1)
print('PASS: local HTML links/assets/anchors; generated hashes; 20 complete source-linked modules; curated canon checks.')
