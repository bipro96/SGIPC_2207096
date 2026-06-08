/*
 * SGIPC - Main JavaScript
 */

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

        $$('.nav-link', navLinks).forEach(link => {
            link.addEventListener('click', () => {
                toggle.classList.remove('active');
                navLinks.classList.remove('open');
                document.body.style.overflow = '';
            });
        });
    }


    function initNavbarScroll() {
        const navbar = $(CONFIG.navSelector);
        if (!navbar) return;

        const handleScroll = () => {
            navbar.classList.toggle('scrolled', window.scrollY > 20);
        };

        window.addEventListener('scroll', debounce(handleScroll, 10));
        handleScroll();
    }


    function initScrollTop() {
        const btn = $(CONFIG.scrollTopSelector);
        if (!btn) return;

        const handleScroll = () => {
            btn.classList.toggle('visible', window.scrollY > 600);
        };

        window.addEventListener('scroll', debounce(handleScroll, 50));

        btn.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

  
    function initCounters() {
        const counters = $$(CONFIG.counterSelector);
        if (!counters.length) return;

        const animateCounter = (el) => {
            const target = parseInt(el.dataset.target, 10);
            if (isNaN(target)) return;

            const duration = CONFIG.counterDuration;
            const startTime = performance.now();

            const step = (currentTime) => {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                const ease = 1 - Math.pow(1 - progress, 3);
                const current = Math.floor(target * ease);
                el.textContent = current.toLocaleString();

                if (progress < 1) {
                    requestAnimationFrame(step);
                } else {
                    el.textContent = target.toLocaleString();
                }
            };

            requestAnimationFrame(step);
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        counters.forEach(counter => observer.observe(counter));
    }

   
    function initScrollAnimations() {
        const elements = $$(CONFIG.animateSelector);
        if (!elements.length) return;

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animated');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15, rootMargin: '0px 0px -50px 0px' });

        elements.forEach(el => observer.observe(el));
    }


    function initSmoothScroll() {
        document.addEventListener('click', (e) => {
            const link = e.target.closest('a[href^="#"]');
            if (!link) return;

            const targetId = link.getAttribute('href');
            if (targetId === '#') return;

            const target = $(targetId);
            if (target) {
                e.preventDefault();
                const offset = target.getBoundingClientRect().top + window.scrollY - CONFIG.scrollOffset;
                window.scrollTo({ top: offset, behavior: 'smooth' });
            }
        });
    }


    function init() {
        initMobileNav();
        initNavbarScroll();
        initScrollTop();
        initCounters();
        initScrollAnimations();
        initSmoothScroll();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
