#!/usr/bin/env python3
"""Build reviewed Markdown projections. Python standard library only; no runtime service."""
from pathlib import Path
import html, re, json, hashlib, shutil
from urllib.parse import quote, urlsplit

ROOT = Path(__file__).resolve().parents[1]
PUBLIC = ROOT / '05 Public/Atlas'
WORKSHOP = ROOT / '07 Coordination/Story Completion Workflow/Workshop'
DOCS = ROOT / 'docs'
NAV = [('index','Start'),('colonization','World'),('ai','Luminai'),('characters','People'),('faction','Factions'),('timeline','Timeline'),('research','Research'),('workshop','Workshop'),('todo','Progress')]

def source_url(path):
    return 'https://github.com/cubixmeow-commits/seeds-of-the-throne/blob/main/' + quote(path, safe='/')

def inline(s):
    s=html.escape(s)
    s=re.sub(r'\[\[([^\]|]+)(?:\|([^\]]+))?\]\]', lambda m:'<a href="'+source_url(m[1].removesuffix('.md')+'.md')+'">'+(m[2] or m[1].split('/')[-1])+'</a>',s)
    def link(m):
        url=html.unescape(m[2])
        parsed=urlsplit(url)
        if parsed.scheme not in ('','http','https') or url.startswith('//') or '\\' in url: return m[1]
        return '<a href="'+html.escape(url,quote=True)+'">'+m[1]+'</a>'
    s=re.sub(r'\[([^\]]+)\]\(([^)]+)\)',link,s)
    s=re.sub(r'\*\*([^*]+)\*\*',r'<strong>\1</strong>',s)
    return re.sub(r'`([^`]+)`',r'<code>\1</code>',s)

def render(md):
    """Deliberately small safe Markdown subset used by generated source packets."""
    md=re.sub(r'^---\n.*?\n---\n','',md,flags=re.S)
    out=[];lines=md.splitlines();i=0;para=[]
    def flush():
        if para: out.append('<p>'+inline(' '.join(para))+'</p>');para.clear()
    while i<len(lines):
        line=lines[i];i+=1
        if line.startswith('```'):
            flush();code=[]
            while i<len(lines) and not lines[i].startswith('```'): code.append(lines[i]);i+=1
            i+=1;out.append('<pre><code>'+html.escape('\n'.join(code))+'</code></pre>');continue
        if not line.strip(): flush();continue
        h=re.match(r'^(#{1,6}) (.*)',line)
        if h:
            flush();n=min(6,len(h[1]));slug=re.sub(r'[^a-z0-9]+','-',h[2].lower()).strip('-');out.append(f'<h{n} id="{slug}">{inline(h[2])}</h{n}>');continue
        if line.startswith('|'):
            flush();rows=[line]
            while i<len(lines) and lines[i].startswith('|'): rows.append(lines[i]);i+=1
            out.append('<div class="table-scroll" tabindex="0" role="region" aria-label="Comparison table"><table>')
            for k,row in enumerate(rows):
                if re.fullmatch(r'[| :\-]+',row): continue
                tag='th' if k==0 else 'td';out.append('<tr>'+''.join(f'<{tag}'+(' scope="col"' if k==0 else '')+'>'+inline(c.strip())+f'</{tag}>' for c in row.strip('|').split('|'))+'</tr>')
            out.append('</table></div>');continue
        if re.match(r'^(?:- |\d+\. )',line):
            flush();ordered=bool(re.match(r'^\d',line));tag='ol' if ordered else 'ul';out.append('<'+tag+'>')
            while True:
                txt=re.sub(r'^(?:- |\d+\. )','',line)
                txt=txt.replace('[ ]','☐').replace('[x]','☑')
                out.append('<li>'+inline(txt)+'</li>')
                if i>=len(lines) or not re.match(r'^(?:- |\d+\. )',lines[i]): break
                line=lines[i];i+=1
            out.append('</'+tag+'>');continue
        if line.startswith('> '): flush();out.append('<blockquote>'+inline(line[2:])+'</blockquote>');continue
        para.append(line)
    flush();return '\n'.join(out)

def metadata(text):
    match=re.match(r'^---\n(.*?)\n---\n',text,re.S)
    return dict(line.split(': ',1) for line in match[1].splitlines() if ': ' in line) if match else {}

def shell(slug,title,deck,body,image=None):
    nav=''.join(f'<a href="{key}.html"'+(' aria-current="page"' if key==slug else '')+'>'+label+'</a>' for key,label in NAV)
    art=f'<figure class="atlas-art"><img src="assets/images/{image}" alt="Approved character identity artwork for Seeds of the Throne"><figcaption>Approved appearance. Scene symbolism is interpretation.</figcaption></figure>' if image else ''
    return f'''<!doctype html>
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><meta name="theme-color" content="#090a08"><title>{html.escape(title)} | Seeds of the Throne</title><meta name="description" content="{html.escape(deck,quote=True)}"><link rel="icon" href="favicon.svg"><link rel="stylesheet" href="styles.css?v=20260905"><link rel="stylesheet" href="atlas.css?v=20260905"><script src="app.js?v=20260905" defer></script></head>
<body class="atlas-page"><a class="skip-link" href="#main">Skip to content</a><header class="site-header"><a class="brand" href="index.html"><span class="brand-mark">ST</span><span>Seeds of the Throne</span></a><button class="menu-button" data-menu-button aria-expanded="false" aria-controls="site-nav">Explore <span aria-hidden="true">+</span></button><nav class="site-nav" id="site-nav" data-site-nav aria-label="Primary navigation">{nav}</nav></header>
<main id="main"><header class="atlas-hero"><div><p class="eyebrow">A story in development · September 2026</p><h1>{html.escape(title)}</h1><p class="atlas-deck">{html.escape(deck)}</p><p class="atlas-status">Fictional setting. Confirmed direction, working models, and open decisions are labeled.</p></div>{art}</header>{body}</main><footer class="atlas-footer"><a href="index.html">Story atlas</a><a href="visuals.html">Visual identity</a><a href="archive.html">Development record</a><a href="ideas.html">Experimental ideas</a><a href="https://iainreid.dev/devsite/iainreiddotdev/project-explorer/">Development Explorer</a><p>Built from reviewed vault Markdown. This snapshot changes when the sites are rebuilt.</p></footer></body></html>'''

def main():
    outputs={};entries=[]
    for path in sorted(PUBLIC.glob('*.md')):
        text=path.read_text();meta=metadata(text);slug=meta['route'];title=meta['title'];deck=meta['deck']
        content=re.sub(r'^---\n.*?\n---\n','',text,flags=re.S)
        sections=re.split(r'(?=^## )',content,flags=re.M)
        body='<div class="atlas-body">'
        for section in sections:
            if not section.strip(): continue
            if section.startswith('## Spoilers:'):
                heading,_,rest=section.partition('\n');body+='<details class="spoiler"><summary>'+html.escape(heading[3:])+'</summary><div class="reading">'+render(rest)+'</div></details>'
            else: body+='<section class="reading">'+render(section)+'</section>'
        body+='</div>'
        if slug=='characters':
            portraits=[('sylvan-elaria-identity-master-v1.jpg','Sylvan'),('samuel-franklin-identity-master-v1.jpg','Samuel Franklin'),('konrad-fitzgerald-identity-anchor-v1.webp','Konrad Fitzgerald')]
            gallery='<div class="portrait-strip">'+''.join('<figure><img src="assets/images/'+file+'" alt="Approved identity portrait of '+name+'" loading="lazy"><figcaption>'+name+'</figcaption></figure>' for file,name in portraits)+'</div>'
            body=gallery+body
        if slug=='index':
            state=(ROOT/'07 Coordination/Story Completion Workflow/CURRENT.md').read_text()
            match=re.search(r'\*\*Completed at this depth:\*\*\s*(\d+)\s*/\s*(\d+)',state)
            count,total=match.groups() if match else ('0','0')
            body+='<section class="atlas-body"><div class="reading"><h2>Current development snapshot</h2><p><strong>'+count+' / '+total+'</strong> tasks completed at Macro Shape. This is one development depth, not manuscript completion.</p><progress max="'+total+'" value="'+count+'" aria-label="Macro Shape tasks complete">'+count+' / '+total+'</progress><p><a href="todo.html">Full completion dashboard</a> · <a href="ideas.html">Existing experimental ideas and research status</a> · <a href="workshop.html">New decision workshop</a></p></div></section>'
        outputs[DOCS/(slug+'.html')]=shell(slug,title,deck,body,meta.get('image'))
        entries.append({'route':slug,'title':title,'deck':deck,'source':str(path.relative_to(ROOT)),'html':body})
    modules=[]
    for path in sorted(WORKSHOP.glob('[0-9][0-9] - *.md')):
        text=path.read_text();meta=metadata(text);pathstr=str(path.relative_to(ROOT))
        packet_html=re.sub(r'<(/?)h([1-4])\b',lambda m:'<'+m[1]+'h'+str(int(m[2])+2),render(text))
        modules.append({'id':meta['module'],'title':meta['title'],'gate':meta['gate'],'status':meta.get('status','unknown'),'prerequisites':meta.get('prerequisites',''),'path':pathstr,'markdown':text,'html':packet_html})
    if modules:
        overview=render((WORKSHOP/'README.md').read_text()).replace('<h1 ', '<h2 ').replace('</h1>', '</h2>')
        cards=''.join(f'<a class="module-card" href="workshop.html?module={m["id"]}#session"><span>{m["id"]}</span><strong>{html.escape(m["title"])}</strong><small>{html.escape(m["gate"])}</small></a>' for m in modules)
        body='<div class="atlas-body"><details class="spoiler"><summary>How to use the workshop and review the accepted pass</summary><section class="reading">'+overview+'</section></details><section id="session" class="workshop-session" data-workshop data-source="assets/story-workshop.json"><p role="status">Loading the selected decision packet. Markdown downloads remain available below.</p></section><details class="spoiler"><summary>Browse all twenty modules</summary><nav class="module-grid" aria-label="Workshop modules">'+cards+'</nav></details><noscript><p>JavaScript is needed for the draft editor. Read or download the full Markdown packets below.</p></noscript><details class="spoiler"><summary>All source packets: spoilers and non-canon alternatives</summary><ul>'+''.join(f'<li><a href="assets/workshop/{m["id"]}.md">{html.escape(m["title"])}</a></li>' for m in modules)+'</ul></details></div><script src="workshop.js?v=20260906" defer></script>'
        outputs[DOCS/'workshop.html']=shell('workshop','Build the missing connections.','Twenty accepted directions with unresolved mechanics preserved for focused development.',body)
        for m in modules: outputs[DOCS/'assets/workshop'/f'{m["id"]}.md']=m['markdown']
    data={'version':2,'built_from':'2026-09-06 accepted workshop Markdown','modules':modules}
    outputs[DOCS/'assets/story-workshop.json']=json.dumps(data,ensure_ascii=False,indent=2)+'\n'
    outputs[DOCS/'assets/story-atlas.json']=json.dumps(entries,ensure_ascii=False,indent=2)+'\n'
    # Bundle the exact workflow pointers and their targets; clients never mix this build with live main.
    snapshots=['07 Coordination/Weekly Synthesis/CURRENT-COMPLETION-TODO.md','07 Coordination/Story Completion Workflow/CURRENT.md','07 Coordination/Story Completion Workflow/TASK-REGISTRY.md','08 Story Loop/Brainstorms/CURRENT-EXPERIMENTAL-IDEAS.md']
    for s in list(snapshots):
        match=re.search(r'^source_path:\s*(.+)$',(ROOT/s).read_text(),re.M)
        if match: snapshots.append(match[1].strip())
    for s in snapshots: outputs[DOCS/'assets/vault'/s]=(ROOT/s).read_text()
    for path,text in outputs.items(): path.parent.mkdir(parents=True,exist_ok=True);path.write_text(text)
    manifest={str(p.relative_to(ROOT)):hashlib.sha256(t.encode()).hexdigest() for p,t in outputs.items()}
    (DOCS/'assets/story-build.json').write_text(json.dumps(manifest,indent=2)+'\n')
    print(f'Built {len(entries)} atlas pages, {len(modules)} modules, {len(outputs)} projections.')

if __name__=='__main__': main()
