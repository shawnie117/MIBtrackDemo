#!/usr/bin/env bash
# DEMO BUILD RIG - deep diagnosis of failing routes.
set -u

HERE="$(cd "$(dirname "$0")" && pwd)"
. "$HERE/demo.env"
BUILD="$DEMO_BUILD"
BASE="$DEMO_BASE"
CJ=/tmp/mib_deep_cj.txt

echo "### 1. Is CI_ENV visible to PHP under the server?"
cd "$BUILD" || exit 1
php -r 'var_dump(getenv("CI_ENV"));'

echo
echo "### 2. Authenticate"
rm -f "$CJ"
curl -s -c "$CJ" -o /dev/null "$BASE/login"
curl -s -c "$CJ" -b "$CJ" -o /dev/null -X POST -d 'username=demo&password=demo123' "$BASE/login"
curl -s -c "$CJ" -b "$CJ" -o /tmp/deep_dash.html "$BASE/vendor/dashboard"
printf '   dashboard bytes=%s  Warning=%s  Deprecated=%s\n' \
  "$(wc -c < /tmp/deep_dash.html)" \
  "$(grep -c 'Warning' /tmp/deep_dash.html || true)" \
  "$(grep -c 'Deprecated' /tmp/deep_dash.html || true)"

echo
echo "### 3. Failing routes - raw response with headers"
for route in leads/lead_report leads/add_lead customers/render_upload_data_page; do
  echo "-------------------------------------------------------------"
  echo "ROUTE $route"
  curl -s -i -c "$CJ" -b "$CJ" "$BASE/vendor/$route" | head -20
  echo
done

echo
echo "### 4. php -l on the leads controller and views"
php -l "$BUILD/application/modules/vendor/controllers/Leads.php"
php -l "$BUILD/application/modules/vendor/views/leads/list_lead.php"
php -l "$BUILD/application/modules/vendor/views/leads/add_edit_lead.php"
php -l "$BUILD/application/modules/vendor/views/customers/upload_customer_data.php"

echo
echo "### 5. memory / limits"
php -r 'echo "memory_limit=", ini_get("memory_limit"), "  max_execution_time=", ini_get("max_execution_time"), PHP_EOL;'
