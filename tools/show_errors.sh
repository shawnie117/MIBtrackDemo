#!/usr/bin/env bash
# DEMO BUILD RIG - dump the newest PHP/CI errors for the running build server.
set -u

HERE="$(cd "$(dirname "$0")" && pwd)"
. "$HERE/demo.env"

echo "=== built-in server log (tail) ==="
tail -40 /tmp/mib_demo_srv.log 2>/dev/null | sed 's/^/  /'

echo
echo "=== CI log files ==="
ls -la "$DEMO_BUILD/application/logs" | sed 's/^/  /'

newest=$(ls -t "$DEMO_BUILD"/application/logs/log-*.php 2>/dev/null | head -1)
if [ -n "${newest:-}" ]; then
  echo
  echo "=== tail of $newest ==="
  tail -40 "$newest" | sed 's/^/  /'
fi
