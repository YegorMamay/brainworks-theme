document.addEventListener('DOMContentLoaded', () => {





    // Accordion for .bw-theme-menu
    const menuItems = document.querySelectorAll('.bw-theme-menu .menu-item-has-children');

    menuItems.forEach(item => {
        const toggleBtn = document.createElement('button');
        toggleBtn.className = 'menu-toggle';
        toggleBtn.setAttribute('aria-expanded', 'false');
        item.appendChild(toggleBtn);

        toggleBtn.addEventListener('click', (e) => {
            e.preventDefault();
            item.classList.toggle('menu-item-open');
            const isExpanded = item.classList.contains('menu-item-open');
            toggleBtn.setAttribute('aria-expanded', isExpanded);
        });
    });
    // Smooth Scrolling for Anchor Links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;

            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                e.preventDefault();

                const headerOffset = document.querySelector('.site-header').offsetHeight || 0;
                const elementPosition = targetElement.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset - 20; // 20px extra padding

                window.scrollTo({
                    top: offsetPosition,
                    behavior: "smooth"
                });
            }
        });
    });

    // Archive Description Show/Hide
    const descriptionWrappers = document.querySelectorAll('.archive-description-wrapper');
    descriptionWrappers.forEach(wrapper => {
        const inner = wrapper.querySelector('.archive-description-inner');
        const toggleBtn = wrapper.querySelector('.archive-description-toggle');
        const maxHeight = 120; // Matches CSS max-height

        if (inner) {
            if (inner.scrollHeight > maxHeight) {
                inner.classList.add('collapsed');
                if (toggleBtn) {
                    toggleBtn.style.display = 'block';

                    toggleBtn.addEventListener('click', function (e) {
                        e.preventDefault();

                        if (inner.classList.contains('collapsed')) {
                            // Expand
                            inner.classList.remove('collapsed');
                            inner.classList.add('expanded');

                            // Set height to current scrollHeight for animation
                            inner.style.maxHeight = inner.scrollHeight + "px";

                            // After transition, remove max-height to allow auto-growth
                            // After transition, remove max-height to allow auto-growth
                            const handleTransitionEnd = () => {
                                if (inner.classList.contains('expanded')) {
                                    inner.style.maxHeight = 'none';
                                }
                                inner.removeEventListener('transitionend', handleTransitionEnd);
                            };
                            inner.addEventListener('transitionend', handleTransitionEnd);

                            this.textContent = this.getAttribute('data-hide-text');
                        } else {
                            // Collapse

                            // Set height explicitly to current scrollHeight before collapsing to enable transition
                            inner.style.maxHeight = inner.scrollHeight + "px";

                            // Force reflow
                            inner.offsetHeight;

                            inner.classList.remove('expanded');
                            inner.classList.add('collapsed');

                            // Set max-height back to initial restricted value
                            inner.style.maxHeight = null; // Falls back to CSS 120px

                            this.textContent = this.getAttribute('data-show-text');
                        }
                    });
                }
            }
        }
    });

    // Sticky Sidebar Scroll Trigger
    const sidebars = document.querySelectorAll('.sidebar');
    if (sidebars.length > 0) {
        // Get the computed value of the custom property
        const stickyState = getComputedStyle(document.documentElement).getPropertyValue('--sidebar-sticky').trim();
        const scrollTriggerVar = getComputedStyle(document.documentElement).getPropertyValue('--sidebar-scroll-trigger').trim();
        const scrollTrigger = parseInt(scrollTriggerVar, 10) || 0;

        if (stickyState === 'sticky') {
            const handleSidebarScroll = () => {
                sidebars.forEach(sidebar => {
                    if (window.scrollY >= scrollTrigger) {
                        sidebar.classList.add('is-sticky-active');
                    } else {
                        sidebar.classList.remove('is-sticky-active');
                    }
                });
            };

            // Initial check
            handleSidebarScroll();

            // Add listener
            window.addEventListener('scroll', handleSidebarScroll);
        }
    }
    // Mobile Menu Toggle
    const hamburger = document.querySelector('.js-hamburger');
    const mobileMenu = document.querySelector('.mobile-menu-container');
    const body = document.body;

    if (hamburger && mobileMenu) {
        hamburger.addEventListener('click', function () {
            this.classList.toggle('is-active');
            mobileMenu.classList.toggle('is-open');
            body.classList.toggle('mobile-menu-open');
        });

        // Close on escape
        document.addEventListener('keydown', function (event) {
            if (event.key === "Escape" && mobileMenu.classList.contains('is-open')) {
                hamburger.classList.remove('is-active');
                mobileMenu.classList.remove('is-open');
                body.classList.remove('mobile-menu-open');
            }
        });

        // Mobile Menu Accordion
        const menuItems = mobileMenu.querySelectorAll('.menu-item-has-children');

        menuItems.forEach(item => {
            // Create toggle button
            const span = document.createElement('span');
            span.className = 'menu-toggle';
            item.appendChild(span);

            // Toggle click event
            span.addEventListener('click', function (e) {
                e.preventDefault();
                this.classList.toggle('is-active');
                const subMenu = item.querySelector('.sub-menu');
                if (subMenu) {
                    if (subMenu.style.display === 'block') {
                        subMenu.style.display = 'none';
                    } else {
                        subMenu.style.display = 'block';
                    }
                }
            });

            // Anchor click event (empty or #)
            const anchor = item.querySelector('a');
            if (anchor) {
                anchor.addEventListener('click', function (e) {
                    const href = this.getAttribute('href');
                    if (!href || href === '#' || href === '') {
                        e.preventDefault();
                        const toggle = item.querySelector('.menu-toggle');
                        if (toggle) {
                            toggle.click(); // Trigger the toggle
                        }
                    }
                });
            }
        });

        // Close button inside menu
        const closeBtn = mobileMenu.querySelector('.js-mobile-menu-close');
        if (closeBtn) {
            closeBtn.addEventListener('click', function () {
                hamburger.classList.remove('is-active');
                mobileMenu.classList.remove('is-open');
                body.classList.remove('mobile-menu-open');
            });
        }

        // Close on anchor link click
        const menuLinks = mobileMenu.querySelectorAll('a[href*="#"]');
        menuLinks.forEach(link => {
            link.addEventListener('click', function () {
                const href = this.getAttribute('href');
                // Don't close if it's just a toggle link
                if (href && href !== '#' && href !== '') {
                    hamburger.classList.remove('is-active');
                    mobileMenu.classList.remove('is-open');
                    body.classList.remove('mobile-menu-open');
                }
            });
        });
    }
    // WooCommerce live cart update for [woo_icons] shortcode
    if (typeof window.wooIconsAjax !== 'undefined') {
        const wooAjax = window.wooIconsAjax;

        function updateWooIcons() {
            fetch(wooAjax.ajaxurl, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({
                    action: 'woo_icons_cart',
                    nonce: wooAjax.nonce,
                }),
            })
                .then(r => r.json())
                .then(data => {
                    if (!data.success) return;
                    const count = data.data.count;
                    const total = data.data.total;

                    // Update all badges on the page
                    document.querySelectorAll('[data-woo-cart-count]').forEach(badge => {
                        badge.textContent = count;
                        badge.style.display = count > 0 ? '' : 'none';
                    });

                    // Update all totals on the page
                    document.querySelectorAll('[data-woo-cart-total]').forEach(el => {
                        el.innerHTML = total;
                    });
                })
                .catch(() => { });
        }

        // WooCommerce fires jQuery events on the document after cart changes.
        // We hook into them if jQuery is available; otherwise fall back to
        // a MutationObserver on the mini-cart fragment (standard WC behaviour).
        if (typeof jQuery !== 'undefined') {
            jQuery(document.body).on(
                'added_to_cart removed_from_cart wc_fragments_refreshed',
                updateWooIcons
            );
        }

        // Also listen for WooCommerce's custom event dispatched on the body
        // Also listen for WooCommerce's custom event dispatched on the body
        document.body.addEventListener('wc-cart-fragments-refresh', updateWooIcons);
    }

    // -----------------------------------------------------------------------
    // Product view switcher (grid / list)
    // -----------------------------------------------------------------------
    const switcher = document.querySelector('.bw-view-switcher');
    if (switcher) {
        const STORAGE_KEY = 'bw_product_view';
        const btns = switcher.querySelectorAll('.bw-view-switcher__btn');

        // Apply saved preference immediately (no flash)
        const saved = localStorage.getItem(STORAGE_KEY);
        if (saved) {
            applyView(saved, false);
        }

        btns.forEach(btn => {
            btn.addEventListener('click', () => {
                const view = btn.dataset.view;
                applyView(view, true);
            });
        });

        function applyView(view, save) {
            // Toggle body class
            document.body.classList.toggle('woo-list-view', view === 'list');

            // Update button states
            btns.forEach(b => {
                const active = b.dataset.view === view;
                b.classList.toggle('is-active', active);
                b.setAttribute('aria-pressed', String(active));
            });

            // Persist
            if (save) {
                localStorage.setItem(STORAGE_KEY, view);
            }
        }
    }

    // Shortcode [showhide] logic
    document.querySelectorAll('.show-hide-block').forEach(block => {
        const content = block.querySelector('.show-hide-content');
        const button = block.querySelector('.show-hide-button');

        if (content && button) {
            // Check if content is actually taller than the collapsed height
            // We need to wait for a bit to get the correct scrollHeight if there are images
            const checkHeight = () => {
                const targetHeight = parseInt(getComputedStyle(content).getPropertyValue('--show-hide-height')) || 120;
                if (content.scrollHeight <= targetHeight + 10) {
                    button.style.display = 'none';
                    content.style.maxHeight = 'none';
                    content.classList.add('no-fade');
                }
            };

            checkHeight();
            window.addEventListener('load', checkHeight); // Run again on full load

            button.addEventListener('click', (e) => {
                e.preventDefault();
                const isExpanded = block.classList.contains('is-expanded');

                if (!isExpanded) {
                    // Expand
                    content.style.maxHeight = content.scrollHeight + 'px';
                    button.textContent = button.getAttribute('data-less-text');
                    block.classList.add('is-expanded');

                    // Allow auto-height after transition for responsiveness
                    const onTransitionEnd = (e) => {
                        if (e.propertyName === 'max-height') {
                            content.style.maxHeight = 'none';
                            content.removeEventListener('transitionend', onTransitionEnd);
                        }
                    };
                    content.addEventListener('transitionend', onTransitionEnd);
                } else {
                    // Collapse
                    // Set to current height first to enable transition
                    content.style.maxHeight = content.scrollHeight + 'px';

                    // Force reflow
                    content.offsetHeight;

                    block.classList.remove('is-expanded');
                    content.style.maxHeight = null; // Reverts to var(--show-hide-height)
                    button.textContent = button.getAttribute('data-more-text');
                }
            });
        }
    });

});
