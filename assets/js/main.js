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
