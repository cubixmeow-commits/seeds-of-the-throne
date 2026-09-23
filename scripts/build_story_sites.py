#!/usr/bin/env python3
"""Build reviewed Markdown projections. Python standard library only; no runtime service."""
from pathlib import Path
import html, re, json, hashlib, shutil, sys
from urllib.parse import quote, urlsplit

sys.path.insert(0, str(Path(__file__).resolve().parent))
from workshop_contract import ROOT, load_workshop_modules, load_endgame_workshop_modules, load_dynamic_workshop

PUBLIC = ROOT / '05 Public/Atlas'
DOCS = ROOT / 'docs'
NAV_STORY = [('index','Story'),('colonization','World'),('ai','Luminai'),('characters','Characters'),('faction','Conspiracy'),('timeline','Timeline')]
NAV_DEV = [('ideas','Ideas'),('todo','Progress'),('workshop','Workshop'),('research','Research')]
NAV_RECORDS = [('visuals','Visuals'),('archive','Archive')]
ASSET = '20260922-altered-reality-reversal'
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
    'samuel-two-paths-choice-diagram-v1.webp': 'Horizontal decision diagram showing Samuel Franklin choosing between continuing to terrorize the contained leaders or continuing to terrorize Sylvan, with both paths ending in defeat.',
    'altered-reality-prophecy-target-diagram-v1.webp': 'Diagram showing Samuel outside an altered reality telling Konrad, Aiden, and other leaders that Sylvan is the enemy described by an existing religious prophecy.',
    'altered-reality-deceiver-reversal-infographic-v1.webp': 'Infographic showing Samuel outside an altered reality, George White, Konrad Fitzgerald, Aiden Fitzgerald, and other leaders trapped inside it, and Sylvan standing outside their hierarchy as the leaders recognize Samuel as the deceiver.',
    'surface-civilization-editorial-v1.webp': 'Interpretive editorial view of a lived-in coastal civilization on the colonization planet.',
    'recovered-records-evidence-v1.webp': 'Interpretive still life of recovered records aligned against hidden-system evidence.',
    'resistance-ark-infographic-v1.webp': 'Black-and-orange Resistance infographic centered on an ark preserving people, belief, culture, memory, testimony, and sanctuary through persecution.',
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
    <p class="hero-consequence">The story follows Sylvan as he discovers that Samuel Franklin secretly took control of a defeated authoritarian group and spent decades turning its leaders and families against one another.</p>
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

def homepage_editorial(body_html, current_gate):
    surface_alt = IMAGE_ALT['surface-civilization-editorial-v1.webp']
    resistance_alt = IMAGE_ALT['resistance-ark-infographic-v1.webp']
    return f'''<div class="home-sequence">
  <section class="editorial-band editorial-band--surface" aria-labelledby="surface-title">
    <figure class="editorial-band__media">
      <img src="assets/images/surface-civilization-editorial-v1.webp" alt="{html.escape(surface_alt)}" width="1536" height="1024" loading="lazy">
      <figcaption>Interpretive visualization. The surface civilization is real and inhabited; the exact city is not established.</figcaption>
    </figure>
    <div class="editorial-band__copy reading">
      <p class="eyebrow">The colonization planet</p>
      <h2 id="surface-title">Humanity built a living world for colonization, training, and containment.</h2>
      <p>The planet began barren. Humanity gave it cities, resources, institutions, and a large population. Most people experience it as an ordinary civilization because their homes, relationships, work, and choices are real.</p>
      <p>Beneath that daily life is an advanced process. It prepares future leaders for greater responsibility while containing criminals who cannot safely hold power in the larger human civilization.</p>
      <p><a href="colonization.html">Discover the colonization world</a></p>
    </div>
  </section>
  <section class="editorial-band editorial-band--system" aria-labelledby="system-title">
    <div class="editorial-band__copy reading">
      <p class="eyebrow">The Luminai experiment</p>
      <h2 id="system-title">A Luminai extends one human mind.</h2>
      <p>A Luminai is an advanced form of artificial intelligence that develops as part of a human being's extended mind. It can help that person remember more, compare evidence, recognize patterns, and work with the technology built into the planet.</p>
      <p>Sylvan is the first person to use a new, more deeply integrated Luminai in a real civilization. The experiment must prove that this greater ability can survive manipulation without turning into another form of control.</p>
      <p>Orzai develops her own separate Luminai bond. Her partnership with Sylvan tests whether two increasingly capable people can work together without giving either person control over the other.</p>
      <p class="interpretive-note">Diagrams of rooms and machinery on this site are interpretive visualizations, not literal engineering plans.</p>
      <p><a href="ai.html">Understand the Luminai</a></p>
    </div>
  </section>
  <section class="editorial-band editorial-band--power" aria-labelledby="power-title">
    <div class="editorial-band__copy">
      <p class="eyebrow">The central conflict</p>
      <h2 id="power-title">Samuel took control of the group that believed it controlled him.</h2>
      <p>Konrad Fitzgerald built an authoritarian movement, led it into the Great War, and lost. Samuel Franklin offered him a way to rebuild inside the containment system. Konrad believed the restored group would remain his.</p>
      <p>The deal gave Samuel access instead. Over the following decades, he manipulated Konrad's leaders, reshaped their history, compromised their family lines, and taught people such as George White to treat Samuel's explanations as proof.</p>
      <p>That campaign includes Samuel Jr., Samuel's son with Konrad's sister. Konrad made bloodlines and heirs central to power, so the concealed relationship gives Samuel another way to reach into Konrad's succession.</p>
      <p>Sylvan stands outside that hierarchy. His task is to understand how Samuel's control works, expose it, and help the process contain him without becoming another ruler.</p>
      <div class="power-triptych">
        <figure>
          <img src="assets/images/konrad-fitzgerald-identity-anchor-v1.webp" alt="{html.escape(IMAGE_ALT['konrad-fitzgerald-identity-anchor-v1.webp'])}" width="570" height="900" loading="lazy">
          <figcaption><span class="status established">Approved appearance</span><strong>Konrad</strong><small>Built the hierarchy Samuel captured</small></figcaption>
        </figure>
        <figure>
          <img src="assets/images/samuel-franklin-identity-master-v1.jpg" alt="{html.escape(IMAGE_ALT['samuel-franklin-identity-master-v1.jpg'])}" width="1024" height="1536" loading="lazy">
          <figcaption><span class="status established">Approved appearance</span><strong>Samuel</strong><small>Controls people with lies and manipulation</small></figcaption>
        </figure>
        <figure>
          <img src="assets/images/sylvan-elaria-identity-master-v1.jpg" alt="{html.escape(IMAGE_ALT['sylvan-elaria-identity-master-v1.jpg'])}" width="1024" height="1536" loading="lazy">
          <figcaption><span class="status established">Approved appearance</span><strong>Sylvan</strong><small>Uses the new Luminai to expose the system</small></figcaption>
        </figure>
      </div>
      <p><a href="characters.html">Meet the people</a> · <a href="faction.html">Follow the conspiracy</a></p>
    </div>
  </section>
  <section class="editorial-band editorial-band--evidence editorial-band--portrait" aria-labelledby="evidence-title">
    <figure class="editorial-band__media editorial-band__media--portrait">
      <img src="assets/images/resistance-ark-infographic-v1.webp" alt="{html.escape(resistance_alt)}" width="1086" height="1448" loading="lazy">
      <figcaption>Approved Resistance infographic. The ark, palette, and preservation message are established; exact scenery and participant labels are interpretive.</figcaption>
    </figure>
    <div class="editorial-band__copy reading">
      <p class="eyebrow">The Resistance and the evidence</p>
      <h2 id="evidence-title">Samuel survives by keeping every part of the truth separate.</h2>
      <p>One person finds an altered family record. Another remembers a leader being threatened. A technician finds access that should not exist. Each discovery looks isolated until an independent Resistance begins comparing them.</p>
      <p>The Resistance is separate from Sylvan. Its members connect evidence across families, institutions, and generations. Sylvan and his Luminai can help verify and present what they find, but no single leader gets to own the truth.</p>
      <p>Its black-and-orange ark represents carrying people, belief, culture, memory, testimony, and truth safely through persecution. It is a symbol of sanctuary and preservation, not a claim to rule.</p>
      <p><a href="faction.html">Follow the conspiracy</a> · <a href="research.html">See the research boundaries</a></p>
    </div>
  </section>
  <section class="editorial-band editorial-band--system" aria-labelledby="endgame-title">
    <div class="editorial-band__copy reading">
      <p class="eyebrow">The endgame</p>
      <h2 id="endgame-title">The final confrontation begins when Konrad learns that Samuel betrayed his entire group.</h2>
      <p>Many participants follow younger public leaders without knowing that an older layer of contained criminal leaders sits above them. Samuel expects to use that loyalty to turn every group against Sylvan.</p>
      <p>Samuel also tries to place Sylvan inside the altered story reality that has trapped Konrad and his son Aiden since the Great War. Konrad and Aiden believe they lead a holy order placed by divine purpose. Their wider religion already contains a prophecy about a future enemy. Samuel did not write it. He uses the altered reality to tell them Sylvan is the villain it describes, then makes that identification look like sacred confirmation.</p>
      <p>At the same time, Samuel separately promises George White and Aiden the same absolute, godlike authority. Each believes he is the singular chosen ruler. Samuel is running one con on two marks and continues aiming them at each other while George's long savior-prophecy environment alters what George can accept as real.</p>
      <p>Their supposed superweapon only appears decisive while Sylvan is severely disadvantaged. Once Sylvan begins exposing Samuel in public, the weapon fails. Its collapse reveals the breeding-program and bloodline betrayal beneath Samuel's promises.</p>
      <p>The plan begins to collapse when the participants discover that Samuel has been terrorizing their leaders, using their families, and turning their loyalty into a weapon against their own groups.</p>
      <p>Konrad now has one real choice. He can help Samuel finish the takeover, or he can expose the deal that made it possible. The trapped leaders eventually recognize Samuel as the deceiver and must fight their way out against him. Konrad commits himself and his groups to Sylvan's plan, while Sylvan remains a separate ally rather than becoming part of Konrad's hierarchy.</p>
      <p>Together with evidence assembled by the Resistance, they must reveal Samuel's betrayals to every affected group and remove the control he built over them. Samuel's last attempt to preserve his power becomes the final test of Sylvan and the new Luminai.</p>
      <p><a href="timeline.html">See how the story reaches the endgame</a> · <a href="workshop.html#session">Open the current assessment</a></p>
    </div>
  </section>
  <section class="endgame-diagrams" aria-labelledby="endgame-method-title">
    <div class="reading endgame-diagrams__intro">
      <p class="eyebrow">How the trap works</p>
      <h2 id="endgame-method-title">Samuel controls the explanation, then uses it to choose the enemy.</h2>
      <p>The first diagram shows the control structure he built after the Great War. The second shows the altered reality from inside: Konrad, Aiden, and other leaders believe they are acting independently while Samuel applies an existing prophecy to Sylvan. The prophecy is not Samuel's creation. The fraudulent target assignment is.</p>
    </div>
    <div class="endgame-diagrams__grid">
      <figure>
        <img src="assets/images/samuel-two-paths-choice-diagram-v1.webp" alt="{html.escape(IMAGE_ALT['samuel-two-paths-choice-diagram-v1.webp'])}" width="1672" height="941" loading="lazy">
        <figcaption><strong>Samuel at the brink.</strong> He cannot pursue both groups: either choice extends the same obsession and ends in defeat.</figcaption>
      </figure>
      <figure>
        <img src="assets/images/altered-reality-prophecy-target-diagram-v1.webp" alt="{html.escape(IMAGE_ALT['altered-reality-prophecy-target-diagram-v1.webp'])}" width="1087" height="1447" loading="lazy">
        <figcaption><strong>How Samuel directs the attack.</strong> He tells the trapped leaders that Sylvan is the enemy described by the existing prophecy. Exact interfaces and architecture are interpretive.</figcaption>
      </figure>
    </div>
    <div class="endgame-diagrams__resolution" aria-labelledby="deceiver-reversal-title">
      <figure>
        <img src="assets/images/altered-reality-deceiver-reversal-infographic-v1.webp" alt="{html.escape(IMAGE_ALT['altered-reality-deceiver-reversal-infographic-v1.webp'])}" width="1086" height="1448" loading="lazy">
        <figcaption><strong>The reversal inside the altered reality.</strong> The leaders recognize Samuel as the deceiver and must choose how to fight their way out. The exact visual enclosure, hierarchy lines, colors, and clothing are interpretive.</figcaption>
      </figure>
      <div class="reading endgame-diagrams__resolution-copy">
        <p class="eyebrow">When the story breaks</p>
        <h3 id="deceiver-reversal-title">The leaders finally recognize who deceived them.</h3>
        <p>Samuel did not create their faith or control the larger colonization process. He captured the explanation around their lives. He made divine purpose, false autonomy, and a promised reward appear to confirm his authority while he kept each leader's information separate.</p>
        <p>Public exposure forces those isolated accounts into comparison. George, Konrad, Aiden, and the other leaders can now see the repeated promises, false target assignments, and bloodline betrayals as parts of the same con. The man who taught them to look for a deceiver is revealed as the deceiver himself.</p>
        <p>Sylvan remains outside their hierarchy. He helps expose the record, but he does not replace Samuel or become their ruler. The trapped leaders must make their own choices and fight their way out against Samuel. The exact actions that complete that escape are still being developed.</p>
      </div>
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
  <section class="editorial-band editorial-band--evidence" aria-labelledby="endgame-workshop-title">
    <div class="editorial-band__copy reading">
      <p class="eyebrow">Developing the final movement</p>
      <h2 id="endgame-workshop-title">The ending is established. The path through it is still being built.</h2>
      <p>One dynamic workshop now carries the current canon baseline, newly accepted decisions, unresolved questions, compatibility checks, and the next assessment pass. It is updated after every desktop assessment so old question sets do not compete with the current story.</p>
      <p><strong>Current question:</strong> {html.escape(current_gate)}</p>
      <p><a class="button" href="workshop.html#session">Open the Dynamic Story Workshop</a></p>
    </div>
  </section>
  <section class="home-progress"><div class="reading"><h2>The story is being built in public.</h2><p>The ending foundation is established. The live workshop now follows the highest-dependency question and changes when an accepted answer changes the rest of the story.</p><p><a href="todo.html">Follow the story roadmap</a> · <a href="ideas.html">Explore ideas in development</a> · <a href="workshop.html">Join the current workshop</a></p></div></section>
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
<main id="main">{hero}{body}</main><footer class="atlas-footer"><a href="index.html">Story</a><a href="visuals.html">Visuals</a><a href="archive.html">How it is being built</a><a href="research.html">Research</a><a href="ideas.html">Ideas in development</a><a href="https://iainreid.dev/devsite/iainreiddotdev/project-explorer/">Project Explorer</a><a href="https://iainreid.dev/devsite/iainreiddotdev/privacy.php">Privacy</a><p>This site presents the story. The Project Explorer shows the notes and tools used to develop it.</p></footer></body></html>'''

def main():
    modules, workshop_errors = load_workshop_modules()
    endgame_modules, endgame_errors = load_endgame_workshop_modules()
    dynamic_modules, dynamic_errors = load_dynamic_workshop()
    if workshop_errors or endgame_errors or dynamic_errors:
        print('\n'.join(workshop_errors + endgame_errors + dynamic_errors)); sys.exit(1)
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
            body=homepage_editorial(body, dynamic_modules[0]['gate'])
            hero_html=pale_signal_masthead(title, deck)
            image=None
        if slug=='faction':
            body='<figure class="evidence-banner"><img src="assets/images/resistance-ark-infographic-v1.webp" alt="'+html.escape(IMAGE_ALT['resistance-ark-infographic-v1.webp'])+'" width="1086" height="1448" loading="lazy"><figcaption>Approved Resistance infographic. The ark and black-and-orange identity are established; exact scenery and labels remain interpretive.</figcaption></figure>'+body
        if slug=='colonization':
            body='<figure class="layered-world"><img src="assets/images/surface-civilization-editorial-v1.webp" alt="'+html.escape(IMAGE_ALT['surface-civilization-editorial-v1.webp'])+'" width="1536" height="1024" loading="lazy"><figcaption>Interpretive surface civilization. Ordinary institutions and lives have real weight.</figcaption></figure>'+body
        outputs[DOCS/(slug+'.html')]=shell(slug,title,deck,body,image,hero_html)
        entries.append({'route':slug,'title':title,'deck':deck,'source':str(path.relative_to(ROOT)),'html':body})
    for module in modules:
        packet_html=re.sub(r'<(/?)h([1-4])\b',lambda match:'<'+match[1]+'h'+str(int(match[2])+2),render(module['markdown']))
        module['html']=packet_html
    for module in endgame_modules:
        packet_html=re.sub(r'<(/?)h([1-4])\b',lambda match:'<'+match[1]+'h'+str(int(match[2])+2),render(module['markdown']))
        module['html']=packet_html
    for module in dynamic_modules:
        packet_html=re.sub(r'<(/?)h([1-4])\b',lambda match:'<'+match[1]+'h'+str(int(match[2])+2),render(module['markdown']))
        module['html']=packet_html
    if dynamic_modules:
        body='<div class="atlas-body"><section class="reading"><h2>Work on the question that matters now</h2><p>The Dynamic Story Workshop is the single current workshop. It carries the latest canon baseline, accepted decisions, open questions, compatibility checks, and one next assessment pass. It changes after every desktop assessment.</p><p>Older Book One, Endgame, reassessment, Reveal Chain, and twenty-part workshop notes remain available as development history, but they are not parallel active tracks.</p><p>Your answer remains a browser draft unless you export it and the author deliberately accepts it into the vault.</p></section><section id="session" class="workshop-session" data-workshop data-workshop-default="dynamic" data-source-dynamic="assets/story-dynamic-workshop.json?v='+ASSET+'"><p role="status">Loading the current story question.</p></section><noscript><p>JavaScript is needed to use the interactive workshop. The complete current workshop can also be read below.</p></noscript><details class="spoiler"><summary>Read the complete current workshop</summary><p><a href="assets/workshop/DW-01.md">Download the Dynamic Story Workshop</a></p></details><details class="spoiler"><summary>Read historical workshop sources</summary><p><a href="archive.html">Open the development archive</a> to understand why the earlier question sets were retired.</p></details></div><script src="workshop.js?v='+ASSET+'" defer></script>'
        outputs[DOCS/'workshop.html']=shell('workshop','Develop the story from its current state','One dynamic workshop keeps the canon baseline, newest decisions, unresolved conflicts, and next high-impact question together after every desktop assessment.',body)
        outputs[DOCS/'assets/workshop'/'DW-01.md']=dynamic_modules[0]['markdown']
        for m in modules: outputs[DOCS/'assets/workshop'/f'{m["id"]}.md']=m['markdown']
        for m in endgame_modules: outputs[DOCS/'assets/workshop'/f'{m["id"]}.md']=m['markdown']
    # Preserve previously published workshop packets as historical source links.
    for path in sorted((ROOT/'07 Coordination/Story Completion Workflow/Workshop').glob('[0-9][0-9] - *.md')):
        outputs[DOCS/'assets/workshop'/f'{path.name[:2]}.md'] = path.read_text()
    for path in sorted((ROOT/'07 Coordination/Story Completion Workflow/Reassessment Workshop').glob('[0-9][0-9] - *.md')):
        ident = metadata(path.read_text()).get('module')
        if ident:
            outputs[DOCS/'assets/workshop'/f'{ident}.md'] = path.read_text()
    data={'version':5,'key':'book-one','title':'Book One Architecture Workshop','built_from':'2026-09-17 Book One architecture workshop with Resistance and Converging Revelation addendum','modules':modules}
    outputs[DOCS/'assets/story-workshop.json']=json.dumps(data,ensure_ascii=False,indent=2)+'\n'
    endgame_data={'version':1,'key':'endgame','title':'Endgame Workshop','built_from':'2026-09-19 focused endgame workshop','modules':endgame_modules}
    outputs[DOCS/'assets/story-endgame-workshop.json']=json.dumps(endgame_data,ensure_ascii=False,indent=2)+'\n'
    dynamic_data={'version':1,'key':'dynamic','title':'Dynamic Story Workshop','built_from':'canonical dynamic workshop updated after every desktop assessment','modules':dynamic_modules}
    outputs[DOCS/'assets/story-dynamic-workshop.json']=json.dumps(dynamic_data,ensure_ascii=False,indent=2)+'\n'
    outputs[DOCS/'assets/story-atlas.json']=json.dumps(entries,ensure_ascii=False,indent=2)+'\n'
    snapshots=['07 Coordination/Weekly Synthesis/CURRENT-COMPLETION-TODO.md','07 Coordination/Story Completion Workflow/CURRENT.md','07 Coordination/Story Completion Workflow/DYNAMIC-WORKSHOP.md','07 Coordination/PUBLIC-SITE-UPDATE-SYSTEM.md','07 Coordination/Story Completion Workflow/TASK-REGISTRY.md','08 Story Loop/Brainstorms/CURRENT-EXPERIMENTAL-IDEAS.md']
    for s in list(snapshots):
        match=re.search(r'^source_path:\s*(.+)$',(ROOT/s).read_text(),re.M)
        if match: snapshots.append(match[1].strip())
    for s in snapshots: outputs[DOCS/'assets/vault'/s]=(ROOT/s).read_text()
    for path,text in outputs.items(): path.parent.mkdir(parents=True,exist_ok=True);path.write_text(text)
    manifest={str(p.relative_to(ROOT)):hashlib.sha256(t.encode()).hexdigest() for p,t in outputs.items()}
    (DOCS/'assets/story-build.json').write_text(json.dumps(manifest,indent=2)+'\n')
    print(f'Built {len(entries)} atlas pages, {len(dynamic_modules)} live Dynamic module, {len(modules) + len(endgame_modules)} historical BA/EG modules, {len(outputs)} projections.')

if __name__=='__main__': main()
