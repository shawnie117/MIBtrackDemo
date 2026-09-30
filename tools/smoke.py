#!/usr/bin/env python3
"""
DEMO BUILD RIG - smoke test every vendor page route.

Logs in once, then requests every PAGE route discovered by list_routes.py and
records status, byte size, and any PHP error text that leaked into the HTML.

Also reports the set of backend API methods that are still unimplemented,
harvested from _build/mock_missing.log, which the mock Api.php appends to.

Usage:
    python tools/smoke.py [--base URL] [--verbose]

The base URL defaults to whatever tools/demo.env specifies, so the port lives
in exactly one place.
"""
import argparse
import http.cookiejar
import json
import pathlib
import re
import sys
import urllib.error
import urllib.parse
import urllib.request

ROOT = pathlib.Path(__file__).resolve().parent.parent
ROUTES_JSON = ROOT / 'tools' / 'routes.json'
MISSING_LOG = ROOT / '_build' / 'mock_missing.log'
REPORT = ROOT / 'tools' / 'smoke_report.json'
ENV_FILE = ROOT / 'tools' / 'demo.env'


def default_base():
    """Read DEMO_HOST/DEMO_PORT out of tools/demo.env."""
    host, port = '127.0.0.1', '8765'
    try:
        for line in ENV_FILE.read_text().splitlines():
            line = line.strip()
            if line.startswith('DEMO_HOST='):
                host = line.split('=', 1)[1].strip().strip('"')
            elif line.startswith('DEMO_PORT='):
                port = line.split('=', 1)[1].strip().strip('"')
    except OSError:
        pass
    return f'http://{host}:{port}'

# Text that indicates the page rendered but PHP complained.
ERROR_PATTERNS = [
    ('fatal', re.compile(r'Fatal error', re.I)),
    ('parse', re.compile(r'Parse error', re.I)),
    ('warning', re.compile(r'<b>Warning</b>|Warning:', re.I)),
    ('notice', re.compile(r'<b>Notice</b>|Notice:', re.I)),
    ('deprecated', re.compile(r'Deprecated:', re.I)),
    ('ci_error', re.compile(r'An Error Was Encountered|Unable to load the requested', re.I)),
    ('db', re.compile(r'A Database Error Occurred', re.I)),
]

# Routes we deliberately skip: they mutate state, log out, or stream binaries.
SKIP = {
    'dashboard/logout', 'login/logout',
    'login/index', 'login/landing_page',
}
SKIP_PREFIX = ('deactivate_', 'reactivate_', 'confirm_', 'reject_', 'close_',
               'reopen_', 'resolve_', 'approve_', 'set_')


def build_opener():
    cj = http.cookiejar.CookieJar()
    return urllib.request.build_opener(urllib.request.HTTPCookieProcessor(cj))


def fetch(opener, url, data=None, timeout=30):
    req = urllib.request.Request(
        url,
        data=urllib.parse.urlencode(data).encode() if data else None,
        headers={'User-Agent': 'mib-demo-smoke/1.0'},
    )
    try:
        with opener.open(req, timeout=timeout) as r:
            return r.status, r.read().decode('utf-8', 'replace')
    except urllib.error.HTTPError as e:
        return e.code, e.read().decode('utf-8', 'replace')
    except Exception as e:                                    # noqa: BLE001
        return 0, f'__TRANSPORT_ERROR__ {e}'


def main():
    ap = argparse.ArgumentParser()
    ap.add_argument('--base', default=default_base())
    ap.add_argument('--verbose', action='store_true')
    args = ap.parse_args()
    base = args.base.rstrip('/')

    if not ROUTES_JSON.exists():
        sys.exit(f'missing {ROUTES_JSON}; run list_routes.py first')

    routes = json.loads(ROUTES_JSON.read_text())['routes']

    if MISSING_LOG.exists():
        MISSING_LOG.unlink()

    opener = build_opener()

    # --- authenticate -------------------------------------------------
    status, _ = fetch(opener, f'{base}/login')
    if status != 200:
        sys.exit(f'login page unreachable (status {status}); is the server up?')
    fetch(opener, f'{base}/login', data={'username': 'demo', 'password': 'demo123'})
    status, body = fetch(opener, f'{base}/vendor/dashboard')
    if status != 200 or 'Hi, Demo' not in body:
        sys.exit(f'authentication failed (status {status})')
    print('auth OK\n')

    # --- walk every PAGE route ---------------------------------------
    results = []
    for ctrl, methods in routes.items():
        for method, kind in sorted(methods.items()):
            if kind != 'PAGE':
                continue
            route = f'{ctrl}/{method}'
            if route in SKIP or method.startswith(SKIP_PREFIX):
                continue

            url = f'{base}/vendor/{route}'
            status, body = fetch(opener, url)

            problems = [name for name, rx in ERROR_PATTERNS if rx.search(body)]
            results.append({
                'route': route,
                'status': status,
                'bytes': len(body),
                'problems': problems,
                'has_chrome': 'page-sidebar-menu' in body,
            })
            if args.verbose:
                flag = ','.join(problems) if problems else 'ok'
                print(f'  {status}  {len(body):>7}  {route:<48} {flag}')

    # --- summary ------------------------------------------------------
    ok = [r for r in results if r['status'] == 200 and not r['problems']]
    warned = [r for r in results if r['status'] == 200 and r['problems']]
    broken = [r for r in results if r['status'] != 200]

    print('=' * 68)
    print(f'{"routes tested":<26} {len(results)}')
    print(f'{"clean 200":<26} {len(ok)}')
    print(f'{"200 with PHP problems":<26} {len(warned)}')
    print(f'{"non-200":<26} {len(broken)}')
    print('=' * 68)

    if broken:
        print('\n--- non-200 ---')
        for r in sorted(broken, key=lambda x: x['route']):
            print(f'  {r["status"]}  {r["route"]}')

    if warned:
        print('\n--- 200 but PHP complained ---')
        for r in sorted(warned, key=lambda x: x['route'])[:40]:
            print(f'  {",".join(r["problems"]):<28} {r["route"]}')
        if len(warned) > 40:
            print(f'  ... and {len(warned) - 40} more')

    missing = []
    if MISSING_LOG.exists():
        missing = sorted(set(MISSING_LOG.read_text().split()))
        print(f'\n--- unimplemented backend methods: {len(missing)} ---')
        for m in missing:
            print(f'  {m}')

    REPORT.write_text(json.dumps(
        {'results': results, 'missing_api_methods': missing}, indent=2), encoding='utf-8')
    print(f'\nwrote {REPORT}')


if __name__ == '__main__':
    main()
