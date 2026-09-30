<?php
/**
 * DEMO-ONLY VIEW - guided tour shell (v3)
 *
 * This page is a frame around the real application. The vendor pages are
 * loaded, unmodified, into the iframe below, so the audience always sees
 * the genuine website rather than a redrawn copy of it.
 *
 * Nothing in this file styles or scripts the pages inside the iframe.
 *
 * Element ids here are the contract with assets/js/demo-tour.js. If you
 * rename one, rename it there too.
 */
?>
<!doctype html>
<html lang="<?php echo html_escape($tour_lang); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>MI-BTrack Guided Demo</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/demo-tour.css'); ?>?v=<?php echo filemtime(FCPATH . 'assets/css/demo-tour.css'); ?>">
</head>
<body data-tour="<?php echo html_escape($tour_id); ?>" data-lang="<?php echo html_escape($tour_lang); ?>">
<main class="tour-app">

    <header class="tour-topbar">
        <div>
            <strong>MI-BTrack Guided Demo</strong>
            <span id="tour-mode-label">Full Demo</span>
        </div>
        <div class="tour-top-actions">
            <label for="tour-language">Language
                <select id="tour-language">
                    <option value="mr"<?php echo $tour_lang === 'mr' ? ' selected' : ''; ?>>मराठी</option>
                    <option value="hi"<?php echo $tour_lang === 'hi' ? ' selected' : ''; ?>>हिंदी</option>
                    <option value="en"<?php echo $tour_lang === 'en' ? ' selected' : ''; ?>>English</option>
                </select>
            </label>
            <label for="tour-speed">Pace
                <select id="tour-speed">
                    <option value="0.5">0.5×</option>
                    <option value="1" selected>1×</option>
                    <option value="1.5">1.5×</option>
                    <option value="2">2×</option>
                    <option value="3">3×</option>
                </select>
            </label>
            <button id="tour-reset" type="button" title="Removes every record added in this browser session">Clear demo records</button>
            <a href="<?php echo base_url('vendor/dashboard'); ?>">Exit tour</a>
        </div>
    </header>

    <section class="tour-stage">
        <!-- The real vendor application. Loaded as-is; never restyled. -->
        <iframe id="tour-frame"
                title="MI-BTrack demo application"
                src="<?php echo base_url('vendor/dashboard'); ?>"></iframe>

        <div id="tour-spotlight" aria-hidden="true"></div>

        <!--
            Start gate. Two reasons this exists:
            1. Browsers block audio that did not follow a user gesture, so an
               autoplaying tour is silent for its own first step.
            2. It gives the presenter a moment before anything moves.
        -->
        <div id="tour-start">
            <div class="tour-start-card">
                <h2>MI-BTrack Full Demo</h2>
                <p>The real screens will open and the approved example details will be entered automatically while the selected-language guide explains the workflow.</p>
                <ul>
                    <li>You can pause at any moment, and nothing will move until you resume.</li>
                    <li><strong>Take control</strong> hands the screen over so you can try it yourself.</li>
                    <li>All names, numbers and amounts are invented. No real customer is contacted.</li>
                    <li>Anything created stays in this browser session only.</li>
                </ul>
                <button id="tour-start-btn" type="button">Start the tour</button>
            </div>
        </div>
    </section>

    <aside class="tour-player">
        <div class="tour-progress"><span id="tour-progress-bar"></span></div>

        <div class="tour-copy">
            <!--
                aria-live is on this block alone rather than the whole panel,
                so a screen reader announces the step being explained without
                re-reading the buttons and the counter every time.
            -->
            <span id="tour-chapter"></span>
            <h2 id="tour-title" aria-live="polite">Ready when you are</h2>
            <p id="tour-caption" aria-live="polite"></p>
            <p id="tour-cue" aria-live="polite"></p>
            <small id="tour-counter"></small>
            <small id="tour-status"> · Everything stays inside this browser session.</small>
        </div>

        <div class="tour-controls">
            <button id="tour-prev" type="button">Previous</button>
            <button id="tour-play" class="primary" type="button">Pause</button>
            <button id="tour-next" type="button">Next</button>
            <button id="tour-replay" type="button" title="Play this explanation again without repeating its actions">Replay</button>
            <button id="tour-control" type="button">Take control</button>
        </div>

        <!-- Shown only when a step could not complete. Never hides a failure. -->
        <div id="tour-error" role="alert">
            <p id="tour-error-title"></p>
            <p id="tour-error-text"></p>
            <div class="tour-error-actions">
                <button id="tour-retry" type="button">Retry this step</button>
                <button id="tour-skip" type="button">Skip and continue</button>
                <button id="tour-error-manual" type="button">Let me look myself</button>
                <button id="tour-setup" type="button"></button>
            </div>
        </div>

        <!-- Narration player. Falls back to the browser voice if a recording
             has not been produced yet, so the tour is testable before the
             audio pack arrives. -->
        <audio id="tour-audio" preload="none"></audio>
    </aside>
</main>

<script>window.MIB_TOUR_BASE = <?php echo json_encode(base_url()); ?>;</script>
<script src="<?php echo base_url('assets/js/demo-tour-content.js'); ?>?v=<?php echo filemtime(FCPATH . 'assets/js/demo-tour-content.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/demo-tour.js'); ?>?v=<?php echo filemtime(FCPATH . 'assets/js/demo-tour.js'); ?>"></script>
</body>
</html>
