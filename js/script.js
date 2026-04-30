

(function() {
    'use strict';

    
    const CONFIG = {
        navSelector: '.navbar',
        navToggleSelector: '.nav-toggle',
        navLinksSelector: '.nav-links',
        scrollTopSelector: '.scroll-top',
        animateSelector: '.animate-on-scroll',
        counterSelector: '.stat-number',
        counterDuration: 2000,
        scrollOffset: 100
    };

    // ============================================
    // UTILITY FUNCTIONS
    // ============================================
    const $ = (selector, context = document) => context.querySelector(selector);
    const $$ = (selector, context = document) => Array.from(context.querySelectorAll(selector));
    const debounce = (fn, delay) => {
        let timeout;
        return (...args) => {
            clearTimeout(timeout);
            timeout = setTimeout(() => fn.apply(null, args), delay);
        };
    };


    function initMobileNav() {
        const toggle = $(CONFIG.navToggleSelector);
        const navLinks = $(CONFIG.navLinksSelector);
        if (!toggle || !navLinks) return;

        toggle.addEventListener('click', () => {
            toggle.classList.toggle('active');
            navLinks.classList.toggle('open');
            document.body.style.overflow = navLinks.classList.contains('open') ? 'hidden' : '';
        });

        // Close menu when clicking a link
        $$('.nav-link', navLinks).forEach(link => {
            link.addEventListener('click', () => {
                toggle.classList.remove('active');
                navLinks.classList.remove('open');
                document.body.style.overflow = '';
            });
        });
    }

    // ============================================
    // NAVBAR SCROLL EFFECT
    // ============================================
    function initNavbarScroll() {
        const navbar = $(CONFIG.navSelector);
        if (!navbar) return;

        const handleScroll = () => {
            navbar.classList.toggle('scrolled', window.scrollY > 20);
        };

        window.addEventListener('scroll', debounce(handleScroll, 10));
        handleScroll();
    }


    function initActiveNav() {
        const currentPage = window.location.pathname.split('/').pop() || 'index.html';
        $$('.nav-link').forEach(link => {
            const href = link.getAttribute('href');
            if (href === currentPage || (currentPage === '' && href === 'index.html')) {
                link.classList.add('active');
            }
        });
    }

}