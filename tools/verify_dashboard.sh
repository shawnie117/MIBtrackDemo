#!/usr/bin/env bash
# DEMO BUILD RIG - verify the vendor dashboard renders its widgets.
#
# Hits the dashboard three times in a row on purpose: the reminder data is
# cached for 5-60 minutes, so the first request exercises the cache-miss path
# and the later ones the cache-hit path. Those two paths must agree - when
# they did not, the second request died mid-render with a 500.
set -u

HERE="$(cd "$(dirname "$0")" && pwd)"
. "$HERE/demo.env"

BASE="$DEMO_BASE"
CJ=/tmp/mib_dash_cj.txt
OUT=/tmp/mib_dash.html
rm -f "$CJ" "$DEMO_BUILD/mock_missing.log"

curl -s -c "$CJ" -o /dev/null "$BASE/login"
curl -s -c "$CJ" -b "$CJ" -o /dev/null -X POST -d 'username=demo&password=demo123' "$BASE/login"

echo "=== dashboard, three consecutive requests (cache miss then hits) ==="
for n in 1 2 3; do
  curl -s -c "$CJ" -b "$CJ" -o "$OUT" \
    -w "  request $n: status=%{http_code} bytes=%{size_download}\n" "$BASE/vendor/dashboard"
done

echo
echo "=== reminder portlets rendered ==="
grep -c 'class="reminder-item"' "$OUT" | sed 's/^/  count: /'

python3 - "$OUT" <<'PY'
import re, sys

html = open(sys.argv[1], encoding='utf-8', errors='replace').read()

# Quick-action tiles. The heading tag carries a multi-line style attribute, so
# match across newlines rather than trying to stay on one line.
tiles = re.findall(r'widget-thumb-heading.*?<b>\s*(.*?)\s*</b>', html, re.S)
print('\n=== quick-action tiles ===')
for i, name in enumerate(tiles, 1):
    print('  %d. %s' % (i, ' '.join(name.split())))

# Top-level sidebar groups only. Expandable groups render as
# <a class="nav-link nav-toggle">; "Dashboard" is hard-coded above the loop
# and is a plain nav-link, so add it explicitly instead of loosening the
# pattern (which would pull in every submenu entry too).
start  = html.find('page-sidebar-menu')
end    = html.find('page-content-wrapper', start)
region = html[start:end]
groups = re.findall(
    r'nav-link nav-toggle[^>]*>\s*<i[^>]*></i>\s*<span class="title">([^<]+)', region)
print('\n=== sidebar top-level groups, in order ===')
for i, name in enumerate(['Dashboard'] + groups, 1):
    print('  %2d. %s' % (i, name.strip()))
PY

echo
echo "=== PHP problems in rendered output ==="
for pat in 'Fatal error' 'Parse error' 'Warning:' 'Notice:' 'Deprecated:' 'An Error Was Encountered'; do
  printf '  %-26s %s\n' "$pat" "$(grep -c "$pat" "$OUT" 2>/dev/null || true)"
done

echo
echo "=== unimplemented backend methods hit by the dashboard ==="
if [ -f "$DEMO_BUILD/mock_missing.log" ]; then
  sort -u "$DEMO_BUILD/mock_missing.log" | sed 's/^/  /'
else
  echo "  (none)"
fi
