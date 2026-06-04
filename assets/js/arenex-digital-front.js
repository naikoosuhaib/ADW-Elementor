/**
 * CMP Elementor — Front-end JS v4
 * Carousel: robust rAF ticker with proper retry logic
 */
(function () {
    'use strict';

    /* ─────────────────────────────────────────
       CAROUSEL
    ───────────────────────────────────────────*/
    function initCarousels(scope) {
        (scope || document).querySelectorAll('.cmp-carousel-wrapper:not(.cmp-car-bound)').forEach(function (wrapper) {
            wrapper.classList.add('cmp-car-bound');
            var paused = false;

            /* Pause/resume handlers */
            wrapper.addEventListener('mouseenter',  function () { paused = true; });
            wrapper.addEventListener('mouseleave',  function () { paused = false; });
            wrapper.addEventListener('touchstart',  function () { paused = true; }, { passive: true });
            wrapper.addEventListener('touchend',    function () { setTimeout(function () { paused = false; }, 1500); });

            /* Start each row independently so one failing doesn't block others */
            wrapper.querySelectorAll('.cmp-carousel-row').forEach(function (row) {
                var speed      = parseFloat(row.getAttribute('data-speed') || '40');
                var mobSpeed   = parseFloat(row.getAttribute('data-mob-speed') || speed);
                var reverse    = row.classList.contains('cmp-carousel-row-2');
                var started    = false;
                var pos        = 0;
                var totalW     = 0;
                var attempts   = 0;

                row.style.animation    = 'none';
                row.style.willChange   = 'transform';

                /* rAF ticker — runs even before we know totalW */
                function tick() {
                    if (!started) { requestAnimationFrame(tick); return; }
                    if (!paused) {
                        var spd  = window.innerWidth <= 768 ? mobSpeed : speed;
                        var step = totalW / (spd * 60);
                        pos += reverse ? step : -step;
                        if (!reverse && pos <= -totalW) pos = 0;
                        if (reverse  && pos >= 0)       pos = -totalW;
                        row.style.transform = 'translateX(' + pos + 'px)';
                    }
                    requestAnimationFrame(tick);
                }
                requestAnimationFrame(tick);

                /* Measure when layout is ready — retry up to 20 times (4 seconds) */
                function tryMeasure() {
                    var w = row.scrollWidth;
                    if (w > 0 && row.children.length > 0) {
                        totalW = w / 2;
                        pos    = reverse ? -totalW : 0;
                        started = true;
                    } else if (attempts < 20) {
                        attempts++;
                        setTimeout(tryMeasure, 200);
                    }
                }

                /* Try after load, after fonts, and after a short delay for Elementor */
                setTimeout(tryMeasure, 300);
                if (document.fonts && document.fonts.ready) {
                    document.fonts.ready.then(function () { setTimeout(tryMeasure, 100); });
                }
                window.addEventListener('load', function () { setTimeout(tryMeasure, 200); });
            });
        });
    }

    /* ─────────────────────────────────────────
       SCROLL REVEAL
    ───────────────────────────────────────────*/
    function initReveal(scope) {
        var els = (scope || document).querySelectorAll('.cmp-reveal:not(.cmp-reveal-bound)');
        if (!els.length) return;
        /* Always visible in editor */
        if (window.elementorFrontend && window.elementorFrontend.isEditMode && window.elementorFrontend.isEditMode()) {
            els.forEach(function (el) { el.classList.add('cmp-visible'); });
            return;
        }
        var obs = new IntersectionObserver(function (entries) {
            entries.forEach(function (e) { if (e.isIntersecting) e.target.classList.add('cmp-visible'); });
        }, { threshold: 0.08, rootMargin: '0px 0px -30px 0px' });
        els.forEach(function (el) { el.classList.add('cmp-reveal-bound'); obs.observe(el); });
    }

    /* ─────────────────────────────────────────
       STATS COUNTER
    ───────────────────────────────────────────*/
    function initCounters(scope) {
        var els = (scope || document).querySelectorAll('.cmp-stat-number[data-target]:not([data-counted])');
        if (!els.length) return;
        if (window.elementorFrontend && window.elementorFrontend.isEditMode && window.elementorFrontend.isEditMode()) {
            els.forEach(function (el) {
                el.textContent = (el.getAttribute('data-target') || '0') + (el.getAttribute('data-suffix') || '+');
                el.setAttribute('data-counted', 'true');
            });
            return;
        }
        var obs = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) return;
                var el = entry.target;
                if (el.getAttribute('data-counted')) return;
                el.setAttribute('data-counted', 'true');
                var target   = parseInt(el.getAttribute('data-target'));
                var suffix   = el.getAttribute('data-suffix') || '+';
                var start    = performance.now();
                var duration = 2000;
                (function step(now) {
                    var p    = Math.min((now - start) / duration, 1);
                    var ease = 1 - Math.pow(1 - p, 3);
                    el.textContent = Math.floor(target * ease) + suffix;
                    if (p < 1) requestAnimationFrame(step);
                })(start);
            });
        }, { threshold: 0.5 });
        els.forEach(function (el) { obs.observe(el); });
    }

    /* ─────────────────────────────────────────
       LIGHTBOX
    ───────────────────────────────────────────*/
    function initLightbox(scope) {
        var lightbox = document.querySelector('.cmp-lightbox');
        var items    = (scope || document).querySelectorAll('.cmp-carousel-item:not(.cmp-lb-bound)');
        if (!lightbox || !items.length) return;

        var data = [];
        document.querySelectorAll('.cmp-carousel-item').forEach(function (item) {
            var idx = parseInt(item.getAttribute('data-index'));
            if (!data[idx]) {
                var bg = item.querySelector('.cmp-carousel-item-bg');
                data[idx] = { cat: item.getAttribute('data-cat'), title: item.getAttribute('data-title'), desc: item.getAttribute('data-desc'), img: bg ? bg.style.backgroundImage : '' };
            }
        });

        var cur = 0;
        function show(i) {
            cur = ((i % data.length) + data.length) % data.length;
            var d = data[cur]; if (!d) return;
            var imgEl = lightbox.querySelector('.cmp-lightbox-img'), catEl = lightbox.querySelector('.cmp-lightbox-cat'), titleEl = lightbox.querySelector('.cmp-lightbox-title'), descEl = lightbox.querySelector('.cmp-lightbox-desc');
            if (imgEl) imgEl.style.backgroundImage = d.img;
            if (catEl) catEl.textContent   = d.cat;
            if (titleEl) titleEl.textContent = d.title;
            if (descEl) descEl.textContent  = d.desc;
            lightbox.classList.add('cmp-active');
            document.body.style.overflow = 'hidden';
        }
        function close() { lightbox.classList.remove('cmp-active'); document.body.style.overflow = ''; }

        items.forEach(function (item) {
            item.classList.add('cmp-lb-bound');
            item.addEventListener('click', function () { show(parseInt(item.getAttribute('data-index'))); });
        });

        var closeBtn = lightbox.querySelector('.cmp-lightbox-close');
        if (closeBtn && !closeBtn.classList.contains('cmp-lb-bound')) {
            closeBtn.classList.add('cmp-lb-bound');
            closeBtn.addEventListener('click', close);
            lightbox.addEventListener('click', function (e) { if (e.target === lightbox) close(); });
            var prev = lightbox.querySelector('.cmp-lightbox-prev');
            var next = lightbox.querySelector('.cmp-lightbox-next');
            if (prev) prev.addEventListener('click', function (e) { e.stopPropagation(); show(cur - 1); });
            if (next) next.addEventListener('click', function (e) { e.stopPropagation(); show(cur + 1); });
            document.addEventListener('keydown', function (e) {
                if (!lightbox.classList.contains('cmp-active')) return;
                if (e.key === 'Escape')     close();
                if (e.key === 'ArrowLeft')  show(cur - 1);
                if (e.key === 'ArrowRight') show(cur + 1);
            });
        }
    }

    /* ─────────────────────────────────────────
       TESTIMONIAL SLIDER
    ───────────────────────────────────────────*/
    function initSlider(scope) {
        (scope || document).querySelectorAll('.cmp-test-slider-wrapper:not(.cmp-slider-bound)').forEach(function (wrapper) {
            wrapper.classList.add('cmp-slider-bound');
            var track   = wrapper.querySelector('.cmp-test-track');
            var slides  = wrapper.querySelectorAll('.cmp-test-slide');
            var dots    = wrapper.querySelectorAll('.cmp-test-dot');
            var prev    = wrapper.querySelector('.cmp-test-prev');
            var next    = wrapper.querySelector('.cmp-test-next');
            if (!track || !slides.length) return;

            var total     = slides.length;
            var cur       = 0;
            var timer;
            var autoplay  = wrapper.getAttribute('data-autoplay') !== '0';
            var speed     = parseInt(wrapper.getAttribute('data-speed') || '5000');

            /* Auto-height: measure each slide and set slider height to current */
            function updateHeight() {
                var activeSlide = slides[cur];
                if (activeSlide) {
                    /* Temporarily make visible to measure */
                    var slider = wrapper.querySelector('.cmp-test-slider');
                    if (slider) slider.style.height = activeSlide.scrollHeight + 'px';
                }
            }

            function go(i) {
                cur = ((i % total) + total) % total;
                track.style.transform = 'translateX(-' + (cur * 100) + '%)';
                /* Update active classes */
                slides.forEach(function (s, idx) { s.classList.toggle('cmp-slide-active', idx === cur); });
                dots.forEach(function (d, idx) { d.classList.toggle('cmp-active', idx === cur); });
                updateHeight();
            }

            function resetTimer() {
                clearInterval(timer);
                if (autoplay) {
                    timer = setInterval(function () { go(cur + 1); }, speed);
                }
            }

            if (prev) prev.addEventListener('click', function () { go(cur - 1); resetTimer(); });
            if (next) next.addEventListener('click', function () { go(cur + 1); resetTimer(); });
            dots.forEach(function (dot, idx) { dot.addEventListener('click', function () { go(idx); resetTimer(); }); });

            /* Swipe */
            var tx = 0;
            track.addEventListener('touchstart', function (e) { tx = e.touches[0].clientX; }, { passive: true });
            track.addEventListener('touchend',   function (e) { var diff = tx - e.changedTouches[0].clientX; if (Math.abs(diff) > 50) { go(diff > 0 ? cur + 1 : cur - 1); resetTimer(); } });

            /* Initialize: set height for first slide, mark active */
            slides[0].classList.add('cmp-slide-active');
            setTimeout(updateHeight, 100);
            window.addEventListener('resize', updateHeight);
            resetTimer();
        });
    }

    /* ─────────────────────────────────────────
       FAQ
    ───────────────────────────────────────────*/
    function initFaq(scope) {
        (scope || document).querySelectorAll('.cmp-faq-question:not(.cmp-faq-bound)').forEach(function (btn) {
            btn.classList.add('cmp-faq-bound');
            btn.addEventListener('click', function () {
                var item   = btn.parentElement;
                var wasOpen = item.classList.contains('cmp-open') || item.classList.contains('cmp-faq-active');
                var list   = item.parentElement;
                if (list) list.querySelectorAll('.cmp-faq-item').forEach(function (i) { i.classList.remove('cmp-open'); i.classList.remove('cmp-faq-active'); i.querySelector('.cmp-faq-question').setAttribute('aria-expanded','false'); });
                if (!wasOpen) { item.classList.add('cmp-open'); item.classList.add('cmp-faq-active'); btn.setAttribute('aria-expanded','true'); }
            });
        });
    }

    /* ─────────────────────────────────────────
       DARK HERO STAT COUNTERS
    ───────────────────────────────────────────*/
    function initDarkHeroCounters(scope) {
        (scope || document).querySelectorAll('.cmp-dark-hero-stats:not(.cmp-dhc-bound)').forEach(function (statsWrap) {
            statsWrap.classList.add('cmp-dhc-bound');

            // In editor mode, show final values immediately
            if (window.elementorFrontend && window.elementorFrontend.isEditMode()) {
                statsWrap.querySelectorAll('[data-count]').forEach(function (el) {
                    el.textContent = el.getAttribute('data-count');
                });
                return;
            }

            var observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (!entry.isIntersecting) return;
                    observer.unobserve(entry.target);
                    entry.target.querySelectorAll('[data-count]').forEach(function (el) {
                        var target = parseInt(el.getAttribute('data-count'), 10);
                        if (isNaN(target)) return;
                        var duration = 2000;
                        var start = performance.now();
                        function tick(now) {
                            var p = Math.min((now - start) / duration, 1);
                            var eased = 1 - Math.pow(1 - p, 3);
                            el.textContent = Math.round(target * eased);
                            if (p < 1) requestAnimationFrame(tick);
                        }
                        requestAnimationFrame(tick);
                    });
                });
            }, { threshold: 0.2 });

            observer.observe(statsWrap);
        });
    }

    /* ─────────────────────────────────────────
       CONTACT FORM
    ───────────────────────────────────────────*/
    function initContactForm(scope) {
        (scope || document).querySelectorAll('.cmp-contact-form:not(.cmp-cf-bound)').forEach(function (form) {
            form.classList.add('cmp-cf-bound');
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                var wrap = form.closest('.cmp-contact-form-wrap');
                if (!wrap) return;
                var success = wrap.querySelector('.cmp-contact-success');
                if (success) {
                    form.style.display = 'none';
                    // Also hide form title and desc
                    var title = wrap.querySelector('.cmp-contact-form-title');
                    var desc = wrap.querySelector('.cmp-contact-form-desc');
                    if (title) title.style.display = 'none';
                    if (desc) desc.style.display = 'none';
                    success.style.display = 'block';
                }
            });
        });
    }

    /* ─────────────────────────────────────────
       SPLIT SCROLL — image crossfade on scroll
    ───────────────────────────────────────────*/
    function initSplitScroll(scope) {
        (scope || document).querySelectorAll('.cmp-split-scroll:not(.cmp-ss-bound)').forEach(function (section) {
            section.classList.add('cmp-ss-bound');
            var panels = section.querySelectorAll('.cmp-split-scroll__panel');
            var images = section.querySelectorAll('.cmp-split-scroll__img');
            if (!panels.length || !images.length) return;
            if (window.innerWidth <= 1024) return;

            /* Force overflow:visible on all ancestors so position:sticky works in Elementor */
            var node = section.parentElement;
            while (node && node !== document.body) {
                var ov = window.getComputedStyle(node).overflow;
                if (ov === 'hidden' || ov === 'clip') {
                    node.style.overflow = 'visible';
                }
                node = node.parentElement;
            }

            if (window.elementorFrontend && window.elementorFrontend.isEditMode && window.elementorFrontend.isEditMode()) {
                images.forEach(function (img, i) { img.style.opacity = i === 0 ? '1' : '0'; });
                return;
            }
            function activateImage(index) {
                images.forEach(function (img, i) { img.style.opacity = i === index ? '1' : '0'; });
            }
            var obs = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        activateImage(parseInt(entry.target.getAttribute('data-index'), 10));
                    }
                });
            }, { threshold: 0.5 });
            panels.forEach(function (panel) { obs.observe(panel); });
        });
    }

    /* ─────────────────────────────────────────
       FOOTER CTA FORM
    ───────────────────────────────────────────*/
    function initFooterCTAForm(scope) {
        (scope || document).querySelectorAll('.cmp-footer-cta__form:not(.cmp-fcta-bound)').forEach(function (form) {
            form.classList.add('cmp-fcta-bound');
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                var btn = form.querySelector('.cmp-footer-cta__submit');
                if (btn) { btn.textContent = 'Thank You!'; btn.disabled = true; btn.style.opacity = '0.6'; }
            });
        });
    }

    /* ─────────────────────────────────────────
       PROCESS LINES (Modern style animated bars)
    ───────────────────────────────────────────*/
    function initProcessLines(scope) {
        var items = (scope || document).querySelectorAll('.cmp-process--modern .cmp-process__item:not(.cmp-pline-bound)');
        if (!items.length) return;
        if (window.elementorFrontend && window.elementorFrontend.isEditMode && window.elementorFrontend.isEditMode()) {
            items.forEach(function(el) { el.classList.add('cmp-visible', 'cmp-pline-bound'); });
            return;
        }
        var obs = new IntersectionObserver(function(entries) {
            entries.forEach(function(e) {
                if (e.isIntersecting) { e.target.classList.add('cmp-visible'); obs.unobserve(e.target); }
            });
        }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });
        items.forEach(function(el) { el.classList.add('cmp-pline-bound'); obs.observe(el); });
    }

    /* ─────────────────────────────────────────
       LOGO CAROUSEL (marquee speed + pause)
    ───────────────────────────────────────────*/
    function initLogoCarousel(scope) {
        (scope || document).querySelectorAll('.cmp-lc:not(.cmp-lc-bound)').forEach(function (wrap) {
            wrap.classList.add('cmp-lc-bound');
            var speed = wrap.getAttribute('data-speed') || '30';
            var pause = wrap.getAttribute('data-pause-hover') === 'yes';
            var track = wrap.querySelector('.cmp-lc-track');
            if (track) {
                track.style.animationDuration = speed + 's';
            }
            if (pause) {
                var marquee = wrap.querySelector('.cmp-lc-marquee');
                if (marquee) {
                    marquee.addEventListener('mouseenter', function () { if (track) track.style.animationPlayState = 'paused'; });
                    marquee.addEventListener('mouseleave', function () { if (track) track.style.animationPlayState = 'running'; });
                }
            }
        });
    }

    /* ─────────────────────────────────────────
       FLEET CAROUSEL
    ───────────────────────────────────────────*/
    function initFleetCarousel(scope) {
        (scope || document).querySelectorAll('.cmp-fleet-wrap:not(.cmp-fleet-bound)').forEach(function (wrap) {
            wrap.classList.add('cmp-fleet-bound');
            var uid     = wrap.getAttribute('data-uid');
            var total   = parseInt(wrap.getAttribute('data-total') || '0', 10);
            var auto    = wrap.getAttribute('data-auto') === '1';
            var speed   = parseInt(wrap.getAttribute('data-speed') || '5000', 10);
            var accent  = wrap.getAttribute('data-accent') || '#cc1010';
            var current = 0;
            var timer;

            if (total < 2) return;

            function go(n) {
                current = ((n % total) + total) % total;
                var track = wrap.querySelector('.cmp-fleet-track[data-uid="' + uid + '"]');
                if (track) track.style.transform = 'translateX(-' + (current * 100) + '%)';
                wrap.querySelectorAll('.cmp-fleet-dot[data-uid="' + uid + '"]').forEach(function (d, i) {
                    d.classList.toggle('active', i === current);
                    d.style.background = i === current ? accent : 'rgba(255,255,255,.25)';
                    d.style.width = i === current ? '44px' : '28px';
                });
            }

            function resetAuto() {
                clearInterval(timer);
                if (auto) timer = setInterval(function () { go(current + 1); }, speed);
            }

            wrap.querySelectorAll('.cmp-fleet-arrow[data-uid="' + uid + '"]').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    go(current + (btn.getAttribute('data-dir') === 'next' ? 1 : -1));
                    resetAuto();
                });
            });

            wrap.querySelectorAll('.cmp-fleet-dot[data-uid="' + uid + '"]').forEach(function (dot) {
                dot.addEventListener('click', function () {
                    go(parseInt(dot.getAttribute('data-idx'), 10));
                    resetAuto();
                });
            });

            // Touch swipe
            var el = document.getElementById(uid);
            if (el) {
                var sx = 0;
                el.addEventListener('touchstart', function (e) { sx = e.touches[0].clientX; }, { passive: true });
                el.addEventListener('touchend', function (e) {
                    var diff = sx - e.changedTouches[0].clientX;
                    if (Math.abs(diff) > 50) { go(current + (diff > 0 ? 1 : -1)); resetAuto(); }
                });
            }

            resetAuto();
        });
    }

        /* ─────────────────────────────────────────
       MOBILE MENU — full-screen overlay
    ───────────────────────────────────────────*/
    function initMobileMenu(scope) {
        (scope || document).querySelectorAll('.cmp-sh-hamburger:not(.cmp-mob-bound)').forEach(function (btn) {
            btn.classList.add('cmp-mob-bound');
            var nav = btn.closest('.cmp-sh');
            if (!nav) return;
            var overlay = nav.querySelector('.cmp-sh-overlay');
            if (!overlay) return;

            /* Collect ancestors that may clip position:fixed */
            var ancestors = [];
            var el = nav;
            while (el && el !== document.body) {
                ancestors.push(el);
                el = el.parentElement;
            }

            function openMenu() {
                ancestors.forEach(function (a) { a.classList.add('cmp-sh-menu-open'); });
                document.body.classList.add('cmp-sh-noscroll');
                overlay.classList.add('cmp-sh-open');
            }

            function closeMenu() {
                overlay.classList.remove('cmp-sh-open');
                document.body.classList.remove('cmp-sh-noscroll');
                ancestors.forEach(function (a) { a.classList.remove('cmp-sh-menu-open'); });
            }

            btn.addEventListener('click', function (e) { e.stopPropagation(); openMenu(); });

            var closeBtn = overlay.querySelector('.cmp-sh-close');
            if (closeBtn) closeBtn.addEventListener('click', function (e) { e.stopPropagation(); closeMenu(); });

            // Accordion: parent items with submenus toggle their submenu instead of closing the drawer.
            // Leaf links still close the drawer (existing behavior).
            overlay.querySelectorAll('a').forEach(function (link) {
                link.addEventListener('click', function (e) {
                    var inAccordion = !!link.closest('.cmp-sh-overlay-links.is-accordion');
                    var parentLi    = link.closest('.menu-item-has-children');
                    if ( inAccordion && parentLi && parentLi.contains(link) && link.parentElement === parentLi ) {
                        // Parent menu link in accordion mode: toggle submenu, don't navigate, don't close drawer
                        e.preventDefault();
                        e.stopPropagation();
                        parentLi.classList.toggle('is-open');
                        return;
                    }
                    closeMenu();
                });
            });
        });
    }
    /* ─────────────────────────────────────────
       LOCATION FORM
    ───────────────────────────────────────────*/
    function initLocationForm(scope) {
        (scope || document).querySelectorAll('.cmp-loc-contact-form:not(.cmp-locf-bound)').forEach(function (form) {
            form.classList.add('cmp-locf-bound');
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                var wrap = form.closest('.cmp-loc-form');
                if (!wrap) return;
                var success = wrap.querySelector('.cmp-loc-form-success');
                if (success) {
                    form.style.display = 'none';
                    var title = wrap.querySelector('.cmp-loc-form-title');
                    var subtitle = wrap.querySelector('.cmp-loc-form-subtitle');
                    if (title) title.style.display = 'none';
                    if (subtitle) subtitle.style.display = 'none';
                    success.style.display = 'block';
                }
            });
        });
    }

    /* ─────────────────────────────────────────
       INIT
    ───────────────────────────────────────────*/
    /* ─────────────────────────────────────────
       PROCESS STEPS — STYLE 2 ACCORDION
       Click a card to expand its description; collapses any other open card.
       Mobile (<=960px): each card toggles independently.
    ───────────────────────────────────────────*/
    function initProcessAccordion(scope) {
        var containers = (scope || document).querySelectorAll('.cmp-sa-container:not(.cmp-sa-bound)');
        containers.forEach(function (container) {
            container.classList.add('cmp-sa-bound');
            var cards = container.querySelectorAll('.sa-card');
            var isMobile = function () { return window.innerWidth <= 960; };
            cards.forEach(function (card) {
                card.addEventListener('click', function () {
                    var wasActive = card.classList.contains('is-active');
                    if (!isMobile()) {
                        cards.forEach(function (c) { c.classList.remove('is-active'); });
                    }
                    if (!wasActive) {
                        card.classList.add('is-active');
                    } else if (isMobile()) {
                        card.classList.remove('is-active');
                    }
                });
            });
        });
    }

    function initTestimonials(scope) {
        var wraps = (scope || document).querySelectorAll('[data-cmp-testimonials]');
        wraps.forEach(function (wrap) {
            if (wrap.__cmpTstInit) return;
            wrap.__cmpTstInit = true;
            var slides = wrap.querySelectorAll('.cmp-tst-slide');
            var dots   = wrap.querySelectorAll('.cmp-tst-dot');
            var prev   = wrap.querySelector('.cmp-tst-prev');
            var next   = wrap.querySelector('.cmp-tst-next');
            var card   = wrap.querySelector('[data-cmp-tst-card]');
            if (!slides.length) return;
            var idx = 0, timer = null;
            var autoplay = wrap.getAttribute('data-autoplay') === '1';
            var speed    = parseInt(wrap.getAttribute('data-speed') || '6000', 10);
            var pauseHover = wrap.getAttribute('data-pause-hover') === '1';
            function show(i) {
                idx = (i + slides.length) % slides.length;
                slides.forEach(function (s, j) { s.classList.toggle('is-active', j === idx); });
                dots.forEach(function (d, j) { d.classList.toggle('is-active', j === idx); });
            }
            function start() { stop(); if (autoplay) timer = setInterval(function () { show(idx + 1); }, speed); }
            function stop()  { if (timer) { clearInterval(timer); timer = null; } }
            if (prev) prev.addEventListener('click', function () { show(idx - 1); start(); });
            if (next) next.addEventListener('click', function () { show(idx + 1); start(); });
            dots.forEach(function (d) {
                d.addEventListener('click', function () { show(parseInt(d.getAttribute('data-index'), 10)); start(); });
            });
            if (card && pauseHover) {
                card.addEventListener('mouseenter', stop);
                card.addEventListener('mouseleave', start);
            }
            start();
        });
    }

    function cmpInit(scope) {
        initMobileMenu(scope);
        initReveal(scope);
        initCounters(scope);
        initCarousels(scope);
        initLightbox(scope);
        initSlider(scope);
        initFaq(scope);
        initDarkHeroCounters(scope);
        initContactForm(scope);
        initSplitScroll(scope);
        initFooterCTAForm(scope);
        initProcessLines(scope);
        initProcessAccordion(scope);
        initFleetCarousel(scope);
        initLogoCarousel(scope);
        initLocationForm(scope);
        initTestimonials(scope);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () { cmpInit(document); });
    } else {
        cmpInit(document);
    }

    /* Elementor editor */
    if (window.jQuery) {
        jQuery(window).on('elementor/frontend/init', function () {
            elementorFrontend.hooks.addAction('frontend/element_ready/widget', function ($scope) {
                cmpInit($scope[0]);
            });
        });
    }

})();
