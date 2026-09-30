#!/usr/bin/env bash
# Confirm seeded mock data renders inside the real, unmodified views.
set -u

HERE="$(cd "$(dirname "$0")" && pwd)"
. "$HERE/demo.env"
BASE="$DEMO_BASE"
CJ=/tmp/mib_c_cj.txt

rm -f "$CJ"
curl -s -c "$CJ" -o /dev/null "$BASE/login"
curl -s -c "$CJ" -b "$CJ" -o /dev/null -X POST -d 'username=demo&password=demo123' "$BASE/login"

check () {
  local route="$1"; shift
  curl -s -c "$CJ" -b "$CJ" -o /tmp/c.html "$BASE/vendor/$route"
  printf '\n=== %s (%s bytes) ===\n' "$route" "$(wc -c < /tmp/c.html)"
  printf '  page title : %s\n' "$(grep -oP '(?<=<title>)[^<]+' /tmp/c.html | head -1)"
  for needle in "$@"; do
    if grep -qF "$needle" /tmp/c.html; then
      printf '  FOUND      : %s\n' "$needle"
    else
      printf '  MISSING    : %s\n' "$needle"
    fi
  done
  printf '  table rows : %s\n' "$(grep -c '<tr>' /tmp/c.html || true)"
}

check "admin/branch_report" "Kharghar (Head Office)" "Pune Branch" "Nashik Branch" "9800000011" "Anjali Deshmukh"
check "leads/lead_report"   "All Lead Report"
check "dashboard"           "Hi, Demo Admin"
