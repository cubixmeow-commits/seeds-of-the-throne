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

  function setText(selector, text) {
    const node = document.querySelector(selector);
    if (node) node.textContent = text;
  }

  function updateDashboard() {
    setText("#next-session .eyebrow", "Session workspace · Revision 02");
    setText("#next-session .status", "Blocking · Final competitive environment");
    setText("#session-title", "Define the environment the King accidentally gave Sylvan.");
    setText("#next-session .session-instruction", "This session should lock the competitive-environment mechanism and the ethical shape of Sylvan’s final advantage. Define the normal influence inversion first, then the Throne’s sequencing mistake, the reality of George remaining under his father’s control, and the terms Sylvan offers without trying to redesign their internal society.");

    const agenda = document.querySelector("#next-session .session-agenda ol");
    if (agenda) agenda.innerHTML = `
      <li><span>01</span><div><strong>Lock the control inversion</strong><p>Define participant control → equilibrium → contained control, how influence appears in ordinary life, and what failure triggers processing.</p></div></li>
      <li><span>02</span><div><strong>Specify the King’s sequencing mistake</strong><p>Determine what he moved out of order for George, why he believed it would work, and why Sylvan’s displaced advantage arrives at the end.</p></div></li>
      <li><span>03</span><div><strong>Define the real opponent</strong><p>George remains inside his manufactured reality while his father continues making consequential decisions, making the Evil King Sylvan’s de facto counterpart.</p></div></li>
      <li><span>04</span><div><strong>Set Sylvan’s boundary</strong><p>Separate non-interference in hierarchy, breeding arrangements, succession, and traditions from firm limits on attacks against outsiders.</p></div></li>
      <li><span>05</span><div><strong>Design the final offer</strong><p>Specify what cooperation must look like to earn a city and what honest processing means if the group refuses.</p></div></li>`;

    const questions = document.querySelector("#next-session .session-questions ul");
    if (questions) questions.innerHTML = `
      <li>What exactly is a competitive environment testing when control moves from participant to contained group?</li>
      <li>What authority lets the Throne move a segment, and why is the displaced segment preserved?</li>
      <li>What can Sylvan actually do with overwhelming final influence, and what remains outside his authority?</li>
      <li>How does the Throne continue attacking remotely through story functionality, society, institutions, online systems, George, and the Daemon?</li>
      <li>Why do those attacks become increasingly ineffective instead of simply disappearing?</li>
      <li>Which internal traditions remain none of Sylvan’s business, and where do external civilizational boundaries begin?</li>
      <li>What measurable behavior proves the group can earn stewardship of a city?</li>
      <li>What does processing reveal once flattering narrative cover is removed?</li>`;

    setText("#outcomes-title", "Leave the session with five usable decisions");
    const outcomes = document.querySelector("#next-session .outcome-grid");
    if (outcomes) outcomes.innerHTML = `
      <article><span>01</span><h3>Control sequence</h3><p>The normal influence inversion and terminal conditions.</p></article>
      <article><span>02</span><h3>Sequencing mistake</h3><p>Why the King accidentally moves Sylvan’s advantage to the end.</p></article>
      <article><span>03</span><h3>Non-interference rule</h3><p>What Sylvan refuses to govern inside the contained group.</p></article>
      <article><span>04</span><h3>City test</h3><p>What constructive cooperation must prove before stewardship is earned.</p></article>
      <article><span>05</span><h3>Reality outcome</h3><p>What honest consequence means when narrative protection ends.</p></article>`;
    setText("#next-session .session-boundary p", "Do not make Sylvan responsible for rescuing George or reforming the contained group’s culture. The question is whether their actual hierarchy can stop externalizing destruction and become capable of constructive cooperation.");

    setText("#overview-title", "The endgame has changed. The victory is what Sylvan refuses to control.");
    setText("#overview .lede", "The Evil King tried to reorder the competitive environment for the Throwaway Prince and accidentally moved Sylvan’s period of overwhelming influence to the end. George remains inside his father’s manufactured reality, leaving the father as the de facto authority Sylvan must actually deal with.");
    setText("#trajectory-title", "Turn overwhelming influence into a test of leadership, not domination.");
    const focusCopy = document.querySelector("#overview .focus-card p:last-child");
    if (focusCopy) focusCopy.textContent = "Sylvan stops trying to repair the contained group from inside. He accepts their chosen hierarchy, sets boundaries on what reaches outsiders, and offers cooperation, earned stewardship, or honest consequence.";
    const metrics = document.querySelectorAll("#overview .metric-grid > div");
    if (metrics[3]) metrics[3].querySelector("dd").textContent = "Competitive endgame mechanics";

    const established = document.querySelector(".state-established ul");
    if (established) established.insertAdjacentHTML("beforeend", "<li>Competitive environments invert influence over time</li>");
    const locked = document.querySelector(".state-locked ul");
    if (locked) locked.insertAdjacentHTML("beforeend", "<li>Sylvan is not responsible for rescuing George</li><li>The Throne remains George’s de facto decision-maker</li>");
    const working = document.querySelector(".state-working ul");
    if (working) working.insertAdjacentHTML("beforeend", "<li>Sylvan’s non-interference doctrine</li><li>Cooperation as a path to earned city stewardship</li>");
    const unresolved = document.querySelector(".state-unresolved ul");
    if (unresolved) unresolved.insertAdjacentHTML("beforeend", "<li>Exact segment-reordering mechanics</li><li>Requirements for earning a city</li><li>Processing without narrative cover</li>");

    setText("#story-engine .section-heading > p", "The father’s final strategic mistake converts the normal control inversion into an endgame where Sylvan has the advantage and must decide what legitimate leadership looks like.");
    const flow = document.querySelector("#story-engine .story-flow");
    if (flow) flow.innerHTML = `
      <li><span class="flow-number">01</span><div><strong>Participant control</strong><p>The participant begins with the favorable position and a real opportunity to build something.</p></div></li>
      <li><span class="flow-number">02</span><div><strong>Equilibrium</strong><p>Influence shifts invisibly until cooperation, institutions, money, and social support become genuinely contested.</p></div></li>
      <li><span class="flow-number">03</span><div><strong>Contained control</strong><p>The contained group gains leverage and repeatedly reveals what it does when it can finally destroy the participant’s work.</p></div></li>
      <li><span class="flow-number">04</span><div><strong>The King cheats</strong><p>Trying to protect George and accelerate Sylvan’s defeat, the Throne moves segments of their environment out of order.</p></div></li>
      <li><span class="flow-number">05</span><div><strong>The displaced segment returns</strong><p>The participant-control segment was moved, not erased. It arrives last, leaving Sylvan with overwhelming final influence.</p></div></li>
      <li><span class="flow-number">06</span><div><strong>The wrong opponent</strong><p>George never fully emerges from his manufactured reality. His father keeps deciding for him and continues the war through weak remote attacks.</p></div></li>
      <li class="flow-climax"><span class="flow-number">07</span><div><strong>The leadership test</strong><p>Sylvan does not seize their hierarchy. He offers a behavioral choice: cooperate and earn a city, or face honest consequences without narrative cover.</p></div></li>`;
    const quote = document.querySelector("#story-engine blockquote p");
    if (quote) quote.textContent = "I do not have to decide who you should be. I only have to decide what I will cooperate with.";
    setText("#story-engine blockquote cite", "Sylvan’s emerging leadership principle");

    const sylvan = Array.from(document.querySelectorAll("#cast .character-card")).find(card => card.querySelector("h3")?.textContent === "Sylvan Elaria");
    if (sylvan) {
      const desc = sylvan.querySelector(":scope > p:not(.role)");
      if (desc) desc.textContent = "Ends with overwhelming influence but refuses to turn victory into ownership of other people. He governs his boundaries, not the contained group’s identity.";
      const facts = sylvan.querySelectorAll("dd");
      if (facts[0]) facts[0].textContent = "Evidence, legitimacy, final influence";
      if (facts[1]) facts[1].textContent = "Restraint without passivity";
      if (facts[2]) facts[2].textContent = "Boundaries, city test, personal cost";
    }
    const throne = Array.from(document.querySelectorAll("#cast .character-card")).find(card => card.querySelector("h3")?.textContent === "The Throne figure");
    if (throne) {
      const desc = throne.querySelector(":scope > p:not(.role)");
      if (desc) desc.textContent = "Never releases George from the false reality and becomes the actual decision-maker Sylvan faces. After losing direct control, he continues the conflict through increasingly ineffective remote attacks.";
      const facts = throne.querySelectorAll("dd");
      if (facts[0]) facts[0].textContent = "Preserve hierarchy and narrative control";
      if (facts[1]) facts[1].textContent = "George, Daemon, story functionality, remote influence";
      if (facts[2]) facts[2].textContent = "Cooperate and earn stewardship, or face reality";
    }

    const principles = document.querySelector("#world .principle-grid");
    if (principles) principles.insertAdjacentHTML("beforeend", `<article><span aria-hidden="true">05</span><h3>Competitive control inverts</h3><p>Participants begin ahead; contained criminals eventually receive enough influence to reveal what they do with power.</p></article><article><span aria-hidden="true">06</span><h3>Leadership has boundaries</h3><p>Internal autonomy can coexist with accountability for conduct imposed on outsiders.</p></article>`);

    const systemDetails = Array.from(document.querySelectorAll("#questions details")).find(d => d.querySelector("summary")?.textContent.includes("System and aftermath"));
    if (systemDetails) {
      setText("summary .question-count", "13 questions");
      const list = systemDetails.querySelector("ul");
      if (list) list.insertAdjacentHTML("beforeend", `
        <li data-filter-item>What exactly did the Throne move out of order in Sylvan’s competitive environment?</li>
        <li data-filter-item>Why does the displaced participant-control segment arrive at the end instead of being corrected?</li>
        <li data-filter-item>What external boundaries limit the contained group while preserving internal autonomy?</li>
        <li data-filter-item>What must the group prove to earn stewardship of a city?</li>
        <li data-filter-item>What does processing look like without false narrative or story functionality?</li>`);
    }

    const roadmap = document.querySelector("#roadmap .roadmap-list");
    if (roadmap) roadmap.innerHTML = `
      <li><span class="roadmap-step">1</span><div><h3>Lock the competitive-environment cycle</h3><p>Define the normal influence inversion, visible symptoms, solvency threshold, and processing trigger.</p></div><span class="status status-next">Next</span></li>
      <li><span class="roadmap-step">2</span><div><h3>Specify the Throne’s sequencing mistake</h3><p>What he moved, why he moved it, and why that gives Sylvan the final advantage.</p></div><span class="status status-unresolved">Queued</span></li>
      <li><span class="roadmap-step">3</span><div><h3>Define Sylvan’s final authority</h3><p>Separate overwhelming influence from unrestricted power and establish what he can legitimately control.</p></div><span class="status status-unresolved">Queued</span></li>
      <li><span class="roadmap-step">4</span><div><h3>Map the King’s remote war</h3><p>Story functionality, social influence, institutions, online attacks, George, and the Daemon—and why they stop working well.</p></div><span class="status status-unresolved">Queued</span></li>
      <li><span class="roadmap-step">5</span><div><h3>Lock the non-interference doctrine</h3><p>Define the line between respecting their hierarchy and enforcing boundaries against external harm.</p></div><span class="status status-unresolved">Queued</span></li>
      <li><span class="roadmap-step">6</span><div><h3>Design the city test</h3><p>Specify the constructive behavior, duration, accountability, and evidence required to earn stewardship.</p></div><span class="status status-unresolved">Queued</span></li>
      <li><span class="roadmap-step">7</span><div><h3>Define honest processing</h3><p>Show what remains when false victory, heroic biography, and story functionality can no longer reinterpret consequences.</p></div><span class="status status-unresolved">Queued</span></li>
      <li><span class="roadmap-step">8</span><div><h3>Return to opening and viewpoint</h3><p>Once the endgame mechanism is stable, use it to determine what the beginning must promise and which viewpoint best carries that promise.</p></div><span class="status status-unresolved">Queued</span></li>`;

    setText("#roadmap .continuity-alert h3", "The endgame is now ahead of the opening architecture.");
    const alertCopy = document.querySelector("#roadmap .continuity-alert p:last-child");
    if (alertCopy) alertCopy.textContent = "Preserve the unresolved Witness–Inheritor–Protagonist question, but do not let it displace the current brainstorming priority: finish the competitive environment, Sylvan’s boundaries, and the cooperation-versus-consequence outcome first.";
  }

  updateDashboard();
  let filterItems = Array.from(document.querySelectorAll("[data-filter-item]"));

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
