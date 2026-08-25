(() => {
  "use strict";
  const REPO_RAW = "https://raw.githubusercontent.com/cubixmeow-commits/seeds-of-the-throne/main/";
  const POINTER_PATH = "07%20Coordination/Weekly%20Synthesis/CURRENT-COMPLETION-TODO.md";
  const REGISTRY_PATH = "07%20Coordination/Story%20Completion%20Workflow/TASK-REGISTRY.md";
  const CURRENT_PATH = "07%20Coordination/Story%20Completion%20Workflow/CURRENT.md";
  const SWEEPS = ["Macro", "Causal", "Agency", "Systems + evidence", "Sequence", "Scene map", "Scene development", "Draft"];

  function cleanMarkdown(value) {
    return value.replace(/\[([^\]]+)\]\([^\)]+\)/g, "$1").replace(/\[\[([^\]|]+\|)?([^\]]+)\]\]/g, (_, alias, label) => label || alias || "").replace(/[*_`>#]/g, "").trim();
  }

  function parseWeekly(markdown) {
    const groups = [];
    let group = null;
    let task = null;
    for (const line of markdown.split(/\r?\n/)) {
      const heading = line.match(/^#\s+(.+)$/);
      if (heading) {
        const title = cleanMarkdown(heading[1]);
        const kind = title.startsWith("Priority ") ? "priority" : title === "Weekly completion gate" ? "gate" : title === "Deliberately leave open this week" ? "deferred" : title === "Parallel safe work" ? "parallel" : "other";
        group = { title, kind, tasks: [] };
        groups.push(group);
        task = null;
        continue;
      }
      const checkbox = line.match(/^- \[([ xX])\]\s+(.+)$/);
      if (checkbox && group) {
        task = { done: checkbox[1].toLowerCase() === "x", title: cleanMarkdown(checkbox[2]), details: [] };
        group.tasks.push(task);
        continue;
      }
      if (task && /^\s{2,}-\s+/.test(line)) task.details.push(cleanMarkdown(line.replace(/^\s{2,}-\s+/, "")));
    }
    return groups.filter(item => item.tasks.length);
  }

  function parseRegistry(markdown) {
    const rows = [];
    for (const line of markdown.split(/\r?\n/)) {
      if (!/^\| SC-\d{3} \|/.test(line)) continue;
      const cells = line.split("|").slice(1, -1).map(cell => cell.trim());
      rows.push({ id: cells[0], priority: cells[1], title: cells[2], depth: cells[3], phase: cells[4], validation: cells[5] });
    }
    return rows;
  }

  function parseCurrent(markdown) {
    const match = markdown.match(/\*\*Current sweep:\*\*\s*([^\n]+)/);
    return match ? cleanMarkdown(match[1]) : "Macro Shape";
  }

  function parsePointer(markdown) {
    const match = markdown.match(/^source_path:\s*(.+)$/m);
    if (!match) throw new Error("The weekly completion pointer has no source_path.");
    return match[1].trim().split("/").map(segment => encodeURIComponent(segment)).join("/");
  }

  function element(name, className, text) {
    const node = document.createElement(name);
    if (className) node.className = className;
    if (text !== undefined) node.textContent = text;
    return node;
  }

  function renderTask(task, registryItem) {
    const row = element("article", `todo-task${task.done ? " is-done" : ""}`);
    const marker = element("span", "todo-check", task.done ? "✓" : "○");
    marker.setAttribute("aria-hidden", "true");
    const copy = element("div", "todo-task-copy");
    copy.append(element("p", "todo-task-title", task.title), element("p", "todo-state", task.done ? "Done" : registryItem ? registryItem.depth.replaceAll("-", " ") : "Tracked"));
    if (task.details.length) copy.append(element("p", "todo-detail", task.details.at(-1)));
    row.append(marker, copy);
    if (registryItem) row.dataset.taskId = registryItem.id;
    return row;
  }

  function render(groups, registry, currentSweep) {
    const priorityGroups = groups.filter(group => group.kind === "priority");
    const priorityTasks = priorityGroups.flatMap(group => group.tasks);
    const completed = priorityTasks.filter(task => task.done).length;
    const percent = priorityTasks.length ? Math.round((completed / priorityTasks.length) * 100) : 0;
    document.querySelector("#overall-count").textContent = `${completed} / ${priorityTasks.length}`;
    document.querySelector("#overall-percent").textContent = `${percent}%`;
    document.querySelector("#current-sweep").textContent = currentSweep;
    document.querySelector("#overall-fraction").textContent = `${completed} / ${priorityTasks.length}`;
    const progress = document.querySelector("#overall-progress");
    progress.value = percent;
    progress.textContent = `${percent}%`;

    const sweepList = document.querySelector("#sweep-line");
    const activeIndex = Math.max(0, SWEEPS.findIndex(name => currentSweep.toLowerCase().includes(name.toLowerCase().split(" ")[0])));
    SWEEPS.forEach((name, index) => {
      const item = element("li", index === activeIndex ? "is-current" : "", name);
      if (index === activeIndex) item.setAttribute("aria-current", "step");
      sweepList.append(item);
    });

    const groupRoot = document.querySelector("#todo-groups");
    let registryIndex = 0;
    priorityGroups.forEach(group => {
      const section = element("section", "todo-group");
      const header = element("div", "todo-group-head");
      const done = group.tasks.filter(task => task.done).length;
      header.append(element("h3", "", group.title), element("p", "", `${done} / ${group.tasks.length} complete`));
      section.append(header);
      group.tasks.forEach(item => section.append(renderTask(item, registry[registryIndex++])));
      groupRoot.append(section);
    });
    groupRoot.setAttribute("aria-busy", "false");
    const gates = groups.find(group => group.kind === "gate");
    if (gates) gates.tasks.forEach(item => document.querySelector("#gate-list").append(renderTask(item)));
    document.querySelector("#todo-status").textContent = `Loaded ${priorityTasks.length} completion tasks from repository Markdown.`;
  }

  async function loadDashboard() {
    const localPreview = ["localhost", "127.0.0.1"].includes(window.location.hostname);
    const sourceRoot = localPreview ? "../" : REPO_RAW;
    const pointerResponse = await fetch(sourceRoot + POINTER_PATH, { cache: "no-store" });
    if (!pointerResponse.ok) throw new Error("The current weekly completion pointer could not be loaded.");
    const weeklyPath = parsePointer(await pointerResponse.text());
    const responses = await Promise.all([fetch(sourceRoot + weeklyPath, { cache: "no-store" }), fetch(sourceRoot + REGISTRY_PATH, { cache: "no-store" }), fetch(sourceRoot + CURRENT_PATH, { cache: "no-store" })]);
    if (responses.some(item => !item.ok)) throw new Error("One or more Markdown sources could not be loaded.");
    const [weekly, registry, current] = await Promise.all(responses.map(item => item.text()));
    render(parseWeekly(weekly), parseRegistry(registry), parseCurrent(current));
  }

  if (typeof document !== "undefined") loadDashboard().catch(error => {
    document.querySelector("#todo-status").textContent = "Live progress could not be loaded. Open the source Markdown below for the current checklist.";
    document.querySelector("#todo-groups").setAttribute("aria-busy", "false");
    document.querySelector("#todo-groups").append(element("p", "todo-error", error.message));
  });
  if (typeof module !== "undefined") module.exports = { parseWeekly, parseRegistry, parseCurrent, parsePointer };
})();
