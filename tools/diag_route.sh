#!/usr/bin/env bash
# Show the real PHP error for each failing route by enabling display_errors
# through the built-in server's stderr log.
set -u

HERE="$(cd "$(dirname "$0")" && pwd)"
. "$HERE/demo.env"
BASE="$DEMO_BASE"
CJ=/tmp/mib_diag_cj.txt
LOG=/tmp/mib_demo_srv.log

rm -f "$CJ"
curl -s -c "$CJ" -o /dev/null "$BASE/login"
curl -s -c "$CJ" -b "$CJ" -o /dev/null -X POST -d 'username=demo&password=demo123' "$BASE/login"

for route in "$@"; do
  echo "=================================================================="
  echo "ROUTE: $route"
  echo "=================================================================="
  : > /tmp/mib_mark
  MARK=$(wc -l < "$LOG")
  curl -s -c "$CJ" -b "$CJ" -o /tmp/diag_body.html \
    -w '  http=%{http_code} bytes=%{size_download}\n' "$BASE/vendor/$route"
  echo "  --- server log (new lines) ---"
  tail -n +"$((MARK+1))" "$LOG" | grep -iE 'error|warning|fatal|uncaught|stack' | head -12 | sed 's/^/  /'
  echo "  --- body head ---"
  head -c 700 /tmp/diag_body.html | tr -d '\000' | sed 's/^/  /'
  echo
done
