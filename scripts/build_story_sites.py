#!/usr/bin/env python3
"""Build reviewed Markdown projections. Python standard library only; no runtime service."""
from pathlib import Path
import html, re, json, hashlib, shutil, sys
from urllib.parse import quote, urlsplit

sys.path.insert(0, str(Path(__file__).resolve().parent))
from workshop_contract import ROOT, load_workshop_modules

PUBLIC = ROOT / '05 Public/Atlas'
DOCS = ROOT / 'docs'
NAV_STORY = [('index','Story'),('colonization','World'),('ai','Luminai'),('characters','Characters'),('faction','Conspiracy'),('timeline','Timeline')]
NAV_DEV = [('ideas','Ideas'),('todo','Progress'),('workshop','Workshop'),('research','Research')]
NAV_RECORDS = [('visuals','Visuals'),('archive','Archive')]
ASSET = '20260911-book-one-architecture'
IMAGE_ALT = {
    'konrad-controlled-by-samuel-key-art-v1.webp': 'Samuel covertly controls Konrad while Sylvan observes the relationship.',
    'sylvan-elaria-identity-master-v1.jpg': 'Approved visual identity portrait of Sylvan Elaria.',
    'samuel-franklin-identity-master-v1.jpg': 'Approved visual identity portrait of Samuel Franklin.',
    'konrad-fitzgerald-identity-anchor-v1.webp': 'Approved visual identity portrait of Konrad Fitzgerald.',
    'samuel-sylvan-confrontation.jpg': 'Approved scene of Samuel confronting Sylvan.',
    'remote-war-gold.jpg': 'Approved historical scene of remote war in gold light.',
    'disclosure-poster.jpg': 'Approved disclosure poster from the story world.',
    'planetary-cutaway-hero-desktop-v1.webp': 'Symbolic visualization of an inhabited surface civilization above concealed planetary infrastructure.',
    'planetary-cutaway-hero-mobile-v1.webp': 'Portrait symbolic visualization of an inhabited surface civilization above concealed planetary infrastructure.',
    'surface-civilization-editorial-v1.webp': 'Interpretive editorial view of a lived-in coastal civilization on the colonization planet.',
    'recovered-records-evidence-v1.webp': 'Interpretive still life of recovered records aligned against hidden-system evidence.',
}
PAGE_CLASS = {
    'index': 'page-home',
    'colonization': 'page-world',
    'ai': 'page-luminai',
    'characters': 'page-characters',
    'faction': 'page-conspiracy',
    'timeline': 'page-timeline',
    'research': 'page-research',
    'archive': 'page-archive',
    'workshop': 'page-workshop',
}

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
    s=re.sub(r'(?<!\*)\*([^*]+)\*(?!\*)',r'<em>\1</em>',s)
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

def nav_links(slug, items):
    return ''.join(f'<a href="{key}.html"'+(' aria-current="page"' if key==slug else '')+'>'+label+'</a>' for key,label in items)

def pale_signal_masthead(title, deck):
    alt_desktop = IMAGE_ALT['planetary-cutaway-hero-desktop-v1.webp']
    return f'''<header class="signal-masthead" aria-labelledby="home-title">
  <div class="signal-masthead__copy">
    <p class="eyebrow">A science-fiction story in development</p>
    <h1 id="home-title">{html.escape(title)}</h1>
    <p class="atlas-deck">{html.escape(deck)}</p>
    <p class="atlas-status">Confirmed story information, developing ideas, and unanswered questions are labeled separately.</p>
    <p class="hero-consequence">The final battle is not about taking the planet. It is about making everyone see who has been contained all along.</p>
    <p class="hero-actions"><a class="button" href="colonization.html">Enter the story</a><a class="button secondary" href="https://iainreid.dev/devsite/iainreiddotdev/project-explorer/">See how it is being built</a></p>
  </div>
  <div class="signal-fragment">
    <figure class="signal-fragment__frame">
      <picture>
        <source media="(max-width: 52rem)" srcset="assets/images/planetary-cutaway-hero-mobile-v1.webp" width="941" height="1672">
        <img src="assets/images/planetary-cutaway-hero-desktop-v1.webp" alt="{html.escape(alt_desktop)}" width="1672" height="941" fetchpriority="high">
      </picture>
    </figure>
    <p class="signal-annotation">Infrastructure held beneath ordinary life.</p>
  </div>
</header>'''

def homepage_editorial(body_html, count, total):
    surface_alt = IMAGE_ALT['surface-civilization-editorial-v1.webp']
    evidence_alt = IMAGE_ALT['recovered-records-evidence-v1.webp']
    return f'''<div class="home-sequence">
  <section class="editorial-band editorial-band--surface" aria-labelledby="surface-title">
    <figure class="editorial-band__media">
      <img src="assets/images/surface-civilization-editorial-v1.webp" alt="{html.escape(surface_alt)}" width="1536" height="1024" loading="lazy">
      <figcaption>Interpretive visualization. The surface civilization is real and inhabited; the exact city is not established.</figcaption>
    </figure>
    <div class="editorial-band__copy reading">
      <p class="eyebrow">The world everyone knew</p>
      <h2 id="surface-title">A real life inside a constructed world.</h2>
      <p>Its institutions, daily work, relationships, and apparent technology must feel like a civilization before participants understand its hidden architecture. Participants retain real agency, so the resulting history can diverge from its source.</p>
      <p><a href="colonization.html">Discover the colonization world</a></p>
    </div>
  </section>
  <section class="editorial-band editorial-band--system" aria-labelledby="system-title">
    <div class="editorial-band__copy reading">
      <p class="eyebrow">The system underneath</p>
      <h2 id="system-title">A process for resources, training, and containment.</h2>
      <p>Humanity built a process that could create sustainable resources, support a large population, train people for greater responsibility, and contain dangerous criminals. Inside that environment, humanity developed the Luminai.</p>
      <p class="interpretive-note">Diagrams of rooms and machinery on this site are interpretive visualizations, not literal engineering plans.</p>
      <p><a href="ai.html">Understand the Luminai</a></p>
    </div>
  </section>
  <section class="editorial-band editorial-band--power" aria-labelledby="power-title">
    <div class="editorial-band__copy">
      <p class="eyebrow">Competing uses of power</p>
      <h2 id="power-title">People before positions.</h2>
      <div class="power-triptych">
        <figure>
          <img src="assets/images/konrad-fitzgerald-identity-anchor-v1.webp" alt="{html.escape(IMAGE_ALT['konrad-fitzgerald-identity-anchor-v1.webp'])}" width="570" height="900" loading="lazy">
          <figcaption><span class="status established">Approved appearance</span><strong>Konrad</strong><small>Public domination and hierarchy</small></figcaption>
        </figure>
        <figure>
          <img src="assets/images/samuel-franklin-identity-master-v1.jpg" alt="{html.escape(IMAGE_ALT['samuel-franklin-identity-master-v1.jpg'])}" width="1024" height="1536" loading="lazy">
          <figcaption><span class="status established">Approved appearance</span><strong>Samuel</strong><small>Private capture and controlled interpretation</small></figcaption>
        </figure>
        <figure>
          <img src="assets/images/sylvan-elaria-identity-master-v1.jpg" alt="{html.escape(IMAGE_ALT['sylvan-elaria-identity-master-v1.jpg'])}" width="1024" height="1536" loading="lazy">
          <figcaption><span class="status established">Approved appearance</span><strong>Sylvan</strong><small>Reality, correction, and consent</small></figcaption>
        </figure>
      </div>
      <p><a href="characters.html">Meet the people</a> · <a href="faction.html">Follow the conspiracy</a></p>
    </div>
  </section>
  <section class="editorial-band editorial-band--evidence" aria-labelledby="evidence-title">
    <figure class="editorial-band__media">
      <img src="assets/images/recovered-records-evidence-v1.webp" alt="{html.escape(evidence_alt)}" width="1774" height="887" loading="lazy">
      <figcaption>Interpretive visualization of recovered records and provenance paths. Not literal documents.</figcaption>
    </figure>
    <div class="editorial-band__copy reading">
      <p class="eyebrow">The record does not agree</p>
      <h2 id="evidence-title">Evidence is not the same thing as an explanation.</h2>
      <p>The colonization environment can direct people toward numbers, records, places, and historical patterns. Each person must decide which patterns matter and what they actually prove. Samuel understands that difference.</p>
      <p><a href="faction.html">Follow the conspiracy</a> · <a href="research.html">See the research boundaries</a></p>
    </div>
  </section>
  {body_html}
  <section class="editorial-band editorial-band--forward" aria-labelledby="forward-title">
    <div class="editorial-band__copy reading">
      <p class="eyebrow">Watch the story being built</p>
      <h2 id="forward-title">Follow the story, or see how it is being built.</h2>
      <p>This project is being developed in public with an AI-assisted story system. Ideas begin as conversation, become clear decisions, and move toward scenes and finished prose without hiding what is settled and what still needs work.</p>
      <p class="hero-actions"><a class="button" href="colonization.html">Enter the story</a><a class="button secondary" href="https://iainreid.dev/devsite/iainreiddotdev/project-explorer/">Open Project Explorer</a></p>
    </div>
  </section>
  <section class="home-progress"><div class="reading"><h2>The story is being built in public.</h2><p><strong>{count} of {total}</strong> Book One architecture questions have accepted answers in the current development pass. The ending is established; this workshop is building the objective, opening, middle, character choices, and scene-ready sequence that lead to it.</p><progress max="{total}" value="{count}" aria-label="Book One architecture questions with accepted answers">{count} / {total}</progress><p><a href="todo.html">Follow the story roadmap</a> · <a href="ideas.html">Explore ideas in development</a> · <a href="workshop.html">Join the current workshop</a></p></div></section>
</div>'''

def shell(slug,title,deck,body,image=None,hero_html=None):
    nav='<div class="nav-group" aria-label="Story">'+nav_links(slug,NAV_STORY)+'</div><div class="nav-group" aria-label="Development">'+nav_links(slug,NAV_DEV)+'</div><div class="nav-group" aria-label="Records">'+nav_links(slug,NAV_RECORDS)+'</div>'
    page_class = PAGE_CLASS.get(slug, 'atlas-page')
    if hero_html:
        hero = hero_html
    else:
        alt=IMAGE_ALT.get(image,'Approved artwork from Seeds of the Throne.')
        art=f'<figure class="atlas-art"><img src="assets/images/{image}" alt="{html.escape(alt)}" loading="lazy"><figcaption>Approved appearance. Scene symbolism is interpretation.</figcaption></figure>' if image else ''
        actions='<p class="hero-actions"><a class="button" href="colonization.html">Enter the story</a><a class="button secondary" href="archive.html">See how it is being developed</a></p>' if slug=='index' else ''
        hero=f'<header class="atlas-hero"><div><p class="eyebrow">A science-fiction story in development</p><h1>{html.escape(title)}</h1><p class="atlas-deck">{html.escape(deck)}</p><p class="atlas-status">Confirmed story information, developing ideas, and unanswered questions are labeled separately.</p>{actions}</div>{art}</header>'
    return f'''<!doctype html>
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><meta name="theme-color" content="#dbe4e7"><title>{html.escape(title)} | Seeds of the Throne</title><meta name="description" content="{html.escape(deck,quote=True)}"><link rel="icon" href="favicon.svg"><link rel="stylesheet" href="styles.css?v={ASSET}"><link rel="stylesheet" href="atlas.css?v={ASSET}"><script src="app.js?v={ASSET}" defer></script></head>
<body class="atlas-page {page_class}"><a class="skip-link" href="#main">Skip to content</a><header class="site-header"><a class="brand" href="index.html"><span class="brand-mark">ST</span><span>Seeds of the Throne</span></a><button class="menu-button" type="button" data-menu-button aria-expanded="false" aria-controls="site-nav">Menu</button><nav class="site-nav" id="site-nav" data-site-nav aria-label="Primary navigation">{nav}</nav></header>
<main id="main">{hero}{body}</main><footer class="atlas-footer"><a href="index.html">Story</a><a href="visuals.html">Visuals</a><a href="archive.html">How it is being built</a><a href="research.html">Research</a><a href="ideas.html">Ideas in development</a><a href="https://iainreid.dev/devsite/iainreiddotdev/project-explorer/">Project Explorer</a><p>This site presents the story. The Project Explorer shows the notes and tools used to develop it.</p></footer></body></html>'''

def main():
    modules, workshop_errors = load_workshop_modules()
    if workshop_errors:
        print('\n'.join(workshop_errors)); sys.exit(1)
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
        hero_html=None
        image=meta.get('image')
        if slug=='characters':
            portraits=[
                ('konrad-fitzgerald-identity-anchor-v1.webp','Konrad Fitzgerald','Public hierarchy and command'),
                ('samuel-franklin-identity-master-v1.jpg','Samuel Franklin','Private compromise and capture'),
                ('sylvan-elaria-identity-master-v1.jpg','Sylvan Elaria','Reality contact and correction'),
            ]
            gallery='<div class="power-triptych power-triptych--page">'+''.join(
                f'<figure><img src="assets/images/{file}" alt="Approved identity portrait of {name}" loading="lazy"><figcaption><span class="status established">Approved appearance</span><strong>{name}</strong><small>{role}</small></figcaption></figure>'
                for file,name,role in portraits
            )+'</div>'
            body=gallery+body
        if slug=='index':
            state=(ROOT/'07 Coordination/Story Completion Workflow/CURRENT.md').read_text()
            match=re.search(r'\*\*Completed at this depth:\*\*\s*(\d+)\s*/\s*(\d+)',state)
            count,total=match.groups() if match else ('0','0')
            # Keep approved story sections; wrap with editorial bands and drop duplicate progress inject from old builder.
            body=homepage_editorial(body, count, total)
            hero_html=pale_signal_masthead(title, deck)
            image=None
        if slug=='faction':
            body='<figure class="evidence-banner"><img src="assets/images/recovered-records-evidence-v1.webp" alt="'+html.escape(IMAGE_ALT['recovered-records-evidence-v1.webp'])+'" width="1774" height="887" loading="lazy"><figcaption>Interpretive evidence composition. Claim, source, discrepancy, and consequence remain separate.</figcaption></figure>'+body
        if slug=='colonization':
            body='<figure class="layered-world"><img src="assets/images/surface-civilization-editorial-v1.webp" alt="'+html.escape(IMAGE_ALT['surface-civilization-editorial-v1.webp'])+'" width="1536" height="1024" loading="lazy"><figcaption>Interpretive surface civilization. Ordinary institutions and lives have real weight.</figcaption></figure>'+body
        outputs[DOCS/(slug+'.html')]=shell(slug,title,deck,body,image,hero_html)
        entries.append({'route':slug,'title':title,'deck':deck,'source':str(path.relative_to(ROOT)),'html':body})
    for module in modules:
        packet_html=re.sub(r'<(/?)h([1-4])\b',lambda match:'<'+match[1]+'h'+str(int(match[2])+2),render(module['markdown']))
        module['html']=packet_html
    if modules:
        cards=''.join(f'<a class="module-card" href="workshop.html?module={m["id"]}#session"><span>{m["id"]}</span><strong>{html.escape(m["title"])}</strong><small>{html.escape(m["gate"])}</small></a>' for m in modules)
        body='<div class="atlas-body"><section class="reading"><h2>How the current workshop works</h2><p>These ten questions turn the established ending into a buildable Book One. Choose one topic to read the known constraints, alternatives, scene test, and author gate. New answers entered here remain browser drafts unless exported.</p></section><section id="session" class="workshop-session" data-workshop data-source="assets/story-workshop.json?v='+ASSET+'"><p role="status">Loading the selected story question.</p></section><details class="spoiler"><summary>Choose from ten Book One architecture topics</summary><nav class="module-grid" aria-label="Workshop topics">'+cards+'</nav></details><noscript><p>JavaScript is needed to use the interactive workshop. The complete questions can also be read below.</p></noscript><details class="spoiler"><summary>Read the complete workshop notes</summary><ul>'+''.join(f'<li><a href="assets/workshop/{m["id"]}.md">{html.escape(m["title"])}</a></li>' for m in modules)+'</ul></details></div><script src="workshop.js?v='+ASSET+'" defer></script>'
        outputs[DOCS/'workshop.html']=shell('workshop','Build the path through Book One','The current workshop defines the contest, deception, countdown, opening, middle, character choices, evidence order, and scene-ready sequence that lead to the established ending.',body)
        for m in modules: outputs[DOCS/'assets/workshop'/f'{m["id"]}.md']=m['markdown']
    # Preserve previously published workshop packets as historical source links.
    for path in sorted((ROOT/'07 Coordination/Story Completion Workflow/Workshop').glob('[0-9][0-9] - *.md')):
        outputs[DOCS/'assets/workshop'/f'{path.name[:2]}.md'] = path.read_text()
    for path in sorted((ROOT/'07 Coordination/Story Completion Workflow/Reassessment Workshop').glob('[0-9][0-9] - *.md')):
        ident = metadata(path.read_text()).get('module')
        if ident:
            outputs[DOCS/'assets/workshop'/f'{ident}.md'] = path.read_text()
    data={'version':3,'built_from':'2026-09-11 Book One architecture workshop','modules':modules}
    outputs[DOCS/'assets/story-workshop.json']=json.dumps(data,ensure_ascii=False,indent=2)+'\n'
    outputs[DOCS/'assets/story-atlas.json']=json.dumps(entries,ensure_ascii=False,indent=2)+'\n'
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
