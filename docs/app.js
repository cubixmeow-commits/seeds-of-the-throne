(() => {
  const root = document.documentElement;
  const themeButton = document.querySelector("#theme-toggle");
  const searchInput = document.querySelector("#atlas-search");
  const clearButton = document.querySelector("#clear-search");
  const emptyClearButton = document.querySelector("#empty-clear");
  const filterStatus = document.querySelector("#filter-status");
  const noResults = document.querySelector("#no-results");
  const copyButton = document.querySelector("#copy-brief");
  const copyStatus = document.querySelector("#copy-status");
  const filterItems = Array.from(document.querySelectorAll("[data-filter-item]"));

  const sessionBrief = [
    "Seeds of the Throne — Next development session",
    "",
    "FOCUS",
    "Choose who carries the story. Turn the project’s strongest endgame material into a usable beginning.",
    "",
    "WORK IN THIS ORDER",
    "1. Choose the protagonist architecture.",
    "2. Build Sylvan as a person: want, relationship, flaw, and cost.",
    "3. Design the opening disturbance and irreversible loss.",
    "4. Trace the evidence from creation to delivery to George.",
    "5. Close with five settled statements and label everything else provisional.",
    "",
    "QUESTIONS THAT UNLOCK THE DRAFT",
    "- Who experiences the first scene, and why is that person the best lens?",
    "- Is Sylvan the protagonist, witness, inheritor, or a bridge between roles?",
    "- What does Sylvan want before the archive becomes his burden?",
    "- Which relationship makes the evidence emotionally meaningful?",
    "- What flaw makes preserving or revealing the truth difficult?",
    "- What event forces the story to begin now?",
    "- What does Sylvan lose in the opening that cannot be restored?",
    "- What does he risk by showing George the truth?",
    "",
    "LEAVE WITH",
    "- A one-sentence viewpoint statement",
    "- Sylvan’s story engine",
    "- An opening beat chain",
    "- An evidence pathway",
    "",
    "BOUNDARY",
    "Do not solve world systems unless an answer is required to make the opening work."
  ].join("\n");

  const storedTheme = localStorage.getItem("sot-theme");
  const preferredTheme = window.matchMedia("(prefers-color-scheme: light)").matches ? "light" : "dark";

  function applyTheme(theme) {
    const nextTheme = theme === "light" ? "light" : "dark";
    const isDark = nextTheme === "dark";
    root.dataset.theme = nextTheme;
    themeButton.setAttribute("aria-pressed", String(isDark));
    themeButton.textContent = isDark ? "Use light theme" : "Use dark theme";
    document.querySelector('meta[name="theme-color"]').setAttribute("content", isDark ? "#121722" : "#f7f3e9");
  }

  applyTheme(storedTheme || preferredTheme);

  themeButton.addEventListener("click", () => {
    const nextTheme = root.dataset.theme === "dark" ? "light" : "dark";
    localStorage.setItem("sot-theme", nextTheme);
    applyTheme(nextTheme);
  });

  function clearFilter() {
    searchInput.value = "";
    updateFilter();
    searchInput.focus();
  }

  function updateFilter() {
    const query = searchInput.value.trim().toLocaleLowerCase();
    let visibleCount = 0;

    filterItems.forEach((item) => {
      const matches = query === "" || item.textContent.toLocaleLowerCase().includes(query);
      item.hidden = !matches;
      if (matches) visibleCount += 1;
    });

    document.querySelectorAll(".question-groups details").forEach((group) => {
      const visibleQuestions = group.querySelectorAll("li[data-filter-item]:not([hidden])").length;
      group.hidden = query !== "" && visibleQuestions === 0;
      if (query !== "" && visibleQuestions > 0) group.open = true;
    });

    clearButton.hidden = query === "";
    noResults.hidden = query === "" || visibleCount !== 0;
    filterStatus.textContent = query === ""
      ? `${filterItems.length} questions and reports available.`
      : `${visibleCount} ${visibleCount === 1 ? "match" : "matches"} for “${searchInput.value.trim()}”.`;
  }

  searchInput.addEventListener("input", updateFilter);
  clearButton.addEventListener("click", clearFilter);
  emptyClearButton.addEventListener("click", clearFilter);
  updateFilter();

  copyButton.addEventListener("click", async () => {
    try {
      await navigator.clipboard.writeText(sessionBrief);
      copyStatus.textContent = "Session guide copied.";
    } catch {
      copyStatus.textContent = "Unable to copy. Select the questions in the roadmap instead.";
    }
  });
})();
