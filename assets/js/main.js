(() => {
    'use strict';

    const $ = (selector, root = document) => root.querySelector(selector);
    const $$ = (selector, root = document) => Array.from(root.querySelectorAll(selector));
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /* ------------------------------------------------------------ Disclosure helper */
    function disclosure(toggle, panel, { onOpen, onClose } = {}) {
        const open = () => {
            panel.hidden = false;
            toggle.setAttribute('aria-expanded', 'true');
            onOpen && onOpen();
        };
        const close = () => {
            panel.hidden = true;
            toggle.setAttribute('aria-expanded', 'false');
            onClose && onClose();
        };
        const isOpen = () => toggle.getAttribute('aria-expanded') === 'true';

        toggle.addEventListener('click', () => (isOpen() ? close() : open()));
        document.addEventListener('click', (event) => {
            if (isOpen() && !panel.contains(event.target) && !toggle.contains(event.target)) {
                close();
            }
        });
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && isOpen()) {
                close();
                toggle.focus();
            }
        });
        return { open, close, isOpen };
    }

    /* ------------------------------------------------------------ Locations dropdown */
    const dropdownToggle = $('[data-dropdown-toggle]');
    const dropdownPanel = $('[data-dropdown-panel]');
    if (dropdownToggle && dropdownPanel) {
        disclosure(dropdownToggle, dropdownPanel);
    }

    /* ------------------------------------------------------------ Mobile menu */
    const menuToggle = $('[data-menu-toggle]');
    const menu = $('[data-menu]');
    if (menuToggle && menu) {
        const label = $('.menu-toggle__label', menuToggle);
        const menuControl = disclosure(menuToggle, menu, {
            onOpen: () => {
                document.body.classList.add('is-locked');
                if (label) label.textContent = 'Close';
            },
            onClose: () => {
                document.body.classList.remove('is-locked');
                if (label) label.textContent = 'Menu';
            },
        });
        window.matchMedia('(min-width: 1101px)').addEventListener('change', (event) => {
            if (event.matches && menuControl.isOpen()) menuControl.close();
        });
        $$('a', menu).forEach((link) => link.addEventListener('click', () => menuControl.close()));
    }

    /* ------------------------------------------------------------ Booking dialog */
    const dialog = $('[data-booking-dialog]');
    if (dialog && typeof dialog.showModal === 'function') {
        $$('[data-open-booking]').forEach((button) => {
            button.addEventListener('click', (event) => {
                event.preventDefault();
                if (menu && !menu.hidden && menuToggle) menuToggle.click();
                dialog.showModal();
            });
        });
        $$('[data-close-booking]', dialog).forEach((button) => button.addEventListener('click', () => dialog.close()));
        dialog.addEventListener('click', (event) => {
            if (event.target === dialog) dialog.close();
        });
    } else {
        // No <dialog> support: send guests to the locations section instead.
        $$('[data-open-booking]').forEach((button) => {
            button.addEventListener('click', () => {
                window.location.href = (document.querySelector('.site-header__logo')?.getAttribute('href') || '/') + '#locations';
            });
        });
    }

    /* ------------------------------------------------------------ Location switcher */
    $$('[data-switcher]').forEach((switcher) => {
        const toggle = $('[data-switcher-toggle]', switcher);
        const list = $('[data-switcher-list]', switcher);
        if (toggle && list) disclosure(toggle, list);
    });

    /* ------------------------------------------------------------ Sub-navigation state */
    const subnav = $('[data-subnav]');
    if (subnav && 'IntersectionObserver' in window) {
        const links = $$('a', subnav);
        const sections = links
            .map((link) => document.getElementById(link.hash.slice(1)))
            .filter(Boolean);

        const setActive = (id) => {
            links.forEach((link) => {
                const active = link.hash === '#' + id;
                link.classList.toggle('is-active', active);
                if (active) {
                    link.setAttribute('aria-current', 'true');
                    const left = link.offsetLeft - subnav.clientWidth / 2 + link.clientWidth / 2;
                    subnav.scrollTo({ left, behavior: reducedMotion ? 'auto' : 'smooth' });
                } else {
                    link.removeAttribute('aria-current');
                }
            });
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) setActive(entry.target.id);
            });
        }, { rootMargin: '-35% 0px -60% 0px' });

        sections.forEach((section) => observer.observe(section));
    }

    /* ------------------------------------------------------------ FAQ filter */
    const filter = $('[data-faq-filter]');
    if (filter) {
        filter.hidden = false;
        const buttons = $$('button', filter);
        const items = $$('[data-location]');
        const groups = $$('[data-faq-group]');

        buttons.forEach((button) => {
            button.addEventListener('click', () => {
                const value = button.dataset.value;
                buttons.forEach((b) => b.setAttribute('aria-pressed', String(b === button)));
                items.forEach((item) => {
                    const show = value === 'all' || item.dataset.location === value || item.dataset.location === 'group';
                    item.hidden = !show;
                });
                groups.forEach((group) => {
                    group.hidden = $$('[data-location]', group).every((item) => item.hidden);
                });
            });
        });
    }

    /* ------------------------------------------------------------ Hero slider */
    $$('[data-slider]').forEach((slider) => {
        const slides = $$('[data-slide]', slider);
        const controls = $('[data-slider-controls]', slider);
        if (slides.length < 2 || !controls) return;

        const dots = $$('[data-slide-to]', slider);
        const pauseButton = $('[data-slider-pause]', slider);
        const duration = parseFloat(getComputedStyle(slider).getPropertyValue('--slide-duration')) || 7000;
        let current = 0;
        let timer = null;
        let userPaused = reducedMotion;
        let held = false;

        controls.hidden = false;

        const show = (index) => {
            current = (index + slides.length) % slides.length;
            slides.forEach((slide, i) => {
                const active = i === current;
                slide.classList.toggle('is-active', active);
                slide.inert = !active;
                if (active) slide.removeAttribute('aria-hidden');
                else slide.setAttribute('aria-hidden', 'true');
            });
            dots.forEach((dot, i) => {
                if (i === current) dot.setAttribute('aria-current', 'true');
                else dot.removeAttribute('aria-current');
            });
            schedule();
        };

        const playing = () => !userPaused && !held && !document.hidden;

        function schedule() {
            clearTimeout(timer);
            slider.dataset.state = playing() ? 'playing' : 'paused';
            if (playing()) timer = setTimeout(() => show(current + 1), duration);
        }

        const hold = (value) => {
            if (held === value) return;
            held = value;
            // Restart the progress line so it matches the fresh timer.
            slider.dataset.state = 'paused';
            void slider.offsetWidth;
            schedule();
        };

        pauseButton?.addEventListener('click', () => {
            userPaused = !userPaused;
            pauseButton.setAttribute('aria-label', userPaused ? 'Play slideshow' : 'Pause slideshow');
            schedule();
        });
        if (pauseButton && userPaused) pauseButton.setAttribute('aria-label', 'Play slideshow');

        $('[data-slider-prev]', slider)?.addEventListener('click', () => show(current - 1));
        $('[data-slider-next]', slider)?.addEventListener('click', () => show(current + 1));
        dots.forEach((dot) => dot.addEventListener('click', () => show(Number(dot.dataset.slideTo))));

        slider.addEventListener('mouseenter', () => hold(true));
        slider.addEventListener('mouseleave', () => hold(slider.contains(document.activeElement)));
        slider.addEventListener('focusin', () => hold(true));
        slider.addEventListener('focusout', (event) => {
            if (!slider.contains(event.relatedTarget)) hold(slider.matches(':hover'));
        });
        document.addEventListener('visibilitychange', schedule);

        let touchX = null;
        slider.addEventListener('touchstart', (event) => { touchX = event.touches[0].clientX; }, { passive: true });
        slider.addEventListener('touchend', (event) => {
            if (touchX === null) return;
            const delta = event.changedTouches[0].clientX - touchX;
            if (Math.abs(delta) > 50) show(current + (delta < 0 ? 1 : -1));
            touchX = null;
        });

        show(0);
    });

    /* ------------------------------------------------------------ Apartment carousel */
    $$('[data-carousel]').forEach((carousel) => {
        const track = $('[data-carousel-track]', carousel);
        const controls = $('[data-carousel-controls]', carousel);
        const prev = $('[data-carousel-prev]', carousel);
        const next = $('[data-carousel-next]', carousel);
        const bar = $('[data-carousel-progress]', carousel);
        if (!track || !controls) return;

        const step = () => {
            const item = track.firstElementChild;
            const gap = parseFloat(getComputedStyle(track).columnGap) || 0;
            return item ? item.getBoundingClientRect().width + gap : track.clientWidth;
        };

        const update = () => {
            const max = track.scrollWidth - track.clientWidth;
            controls.hidden = max <= 1;
            if (max <= 1) return;
            prev.disabled = track.scrollLeft <= 1;
            next.disabled = track.scrollLeft >= max - 1;
            if (bar) {
                const visible = track.clientWidth / track.scrollWidth;
                bar.style.width = (visible * 100) + '%';
                bar.style.transform = 'translateX(' + ((track.scrollLeft / max) * (1 / visible - 1) * 100) + '%)';
            }
        };

        const behavior = reducedMotion ? 'auto' : 'smooth';
        prev.addEventListener('click', () => track.scrollBy({ left: -step(), behavior }));
        next.addEventListener('click', () => track.scrollBy({ left: step(), behavior }));
        track.addEventListener('scroll', update, { passive: true });
        window.addEventListener('resize', update);
        update();
    });

    /* ------------------------------------------------------------ Suite gallery lightbox */
    const gallery = $('[data-gallery]');
    const lightbox = $('[data-lightbox]');
    if (gallery && lightbox && typeof lightbox.showModal === 'function') {
        const photos = JSON.parse(gallery.dataset.gallery || '[]');
        const image = $('[data-lightbox-image]', lightbox);
        const caption = $('[data-lightbox-caption]', lightbox);
        const count = $('[data-lightbox-count]', lightbox);
        let index = 0;
        let opener = null;

        const render = () => {
            const photo = photos[index];
            image.src = photo.src;
            image.alt = photo.alt;
            caption.textContent = photo.alt;
            count.textContent = (index + 1) + ' / ' + photos.length;
        };
        const go = (delta) => {
            index = (index + delta + photos.length) % photos.length;
            render();
        };

        $$('[data-gallery-open]', gallery).forEach((trigger) => {
            trigger.hidden = false;
            trigger.addEventListener('click', (event) => {
                event.preventDefault();
                opener = trigger;
                index = Number(trigger.dataset.galleryOpen) || 0;
                render();
                lightbox.showModal();
                document.body.classList.add('is-locked');
            });
        });

        $('[data-lightbox-prev]', lightbox).addEventListener('click', () => go(-1));
        $('[data-lightbox-next]', lightbox).addEventListener('click', () => go(1));
        $('[data-lightbox-close]', lightbox).addEventListener('click', () => lightbox.close());
        lightbox.addEventListener('keydown', (event) => {
            if (event.key === 'ArrowLeft') go(-1);
            if (event.key === 'ArrowRight') go(1);
        });
        lightbox.addEventListener('close', () => {
            document.body.classList.remove('is-locked');
            opener?.focus();
        });
    }

    /* ------------------------------------------------------------ Reveal on scroll */
    const revealItems = $$('.reveal');
    if (reducedMotion || !('IntersectionObserver' in window)) {
        revealItems.forEach((item) => item.classList.add('is-visible'));
    } else {
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, { rootMargin: '0px 0px -8% 0px', threshold: 0.08 });

        revealItems.forEach((item) => revealObserver.observe(item));
    }
})();
