/* =====================================================================
 * MI-BTrack guided demo - tour runtime (v3)
 * ---------------------------------------------------------------------
 * DEMO-ONLY FILE. It never touches a normal vendor page's markup. It
 * loads the real page in an iframe and drives that page's own controls,
 * so the website the audience sees is the website the customer gets.
 *
 * Design rules this file is built on, in order of importance:
 *
 *  1. HONESTY. Connected demo saves must be confirmed by the session API.
 *     Steps that only explain a screen say so.
 *  2. ONE EPOCH, ONE STEP. Every step runs under an epoch number. Any
 *     navigation (next / previous / language / replay / take control)
 *     bumps the epoch, and every async continuation checks it before
 *     touching the DOM. Nothing from an old step can survive.
 *  3. EVERYTHING IS DISPOSABLE. Timers, intervals, animation frames,
 *     audio handlers, speech handlers and iframe load handlers are all
 *     registered for disposal and torn down on every transition.
 *  4. PAUSE MEANS PAUSE. A pause gate is awaited between every single
 *     micro-operation, including between two typed characters, so Pause
 *     freezes typing mid-word and Resume continues from that character.
 *  5. SESSION-ONLY SAVES. Connected story steps reuse their session-owned
 *     sample records. They do not write to production data.
 *  6. EXPLICIT ACTIONS. Data changes belong to a declared story preparation
 *     or on-screen save cue; explanation-only steps do not submit forms.
 *
 * Author note for the next developer: prefer adding a new cue "kind" over
 * adding a special case inside runStep(). The step list should stay
 * declarative so that the narration and the on-screen action can never
 * drift apart.
 * ===================================================================== */

(function () {
    'use strict';

    // =================================================================
    // 0. Bootstrap and constants
    // =================================================================

    var BASE = window.MIB_TOUR_BASE || '/';
    var CONTENT = window.MIB_TOUR_CONTENT || {};

    // How long we are willing to wait for the real application before we
    // stop and explain the problem instead of silently carrying on.
    var TIMEOUT = {
        pageLoad: 25000,   // the vendor page's own load event
        docReady: 15000,   // document.readyState === 'complete'
        element: 15000,    // a field or table appearing (covers AJAX tables)
        options: 12000     // a dependent dropdown filling in
    };

    // Values are user-facing playback rates. Internal timing uses the
    // reciprocal so typing, cues and narration remain synchronized.
    var SPEED = { '0.5': 2, '1': 1, '1.5': 2 / 3, '2': 0.5, '3': 1 / 3 };

    var dom = {};
    [
        'tour-frame', 'tour-spotlight', 'tour-chapter', 'tour-title', 'tour-caption',
        'tour-counter', 'tour-progress-bar', 'tour-status', 'tour-prev', 'tour-play',
        'tour-next', 'tour-control', 'tour-replay', 'tour-language', 'tour-speed',
        'tour-reset', 'tour-audio', 'tour-start', 'tour-start-btn', 'tour-error',
        'tour-error-title', 'tour-error-text', 'tour-retry', 'tour-skip',
        'tour-setup', 'tour-error-manual', 'tour-mode-label', 'tour-cue'
    ].forEach(function (id) {
        dom[id.replace('tour-', '').replace(/-(\w)/g, function (m, c) { return c.toUpperCase(); })] =
            document.getElementById(id);
    });
    dom.stage = document.querySelector('.tour-stage');

    var state = {
        tourId: document.body.getAttribute('data-tour') || 'full',
        lang: document.body.getAttribute('data-lang') || 'mr',
        steps: [],
        index: 0,
        epoch: 0,
        started: false,
        paused: false,
        manual: false,
        speed: 1,
        disposers: [],
        resumeWaiters: [],
        cueLedger: {},  // cues already performed for the current step
        cueLog: [],     // timing evidence for the current recording
        cueComplete: true,

        // Observable progress, exposed on window.MIB_TOUR. Lets the live test
        // wait for a step to genuinely settle instead of guessing with a
        // timeout, and makes it obvious in the console where a step stalled.
        //   idle | loading | cueing | narrating | error | finished
        phase: 'idle',
        lastError: null
    };

    function setPhase(phase) {
        state.phase = phase;
        document.body.setAttribute('data-phase', phase);
    }

    state.steps = CONTENT[state.tourId] || CONTENT.full || [];

    // =================================================================
    // 1. Cancellation, disposal and the pause gate
    // =================================================================

    /** Thrown when a step is abandoned. Never shown to the user. */
    function Cancelled() { this.cancelled = true; }

    /**
     * Thrown when the real application did not do what the step needed.
     * The message is written for a non-technical presenter, because it is
     * displayed verbatim in the recovery panel.
     */
    function StepError(message, hint) {
        this.stepError = true;
        this.message = message;
        this.hint = hint || '';
    }

    function guard(epoch) {
        if (epoch !== state.epoch) { throw new Cancelled(); }
    }

    /** Register a teardown function for the current step. */
    function track(dispose) {
        state.disposers.push(dispose);
        return dispose;
    }

    /** Tear down everything the previous step created. */
    function disposeStep() {
        var list = state.disposers;
        state.disposers = [];
        for (var i = list.length - 1; i >= 0; i--) {
            try { list[i](); } catch (e) { /* teardown must never throw */ }
        }
        // Release anything blocked on the pause gate so it can observe the
        // epoch change and unwind instead of waiting forever.
        var waiters = state.resumeWaiters;
        state.resumeWaiters = [];
        waiters.forEach(function (w) { w(); });
    }

    /**
     * The pause gate. Awaited between every micro-operation. While paused
     * this never resolves, which is exactly why Pause is able to freeze a
     * half-typed word instead of letting the typing interval run on.
     */
    function gate(epoch) {
        guard(epoch);
        if (!state.paused) { return Promise.resolve(); }
        return new Promise(function (resolve) {
            state.resumeWaiters.push(resolve);
        }).then(function () {
            guard(epoch);
        });
    }

    function releaseGate() {
        var waiters = state.resumeWaiters;
        state.resumeWaiters = [];
        waiters.forEach(function (w) { w(); });
    }

    /** Cancellable, pause-aware sleep. */
    function sleep(ms, epoch) {
        return gate(epoch).then(function () {
            return new Promise(function (resolve, reject) {
                var timer = setTimeout(function () {
                    if (epoch !== state.epoch) { reject(new Cancelled()); return; }
                    resolve();
                }, ms * state.speed);
                track(function () { clearTimeout(timer); reject(new Cancelled()); });
            });
        });
    }

    // =================================================================
    // 2. Talking to the real page inside the iframe
    // =================================================================

    function frameWin() {
        try { return dom.frame.contentWindow; } catch (e) { return null; }
    }

    function frameDoc() {
        try { return dom.frame.contentDocument || dom.frame.contentWindow.document; }
        catch (e) { return null; }
    }

    function absolute(url) {
        return new URL(url, BASE).href;
    }

    /**
     * Where the iframe actually is right now.
     *
     * Deliberately reads contentWindow.location rather than frame.src: the
     * presenter may have navigated by hand in Take control mode, and src
     * still holds the last value we assigned. Using src here was why the
     * old player could "load" a page that was not on screen.
     */
    function liveUrl() {
        var win = frameWin();
        try { return win && win.location ? win.location.href : null; }
        catch (e) { return null; }
    }

    function onceFrameLoad(epoch, timeout, what) {
        return new Promise(function (resolve, reject) {
            var settled = false;
            function done(ok, err) {
                if (settled) { return; }
                settled = true;
                dom.frame.removeEventListener('load', onLoad);
                clearTimeout(timer);
                ok ? resolve() : reject(err);
            }
            function onLoad() {
                if (epoch !== state.epoch) { done(false, new Cancelled()); return; }
                done(true);
            }
            dom.frame.addEventListener('load', onLoad);
            var timer = setTimeout(function () {
                done(false, new StepError(
                    'The page took too long to open.',
                    'The demo server may have stopped. Check that it is still running, then choose Retry step.'
                ));
            }, timeout);
            track(function () { done(false, new Cancelled()); });
            if (what) { setCue(what); }
        });
    }

    function awaitDocReady(epoch) {
        var deadline = Date.now() + TIMEOUT.docReady;
        function check() {
            guard(epoch);
            var doc = frameDoc();
            if (doc && doc.readyState === 'complete' && doc.body) { return Promise.resolve(); }
            if (Date.now() > deadline) {
                throw new StepError(
                    'The page opened but did not finish loading.',
                    'Choose Retry step. If it keeps happening, open the page yourself with Take control.'
                );
            }
            return sleep(120, epoch).then(check);
        }
        return Promise.resolve().then(check);
    }

    /**
     * Put the requested vendor page on screen.
     *
     * Reloads only when the iframe is not already on that URL, but unlike
     * the old player it compares against the live location, so returning
     * from Take control re-loads the page the step actually needs.
     */
    function ensurePage(url, epoch, force) {
        return gate(epoch).then(function () {
            var wanted = absolute(url);
            var here = liveUrl();

            if (!force && here && here.split('#')[0] === wanted.split('#')[0]) {
                return awaitDocReady(epoch);
            }

            // The iframe may already be fetching the page we want. That happens
            // on the very first step, because the shell points the iframe at the
            // dashboard in its own markup and the tour can be started before
            // that finishes. During that window contentWindow.location still
            // reads about:blank, so a naive comparison concludes we are on the
            // wrong page. Reassigning src mid-flight can cancel the in-flight
            // load and leave the tour waiting for an event that never comes.
            // Attaching to the load already running avoids that entirely.
            var pending = dom.frame.getAttribute('src');
            var loadingWhatWeWant = (!here || here === 'about:blank') &&
                pending && absolute(pending).split('#')[0] === wanted.split('#')[0];

            if (loadingWhatWeWant) {
                if (dom.frame.contentDocument &&
                    dom.frame.contentDocument.readyState === 'complete') {
                    return awaitDocReady(epoch);
                }
                return onceFrameLoad(epoch, TIMEOUT.pageLoad, 'Opening the page…')
                    .then(function () {
                        guard(epoch);
                        return awaitDocReady(epoch);
                    });
            }

            var load = onceFrameLoad(epoch, TIMEOUT.pageLoad, 'Opening the page…');
            dom.frame.src = wanted;
            return load.then(function () {
                guard(epoch);
                return awaitDocReady(epoch);
            });
        });
    }

    /**
     * Decide which page a step should be looking at.
     *
     * Most steps name their own URL. A step marked `stay` describes whatever
     * page the previous step's save produced - for example the lead detail
     * screen, whose address contains a generated record id we cannot know in
     * advance. If we are not on that page (because the save was skipped, or
     * the presenter navigated away), fall back to the step's own url so the
     * tour still shows something truthful instead of narrating a blank.
     */
    function resolvePage(step, epoch) {
        if (!step.stay) { return ensurePage(step.url, epoch, state.tourId === 'full'); }
        var here = liveUrl() || '';
        if (step.stayIfUrlContains && here.indexOf(step.stayIfUrlContains) === -1) {
            return ensurePage(step.url, epoch);
        }
        return gate(epoch).then(function () { return awaitDocReady(epoch); });
    }

    function saveStory(action, epoch) {
        function request(options) {
            var controller=new AbortController();
            var timer=setTimeout(function(){controller.abort();},10000);
            track(function(){controller.abort();clearTimeout(timer);});
            options.signal=controller.signal;
            return fetch(BASE+'vendor/dashboard/story',options).finally(function(){clearTimeout(timer);});
        }
        return gate(epoch).then(function () {
            return request({credentials:'same-origin',cache:'no-store'});
        }).then(function (r) { if(!r.ok || r.redirected) throw new Error('Demo login required.'); return r.json(); })
        .then(function (s) {
            guard(epoch);
            return request({method:'POST',credentials:'same-origin',
                body:new URLSearchParams({action:action,token:s.token})});
        }).then(function (r) { return r.json().then(function(s){if(!r.ok || !s.ok) throw new Error(s.message || 'Demo save failed.');}); })
        .then(function () { return gate(epoch); });
    }

    /**
     * Wait for an element to exist and be visible.
     *
     * Report tables arrive by AJAX after the page load event, so polling is
     * required. A missing element raises a StepError naming the selector,
     * which the recovery panel shows along with the step's setup link. The
     * old player ignored a missing selector silently, which is how the tour
     * ended up narrating fields nobody could see.
     */
    function awaitElement(selector, epoch, options) {
        options = options || {};
        var timeout = options.timeout || TIMEOUT.element;
        var deadline = Date.now() + timeout;

        function visible(el) {
            if (options.requireVisible === false) { return true; }
            if (!el.offsetParent && el.offsetWidth === 0 && el.offsetHeight === 0) {
                // Fixed-position and collapsed elements report no offsetParent.
                var rect = el.getBoundingClientRect();
                return rect.width > 0 || rect.height > 0;
            }
            return true;
        }

        function check() {
            guard(epoch);
            var doc = frameDoc();
            if (doc) {
                var el = doc.querySelector(selector);
                if (el && visible(el)) {
                    var textReady = !options.expectedText ||
                        (el.textContent || '').indexOf(options.expectedText) !== -1;
                    var rowsReady = !options.minRows ||
                        el.querySelectorAll('tr').length >= options.minRows;
                    if (textReady && rowsReady) { return Promise.resolve(el); }
                }
            }
            if (Date.now() > deadline) {
                if (options.optional) { return Promise.resolve(null); }
                throw new StepError(
                    options.message || 'This part of the screen did not appear.',
                    options.hint || 'The screen may be waiting on data that this demo does not have yet. You can skip this step or take control and look around.'
                );
            }
            return sleep(150, epoch).then(check);
        }
        return Promise.resolve().then(check);
    }

    /** Wait until a <select> has real choices, not just its placeholder. */
    function awaitOptions(selector, epoch, minimum) {
        var need = minimum || 2;
        var deadline = Date.now() + TIMEOUT.options;
        function check() {
            guard(epoch);
            var doc = frameDoc();
            var el = doc && doc.querySelector(selector);
            if (el && el.options && el.options.length >= need) { return Promise.resolve(el); }
            if (Date.now() > deadline) {
                throw new StepError(
                    'A drop-down list on this screen stayed empty.',
                    'That list is filled from another setup screen. Use the button below to open the screen that fills it.'
                );
            }
            return sleep(150, epoch).then(check);
        }
        return Promise.resolve().then(check);
    }

    // =================================================================
    // 3. Spotlight
    // =================================================================

    /**
     * Position the highlight over an element inside the iframe.
     *
     * The spotlight is absolutely positioned inside .tour-stage, so the
     * element rectangle has to be converted from the iframe's viewport into
     * stage coordinates. The old player added the iframe's viewport offset
     * on top of that, which pushed the highlight down by the height of the
     * top bar. Measuring both rectangles and subtracting keeps it correct
     * whatever the surrounding layout does.
     */
    function visibleTargetRect(el) {
        if (!el) { return null; }
        var frameRect = dom.frame.getBoundingClientRect();
        var stageRect = dom.stage.getBoundingClientRect();
        var rect = el.getBoundingClientRect();
        var offsetX = frameRect.left - stageRect.left;
        var offsetY = frameRect.top - stageRect.top;
        var rawTop = offsetY + rect.top;
        var rawLeft = offsetX + rect.left;
        var rawBottom = rawTop + rect.height;
        var rawRight = rawLeft + rect.width;

        // A selector may intentionally name a whole page, long menu or form.
        // Highlight only the visible intersection. Drawing a 1900px ring from
        // a negative top made the cyan box appear detached from the screen.
        var top = Math.max(0, rawTop);
        var left = Math.max(0, rawLeft);
        var bottom = Math.min(dom.stage.clientHeight, rawBottom);
        var right = Math.min(dom.stage.clientWidth, rawRight);
        if (bottom <= top || right <= left) { return null; }

        return { top: top, left: left, width: right - left, height: bottom - top };
    }

    function place(el) {
        if (!el || state.manual) { return; }
        var visible = visibleTargetRect(el);
        if (!visible) { dom.spotlight.style.display = 'none'; return; }
        var pad = 6;

        dom.spotlight.style.top = Math.round(Math.max(0, visible.top - pad)) + 'px';
        dom.spotlight.style.left = Math.round(Math.max(0, visible.left - pad)) + 'px';
        dom.spotlight.style.width = Math.round(Math.min(dom.stage.clientWidth, visible.width + pad * 2)) + 'px';
        dom.spotlight.style.height = Math.round(Math.min(dom.stage.clientHeight, visible.height + pad * 2)) + 'px';
        dom.spotlight.style.display = 'block';
    }

    var activeTarget = null;
    function hideSpotlight() {
        activeTarget = null;
        dom.spotlight.style.display = 'none';
    }

    /**
     * Scroll the element into view, wait for the scroll to actually settle,
     * then highlight it and keep the highlight glued to it for as long as
     * the step is active. Waiting for a stable rectangle replaces the old
     * fixed 350 ms guess, which measured long smooth scrolls mid-flight.
     */
    function focusOn(selector, epoch, options) {
        if (!selector) { hideSpotlight(); return Promise.resolve(null); }

        return awaitElement(selector, epoch, options).then(function (el) {
            if (!el) { hideSpotlight(); return null; }
            guard(epoch);
            activeTarget = el;
            var before = el.getBoundingClientRect();
            var block = before.height > dom.frame.clientHeight * 0.8 ? 'start' : 'center';
            try { el.scrollIntoView({ behavior: 'smooth', block: block, inline: 'nearest' }); }
            catch (e) { try { el.scrollIntoView(); } catch (e2) { /* ancient engine */ } }

            var lastTop = null;
            var stableFrames = 0;
            var deadline = Date.now() + 2500;

            function settle() {
                guard(epoch);
                var top = Math.round(el.getBoundingClientRect().top);
                if (lastTop !== null && Math.abs(top - lastTop) < 1) { stableFrames++; }
                else { stableFrames = 0; }
                lastTop = top;
                if (stableFrames >= 3 || Date.now() > deadline) { return Promise.resolve(); }
                return sleep(50, epoch).then(settle);
            }

            return settle().then(function () {
                guard(epoch);
                // Some vendor forms interrupt smooth scrolling before a
                // short field is fully visible, especially on laptop-height
                // screens. Finish that scroll immediately before drawing.
                var rect = el.getBoundingClientRect();
                var frameHeight = dom.frame.clientHeight;
                if (rect.height < frameHeight * 0.8 &&
                    (rect.top < 24 || rect.bottom > frameHeight - 24)) {
                    try { el.scrollIntoView({ behavior: 'auto', block: 'center', inline: 'nearest' }); }
                    catch (e) { try { el.scrollIntoView(); } catch (e2) { /* old browser */ } }
                }
                place(el);

                // Follow the element: the page may scroll, the window may be
                // resized, or a validation message may shift the layout.
                var raf = 0;
                function follow() {
                    if (epoch !== state.epoch || activeTarget !== el) { return; }
                    // A scene can change pages while its recording continues.
                    // Never redraw the old page's highlight over the new one.
                    if (!el.isConnected || el.ownerDocument !== frameDoc()) { return; }
                    place(el);
                    raf = requestAnimationFrame(follow);
                }
                raf = requestAnimationFrame(follow);
                track(function () { cancelAnimationFrame(raf); });
                return el;
            });
        });
    }

    // =================================================================
    // 4. Cues - the visible actions
    // =================================================================

    function setCue(text) {
        if (dom.cue) {
            dom.cue.textContent = text || '';
            dom.cue.style.display = text ? 'block' : 'none';
        }
    }

    function fire(el, type, extra) {
        var event;
        if (type === 'keydown' || type === 'keyup' || type === 'keypress') {
            event = new KeyboardEvent(type, { bubbles: true, cancelable: true, key: extra || '' });
        } else if (type === 'click') {
            event = new MouseEvent('click', { bubbles: true, cancelable: true, view: el.ownerDocument.defaultView });
        } else {
            event = new Event(type, { bubbles: true, cancelable: true });
        }
        el.dispatchEvent(event);
    }

    /**
     * Type a value one character at a time, awaiting the pause gate between
     * characters so this can be frozen and continued.
     *
     * Dispatches keydown / input / keyup per character and change + blur at
     * the end. That exact sequence matters on the real pages: the AMC form's
     * name suggestion box listens on keyup, and its service-interval field
     * is recalculated by an inline onchange handler. Setting .value alone
     * would leave the page looking filled in but internally untouched.
     */
    function typeInto(el, value, epoch) {
        value = String(value === null || value === undefined ? '' : value);
        try { el.focus(); } catch (e) { /* not focusable */ }
        el.value = '';
        fire(el, 'input');

        var i = 0;
        function step() {
            return gate(epoch).then(function () {
                if (i >= value.length) {
                    fire(el, 'change');
                    fire(el, 'blur');
                    return null;
                }
                var ch = value.charAt(i++);
                el.value = value.slice(0, i);
                fire(el, 'keydown', ch);
                fire(el, 'input');
                fire(el, 'keyup', ch);
                return sleep(Math.max(18, 62 - value.length), epoch).then(step);
            });
        }
        return step();
    }

    /** Choose an option by value, or by the text the user would read. */
    function selectOption(el, cue, epoch) {
        var chosen = null;
        var options = Array.prototype.slice.call(el.options || []);

        if (cue.value !== undefined && cue.value !== null) {
            chosen = options.filter(function (o) { return String(o.value) === String(cue.value); })[0] || null;
        }
        if (!chosen && cue.label) {
            var want = String(cue.label).toLowerCase();
            chosen = options.filter(function (o) {
                return o.textContent.trim().toLowerCase().indexOf(want) !== -1;
            })[0] || null;
        }
        // The approved demonstration script can name a record that is not
        // part of an older cloned database. In that case show the exact
        // approved value in this unsaved practice form instead of stopping
        // the entire tour. No database record is created by this fallback.
        if (!chosen && state.tourId !== 'full' && cue.allowDemoValue && cue.label && el.tagName === 'SELECT') {
            chosen = el.ownerDocument.createElement('option');
            chosen.value = '__demo__' + String(cue.label).replace(/\s+/g, '_');
            chosen.textContent = cue.label;
            chosen.setAttribute('data-tour-demo-option', 'true');
            el.appendChild(chosen);
        }
        if (!chosen) {
            throw new StepError(
                'The choice this step needs is not in the list yet.',
                'That list comes from a setup screen. Open it with the button below, add the missing entry, then come back.'
            );
        }

        try { el.focus(); } catch (e) { /* not focusable */ }
        el.value = chosen.value;
        fire(el, 'input');
        fire(el, 'change');   // dependent drop-downs load from this event
        return gate(epoch);
    }

    /**
     * Run one cue. Each kind is small and self-contained on purpose: adding
     * a new kind here is safer than adding a branch inside runStep().
     */
    function runCue(cue, epoch) {
        return gate(epoch).then(function () {
            var ledgerKey = cue.id || (cue.kind + ':' + (cue.selector || ''));
            if (state.cueLedger[ledgerKey]) { return null; }   // already done for this step

            if (cue.word) { setCue(local(cue.word)); }

            switch (cue.kind) {

                case 'focus':
                    return focusOn(cue.selector, epoch).then(function () {
                        state.cueLedger[ledgerKey] = true;
                    });

                case 'storySave':
                    return focusOn(cue.selector,epoch).then(function () {
                        return saveStory(cue.value,epoch);
                    }).then(function () {
                        setCue('Saved to your private demo session.');
                        state.cueLedger[ledgerKey]=true;
                    });

                case 'type':
                    return focusOn(cue.selector, epoch).then(function (el) {
                        if (!el) { return null; }
                        return typeInto(el, cue.value, epoch);
                    }).then(function () {
                        state.cueLedger[ledgerKey] = true;
                    });

                case 'date':
                case 'dateTime':
                    return focusOn(cue.selector, epoch).then(function (el) {
                        var date = new Date();
                        var pad = function (n) { return ('0' + n).slice(-2); };
                        var month = cue.kind === 'date' ? ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'][date.getMonth()] : pad(date.getMonth() + 1);
                        var value = pad(date.getDate()) + '-' + month + '-' + date.getFullYear() + (cue.kind === 'dateTime' ? ' 10:00 AM' : '');
                        return typeInto(el, value, epoch);
                    }).then(function () { state.cueLedger[ledgerKey] = true; });

                case 'select':
                    return (cue.allowDemoValue
                        ? focusOn(cue.selector, epoch)
                        : awaitOptions(cue.selector, epoch, cue.minOptions).then(function () {
                            return focusOn(cue.selector, epoch);
                        })).then(function (el) {
                        // Clear server-rendered choices in a dependent list so
                        // the wait observes the new AJAX response, not stale
                        // options that a late response would overwrite.
                        if (cue.awaitOptions) {
                            var dependent = frameDoc() && frameDoc().querySelector(cue.awaitOptions);
                            if (dependent && dependent.tagName === 'SELECT') {
                                dependent.innerHTML = '<option value="">Loading...</option>';
                            }
                        }
                        return selectOption(el, cue, epoch);
                    }).then(function () {
                        // A dependent list (district -> city) loads from the
                        // change event we just fired. Wait for it so the next
                        // step is not looking at an empty box.
                        if (cue.awaitOptions) {
                            return awaitOptions(cue.awaitOptions, epoch, cue.awaitMinOptions || 2);
                        }
                        return null;
                    }).then(function () {
                        state.cueLedger[ledgerKey] = true;
                    });

                case 'click':
                    return focusOn(cue.selector, epoch).then(function (el) {
                        if (!el) { return null; }
                        guard(epoch);
                        el.click();
                        function ready() {
                            guard(epoch);
                            var mobile = frameWin() && frameWin().MIB_MOBILE_DEMO;
                            if (mobile && mobile.pending) return sleep(100,epoch).then(ready);
                            if (mobile && mobile.error) throw new StepError('Demo record could not be saved.',mobile.error);
                            return sleep(450,epoch);
                        }
                        return ready();
                    }).then(function () {
                        state.cueLedger[ledgerKey] = true;
                    });

                case 'expand':
                    // Open a collapsed section, then wait for its contents.
                    return focusOn(cue.selector, epoch).then(function (el) {
                        if (!el) { return null; }
                        guard(epoch);
                        var doc = frameDoc();
                        var target = cue.target ? doc.querySelector(cue.target) : null;
                        var alreadyOpen = target && target.className.indexOf('in') !== -1;
                        if (!alreadyOpen) { el.click(); }
                        if (!cue.target) { return sleep(400, epoch); }
                        return awaitElement(cue.target + ' input, ' + cue.target + ' select, ' + cue.target + ' a', epoch, {
                            timeout: 6000, optional: true
                        });
                    }).then(function () {
                        state.cueLedger[ledgerKey] = true;
                    });

                case 'navigate':
                    // A mid-sentence page change may take seconds. Do not let
                    // the speaker describe a blank loading frame; the clip is
                    // the cue clock, so pausing it also preserves later timing.
                    var wasPlaying = dom.audio && !dom.audio.paused;
                    if (wasPlaying) { dom.audio.pause(); }
                    hideSpotlight();
                    return ensurePage(cue.selector, epoch).then(function () {
                        return focusOn(cue.target, epoch);
                    }).then(function () {
                        state.cueLedger[ledgerKey] = true;
                        if (wasPlaying && !state.paused && epoch === state.epoch) {
                            var resume = dom.audio.play();
                            if (resume && typeof resume.catch === 'function') {
                                resume.catch(function () {
                                    if (epoch !== state.epoch) { return; }
                                    showError(new StepError(
                                        'The recording could not resume after opening the page.',
                                        'Choose Retry step, or take control and continue by hand.'
                                    ), state.steps[state.index]);
                                });
                            }
                        }
                    });

                default:
                    return null;
            }
        });
    }

    // =================================================================
    // 5. Narration
    // =================================================================

    function local(bundle) {
        if (!bundle) { return ''; }
        if (typeof bundle === 'string') { return bundle; }
        return bundle[state.lang] || bundle.en || '';
    }

    function audioUrl(step) {
        // Flat per-language layout, keyed on the stable step id, so the core,
        // AMC and full tours all reuse one recording per step per language.
        // That is the difference between paying for 22 clips and 66.
        return BASE + 'assets/tour/audio/' + state.lang + '/' + step.id + '.mp3?v=20260929-v4';
    }

    /**
     * Speak the step and resolve when the narration finishes.
     *
     * Tries the recorded clip first, falls back to the browser voice, and
     * falls back again to a timed read. A single `settled` flag guarantees
     * exactly one outcome per call, which is what stops the double-advance
     * the old player suffered when a missing mp3 fired both onerror and a
     * rejected play() promise.
     */
    function narrate(step, epoch) {
        var text = local(step.text);
        if (!text) { return Promise.resolve(); }

        return gate(epoch).then(function () {
            return new Promise(function (resolve, reject) {
                var settled = false;
                var audio = dom.audio;

                function finish() {
                    if (settled) { return; }
                    settled = true;
                    cleanup();
                    if (epoch !== state.epoch) { reject(new Cancelled()); return; }
                    resolve();
                }
                function abandon() {
                    if (settled) { return; }
                    settled = true;
                    cleanup();
                    reject(new Cancelled());
                }
                function cleanup() {
                    if (audio) {
                        audio.onended = null;
                        audio.onerror = null;
                        try { audio.pause(); } catch (e) { /* already stopped */ }
                    }
                }

                track(function () {
                    abandon();
                    stopSpeech();
                });

                if (!audio) { return timedRead(); }

                audio.onended = finish;
                audio.onerror = function () { useBrowserVoice(); };
                audio.src = audioUrl(step);
                // Assign after src: Chromium resets playbackRate to 1 when a
                // new media resource is selected.
                audio.playbackRate = 1 / state.speed;

                var attempt = audio.play();
                if (attempt && typeof attempt.catch === 'function') {
                    attempt.catch(function () { useBrowserVoice(); });
                }

                // ---- fallbacks -------------------------------------------

                function useBrowserVoice() {
                    if (settled) { return; }
                    if (state.tourId === 'full') {
                        settled = true;
                        cleanup();
                        reject(new StepError('The recorded narration could not play.',
                            'Retry this chapter. Full Demo needs its matching recording; it will not silently switch to another voice or continue without audio.'));
                        return;
                    }
                    cleanup();
                    if (!('speechSynthesis' in window)) { return timedRead(); }

                    stopSpeech();
                    var utter = new SpeechSynthesisUtterance(text);
                    utter.lang = state.lang === 'hi' ? 'hi-IN' : state.lang === 'mr' ? 'mr-IN' : 'en-IN';
                    utter.rate = 0.95 / state.speed;
                    utter.onend = function () { if (!speech.cancelling) { finish(); } };
                    utter.onerror = function () { timedRead(); };
                    speech.current = utter;
                    speech.cancelling = false;
                    window.speechSynthesis.speak(utter);

                    // Watchdog. Some engines drop onend entirely, especially
                    // for languages with no installed voice, which used to
                    // stall the tour forever.
                    var budget = estimateMs(text) + 6000;
                    var watchdog = setTimeout(function () {
                        if (!settled) { stopSpeech(); finish(); }
                    }, budget);
                    track(function () { clearTimeout(watchdog); });
                }

                function timedRead() {
                    if (settled) { return; }
                    cleanup();
                    var timer = setTimeout(finish, estimateMs(text));
                    track(function () { clearTimeout(timer); });
                }
            });
        });
    }

    var speech = { current: null, cancelling: false };

    /**
     * Stop the browser voice without letting the resulting onend event be
     * mistaken for the narration finishing. Chrome fires onend on cancel().
     */
    function stopSpeech() {
        if (!('speechSynthesis' in window)) { return; }
        speech.cancelling = true;
        try { window.speechSynthesis.cancel(); } catch (e) { /* nothing playing */ }
        speech.current = null;
    }

    function estimateMs(text) {
        // Roughly 15 characters per second of speech, floor of 3.5 seconds.
        return Math.max(3500, Math.round(text.length * 66 * state.speed));
    }

    /**
     * Wait until the recording reaches the sentence that describes the
     * visible action. `cue.at` is a 0..1 position in the narration. When a
     * step does not provide one, use a sensible action-specific default.
     * Watching audio.currentTime (rather than a plain timeout) means Pause
     * also pauses the cue clock.
     */
    function waitForCueMoment(step, cue, epoch) {
        var ratio = Number(cue.at !== undefined ? cue.at : step.cueAt);
        if (!isFinite(ratio)) {
            ratio = cue.kind === 'expand' ? 0.72 : 0.60;
        }
        ratio = Math.max(0, Math.min(0.95, ratio));

        var text = local(step.text);
        var fallbackTarget = Math.max(3500, text.length * 66) * ratio;
        var fallbackElapsed = 0;

        function tick() {
            return gate(epoch).then(function () {
                guard(epoch);
                var audio = dom.audio;
                if (audio && isFinite(audio.duration) && audio.duration > 0 && !audio.error) {
                    if (audio.currentTime >= audio.duration * ratio) { return null; }
                } else if (fallbackElapsed >= fallbackTarget) {
                    return null;
                }
                return sleep(50, epoch).then(function () {
                    fallbackElapsed += 50;
                    return tick();
                });
            });
        }
        return tick();
    }

    // =================================================================
    // 6. Step execution
    // =================================================================

    function renderChrome(step) {
        var total = state.steps.length;
        dom.counter.textContent = 'Step ' + (state.index + 1) + ' of ' + total;
        dom.progressBar.style.width = ((state.index + 1) / total * 100) + '%';
        dom.chapter.textContent = local(step.chapter);
        dom.title.textContent = local(step.title);
        dom.caption.textContent = local(step.text);
        dom.prev.disabled = state.index === 0;
        dom.next.disabled = state.index >= total - 1;
        dom.modeLabel.textContent = state.tourId === 'short' ? 'Short Demo' : 'Full Demo';
        hideError();
    }

    /**
     * Run the step at state.index.
     *
     * options.skipCues - legacy Short Demo narration-only replay. Full Demo
     * reopens the chapter and repeats its unsaved actions alongside the audio.
     */
    function runStep(options) {
        options = options || {};
        state.epoch++;
        var epoch = state.epoch;

        disposeStep();
        stopSpeech();
        hideSpotlight();
        setCue('');
        if (!options.keepLedger) { state.cueLedger = {}; }
        state.cueLog = [];

        var step = state.steps[state.index];
        if (!step) { return; }
        renderChrome(step);
        state.lastError = null;
        state.cueComplete = !step.cue || !!options.skipCues;
        setPhase('loading');

        var chain = (step.prepare ? saveStory(step.prepare, epoch) : Promise.resolve())
            .then(function () { return resolvePage(step, epoch); })
            .then(function () {
                setCue('');
                if (epoch === state.epoch) { setPhase('cueing'); }
                return focusOn(step.selector, epoch, {
                    optional: !!step.optional,
                    expectedText: step.expectedText,
                    minRows: step.minRows,
                    message: step.missingMessage,
                    hint: step.missingHint
                });
            });

        chain.then(function () {
                guard(epoch);
                setCue('');
                setPhase('narrating');
                var narration = narrate(step, epoch);

                // Run the on-screen action while the recording is speaking
                // about it. The main caption stays visible throughout, and
                // cue.word gives a short live status directly below it.
                var action = Promise.resolve();
                if (!options.skipCues && step.cue) {
                    var cues = Array.isArray(step.cue) ? step.cue : [step.cue];
                    cues.forEach(function (cue) {
                        action = action.then(function () {
                            return waitForCueMoment(step, cue, epoch);
                        }).then(function () {
                            var audio = dom.audio;
                            var record = {
                                id: cue.id,
                                at: cue.at,
                                startedAt: audio ? audio.currentTime : 0,
                                duration: audio ? audio.duration : 0,
                                finishedAt: null
                            };
                            state.cueLog.push(record);
                            return runCue(cue, epoch).then(function () {
                                record.finishedAt = audio ? audio.currentTime : 0;
                            });
                        });
                    });
                    action = action.then(function () {
                        guard(epoch);
                        state.cueComplete = true;
                    });
                }

                return Promise.all([narration, action]);
            })
            // Give a completed save time to remain visible even if the clip
            // ended while the server was responding. Pause still freezes here.
            .then(function () { return state.tourId === 'full' ? sleep(900,epoch) : gate(epoch); })
            .then(function () { return gate(epoch); })
            .then(function () {
                guard(epoch);
                if (state.index < state.steps.length - 1) { goTo(state.index + 1); }
                else { finishTour(); }
            })
            .catch(function (err) {
                if (!err || err.cancelled) { return; }          // normal transition
                if (err.stepError) { showError(err, step); return; }
                showError(new StepError(
                    'Something unexpected happened on this step.',
                    'You can retry it, skip it, or take control and continue by hand. Technical detail: ' + (err.message || err)
                ), step);
            });
    }

    function goTo(index) {
        if (index < 0 || index >= state.steps.length) { return; }
        state.index = index;
        runStep();
    }

    function finishTour() {
        setCue('');
        setPhase('finished');
        dom.status.textContent = 'Tour complete. Use Replay to watch it again, or Take control to explore.';
        dom.play.textContent = 'Replay';
        state.paused = true;
    }

    // =================================================================
    // 7. Recovery panel
    // =================================================================

    function showError(err, step) {
        state.epoch++;
        disposeStep();
        try { dom.audio.pause(); } catch (e) { /* no recording */ }
        stopSpeech();
        hideSpotlight();
        setCue('');
        state.paused = true;
        state.lastError = { message: err.message, hint: err.hint, step: step && step.id };
        setPhase('error');
        dom.play.textContent = 'Resume';

        dom.errorTitle.textContent = err.message;
        dom.errorText.textContent = err.hint || '';
        dom.error.style.display = 'block';

        if (step && step.setup && step.setup.path) {
            dom.setup.style.display = 'inline-block';
            dom.setup.textContent = local(step.setup.label) || 'Open the setup screen';
            dom.setup.onclick = function () {
                dom.frame.src = absolute(step.setup.path);
                enterManual(true);
            };
        } else {
            dom.setup.style.display = 'none';
        }
    }

    function hideError() {
        dom.error.style.display = 'none';
    }

    // =================================================================
    // 8. Controls
    // =================================================================

    function pause() {
        state.paused = true;
        dom.play.textContent = 'Resume';
        try { dom.audio.pause(); } catch (e) { /* nothing playing */ }
        if ('speechSynthesis' in window) {
            try { window.speechSynthesis.pause(); } catch (e) { /* no voice active */ }
        }
        dom.status.textContent = 'Paused. Nothing is moving until you press Resume.';
    }

    function resume() {
        if (state.phase === 'error') {
            state.paused = false;
            runStep();
            return;
        }
        if (state.index >= state.steps.length - 1 && dom.play.textContent === 'Replay') {
            state.index = 0;
            state.paused = false;
            dom.play.textContent = 'Pause';
            runStep();
            return;
        }
        state.paused = false;
        dom.play.textContent = 'Pause';
        dom.status.textContent = 'Playing.';
        if (state.phase === 'narrating') {
            try {
                var playing = dom.audio.play();
                if (playing && playing.catch) { playing.catch(function () {}); }
            } catch (e) { /* fallback voice in use */ }
        }
        if ('speechSynthesis' in window) {
            try { window.speechSynthesis.resume(); } catch (e) { /* no voice active */ }
        }
        releaseGate();   // let the frozen typing / sleep continue where it was
    }

    function enterManual(on) {
        state.manual = on;
        dom.stage.classList.toggle('manual', on);
        dom.control.textContent = on ? 'Return to tour' : 'Take control';
        if (on) {
            hideSpotlight();
            pause();
            dom.status.textContent = 'You are driving. The tour will not touch the screen until you return.';
        } else {
            hideError();
            state.paused = false;
            dom.play.textContent = 'Pause';
            // Full Demo restarts its unsaved practice scene and narration.
            runStep(state.tourId === 'full' ? {} : { skipCues: true });
        }
    }

    dom.next.onclick = function () {
        if (state.index < state.steps.length - 1) {
            state.paused = false;
            dom.play.textContent = 'Pause';
            goTo(state.index + 1);
        }
    };

    dom.prev.onclick = function () {
        if (state.index > 0) {
            state.paused = false;
            dom.play.textContent = 'Pause';
            // Repeat Full Demo visuals too, so the old filled form cannot
            // stay on screen while its introduction starts again.
            state.index--;
            runStep(state.tourId === 'full' ? {} : { skipCues: true });
        }
    };

    dom.play.onclick = function () { state.paused ? resume() : pause(); };

    dom.control.onclick = function () { enterManual(!state.manual); };

    dom.replay.onclick = function () {
        state.paused = false;
        dom.play.textContent = 'Pause';
        runStep(state.tourId === 'full' ? {} : { skipCues: true });
    };

    if (dom.language) {
        dom.language.value = state.lang;
        dom.language.onchange = function () {
            state.lang = this.value;
            document.body.setAttribute('data-lang', state.lang);
            runStep(state.tourId === 'full' ? {} : { skipCues: true, keepLedger: true });
        };
    }

    if (dom.speed) {
        dom.speed.onchange = function () {
            state.speed = SPEED[this.value] || 1;
            if (dom.audio) { dom.audio.playbackRate = Number(this.value) || 1; }
            dom.status.textContent = 'Playback speed set to ' + this.value + '×.';
        };
    }

    dom.retry.onclick = function () {
        hideError();
        state.paused = false;
        dom.play.textContent = 'Pause';
        runStep(state.tourId === 'full' ? {} : { keepLedger: true });
    };

    dom.skip.onclick = function () {
        hideError();
        state.paused = false;
        dom.play.textContent = 'Pause';
        if (state.index < state.steps.length - 1) { goTo(state.index + 1); }
        else { finishTour(); }
    };

    dom.errorManual.onclick = function () { hideError(); enterManual(true); };

    /**
     * Clear every record created in this private demo session.
     *
     * Deliberately worded as "all demo records", because that is what it
     * does: it empties the whole session overlay, including anything a
     * trainee created outside the tour. The old wording promised to reset
     * only the tour's own changes, which was not true.
     */
    dom.reset.onclick = function () {
        var warning = 'Clear ALL records created in this private demo session?\n\n' +
            'This removes every lead, plan, customer and payment added in this browser ' +
            'session - including anything you created yourself outside the tour. ' +
            'The built-in sample data is not affected.';
        if (!window.confirm(warning)) { return; }

        var form = new FormData();
        form.append('action', 'reset');
        fetch(BASE + 'vendor/dashboard/tour_action', {
            method: 'POST', body: form, credentials: 'same-origin'
        }).then(function (response) {
            if (!response.ok) { throw new Error('HTTP ' + response.status); }
            return response.json();
        }).then(function (payload) {
            if (!payload || payload.ok !== true) { throw new Error(payload && payload.message); }
            dom.status.textContent = 'Demo records cleared. Starting again from step one.';
            state.index = 0;
            runStep();
        }).catch(function (err) {
            dom.status.textContent = 'Could not clear the demo records: ' + (err.message || err) +
                '. Nothing was changed.';
        });
    };

    // =================================================================
    // 9. Start
    // =================================================================

    /**
     * The tour waits for a real click before it begins.
     *
     * Browsers block audio that starts without a user gesture, so an
     * autoplaying tour was silent for its own first step. Requiring Start
     * also gives the presenter a moment to get the room's attention.
     */
    function start() {
        if (state.started) { return; }
        state.started = true;
        dom.start.style.display = 'none';
        state.paused = false;
        dom.play.textContent = 'Pause';
        dom.status.textContent = 'Playing. You can pause or take control at any time.';
        runStep();
    }

    dom.startBtn.onclick = start;

    // Show the first step's text before Start so the screen is never blank.
    if (state.steps.length) {
        var first = state.steps[0];
        dom.chapter.textContent = local(first.chapter);
        dom.title.textContent = local(first.title);
        dom.caption.textContent = local(first.text);
        dom.counter.textContent = 'Step 1 of ' + state.steps.length;
        dom.modeLabel.textContent = state.tourId === 'short' ? 'Short Demo' : 'Full Demo';
    } else {
        dom.title.textContent = 'No tour steps were found.';
        dom.caption.textContent = 'Check that demo-tour-content.js loaded before demo-tour.js.';
        dom.startBtn.disabled = true;
    }

    // Keep the highlight correct when the browser window is resized.
    window.addEventListener('resize', function () {
        if (!state.started || state.manual) { return; }
        if (activeTarget && activeTarget.isConnected) { place(activeTarget); }
    });

    /**
     * Small surface for debugging and for the automated live test.
     *
     * Read-only apart from goTo and the control helpers, and it exposes no
     * behaviour the on-screen buttons do not already offer - so it cannot be
     * used to get the tour into a state a presenter could not reach.
     */
    window.MIB_TOUR = {
        version: 3,
        get phase() { return state.phase; },
        get index() { return state.index; },
        get total() { return state.steps.length; },
        get lang() { return state.lang; },
        get paused() { return state.paused; },
        get manual() { return state.manual; },
        get cueComplete() { return state.cueComplete; },
        get cueLog() { return state.cueLog.slice(); },
        get lastError() { return state.lastError; },
        get step() { return state.steps[state.index] || null; },
        stepIds: function () { return state.steps.map(function (s) { return s.id; }); },
        goTo: goTo,
        next: function () { dom.next.click(); },
        prev: function () { dom.prev.click(); },
        toggle: function () { dom.play.click(); },
        sayAgain: function () { dom.replay.click(); },
        start: start,

        /** Where the spotlight is, in stage coordinates. For geometry checks. */
        spotlightRect: function () {
            if (dom.spotlight.style.display === 'none') { return null; }
            return {
                top: parseFloat(dom.spotlight.style.top),
                left: parseFloat(dom.spotlight.style.left),
                width: parseFloat(dom.spotlight.style.width),
                height: parseFloat(dom.spotlight.style.height)
            };
        },

        /** Where the highlighted element is, in the same coordinates. */
        targetRect: function () {
            return activeTarget && activeTarget.isConnected ? visibleTargetRect(activeTarget) : null;
        }
    };
})();
