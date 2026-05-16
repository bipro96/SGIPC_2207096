

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

    // ============================================
    // MOBILE NAVIGATION
    // ============================================
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

    // ============================================
    // ACTIVE NAV LINK HIGHLIGHT
    // ============================================
    function initActiveNav() {
        const currentPage = window.location.pathname.split('/').pop() || 'index.html';
        $$('.nav-link').forEach(link => {
            const href = link.getAttribute('href');
            if (href === currentPage || (currentPage === '' && href === 'index.html')) {
                link.classList.add('active');
            }
        });
    }

    // ============================================
    // SCROLL TO TOP BUTTON
    // ============================================
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

    // ============================================
    // ANIMATED COUNTERS
    // ============================================
    function initCounters() {
        const counters = $$(CONFIG.counterSelector);
        if (!counters.length) return;

        const animateCounter = (el) => {
            const target = parseInt(el.dataset.target, 10);
            if (isNaN(target)) return;

            const duration = CONFIG.counterDuration;
            const startTime = performance.now();
            const startValue = 0;

            const step = (currentTime) => {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                // Ease out cubic
                const ease = 1 - Math.pow(1 - progress, 3);
                const current = Math.floor(startValue + (target - startValue) * ease);
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

    // ============================================
    // SCROLL ANIMATIONS (Fade In)
    // ============================================
    function initScrollAnimations() {
        const elements = $$(CONFIG.animateSelector);
        if (!elements.length) return;

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    // Stagger delay based on element order
                    const delay = index * 100;
                    setTimeout(() => {
                        entry.target.classList.add('animated');
                    }, delay);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15, rootMargin: '0px 0px -50px 0px' });

        elements.forEach(el => observer.observe(el));
    }

    // ============================================
    // DYNAMIC EVENTS RENDERING
    // ============================================
    const EVENTS_DATA = [
        {
            title: 'KUET IUPC 2024',
            date: 'March 15, 2024',
            description: 'Inter University Programming Contest hosted at KUET campus with 50+ university teams competing for the championship.',
            status: 'past'
        },
        {
            title: 'CodeMasters Weekly #42',
            date: 'April 5, 2024',
            description: 'Weekly internal contest focused on graph theory and dynamic programming problems for club members.',
            status: 'past'
        },
        {
            title: 'SGIPC Summer Camp',
            date: 'June 10, 2024',
            description: 'Intensive 5-day training program covering advanced algorithms, contest strategies, and team coordination.',
            status: 'upcoming'
        },
        {
            title: 'Beginner Bootcamp 2.0',
            date: 'July 20, 2024',
            description: 'Structured introduction to competitive programming for first-year students with hands-on problem solving sessions.',
            status: 'upcoming'
        },
        {
            title: 'ICPC Warmup Contest',
            date: 'August 15, 2024',
            description: 'Official warmup contest simulating ICPC environment to prepare teams for the Asia Regional.',
            status: 'upcoming'
        },
        {
            title: 'Algorithmic Thinking Workshop',
            date: 'September 5, 2024',
            description: 'Deep dive into algorithmic problem solving with experienced competitive programmers and alumni mentors.',
            status: 'upcoming'
        }
    ];

    function renderEvents() {
        const container = $('#events-grid');
        if (!container) return;

        container.innerHTML = EVENTS_DATA.map(event => `
            <article class="card event-card animate-on-scroll">
                <div class="card-date">${event.date}</div>
                <h3 class="card-title">${event.title}</h3>
                <p class="card-text">${event.description}</p>
                <div class="event-status ${event.status}">
                    <span>${event.status === 'upcoming' ? '●' : '○'}</span>
                    <span>${event.status === 'upcoming' ? 'Upcoming' : 'Past Event'}</span>
                </div>
            </article>
        `).join('');
    }

    // ============================================
    // DYNAMIC MEMBERS RENDERING
    // ============================================
    const MEMBERS_DATA = [
        {
            name: 'Rafid Hasan',
            handle: '@rafid_01',
            rating: '2048',
            achievement: 'ICPC Asia Regional Finalist',
            color: 'cyan'
        },
        {
            name: 'Nusrat Jahan',
            handle: '@nusrat_j',
            rating: '1892',
            achievement: 'Codeforces Expert',
            color: 'green'
        },
        {
            name: 'Tanvir Ahmed',
            handle: '@tanvir_cse',
            rating: '2156',
            achievement: '2x ICPC Regionalist',
            color: 'cyan'
        },
        {
            name: 'Sadia Islam',
            handle: '@sadia_i',
            rating: '1754',
            achievement: 'KUET IUPC Champion',
            color: 'green'
        },
        {
            name: 'Imran Hossain',
            handle: '@imran_h',
            rating: '1987',
            achievement: 'Meta Hacker Cup Round 3',
            color: 'cyan'
        },
        {
            name: 'Farhana Akter',
            handle: '@farhana_a',
            rating: '1823',
            achievement: 'Google Code Jam Qualifier',
            color: 'green'
        },
        {
            name: 'Mehedi Hasan',
            handle: '@mehedi_cp',
            rating: '2234',
            achievement: 'ICPC World Finals aspirant',
            color: 'cyan'
        },
        {
            name: 'Priya Saha',
            handle: '@priya_s',
            rating: '1678',
            achievement: 'SGIPC Top Coder 2024',
            color: 'green'
        }
    ];

    function renderMembers() {
        const container = $('#members-grid');
        if (!container) return;

        container.innerHTML = MEMBERS_DATA.map(member => `
            <article class="card member-card animate-on-scroll">
                <div class="member-rating" style="color: var(--accent-${member.color})">
                    ${member.rating} Rating
                </div>
                <h3 class="card-title">${member.name}</h3>
                <div class="member-handle">${member.handle}</div>
                <div class="achievement-badge">
                    <span>★</span>
                    <span>${member.achievement}</span>
                </div>
            </article>
        `).join('');
    }

    // ============================================
    // CONTACT FORM
    // ============================================
    function initContactForm() {
        const form = $('#contact-form');
        if (!form) return;

        form.addEventListener('submit', (e) => {
            e.preventDefault();

            const name = $('#form-name').value.trim();
            const email = $('#form-email').value.trim();
            const message = $('#form-message').value.trim();

            if (!name || !email || !message) {
                alert('Please fill in all fields.');
                return;
            }

            // Show success message
            const success = $('#form-success');
            if (success) {
                success.classList.add('visible');
                form.reset();

                // Hide after 5 seconds
                setTimeout(() => {
                    success.classList.remove('visible');
                }, 5000);
            }
        });
    }

    // ============================================
    // SMOOTH SCROLL FOR ANCHOR LINKS
    // ============================================
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

    // ============================================
    // LOADING ANIMATION
    // ============================================
    function initLoader() {
        // Subtle page fade-in
        document.body.style.opacity = '0';
        document.body.style.transition = 'opacity 0.4s ease';

        window.addEventListener('load', () => {
            document.body.style.opacity = '1';
        });
    }

    // ============================================
    // INITIALIZE EVERYTHING
    // ============================================
    function init() {
        initLoader();
        initMobileNav();
        initNavbarScroll();
        initActiveNav();
        initScrollTop();
        initCounters();
        initScrollAnimations();
        renderEvents();
        renderMembers();
        initContactForm();
        initSmoothScroll();
    }

    // DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    // Expose data and helpers globally for page-specific scripts
    window.EVENTS_DATA = EVENTS_DATA;
    window.MEMBERS_DATA = MEMBERS_DATA;

    window.filterEvents = function(filter) {
        const container = document.getElementById('events-grid');
        if (!container) return;

        const buttons = {
            all: document.getElementById('filter-all'),
            upcoming: document.getElementById('filter-upcoming'),
            past: document.getElementById('filter-past')
        };

        // Update button styles
        Object.keys(buttons).forEach(key => {
            if (!buttons[key]) return;
            if (key === filter) {
                buttons[key].classList.remove('btn-secondary');
                buttons[key].classList.add('btn-primary');
            } else {
                buttons[key].classList.remove('btn-primary');
                buttons[key].classList.add('btn-secondary');
            }
        });

        // Filter data
        const filtered = filter === 'all'
            ? EVENTS_DATA
            : EVENTS_DATA.filter(e => e.status === filter);

        container.innerHTML = filtered.map((event, index) => `
            <article class="card event-card animate-on-scroll" style="transition-delay: ${index * 50}ms">
                <div class="card-date">${event.date}</div>
                <h3 class="card-title">${event.title}</h3>
                <p class="card-text">${event.description}</p>
                <div class="event-status ${event.status}">
                    <span>${event.status === 'upcoming' ? '●' : '○'}</span>
                    <span>${event.status === 'upcoming' ? 'Upcoming' : 'Past Event'}</span>
                </div>
            </article>
        `).join('');

        // Re-trigger scroll animations for new elements
        const newElements = container.querySelectorAll('.animate-on-scroll');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animated');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15 });

        newElements.forEach(el => observer.observe(el));
    };
})();
