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
    "Define the final competitive environment: how influence inverts, why the Throne accidentally moves Sylvan’s advantage to the end, and what Sylvan does once he has overwhelming influence without becoming another ruler who redesigns everyone else.",
    "",
    "WORK IN THIS ORDER",
    "1. Specify the normal participant-control → equilibrium → contained-control cycle and the failure threshold that leads to processing.",
    "2. Define exactly what the Throne moved out of order on George’s behalf and why the displaced Sylvan-control segment arrives last.",
    "3. Define the Throne as the de facto opposing decision-maker while George remains inside the manufactured reality.",
    "4. Set Sylvan’s non-interference principle: he does not choose their king, hierarchy, breeding arrangements, or traditions; he sets boundaries on what they do to outsiders.",
    "5. Define the offer to earn a city and the alternative of processing without false narrative or story functionality.",
    "",
    "QUESTIONS THAT UNLOCK THE ENDGAME",
    "- What concrete authority allows a competitive segment to be reordered?",
    "- Why does the Throne believe reordering it will help George or defeat Sylvan?",
    "- What does Sylvan’s overwhelming final influence actually let him do, and what still constrains him?",
    "- Which remote attacks remain available to the Throne through story functionality, society, institutions, online systems, George, and the Daemon?",
    "- Why are those attacks increasingly ineffective once Sylvan’s final segment arrives?",
    "- What external boundaries apply while the contained group keeps its own hierarchy and traditions?",
    "- What must the group demonstrate to earn stewardship of a city?",
    "- What does processing look like when the system stops supplying flattering explanations?",
    "",
    "LEAVE WITH",
    "- A precise competitive-environment sequence",
    "- The Throne’s sequencing mistake",
    "- Sylvan’s non-interference doctrine",
    "- The rules for earning a city",
    "- A clear cooperation-versus-consequence endgame choice",
    "",
    "BOUNDARY",
    "Do not turn Sylvan into George’s rescuer or into the designer of the contained group’s internal society. Judge external behavior and consequences while preserving meaningful internal autonomy."
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
