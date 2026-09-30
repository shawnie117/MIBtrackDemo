#!/usr/bin/env bash
# Dump the complete error output for a single route, tags stripped.
set -u

HERE="$(cd "$(dirname "$0")" && pwd)"
. "$HERE/demo.env"
BASE="$DEMO_BASE"
CJ=/tmp/mib_one_cj.txt
ROUTE="${1:-leads/lead_report}"

rm -f "$CJ"
curl -s -c "$CJ" -o /dev/null "$BASE/login"
curl -s -c "$CJ" -b "$CJ" -o /dev/null -X POST -d 'username=demo&password=demo123' "$BASE/login"
curl -s -c "$CJ" -b "$CJ" -o /tmp/one.html "$BASE/vendor/$ROUTE"

echo "=== $ROUTE : $(wc -c < /tmp/one.html) bytes ==="
sed -e 's/<[^>]*>/ /g' /tmp/one.html \
  | tr -s ' \t' ' ' \
  | grep -vE '^\s*$' \
  | head -40
