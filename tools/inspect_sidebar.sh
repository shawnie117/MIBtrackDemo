#!/usr/bin/env bash
# Inspect the rendered sidebar of the last fetched dashboard page.
set -u
F="${1:-/tmp/dash.html}"

echo "=== top-level menu groups (nav-toggle entries) ==="
grep -oP 'nav-link nav-toggle.*?title">[^<]+' "$F" 2>/dev/null \
  | grep -oP '(?<=title">).*' | nl | sed 's/^/  /'

echo
echo "=== all sidebar titles in order (first 45) ==="
grep -oP '(?<=<span class="title">)[^<]+' "$F" | head -45 | nl | sed 's/^/  /'

echo
echo "=== total sidebar titles ==="
printf '  %s\n' "$(grep -cP '(?<=<span class="title">)[^<]+' "$F")"

echo
echo "=== page <title> ==="
grep -oP '(?<=<title>)[^<]+' "$F" | sed 's/^/  /'
