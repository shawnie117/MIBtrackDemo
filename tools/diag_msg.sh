#!/usr/bin/env bash
# Print the CI error heading/message for each failing route.
set -u

HERE="$(cd "$(dirname "$0")" && pwd)"
. "$HERE/demo.env"
BASE="$DEMO_BASE"
CJ=/tmp/mib_diag_cj.txt

rm -f "$CJ"
curl -s -c "$CJ" -o /dev/null "$BASE/login"
curl -s -c "$CJ" -b "$CJ" -o /dev/null -X POST -d 'username=demo&password=demo123' "$BASE/login"

for route in "$@"; do
  code=$(curl -s -c "$CJ" -b "$CJ" -o /tmp/d.html -w '%{http_code}' "$BASE/vendor/$route")
  msg=$(sed -e 's/<[^>]*>/ /g' /tmp/d.html | tr -s ' \n' ' \n' | grep -viE '^\s*$' \
        | grep -iE 'error|not found|undefined|call to|unable' | head -4 | tr '\n' ' ')
  printf '%-46s http=%s  %s\n' "$route" "$code" "${msg:-<empty body>}"
done
