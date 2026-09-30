#!/usr/bin/env bash
# One-off: repoint every tool script at tools/demo.env instead of a
# hardcoded host:port. Idempotent - safe to re-run.
set -eu

HERE="$(cd "$(dirname "$0")" && pwd)"

FILES="verify_content.sh diag_route.sh diag_msg.sh diag_one.sh diag_fatal.sh diag_trace.sh diag_deep.sh"

for f in $FILES; do
  p="$HERE/$f"
  [ -f "$p" ] || { echo "skip (absent): $f"; continue; }

  # 1. source demo.env right after 'set -u', unless already sourcing it
  if ! grep -q 'demo.env' "$p"; then
    sed -i '0,/^set -u$/s|^set -u$|set -u\n\nHERE="$(cd "$(dirname "$0")" \&\& pwd)"\n. "$HERE/demo.env"|' "$p"
  fi

  # 2. hardcoded base URL -> shared value
  sed -i 's|BASE="http://127\.0\.0\.1:[0-9]\+"|BASE="$DEMO_BASE"|g' "$p"

  # 3. hardcoded build paths -> shared value
  sed -i 's|"/mnt/d/Internship/Mauli Infotech/MIBtrackDemo/_build"|"$DEMO_BUILD"|g' "$p"
  sed -i 's|/mnt/d/Internship/Mauli Infotech/MIBtrackDemo/_build|${DEMO_BUILD}|g' "$p"

  echo "patched: $f"
done

echo
echo "=== residual hardcoded ports in tools/ ==="
grep -rn '127\.0\.0\.1:[0-9]\+\|localhost:[0-9]\+' "$HERE" --include='*.sh' --include='*.py' \
  | grep -v 'demo.env' || echo "  none"
