# MI-BTrack Demo — Server Deployment Guide

## 1. Purpose

This document explains how to deploy the project located in:

```text
MIBtrackDemo/_build
```

The current `_build` application is a **demonstration build**, not the complete production MI-BTrack backend. It preserves the original CodeIgniter screens and controllers but replaces the real Java/Oracle API with synthetic PHP data.

This guide covers two different deployment targets:

1. **Public demo deployment** — recommended for demonstrations, training and the guided tour.
2. **Real production deployment** — requires the original Java REST services, Oracle database and production infrastructure.

Do not mix these two modes. In particular, do not connect the public demo to production APIs, payment services or real customer messaging.

---

## 2. Current Application Architecture

### 2.1 Demo architecture

```text
Browser
  -> Apache / Nginx / IIS
  -> CodeIgniter PHP application
  -> application/libraries/Api.php
  -> application/libraries/MockData.php
  -> application/libraries/MockSeed.php
  -> synthetic baseline data plus the visitor's PHP session
```

Important consequences:

- MySQL is not required for the ordinary demo workflow.
- No Oracle server is required for the demo.
- Every visitor starts with synthetic sample records.
- Records added or changed during the demo are stored in that visitor's session.
- Demo changes are not permanent business records.
- Clearing the browser/session, session expiry or server session cleanup can remove those changes.
- External operations such as payments, messages and production uploads must remain disabled or mocked.

### 2.2 Original production architecture

```text
Browser
  -> CodeIgniter PHP frontend
  -> production Api.php
  -> Java Jersey REST services
  -> Oracle database, queries and stored procedures
```

The original production source is located separately in `MIBtrackShawn`. Deploying `_build` alone does not create the real production system.

---

## 3. Recommended Deployment Choice

For the current project, deploy `_build` as a **separate public demo** using a hostname such as:

```text
https://demo.example.com/
```

Recommended rules:

- Use a dedicated subdomain and HTTPS.
- Use only synthetic accounts and synthetic AMC/customer data.
- Keep the mock `Api.php` in place.
- Do not provide the demo server with access to the production database or private API network.
- Clearly label the application as a demo.
- Use a separate VM, hosting account, container or site pool when possible.

---

## 4. Files to Deploy

The web application is the complete contents of:

```text
MIBtrackDemo/_build/
```

The web server's document root must point to `_build`, not to the parent `MIBtrackDemo` folder.

Do not publish these parent-folder development items:

```text
tools/
tools/node_modules/
artifacts/
PROJECT_HANDOVER.md
VENDOR_WEBSITE_WORKFLOW.md
DEMO_TOUR_VOICE_PACK.md
```

They are useful for development and testing but are not part of the web runtime.

Before packaging, remove generated runtime content from the copy being uploaded:

```text
_build/application/logs/log-*.php
_build/application/cache/ci_*
_build/mock_missing.log
```

Keep the protective `index.html`/`.htaccess` files inside framework directories.

---

## 5. Server Requirements

### 5.1 Recommended runtime

- 64-bit PHP 8.2
- Apache 2.4, Nginx with PHP-FPM, or IIS with FastCGI
- HTTPS certificate
- At least 512 MB PHP memory for report and spreadsheet operations
- A writable private directory for PHP sessions

PHP 8.5 is not recommended for this older CodeIgniter 3 application. PHP 8.2 is the currently tested compatibility target for this demo.

### 5.2 PHP extensions

Enable the following extensions:

```text
curl
fileinfo
gd
intl
json
mbstring
mysqli
openssl
session
zip
```

`mysqli` is not essential to the mocked demo flow, but enabling it avoids failures in older or optional code paths. `zip`, `gd` and `fileinfo` are useful for exports and file validation.

### 5.3 Suggested PHP settings

Use values appropriate for the server's capacity:

```ini
memory_limit = 512M
max_execution_time = 120
post_max_size = 32M
upload_max_filesize = 25M
display_errors = Off
log_errors = On
date.timezone = Asia/Kolkata
session.use_strict_mode = 1
```

The PHP development server command below is only for local testing:

```bat
php -S 127.0.0.1:8765 router.php
```

Never use `php -S` as the public production web server.

---

## 6. Required Backend Configuration Changes

### 6.1 Set the public base URL

Edit:

```text
_build/application/config/config.php
```

Replace the local URL:

```php
$config['base_url'] = 'http://127.0.0.1:8765/';
```

with the final HTTPS URL, including the trailing slash:

```php
$config['base_url'] = 'https://demo.example.com/';
```

If installed in a subdirectory:

```php
$config['base_url'] = 'https://example.com/mibtrack-demo/';
```

The subdomain layout is preferable because URL rewriting and assets are simpler.

### 6.2 Keep the production environment

In `_build/index.php`, keep:

```php
define('ENVIRONMENT', 'production');
```

Production mode prevents PHP warnings and deprecation messages from being rendered inside the UI. Errors should be written to logs instead.

### 6.3 Configure a private session directory

The portable build currently uses:

```php
$config['sess_save_path'] = sys_get_temp_dir();
```

That is acceptable for a short local demo. A hosted deployment should use a dedicated absolute folder outside the public web root.

Linux example:

```php
$config['sess_save_path'] = '/var/lib/mibtrack-demo/sessions';
```

Windows example:

```php
$config['sess_save_path'] = 'C:/MIBTrackData/sessions';
```

The Apache/PHP-FPM/IIS service account must be able to create, read, update and delete files in this directory.

Do not place sessions under `assets/` or another publicly downloadable directory.

### 6.4 Add a strong encryption key

The current encryption key is empty. Generate a unique random value and configure:

```php
$config['encryption_key'] = 'REPLACE_WITH_A_LONG_RANDOM_VALUE';
```

Linux generation example:

```bash
php -r "echo bin2hex(random_bytes(32)), PHP_EOL;"
```

Windows CMD example:

```bat
php -r "echo bin2hex(random_bytes(32)), PHP_EOL;"
```

Do not commit or paste the generated production key into documentation or chat.

### 6.5 Secure session cookies

After HTTPS is working, use:

```php
$config['cookie_secure'] = TRUE;
$config['cookie_httponly'] = TRUE;
```

Keep:

```php
$config['cookie_path'] = '/';
```

For a subdirectory installation, test login and logout carefully because the application currently expects root-relative behavior in several places.

### 6.6 Reduce production logging

Change:

```php
$config['log_threshold'] = 4;
```

to:

```php
$config['log_threshold'] = 1;
```

Level `1` records errors without filling the server with development-level informational logs.

### 6.7 Disable visible debug backtraces

Edit:

```text
_build/application/config/constants.php
```

Change:

```php
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);
```

to:

```php
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', FALSE);
```

### 6.8 Protect secrets and internal addresses

The current `constants.php` contains legacy/internal API addresses and service credentials. Even though the mock demo `Api.php` does not normally call them, they must not be shipped publicly.

Before deployment:

- Remove unused private `192.168.x.x` API URLs.
- Remove unused production API keys.
- Remove payment secrets from the public demo.
- Restrict the Google Maps key by HTTPS referrer and enabled API.
- Rotate any credential that has previously been shared or committed.
- Read real secrets from server environment variables if a future deployment needs them.

Example pattern:

```php
$value = getenv('MIBTRACK_API_KEY');
if ($value === false || $value === '') {
    $value = 'demo-disabled';
}
define('V_APIKEY', $value);
```

For the public demo, inactive external services should use a clearly disabled placeholder instead of a live secret.

### 6.9 CSRF protection

The current application has:

```php
$config['csrf_protection'] = FALSE;
```

CSRF protection should eventually be enabled for a publicly accessible state-changing application. However, this older UI contains many forms and AJAX requests, so turning it on without updating and testing every request can break the demo.

Safe sequence:

1. Deploy initially behind restricted access.
2. Inventory every POST/AJAX endpoint.
3. Add the CodeIgniter CSRF token to forms and AJAX requests.
4. Enable CSRF in a staging deployment.
5. Test login, employee, lead, customer, AMC, ticket and report flows.
6. Enable it publicly only after those tests pass.

Until that work is complete, use access controls and keep the demo's actions synthetic.

---

## 7. Demo API and Data Rules

Keep this file in place for demo hosting:

```text
_build/application/libraries/Api.php
```

It routes controller calls to `MockData` instead of the production network.

Also keep:

```text
_build/application/libraries/MockData.php
_build/application/libraries/MockSeed.php
```

Do not replace the demo `Api.php` with the original production version unless the entire Java/Oracle backend is deliberately being deployed and secured.

### Demo persistence behavior

For the current build:

- Seed data is defined in PHP arrays.
- Adds and edits use session-scoped overlays.
- Two visitors do not share newly added records.
- Server restarts normally preserve active file sessions, but session cleanup can remove them.
- This is suitable for a sales demonstration, not for storing the company's real AMC portfolio.

If the boss needs a fixed set of AMCs visible to every visitor, add them to `MockSeed.php`. If the boss needs edits to remain permanently, a real persistent backend must be designed; sessions are not sufficient.

---

## 8. Apache Deployment

### 8.1 Document root

Point the Apache virtual host directly to the deployed `_build` directory.

Example:

```apache
<VirtualHost *:80>
    ServerName demo.example.com
    DocumentRoot /var/www/mibtrack-demo/_build

    <Directory /var/www/mibtrack-demo/_build>
        Options -Indexes
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/mibtrack-demo-error.log
    CustomLog ${APACHE_LOG_DIR}/mibtrack-demo-access.log combined
</VirtualHost>
```

Enable rewriting:

```bash
sudo a2enmod rewrite
sudo systemctl reload apache2
```

### 8.2 Root `.htaccess`

Create `_build/.htaccess` with:

```apache
Options -Indexes
RewriteEngine On

RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^ index.php [L,QSA]

<FilesMatch "^(\.env|composer\.(json|lock)|.*\.log)$">
    Require all denied
</FilesMatch>
```

The existing `.htaccess` files inside `application` and `system` protect those directories. Confirm that Apache allows those rules to run.

### 8.3 HTTPS

Configure the certificate through the hosting provider or Let's Encrypt, redirect HTTP to HTTPS, and only then turn on `cookie_secure`.

---

## 9. Nginx Deployment

Nginx does not read `.htaccess`. Configure routing and directory protection in the server block.

Example:

```nginx
server {
    listen 80;
    server_name demo.example.com;
    root /var/www/mibtrack-demo/_build;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.2-fpm.sock;
    }

    location ~ ^/(application|system)/ {
        deny all;
    }

    location ~ /\. {
        deny all;
    }

    location ~* \.(log|env|ini)$ {
        deny all;
    }
}
```

Run `nginx -t` before reloading Nginx. Add HTTPS using the server's normal certificate process.

---

## 10. Windows IIS Deployment

For IIS:

1. Install IIS and the URL Rewrite module.
2. Configure PHP 8.2 through FastCGI.
3. Create a new IIS site whose physical path is the `_build` directory.
4. Give the IIS application pool identity write permission only to:
   - the dedicated session directory;
   - `application/logs`;
   - `application/cache` if caching is enabled.
5. Add HTTPS binding and a certificate.
6. Add a `web.config` rewrite rule.

Example `_build/web.config`:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<configuration>
  <system.webServer>
    <directoryBrowse enabled="false" />
    <rewrite>
      <rules>
        <rule name="CodeIgniter" stopProcessing="true">
          <match url="^(.*)$" />
          <conditions logicalGrouping="MatchAll">
            <add input="{REQUEST_FILENAME}" matchType="IsFile" negate="true" />
            <add input="{REQUEST_FILENAME}" matchType="IsDirectory" negate="true" />
          </conditions>
          <action type="Rewrite" url="index.php/{R:1}" appendQueryString="true" />
        </rule>
      </rules>
    </rewrite>
    <security>
      <requestFiltering>
        <hiddenSegments>
          <add segment="application" />
          <add segment="system" />
        </hiddenSegments>
      </requestFiltering>
    </security>
  </system.webServer>
</configuration>
```

Do not expose the PHP development server directly to the internet on Windows.

---

## 11. cPanel / Shared Hosting Deployment

For cPanel-style hosting:

1. Create a subdomain such as `demo.example.com`.
2. Set its document root to a folder containing the contents of `_build`.
3. Select PHP 8.2.
4. Enable the extensions listed earlier.
5. Upload the `_build` contents, including hidden `.htaccess` files.
6. Change `base_url` to the HTTPS subdomain.
7. Create a non-public session directory under the account home directory.
8. Set `sess_save_path` to its absolute path.
9. Make `application/logs` writable by PHP without using world-writable `0777` unless the hosting provider specifically requires it.
10. Confirm HTTPS before setting `cookie_secure = TRUE`.

Example session path:

```php
$config['sess_save_path'] = '/home/account/private/mibtrack_sessions';
```

The hosting provider can show the correct absolute account path.

---

## 12. File Permissions

Recommended Linux ownership and permissions vary by distribution. A typical example is:

```bash
sudo chown -R root:www-data /var/www/mibtrack-demo
sudo find /var/www/mibtrack-demo -type d -exec chmod 750 {} \;
sudo find /var/www/mibtrack-demo -type f -exec chmod 640 {} \;
sudo mkdir -p /var/lib/mibtrack-demo/sessions
sudo chown www-data:www-data /var/lib/mibtrack-demo/sessions
sudo chmod 700 /var/lib/mibtrack-demo/sessions
sudo chown www-data:www-data /var/www/mibtrack-demo/_build/application/logs
sudo chown www-data:www-data /var/www/mibtrack-demo/_build/application/cache
```

Do not recursively set the entire application to `777`.

---

## 13. Access Protection for a Demo

Until the security review and CSRF work are complete, place the demo behind at least one additional control:

- HTTP Basic Authentication;
- VPN access;
- IP allow-list;
- Cloud access gateway;
- hosting-provider password protection.

Also apply rate limiting to login and password-reset endpoints. The visible demo login should use only synthetic credentials.

---

## 14. Deployment Procedure

### Phase A — Prepare

1. Make a timestamped backup of the current server version.
2. Prepare a clean upload copy of `_build`.
3. Remove generated logs and cache entries from that copy.
4. Remove or neutralize unused credentials and private endpoints.
5. Set the final `base_url`.
6. Set production logs, cookies, encryption key and session path.
7. Add the correct Apache, Nginx or IIS rewrite configuration.

### Phase B — Stage

1. Upload to a staging directory or staging hostname.
2. Check the PHP version and extensions.
3. Check directory permissions.
4. Open the login page.
5. Log in with a synthetic demo account.
6. Run the guided tour.
7. Test the main workflows listed in the validation section below.
8. Review PHP and web-server error logs.

### Phase C — Publish

1. Enable HTTPS.
2. Enable secure cookies.
3. Add access protection and rate limiting.
4. Switch DNS or the document root to the tested release.
5. Repeat the smoke test on the public URL.
6. Keep the previous release available for rollback.

---

## 15. Post-Deployment Validation

### 15.1 Basic checks

- `/` redirects or loads the correct login page.
- Static CSS, JavaScript, fonts and images return HTTP 200.
- No request tries to load assets from `127.0.0.1:8765`.
- Unknown routes display the application 404 page.
- Direct requests to `/application/config/config.php` and `/system/` are denied.
- HTTPS does not show mixed-content warnings.
- Cookies are marked `Secure` and `HttpOnly` after HTTPS configuration.
- PHP warnings are not displayed in the page.

### 15.2 Functional workflow checks

Test using synthetic data only:

1. Login and logout.
2. Dashboard loading.
3. Start, pause, resume and finish the guided tour.
4. Add and view an employee.
5. Add and view a lead.
6. Convert or progress the supported lead workflow.
7. Add and view a customer.
8. Add and view an AMC.
9. Open the AMC portfolio.
10. Create and view a ticket where supported.
11. Open reports and apply filters.
12. Confirm workflow error messages and redirect buttons.
13. Confirm that payment, messaging and integration buttons cannot contact real services.

### 15.3 Session isolation test

1. Open the demo in Browser A and add a synthetic employee.
2. Open an incognito Browser B session.
3. Confirm Browser B starts from the baseline seed and does not see Browser A's new session-only record.
4. Confirm Browser A still sees its record while its session remains active.

---

## 16. Logs and Troubleshooting

CodeIgniter logs are stored in:

```text
_build/application/logs/
```

### HTTP 500 with a session error

Example:

```text
Session: Configured save path is not a directory
```

Fix the absolute `sess_save_path`, create the directory, and grant the PHP/web-server service account write permission.

### Login works but immediately returns to login

Check:

- session directory permission;
- HTTPS and `cookie_secure` agreement;
- cookie domain/path;
- reverse proxy behavior;
- PHP session cleanup;
- server clock and timezone.

If deployed behind a proxy or load balancer, review `sess_match_ip` and trusted proxy configuration. Changing client IPs can invalidate sessions when IP matching is enabled.

### CSS/JS missing or most routes return 404

The rewrite configuration is missing or disabled. Confirm Apache `mod_rewrite`, Nginx `try_files`, or IIS URL Rewrite.

### The website still calls `127.0.0.1`

Change `base_url`, clear the CodeIgniter cache and reload without browser cache.

### Blank lists or incomplete screens

Check:

```text
_build/mock_missing.log
```

The demo API deliberately returns an empty result for mock methods that have not been implemented. The known coverage gaps are documented in `PROJECT_HANDOVER.md`.

### PHP 8.5 warnings or compatibility errors

Use PHP 8.2 for this legacy CodeIgniter/PHPExcel application. Do not hide a fatal compatibility problem by suppressing all logging.

---

## 17. Backup and Rollback

Use release directories instead of overwriting the running application in place:

```text
/var/www/mibtrack-demo/releases/2026-09-10-01/_build
/var/www/mibtrack-demo/releases/2026-09-10-02/_build
/var/www/mibtrack-demo/current -> releases/2026-09-10-02/_build
```

Deployment:

1. Upload a new release directory.
2. Apply its server-specific configuration.
3. Test it through a staging hostname or local host mapping.
4. Switch the `current` link/document root.
5. Keep at least one previously tested release.

Rollback means pointing the web server back to the previous release. Demo session data may not be transferable between encryption/configuration changes, which is acceptable for synthetic demo sessions.

---

## 18. Converting to a Real Persistent Application

Do not attempt this by only changing `database.php`. The PHP demo does not implement the original business database layer.

A real deployment requires:

1. The original production-compatible `application/libraries/Api.php`.
2. The Java projects and their build/deployment configuration.
3. An Oracle database with the required schema, procedures and migrations.
4. Private network connectivity between PHP, Java services and Oracle.
5. Authentication/API-key management through server secrets.
6. Real file storage and backup policies.
7. Approved payment, email, SMS, WhatsApp, IndiaMART and Meta configuration.
8. Migration of AMC/customer/employee data through a verified import process.
9. Full authorization, tenant-isolation, audit and security testing.
10. A staging environment before production rollout.

The production request path becomes:

```text
CodeIgniter controller
  -> production Api.php
  -> HTTPS/private Java REST endpoint
  -> Oracle transaction
  -> JSON response
  -> controller/view
```

Before enabling any external integration, confirm that demo no-op behavior has been replaced intentionally and that the account/environment is correct.

---

## 19. Information Required Before Final Server Configuration

Collect these details from the server administrator:

- Final domain/subdomain.
- Linux or Windows.
- Apache, Nginx, IIS or cPanel.
- PHP version and PHP handler/FPM socket.
- Absolute deployment path.
- Absolute private session path.
- HTTPS certificate method.
- Reverse proxy/CDN details.
- Web-service account name.
- Whether the site is public, password-protected or internal-only.
- Whether this is the synthetic demo or the real persistent application.
- Required upload-size and report-generation limits.

With these values, replace the examples in this document with the real paths and domain before publishing.

---

## 20. Final Go-Live Checklist

- [ ] Deployment type confirmed: demo or real production.
- [ ] Document root points to `_build`.
- [ ] PHP 8.2 and required extensions are enabled.
- [ ] Public HTTPS `base_url` is configured.
- [ ] `ENVIRONMENT` is `production`.
- [ ] Dedicated session directory exists and is writable.
- [ ] Encryption key is set privately.
- [ ] Debug backtraces are disabled.
- [ ] Log threshold is reduced to errors.
- [ ] Secure and HttpOnly cookies are enabled after HTTPS.
- [ ] Root URL rewriting works.
- [ ] `application` and `system` cannot be downloaded.
- [ ] Directory listing is disabled.
- [ ] Logs, cache and session files are not public.
- [ ] Internal URLs and unused credentials have been removed.
- [ ] Previously exposed credentials have been rotated.
- [ ] Demo external actions remain safe no-ops.
- [ ] Access restriction/rate limiting is configured.
- [ ] Login, tour, employee, lead, customer, AMC, ticket and reports are tested.
- [ ] No browser console errors or mixed-content requests remain.
- [ ] Error logs have been reviewed.
- [ ] Backup and rollback have been tested.

---

## 21. Recommended Next Step

For the current demo, the next practical step is to obtain the final hostname and web-server type, create a clean deployment copy, remove/replace unused secrets, add the correct rewrite configuration, and test it first on a staging URL.

