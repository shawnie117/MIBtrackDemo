#!/usr/bin/env bash
# Separate real errors from PHP 8.2 "dynamic property" deprecation noise.
set -u

HERE="$(cd "$(dirname "$0")" && pwd)"
. "$HERE/demo.env"
BASE="$DEMO_BASE"
CJ=/tmp/mib_f_cj.txt
ROUTE="${1:-leads/lead_report}"

rm -f "$CJ"
curl -s -c "$CJ" -o /dev/null "$BASE/login"
curl -s -c "$CJ" -b "$CJ" -o /dev/null -X POST -d 'username=demo&password=demo123' "$BASE/login"
code=$(curl -s -c "$CJ" -b "$CJ" -o /tmp/f.html -w '%{http_code}' "$BASE/vendor/$ROUTE")

echo "=== $ROUTE  http=$code  bytes=$(wc -c < /tmp/f.html) ==="
echo
echo "--- error Messages, excluding dynamic-property deprecations ---"
sed -e 's/<[^>]*>/\n/g' /tmp/f.html \
  | grep -E 'Severity|Message:|Filename:|Line Number:' \
  | paste - - - - 2>/dev/null \
  | grep -v 'dynamic property' \
  | head -25

echo
echo "--- counts ---"
printf '  dynamic-property deprecations : %s\n' "$(grep -c 'dynamic property' /tmp/f.html || true)"
printf '  Severity: 1 (E_ERROR)          : %s\n' "$(grep -c 'Severity: 1<' /tmp/f.html || true)"
printf '  Fatal error                    : %s\n' "$(grep -c 'Fatal error' /tmp/f.html || true)"
printf '  Undefined array key            : %s\n' "$(grep -c 'Undefined array key' /tmp/f.html || true)"
printf '  Undefined variable             : %s\n' "$(grep -c 'Undefined variable' /tmp/f.html || true)"
printf '  on null                        : %s\n' "$(grep -c 'on null' /tmp/f.html || true)"

echo
echo "--- last 600 chars of body (where a fatal would land) ---"
tail -c 600 /tmp/f.html | sed -e 's/<[^>]*>/ /g' | tr -s ' '
