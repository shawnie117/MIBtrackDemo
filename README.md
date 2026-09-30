# MIBtrack Demo

Local PHP demonstration of the vendor workflow, Full/Short guided tours, recorded narration, and simulated Android screens. This is a demo, not the production service.

## Run locally

Install Git and PHP CLI (tested with PHP 8.2). Enable the PHP extensions listed in `SERVER_DEPLOYMENT_GUIDE.md`.

```sh
git clone https://github.com/shawnie117/MIBtrackDemo.git
cd MIBtrackDemo/_build
php -S 127.0.0.1:8765 router.php
```

Open http://127.0.0.1:8765 and use the demo login: `demo` / `demo123`. Keep the terminal running. This private repository requires GitHub access when cloning.

The application uses local mock data and PHP sessions; no production database or API keys are needed for normal demo playback. Existing audio is included. Session changes from another PC are not transferred. PHP's temporary directory must be writable.

## Development and tests

```sh
cd tools
npm ci
node test_tour_cleanup.js
node test_connected_story.js
node test_mobile_demo.js
```

Browser tests require Chrome and a running demo server. Some test scripts contain Windows-specific Chrome paths.

## Documentation

- `PROJECT_HANDOVER.md`: project overview and history.
- `CONNECTED_DEMO_STORY.md`: shared mobile/desktop sample records.
- `ANDROID_DEMO_MAPPING.md`: mobile screen mapping and simulations.
- `SERVER_DEPLOYMENT_GUIDE.md`: server preparation and deployment caveats.

Environment files, credentials, caches, logs, local backups, and test screenshots are intentionally excluded. Voice regeneration requires your own ElevenLabs credentials; do not commit them. The PHP built-in server and shared demo login are for local demonstrations, not a public production deployment.
