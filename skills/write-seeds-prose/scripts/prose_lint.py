#!/usr/bin/env python3
"""Conservative mechanical lint for Seeds prose.

This tool flags patterns for human/model inspection. It does not decide whether prose is good.
"""

from __future__ import annotations

import argparse
import json
import re
from collections import Counter
from pathlib import Path

SENTENCE_SPLIT = re.compile(r"(?<=[.!?])(?:[\"'”’)]*)\s+")
WORD = re.compile(r"[A-Za-z0-9']+")
DIALOGUE_START = ('"', '“', "'", '‘')


def sentences(text: str) -> list[str]:
    return [s.strip() for s in SENTENCE_SPLIT.split(text.strip()) if s.strip()]


def opening_key(sentence: str, n: int = 3) -> str | None:
    words = [w.lower() for w in WORD.findall(sentence)]
    if len(words) < n:
        return None
    return " ".join(words[:n])


def is_dialogue_paragraph(paragraph: str) -> bool:
    return paragraph.lstrip().startswith(DIALOGUE_START)


def lint(text: str) -> dict:
    sents = sentences(text)
    paragraphs = [p.strip() for p in re.split(r"\n\s*\n", text.strip()) if p.strip()]

    starters = Counter(k for s in sents if (k := opening_key(s)))
    repeated_starters = {
        key: count for key, count in starters.items() if count >= 3
    }

    narrative_paragraphs = [p for p in paragraphs if not is_dialogue_paragraph(p)]
    one_sentence_narrative_paragraphs = sum(
        1 for p in narrative_paragraphs if len(sentences(p)) == 1
    )
    one_sentence_narrative_ratio = (
        one_sentence_narrative_paragraphs / len(narrative_paragraphs)
        if narrative_paragraphs else 0.0
    )

    longest_one_sentence_narrative_run = 0
    current_one_sentence_narrative_run = 0
    for paragraph in paragraphs:
        if not is_dialogue_paragraph(paragraph) and len(sentences(paragraph)) == 1:
            current_one_sentence_narrative_run += 1
            longest_one_sentence_narrative_run = max(
                longest_one_sentence_narrative_run,
                current_one_sentence_narrative_run,
            )
        else:
            current_one_sentence_narrative_run = 0

    patterns = {
        "not_x_but_y": len(re.findall(r"\bnot\b[^.!?\n]{0,90}\bbut\b", text, flags=re.I)),
        "it_wasnt_it_was": len(re.findall(r"\bit\s+was(?:n['’]t| not)\b[^.!?]{0,90}[.!?]\s*\bit\s+was\b", text, flags=re.I)),
        "question_was_not": len(re.findall(r"\bthe\s+question\s+was\s+not\b", text, flags=re.I)),
    }

    flags: list[dict] = []
    em_dash_count = text.count("—")
    if em_dash_count:
        flags.append({"type": "em_dash", "count": em_dash_count, "severity": "error"})

    for name, count in patterns.items():
        if count >= 2:
            flags.append({"type": name, "count": count, "severity": "warning"})

    if repeated_starters:
        flags.append({
            "type": "repeated_sentence_starters",
            "items": repeated_starters,
            "severity": "warning",
        })

    # Dialogue is commonly formatted as one sentence per paragraph. Only inspect
    # narrative paragraphs for this cadence warning to avoid punishing normal fiction.
    if longest_one_sentence_narrative_run >= 5:
        flags.append({
            "type": "one_sentence_narrative_paragraph_cluster",
            "count": longest_one_sentence_narrative_run,
            "severity": "warning",
        })

    return {
        "sentence_count": len(sents),
        "paragraph_count": len(paragraphs),
        "narrative_paragraph_count": len(narrative_paragraphs),
        "one_sentence_narrative_paragraph_ratio": round(one_sentence_narrative_ratio, 3),
        "longest_one_sentence_narrative_run": longest_one_sentence_narrative_run,
        "pattern_counts": patterns,
        "repeated_sentence_starters": repeated_starters,
        "flags": flags,
        "pass": not any(f["severity"] == "error" for f in flags),
    }


def main() -> int:
    parser = argparse.ArgumentParser(description=__doc__)
    parser.add_argument("path", nargs="?", help="UTF-8 prose file. Reads stdin when omitted.")
    parser.add_argument("--json", action="store_true", dest="as_json")
    args = parser.parse_args()

    if args.path:
        text = Path(args.path).read_text(encoding="utf-8")
    else:
        import sys
        text = sys.stdin.read()

    result = lint(text)
    if args.as_json:
        print(json.dumps(result, indent=2, ensure_ascii=False, sort_keys=True))
    else:
        if not result["flags"]:
            print("No mechanical flags.")
        else:
            for flag in result["flags"]:
                print(json.dumps(flag, ensure_ascii=False, sort_keys=True))
    return 0 if result["pass"] else 1


if __name__ == "__main__":
    raise SystemExit(main())
