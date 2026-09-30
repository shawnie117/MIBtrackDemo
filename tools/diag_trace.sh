#!/usr/bin/env bash
# Trace the redirect chain and CI log entries for given routes.
set -u

HERE="$(cd "$(dirname "$0")" && pwd)"
. "$HERE/demo.env"
BASE="$DEMO_BASE"
CJ=/tmp/mib_tr_cj.txt
BUILD="$DEMO_BUILD"

rm -f "$CJ"
curl -s -c "$CJ" -o /dev/null "$BASE/login"
curl -s -c "$CJ" -b "$CJ" -o /dev/null -X POST -d 'username=demo&password=demo123' "$BASE/login"

# Confirm we really are authenticated
auth=$(curl -s -c "$CJ" -b "$CJ" -o /dev/null -w '%{http_code}' "$BASE/vendor/dashboard")
echo "dashboard (sanity) http=$auth"
echo

for route in "$@"; do
  echo "=============================================================="
  echo "ROUTE $route"
  # -o /dev/null so we only see the status line + Location, no redirect follow
  curl -s -c "$CJ" -b "$CJ" -o /tmp/tr_body.html -D /tmp/tr_hdr.txt \
       -w '  no-follow: http=%{http_code} bytes=%{size_download}\n' "$BASE/vendor/$route"
  grep -iE '^(HTTP/|Location:|Status:)' /tmp/tr_hdr.txt | sed 's/^/    /'
  echo "  --- body (tags stripped, first 300 chars) ---"
  sed -e 's/<[^>]*>/ /g' /tmp/tr_body.html | tr -s ' \n' ' ' | head -c 300 | sed 's/^/    /'
  echo
done

echo
echo "=============================================================="
echo "CI log (today) - error lines"
LOGF=$(ls -1t "$BUILD/application/logs/" 2>/dev/null | head -1)
if [ -n "${LOGF:-}" ]; then
  echo "  file: $LOGF"
  grep -iE 'ERROR|Severity' "$BUILD/application/logs/$LOGF" | tail -20 | sed 's/^/    /'
else
  echo "  (no CI log file)"
fi
