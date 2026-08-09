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
    "Focus: Define Sylvan Elaria and choose the protagonist architecture.",
    "",
    "1. Who narrates the opening?",
    "2. Is Sylvan that narrator?",
    "3. What does Sylvan want before the archive becomes his central burden?",
    "4. Why did he begin recording?",
    "5. What personal relationship gives the evidence emotional meaning?",
    "6. What does he risk by showing George the truth rather than simply defeating him?",
    "",
    "Preserve the continuity warning: the Witness–Inheritor–Protagonist architecture and the Sylvan–George–Throne architecture have not yet been reconciled."
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
      copyStatus.textContent = "Next-session brief copied.";
    } catch {
      copyStatus.textContent = "Unable to copy. Select the questions in the roadmap instead.";
    }
  });
})();
