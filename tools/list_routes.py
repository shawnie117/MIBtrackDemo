#!/usr/bin/env python3
"""
Enumerate every method in the vendor controllers and classify it.

Output feeds two things:
  1. the mock sidebar menu (must point at real routes)
  2. the static exporter's crawl list

Classification:
  PAGE   - calls loadViews() or load->view(), i.e. renders HTML
  ACTION - mutates then redirect()s, no HTML of its own
  AJAX   - echoes json_encode(), consumed by JS
"""
import re
import json
import pathlib
import sys

CTRL_DIR = pathlib.Path(sys.argv[1]) if len(sys.argv) > 1 else pathlib.Path(
    r"D:\Internship\Mauli Infotech\MIBtrackDemo\_build\application\modules\vendor\controllers"
)

FUNC_RE = re.compile(
    r'^\s*(?:(public|private|protected)\s+)?(?:static\s+)?function\s+([A-Za-z_]\w*)\s*\(', re.M)


def split_methods(src: str):
    """Yield (visibility, name, body) by slicing between successive headers."""
    hits = list(FUNC_RE.finditer(src))
    for i, m in enumerate(hits):
        end = hits[i + 1].start() if i + 1 < len(hits) else len(src)
        yield (m.group(1) or 'public'), m.group(2), src[m.start():end]


def classify(body: str) -> str:
    if 'loadViews(' in body or 'load->view(' in body:
        return 'PAGE'
    if 'json_encode(' in body or 'echo json' in body:
        return 'AJAX'
    if 'redirect(' in body:
        return 'ACTION'
    return 'OTHER'


def main():
    result = {}
    api_methods = set()
    api_re = re.compile(r"call_(?:v_|i_|meta_)?api\s*\(\s*['\"]([A-Za-z0-9_]+)['\"]")

    for php in sorted(CTRL_DIR.glob('*.php')):
        src = php.read_text(encoding='utf-8', errors='replace')
        api_methods.update(api_re.findall(src))
        ctrl = php.stem.lower()
        methods = {}
        for vis, name, body in split_methods(src):
            if name in ('__construct', '__destruct'):
                continue
            # CodeIgniter can only route to public methods that do not start
            # with an underscore. Anything else is internal helper code and
            # must not be treated as a page.
            if vis != 'public' or name.startswith('_'):
                continue
            methods[name] = classify(body)
        result[ctrl] = methods

    counts = {}
    for ctrl, methods in result.items():
        for name, kind in methods.items():
            counts[kind] = counts.get(kind, 0) + 1

    print("=== per-controller ===")
    for ctrl, methods in result.items():
        tally = {}
        for kind in methods.values():
            tally[kind] = tally.get(kind, 0) + 1
        print(f"{ctrl:18} " + "  ".join(f"{k}={v}" for k, v in sorted(tally.items())))

    print("\n=== totals ===")
    for k, v in sorted(counts.items()):
        print(f"{k:8} {v}")
    print(f"\ndistinct backend API methods referenced: {len(api_methods)}")

    out = CTRL_DIR.parents[3].parent / 'tools' / 'routes.json'
    out.parent.mkdir(parents=True, exist_ok=True)
    out.write_text(json.dumps(
        {'routes': result, 'api_methods': sorted(api_methods)}, indent=2), encoding='utf-8')
    print(f"\nwrote {out}")

    print("\n=== PAGE routes ===")
    for ctrl, methods in result.items():
        pages = [n for n, k in methods.items() if k == 'PAGE']
        if pages:
            print(f"\n[{ctrl}]")
            for p in sorted(pages):
                print(f"  {ctrl}/{p}")


if __name__ == '__main__':
    main()
