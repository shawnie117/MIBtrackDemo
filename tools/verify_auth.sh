#!/usr/bin/env bash
# DEMO BUILD RIG - verify the auth path and app shell render correctly.
set -u

HERE="$(cd "$(dirname "$0")" && pwd)"
. "$HERE/demo.env"

BASE="$DEMO_BASE"
CJ=/tmp/mib_cj.txt
BUILD_DIR="$DEMO_BUILD"
rm -f "$CJ" "$BUILD_DIR/mock_missing.log"

echo "=== 1. GET /login (unauthenticated) ==="
curl -s -c "$CJ" -o /tmp/l1.html -w '   status=%{http_code} bytes=%{size_download}\n' "$BASE/login"

echo "=== 2. POST /login  demo/demo123 ==="
curl -s -c "$CJ" -b "$CJ" -o /tmp/l2.html \
  -w '   status=%{http_code} location=%{redirect_url}\n' \
  -X POST -d 'username=demo&password=demo123' "$BASE/login"

echo "=== 3. GET /vendor/dashboard (authenticated) ==="
curl -s -c "$CJ" -b "$CJ" -L -o /tmp/dash.html \
  -w '   status=%{http_code} bytes=%{size_download}\n' "$BASE/vendor/dashboard"

echo
echo "=== signed-in user shown in header ==="
grep -o 'Hi, [^<]*' /tmp/dash.html | head -1 | sed 's/^/   /'
grep -o 'id="branch_name"[^>]*>[^<]*' /tmp/dash.html | head -1 | sed 's/^/   /'

echo
echo "=== sidebar top-level menus rendered ==="
grep -oP '(?<=nav-toggle">)\s*<i class="[^"]*"></i>\s*<span class="title">[^<]+' /tmp/dash.html \
  | grep -oP '(?<=title">).*' | sed 's/^/   /'

echo
echo "=== sidebar submenu link count ==="
printf '   %s links\n' "$(grep -c 'class="nav-link "' /tmp/dash.html || echo 0)"

echo
echo "=== PHP problems in rendered output ==="
for pat in 'Fatal error' 'Parse error' 'Warning:' 'Notice:' 'Deprecated:' 'An Error Was Encountered' 'Unable to load'; do
  n=$(grep -c "$pat" /tmp/dash.html 2>/dev/null || echo 0)
  printf '   %-26s %s\n' "$pat" "$n"
done

echo
echo "=== unimplemented backend methods hit by the dashboard ==="
if [ -f "$BUILD_DIR/mock_missing.log" ]; then
  sort -u "$BUILD_DIR/mock_missing.log" | sed 's/^/   /'
  printf '   TOTAL: %s\n' "$(sort -u "$BUILD_DIR/mock_missing.log" | wc -l)"
else
  echo "   (none)"
fi
