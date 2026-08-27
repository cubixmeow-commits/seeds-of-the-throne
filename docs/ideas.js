(() => {
  "use strict";

  const REPO_RAW = "https://raw.githubusercontent.com/cubixmeow-commits/seeds-of-the-throne/main/";
  const POINTER_PATH = "08%20Story%20Loop/Brainstorms/CURRENT-EXPERIMENTAL-IDEAS.md";
  let ideas = [];
  let activeFilter = "all";
  let selectedId = null;

  function cleanMarkdown(value = "") {
    return value
      .replace(/\[([^\]]+)\]\([^)]+\)/g, "$1")
      .replace(/\[\[([^\]|]+)\|([^\]]+)\]\]/g, "$2")
      .replace(/\[\[([^\]]+)\]\]/g, "$1")
      .replace(/\*\*/g, "")
      .replace(/`/g, "")
      .trim();
  }

  function encodePath(path) {
    return path.split("/").map(segment => encodeURIComponent(segment)).join("/");
  }

  function parsePointer(markdown) {
    const match = markdown.match(/^source_path:\s*(.+)$/m);
    if (!match) throw new Error("The experimental-ideas pointer has no source_path.");
    return encodePath(match[1].trim());
  }

  function getSection(markdown, heading, nextHeadingPattern = "## ") {
    const start = markdown.indexOf(heading);
    if (start < 0) return "";
    const contentStart = start + heading.length;
    const rest = markdown.slice(contentStart);
    const next = rest.search(new RegExp(`^${nextHeadingPattern}`, "m"));
    return next < 0 ? rest : rest.slice(0, next);
  }

  function field(block, label) {
    const escaped = label.replace(/[.*+?^${}()|[\]\\]/g, "\\$&");
    const match = block.match(new RegExp(`^\\s*- \\*\\*${escaped}:\\*\\*\\s*(.+)$`, "m"));
    return match ? cleanMarkdown(match[1]) : "";
  }

  function parseIdeas(markdown) {
    const section = getSection(markdown, "## Raw candidate portfolio");
    const matches = [...section.matchAll(/^###\s+(P-\d+)\s+—\s+(.+)$/gm)];
    const review = parseReviewBoard(markdown);
    return matches.map((match, index) => {
      const start = match.index + match[0].length;
      const end = index + 1 < matches.length ? matches[index + 1].index : section.length;
      const block = section.slice(start, end);
      return {
        id: match[1],
        title: cleanMarkdown(match[2]),
        status: review[match[1]] || "UNREVIEWED",
        family: field(block, "Family"),
        possibility: field(block, "Possibility"),
        buildsOn: field(block, "Builds on"),
        storyFunction: field(block, "Story function"),
        characterChoice: field(block, "Character choice"),
        dramaticExpression: field(block, "Dramatic expression"),
        risk: field(block, "Continuity / authority risk"),
        nextGate: field(block, "Next gate")
      };
    });
  }

  function parseReviewBoard(markdown) {
    const section = getSection(markdown, "## Author review board");
    const result = {};
    for (const line of section.split(/\r?\n/)) {
      const match = line.match(/^\|\s*(P-\d+)\s*\|\s*([^|]+)\|/);
      if (match) result[match[1]] = cleanMarkdown(match[2]).toUpperCase();
    }
    return result;
  }

  function parseResearchInputs(markdown) {
    const authority = getSection(markdown, "## Authority ledger");
    const section = getSection(authority, "### Research inputs", "### ");
    return section.split(/\r?\n/).filter(line => /^- \*\*Claim \/ mechanism:/.test(line)).map(line => cleanMarkdown(line.replace(/^-\s+/, "")));
  }

  function parseResearchQueue(markdown) {
    const section = getSection(markdown, "## Suggested research queue");
    const matches = [...section.matchAll(/^- \[([ xX])\] \*\*(R-\d+) — (.+?)\*\*$/gm)];
    return matches.map((match, index) => {
      const start = match.index + match[0].length;
      const end = index + 1 < matches.length ? matches[index + 1].index : section.length;
      const block = section.slice(start, end);
      return { done: match[1].toLowerCase() === "x", id: match[2], title: cleanMarkdown(match[3]), supports: field(block, "Supports"), question: field(block, "Question"), use: field(block, "Use") };
    });
  }

  function element(name, className, text) {
    const node = document.createElement(name);
    if (className) node.className = className;
    if (text !== undefined) node.textContent = text;
    return node;
  }

  function statusClass(status) {
    const normalized = status.toLowerCase();
    if (normalized.includes("explore") || normalized.includes("promote")) return "explore";
    if (normalized.includes("maybe")) return "maybe";
    if (normalized.includes("reject")) return "rejected";
    return "unreviewed";
  }

  function renderIdeaList() {
    const root = document.querySelector("#idea-list");
    root.replaceChildren();
    const visible = ideas.filter(idea => activeFilter === "all" || statusClass(idea.status) === activeFilter);
    if (!visible.length) {
      const empty = element("p", "idea-empty", "No ideas match this filter. Select All to return to the full list.");
      root.append(empty);
      document.querySelector("#ideas-status").textContent = "No ideas match the selected filter.";
      return;
    }
    visible.forEach(idea => {
      const button = element("button", `idea-row${idea.id === selectedId ? " is-selected" : ""}`);
      button.type = "button";
      button.dataset.ideaId = idea.id;
      button.setAttribute("aria-pressed", String(idea.id === selectedId));
      const meta = element("span", "idea-row-meta");
      meta.append(element("span", "idea-id", idea.id), element("span", `idea-review is-${statusClass(idea.status)}`, idea.status));
      button.append(meta, element("strong", "", idea.title), element("small", "", idea.family));
      root.append(button);
    });
    root.setAttribute("aria-busy", "false");
    document.querySelector("#ideas-status").textContent = `Showing ${visible.length} of ${ideas.length} experimental ideas.`;
  }

  function addDetailLine(root, label, value) {
    if (!value) return;
    const group = element("div", "idea-detail-line");
    group.append(element("dt", "", label), element("dd", "", value));
    root.append(group);
  }

  function renderDetail(id, focus = false) {
    const idea = ideas.find(item => item.id === id);
    if (!idea) return;
    selectedId = id;
    const root = document.querySelector("#idea-detail");
    root.replaceChildren();
    const state = element("p", `idea-review is-${statusClass(idea.status)}`, idea.status);
    const title = element("h2", "", idea.title);
    title.id = "inspector-title";
    title.tabIndex = -1;
    root.append(state, title, element("p", "idea-possibility", idea.possibility));
    const details = element("dl", "idea-detail-list");
    addDetailLine(details, "Builds on", idea.buildsOn);
    addDetailLine(details, "Story function", idea.storyFunction);
    addDetailLine(details, "Character choice", idea.characterChoice);
    addDetailLine(details, "Dramatic expression", idea.dramaticExpression);
    addDetailLine(details, "Continuity risk", idea.risk);
    addDetailLine(details, "Next gate", idea.nextGate);
    root.append(details);
    renderIdeaList();
    if (focus) title.focus();
  }

  function renderResearchInputs(inputs) {
    const root = document.querySelector("#research-inputs");
    inputs.forEach((input, index) => {
      const item = element("li", "");
      item.append(element("span", "", String(index + 1).padStart(2, "0")), element("p", "", input));
      root.append(item);
    });
  }

  function renderResearchQueue(queue) {
    const root = document.querySelector("#research-list");
    queue.forEach(item => {
      const article = element("article", `research-item${item.done ? " is-done" : ""}`);
      const head = element("div", "research-item-head");
      head.append(element("span", "research-check", item.done ? "✓" : "○"), element("span", "idea-id", item.id), element("h3", "", item.title), element("span", `research-state${item.done ? " is-complete" : ""}`, item.done ? "Complete" : "Suggested"));
      const body = element("div", "research-item-body");
      const supports = element("p", "research-supports");
      supports.append(element("strong", "", "Supports "), document.createTextNode(item.supports));
      body.append(supports, element("p", "research-question", item.question), element("p", "research-use", item.use));
      article.append(head, body);
      root.append(article);
    });
    root.setAttribute("aria-busy", "false");
  }

  function bindControls() {
    document.querySelector("#idea-list").addEventListener("click", event => {
      const button = event.target.closest("[data-idea-id]");
      if (button) renderDetail(button.dataset.ideaId);
    });
    document.querySelector(".idea-filters").addEventListener("click", event => {
      const button = event.target.closest("[data-idea-filter]");
      if (!button) return;
      activeFilter = button.dataset.ideaFilter;
      document.querySelectorAll("[data-idea-filter]").forEach(item => {
        const active = item === button;
        item.classList.toggle("is-active", active);
        item.setAttribute("aria-pressed", String(active));
      });
      renderIdeaList();
    });
  }

  async function loadIdeas() {
    const localPreview = ["localhost", "127.0.0.1"].includes(window.location.hostname);
    const sourceRoot = localPreview ? "../" : REPO_RAW;
    const pointerResponse = await fetch(sourceRoot + POINTER_PATH, { cache: "no-store" });
    if (!pointerResponse.ok) throw new Error("Unable to load the current experimental-ideas pointer.");
    const sourcePath = parsePointer(await pointerResponse.text());
    const sourceResponse = await fetch(sourceRoot + sourcePath, { cache: "no-store" });
    if (!sourceResponse.ok) throw new Error("Unable to load the current creative-possibilities packet.");
    const markdown = await sourceResponse.text();
    ideas = parseIdeas(markdown);
    const research = parseResearchQueue(markdown);
    const inputs = parseResearchInputs(markdown);
    document.querySelector("#idea-count").textContent = ideas.length;
    document.querySelector("#review-count").textContent = ideas.filter(idea => statusClass(idea.status) === "unreviewed").length;
    document.querySelector("#research-count").textContent = research.length;
    const sourceLink = document.querySelector("#ideas-source-link");
    sourceLink.href = `https://github.com/cubixmeow-commits/seeds-of-the-throne/blob/main/${sourcePath}`;
    sourceLink.textContent = "Open current ideas packet";
    renderIdeaList();
    renderResearchInputs(inputs);
    renderResearchQueue(research);
    if (ideas.length) renderDetail(ideas[0].id);
  }

  if (typeof document !== "undefined") {
    bindControls();
    loadIdeas().catch(error => {
      document.querySelector("#ideas-status").textContent = "Unable to load experimental ideas. Open the source Markdown below and try again.";
      document.querySelector("#idea-list").setAttribute("aria-busy", "false");
      document.querySelector("#research-list").setAttribute("aria-busy", "false");
      document.querySelector("#idea-list").append(element("p", "todo-error", error.message));
    });
  }

  if (typeof module !== "undefined") module.exports = { parsePointer, parseIdeas, parseReviewBoard, parseResearchInputs, parseResearchQueue };
})();
