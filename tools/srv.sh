#!/usr/bin/env bash
# DEMO BUILD RIG - start/stop/status the PHP build server.
# The server is only a build-time tool; it is never part of the shipped demo.
set -u

HERE="$(cd "$(dirname "$0")" && pwd)"
# shellcheck source=demo.env
. "$HERE/demo.env"

PORT="${PORT:-$DEMO_PORT}"
PATTERN="php -S ${DEMO_HOST}:${PORT}"
LOG="/tmp/mib_demo_srv.log"

start() {
  stop >/dev/null 2>&1
  cd "$DEMO_BUILD" || exit 1
  # CI_ENV=development surfaces PHP fatals but breaks redirect() because the
  # deprecation output is sent before headers. Default to production.
  setsid nohup env CI_ENV="${CI_ENV:-production}" \
    php -S "${DEMO_HOST}:${PORT}" -t . router.php >"$LOG" 2>&1 </dev/null &
  disown 2>/dev/null || true
  for _ in $(seq 1 25); do
    sleep 0.4
    code=$(curl -s -o /dev/null -w '%{http_code}' "http://${DEMO_HOST}:${PORT}/" || echo 000)
    if [ "$code" != "000" ]; then
      echo "started on ${DEMO_HOST}:${PORT} (status ${code})"
      return 0
    fi
  done
  echo "FAILED to start; log follows:"
  tail -30 "$LOG"
  return 1
}

stop() {
  pkill -f "$PATTERN" 2>/dev/null || true
  sleep 0.5
  echo "stopped"
}

status() {
  if pgrep -f "$PATTERN" >/dev/null 2>&1; then
    echo "running on ${DEMO_HOST}:${PORT}: pid $(pgrep -f "$PATTERN" | tr '\n' ' ')"
    curl -s -o /dev/null -w "root status=%{http_code}\n" "http://${DEMO_HOST}:${PORT}/"
  else
    echo "not running (expected ${DEMO_HOST}:${PORT})"
  fi
}

case "${1:-status}" in
  start)    start ;;
  startdev) CI_ENV=development start ;;
  stop)     stop ;;
  status)   status ;;
  log)      tail -"${2:-40}" "$LOG" ;;
  url)      echo "$DEMO_BASE" ;;
  *)        echo "usage: $0 {start|startdev|stop|status|log|url}"; exit 2 ;;
esac
