(() => {
  "use strict";

  const REPO_RAW = "https://raw.githubusercontent.com/cubixmeow-commits/seeds-of-the-throne/main/";
  const CURRENT_PATH = "07%20Coordination/Story%20Completion%20Workflow/CURRENT.md";
  const IDEAS_POINTER_PATH = "08%20Story%20Loop/Brainstorms/CURRENT-EXPERIMENTAL-IDEAS.md";

  function cleanMarkdown(value = "") {
    return value
      .replace(/\[([^\]]+)\]\([^)]+\)/g, "$1")
      .replace(/\[\[([^\]|]+)\|([^\]]+)\]\]/g, "$2")
      .replace(/\[\[([^\]]+)\]\]/g, "$1")
      .replace(/[\*_`>#]/g, "")
      .replaceAll(" — ", ": ")
      .trim();
  }

  function encodePath(path) {
    return path.split("/").map(segment => encodeURIComponent(segment)).join("/");
  }

  function field(markdown, label) {
    const escaped = label.replace(/[.*+?^${}()|[\]\\]/g, "\\$&");
    const match = markdown.match(new RegExp(`^- \\*\\*${escaped}:\\*\\*\\s*(.+)$`, "m"));
    return match ? cleanMarkdown(match[1]) : "";
  }

  function parseCurrent(markdown) {
    const completion = field(markdown, "Completed at this depth").match(/(\d+)\s*\/\s*(\d+)/);
    return {
      sweep: field(markdown, "Current sweep"),
      task: field(markdown, "Current task"),
      phase: field(markdown, "Current loop phase").replaceAll("-", " "),
      complete: completion ? Number(completion[1]) : 0,
      total: completion ? Number(completion[2]) : 27,
      nextAction: field(markdown, "Next required author action")
    };
  }

  function parsePointer(markdown) {
    const match = markdown.match(/^source_path:\s*(.+)$/m);
    if (!match) throw new Error("The experimental-ideas pointer has no source path.");
    return encodePath(match[1].trim());
  }

  function getSection(markdown, heading) {
    const start = markdown.indexOf(heading);
    if (start < 0) return "";
    const rest = markdown.slice(start + heading.length);
    const end = rest.search(/^##\s+/m);
    return end < 0 ? rest : rest.slice(0, end);
  }

  function parseIdeas(markdown) {
    const review = getSection(markdown, "## Author review board");
    const rows = [...review.matchAll(/^\|\s*(P-\d+)\s*\|\s*([^|]+)\|\s*([^|]+)\|/gm)].map(match => ({
      id: match[1],
      status: cleanMarkdown(match[2]).toUpperCase(),
      title: cleanMarkdown(match[3])
    }));
    const research = getSection(markdown, "## Suggested research queue");
    const researchItems = [...research.matchAll(/^- \[([ xX])\] \*\*(R-\d+)\s+[^\n]+/gm)];
    const gate = getSection(markdown, "## Recommended first author gate").split(/\r?\n/).map(cleanMarkdown).find(Boolean) || "Open the ideas workspace to choose the first review direction.";
    return {
      rows,
      completeResearch: researchItems.filter(match => match[1].toLowerCase() === "x").length,
      totalResearch: researchItems.length,
      gate
    };
  }

  function element(name, className, text) {
    const node = document.createElement(name);
    if (className) node.className = className;
    if (text !== undefined) node.textContent = text;
    return node;
  }

  function renderCurrent(current) {
    document.querySelector("#explorer-phase").textContent = current.phase || "Author gate";
    document.querySelector("#explorer-complete").textContent = `${current.complete} / ${current.total}`;
    document.querySelector("#explorer-sweep").textContent = current.sweep || "Macro Shape";
    document.querySelector("#explorer-task").textContent = current.task || "Current task unavailable.";
    document.querySelector("#explorer-next-action").textContent = current.nextAction || "Open Story Progress for the current author action.";
    const progress = document.querySelector("#explorer-progress-meter");
    progress.max = current.total;
    progress.value = current.complete;
    progress.textContent = `${current.complete} of ${current.total}`;
  }

  function renderIdeas(packet) {
    const unreviewed = packet.rows.filter(item => item.status.includes("UNREVIEWED"));
    document.querySelector("#explorer-idea-count").textContent = unreviewed.length;
    document.querySelector("#explorer-research-count").textContent = `${packet.completeResearch} / ${packet.totalResearch}`;
    document.querySelector("#explorer-idea-gate").textContent = packet.gate;
    const root = document.querySelector("#explorer-idea-list");
    packet.rows.slice(0, 3).forEach(item => {
      const row = element("li", "");
      row.append(element("span", "idea-id", item.id), element("strong", "", item.title), element("span", "idea-review is-unreviewed", item.status));
      root.append(row);
    });
    root.setAttribute("aria-busy", "false");
  }

  async function loadExplorer() {
    const localPreview = ["localhost", "127.0.0.1"].includes(window.location.hostname);
    const sourceRoot = localPreview ? "../" : REPO_RAW;
    const [currentResponse, pointerResponse] = await Promise.all([
      fetch(sourceRoot + CURRENT_PATH, { cache: "no-store" }),
      fetch(sourceRoot + IDEAS_POINTER_PATH, { cache: "no-store" })
    ]);
    if (!currentResponse.ok || !pointerResponse.ok) throw new Error("The current project pointers could not be loaded.");
    const [currentMarkdown, pointerMarkdown] = await Promise.all([currentResponse.text(), pointerResponse.text()]);
    const ideasPath = parsePointer(pointerMarkdown);
    const ideasResponse = await fetch(sourceRoot + ideasPath, { cache: "no-store" });
    if (!ideasResponse.ok) throw new Error("The current experimental-ideas packet could not be loaded.");
    renderCurrent(parseCurrent(currentMarkdown));
    renderIdeas(parseIdeas(await ideasResponse.text()));
    document.querySelector("#explorer-status").textContent = "Current project state loaded from repository Markdown.";
  }

  if (typeof document !== "undefined") loadExplorer().catch(error => {
    document.querySelector("#explorer-status").textContent = "Current project state could not be loaded. Open Progress and Ideas for the source records.";
    document.querySelector("#explorer-idea-list").setAttribute("aria-busy", "false");
    document.querySelector("#explorer-idea-list").append(element("li", "todo-error", error.message));
  });

  if (typeof module !== "undefined") module.exports = { parseCurrent, parsePointer, parseIdeas };
})();
