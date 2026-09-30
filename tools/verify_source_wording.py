#!/usr/bin/env python3
"""Verify that every approved Marathi quote is present in the source DOCX."""

from pathlib import Path
import re
import sys

from docx import Document


def normalized(text: str) -> str:
    return re.sub(r"\s+", " ", text.replace("\u00a0", " ")).strip()


def main() -> int:
    if len(sys.argv) != 2:
        print("Usage: verify_source_wording.py <authoritative.docx>")
        return 2

    root = Path(__file__).resolve().parents[1]
    plan = (root / "DEMO_FULL_SHORT_TEXT_PLAN.md").read_text(encoding="utf-8")
    quotes = [normalized(line[1:].lstrip()) for line in plan.splitlines() if line.startswith(">")]
    doc = Document(sys.argv[1])
    source_paragraphs = {normalized(paragraph.text) for paragraph in doc.paragraphs if normalized(paragraph.text)}

    missing = [quote for quote in quotes if quote not in source_paragraphs]
    print(f"Approved quoted paragraphs: {len(quotes)}")
    print(f"Exact source matches: {len(quotes) - len(missing)}")
    if missing:
        print("Missing or changed wording:")
        for quote in missing:
            print(f"- {quote}")
        return 1

    print("PASS every Marathi narration paragraph exactly matches the authoritative Word document")
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
