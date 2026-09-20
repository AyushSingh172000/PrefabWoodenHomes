/**
 * Prefab Wooden Homes — Luxury Biophilic Motion Engine
 * Pure Vanilla JS + Hardware Accelerated Animations
 */

document.addEventListener('DOMContentLoaded', () => {
    // ─── 1. Header Scroll Blur & Shrink ───
    const header = document.getElementById('header');
    const backToTop = document.getElementById('backToTop');

    function onScroll() {
        const scrollY = window.scrollY || window.pageYOffset;
        if (header) {
            if (scrollY > 40) {
                header.classList.add('header--scrolled');
            } else {
                header.classList.remove('header--scrolled');
            }
        }
        if (backToTop) {
            if (scrollY > 450) {
                backToTop.classList.add('visible');
            } else {
                backToTop.classList.remove('visible');
            }
        }
    }
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();

    if (backToTop) {
        backToTop.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    // ─── 2. Mobile Navigation Drawer ───
    const hamburger = document.getElementById('hamburger');
    const mainNav = document.getElementById('mainNav');
    const mobileOverlay = document.getElementById('mobileOverlay');

    function toggleMenu(open) {
        const isOpen = open !== undefined ? open : !hamburger.classList.contains('active');
        hamburger.classList.toggle('active', isOpen);
        mainNav.classList.toggle('active', isOpen);
        mobileOverlay.classList.toggle('active', isOpen);
        document.body.style.overflow = isOpen ? 'hidden' : '';
        hamburger.setAttribute('aria-expanded', isOpen);
    }

    if (hamburger && mainNav && mobileOverlay) {
        hamburger.addEventListener('click', () => toggleMenu());
        mobileOverlay.addEventListener('click', () => toggleMenu(false));

        // Mobile dropdown toggle
        mainNav.querySelectorAll('.nav__dropdown').forEach(dropdown => {
            const link = dropdown.querySelector('.nav__link');
            if (link) {
                link.addEventListener('click', (e) => {
                    if (window.innerWidth <= 1080) {
                        e.preventDefault();
                        dropdown.classList.toggle('open');
                    }
                });
            }
        });

        // Close on navigation click
        mainNav.querySelectorAll('a:not(.nav__dropdown > a)').forEach(a => {
            a.addEventListener('click', () => {
                if (window.innerWidth <= 860) toggleMenu(false);
            });
        });

        // Close on ESC
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && mainNav.classList.contains('active')) {
                toggleMenu(false);
            }
        });
    }

    // ─── 3. Smooth Anchor Scrolling ───
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', (e) => {
            const targetId = anchor.getAttribute('href');
            if (targetId && targetId !== '#') {
                const target = document.querySelector(targetId);
                if (target) {
                    e.preventDefault();
                    const headerOffset = 100;
                    const elementPosition = target.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                    window.scrollTo({ top: offsetPosition, behavior: 'smooth' });
                }
            }
        });
    });

    // ─── 4. Full-Bleed Hero Slider ───
    const heroSlider = document.getElementById('heroSlider');
    if (heroSlider) {
        const slides = heroSlider.querySelectorAll('.hero__slide');
        const dots = document.querySelectorAll('.hero__dot');
        let currentSlide = 0;
        let slideTimer = null;
        const slideDuration = 6000;

        function showSlide(index) {
            slides[currentSlide].classList.remove('active');
            if (dots[currentSlide]) dots[currentSlide].classList.remove('active');

            currentSlide = (index + slides.length) % slides.length;

            slides[currentSlide].classList.add('active');
            if (dots[currentSlide]) dots[currentSlide].classList.add('active');
        }

        function startTimer() {
            stopTimer();
            slideTimer = setInterval(() => {
                showSlide(currentSlide + 1);
            }, slideDuration);
        }

        function stopTimer() {
            if (slideTimer) {
                clearInterval(slideTimer);
                slideTimer = null;
            }
        }

        dots.forEach((dot, idx) => {
            dot.addEventListener('click', () => {
                showSlide(idx);
                startTimer();
            });
        });

        // Preload imagery
        slides.forEach((slide, idx) => {
            if (idx > 0) {
                const img = slide.querySelector('img');
                if (img) {
                    const preload = new Image();
                    preload.src = img.src;
                }
            }
        });

        startTimer();
    }

    // ✦ 5. Animated Stats Counters ✦
    const statContainers = document.querySelectorAll('.hero__stats, .stats-row, .stats-grid, [data-stats-container]');
    if (statContainers.length > 0 && 'IntersectionObserver' in window) {
        statContainers.forEach(container => {
            let animated = false;
            const statValues = container.querySelectorAll('.hero__stat-value, .stat-item__value, [data-counter]');
            if (!statValues.length) return;

            const countObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting && !animated) {
                        animated = true;
                        statValues.forEach(el => {
                            const originalText = el.getAttribute('data-counter') || el.textContent.trim();
                            const targetNumber = parseInt(originalText, 10);
                            if (isNaN(targetNumber)) return;

                            const suffix = originalText.replace(/^[0-9]+/, '');
                            const duration = 2000;
                            const startTime = performance.now();

                            function updateCount(currentTime) {
                                const elapsed = currentTime - startTime;
                                const progress = Math.min(elapsed / duration, 1);
                                const easeOut = 1 - Math.pow(1 - progress, 3);
                                const currentVal = Math.floor(easeOut * targetNumber);

                                el.textContent = currentVal + suffix;

                                if (progress < 1) {
                                    requestAnimationFrame(updateCount);
                                } else {
                                    el.textContent = originalText;
                                }
                            }
                            requestAnimationFrame(updateCount);
                        });
                        countObserver.disconnect();
                    }
                });
            }, { threshold: 0.2 });

            countObserver.observe(container);
        });
    }

    // ─── 6. Modern FAQ Accordion ───
    const faqItems = document.querySelectorAll('.faq-item');
    faqItems.forEach(item => {
        const question = item.querySelector('.faq-item__question');
        const answer = item.querySelector('.faq-item__answer');
        const inner = item.querySelector('.faq-item__answer-inner');

        if (question && answer && inner) {
            question.addEventListener('click', () => {
                const isOpen = item.classList.contains('active');

                // Close all others
                faqItems.forEach(other => {
                    if (other !== item && other.classList.contains('active')) {
                        other.classList.remove('active');
                        const otherAns = other.querySelector('.faq-item__answer');
                        if (otherAns) otherAns.style.maxHeight = '0';
                    }
                });

                item.classList.toggle('active');
                answer.style.maxHeight = isOpen ? '0' : (inner.scrollHeight + 24) + 'px';
            });
        }
    });

    // ─── 7. Scroll-Triggered Reveals ───
    const revealTargets = document.querySelectorAll(
        '.reveal-up, .reveal-stagger, .type-card, .benefit-card, .project-card, .testimonial-card, .process-step'
    );

    if (revealTargets.length > 0 && 'IntersectionObserver' in window) {
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('in-view');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

        revealTargets.forEach((el) => {
            if (!el.classList.contains('reveal-up') && !el.classList.contains('reveal-stagger')) {
                el.classList.add('reveal-up');
            }
            revealObserver.observe(el);
        });
    }

    // ✦ 8. Interactive Animated Category Filters ✦
    const filterBars = document.querySelectorAll('.filter-bar');
    filterBars.forEach(bar => {
        const groupName = bar.getAttribute('data-filter-group');
        const pills = bar.querySelectorAll('.filter-pill');
        let targetCards = [];

        if (groupName === 'types') {
            targetCards = document.querySelectorAll('#typesGrid .type-card, .types-grid .type-card');
        } else if (groupName === 'projects') {
            targetCards = document.querySelectorAll('#projectsGrid .project-card, .projects-grid .project-card');
        } else {
            targetCards = document.querySelectorAll('[data-category]');
        }

        pills.forEach(pill => {
            pill.addEventListener('click', (e) => {
                e.preventDefault();
                const filterValue = pill.getAttribute('data-filter');

                // Update active pill
                pills.forEach(p => p.classList.remove('active'));
                pill.classList.add('active');

                // Staggered animated reflow
                let matchIdx = 0;
                targetCards.forEach((card) => {
                    const category = card.getAttribute('data-category') || '';
                    const isMatch = filterValue === 'all' || category === filterValue;

                    if (!isMatch) {
                        card.classList.remove('card--filtered-in');
                        card.classList.add('card--filtered-out');
                        setTimeout(() => {
                            if (card.classList.contains('card--filtered-out')) {
                                card.style.display = 'none';
                            }
                        }, 280);
                    } else {
                        card.style.display = '';
                        const currentDelay = matchIdx * 0.05;
                        matchIdx++;
                        requestAnimationFrame(() => {
                            card.classList.remove('card--filtered-out');
                            card.classList.add('card--filtered-in');
                            card.style.transitionDelay = `${currentDelay}s`;
                        });
                    }
                });
            });
        });
    });

    // ✦ 9. High-Fidelity 3D Perspective Tilt with Specular Glare ✦
    const tiltCards = document.querySelectorAll('.type-card, .project-card, .benefit-card, .testimonial-card, .stat-item, .process-step');

    tiltCards.forEach(card => {
        let glare = card.querySelector('.card-glare');
        if (!glare) {
            glare = document.createElement('div');
            glare.className = 'card-glare';
            card.appendChild(glare);
        }

        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;

            // Accurate 3D tilt calculation (-10deg to +10deg)
            const rotateX = Number(((centerY - y) / centerY * 10).toFixed(2));
            const rotateY = Number(((x - centerX) / centerX * 10).toFixed(2));

            // Disable CSS transition fighting during active mouse tracking
            card.style.transition = 'transform 0.06s linear, box-shadow 0.2s ease';
            card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale3d(1.025, 1.025, 1.025) translateY(-8px)`;

            if (glare) {
                glare.style.opacity = '1';
                glare.style.transition = 'opacity 0.15s ease';
                glare.style.background = `radial-gradient(circle at ${x}px ${y}px, rgba(255,255,255,0.42) 0%, rgba(212,175,55,0.2) 35%, transparent 70%)`;
            }
        });

        card.addEventListener('mouseleave', () => {
            // Smooth spring return on exit
            card.style.transition = 'transform 0.55s cubic-bezier(0.2, 0.8, 0.2, 1), box-shadow 0.55s ease';
            card.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) scale3d(1, 1, 1) translateY(0px)';
            if (glare) {
                glare.style.opacity = '0';
                glare.style.transition = 'opacity 0.4s ease';
            }
        });
    });

    // ✦ 10. Magnetic CTAs & Fluid Buttons ✦
    const magneticBtns = document.querySelectorAll('.btn--primary, .btn-magnetic');

    magneticBtns.forEach(btn => {
        btn.addEventListener('mousemove', (e) => {
            const rect = btn.getBoundingClientRect();
            const x = e.clientX - rect.left - rect.width / 2;
            const y = e.clientY - rect.top - rect.height / 2;
            btn.style.transition = 'transform 0.08s linear';
            btn.style.transform = `translate(${x * 0.35}px, ${y * 0.35}px) scale(1.04)`;
        });

        btn.addEventListener('mouseleave', () => {
            btn.style.transition = 'transform 0.45s cubic-bezier(0.2, 0.8, 0.2, 1)';
            btn.style.transform = 'translate(0px, 0px) scale(1)';
        });
    });

    // ─── 11. Multi-Layer Hero Parallax ───
    const heroSection = document.getElementById('heroSection');
    if (heroSection) {
        const heroSliderInner = heroSection.querySelector('.hero__slider');
        const heroContent = heroSection.querySelector('.hero__content');

        window.addEventListener('scroll', () => {
            const scrollY = window.pageYOffset;
            if (scrollY < window.innerHeight) {
                if (heroSliderInner) {
                    heroSliderInner.style.transform = `translateY(${scrollY * 0.28}px)`;
                }
                if (heroContent) {
                    heroContent.style.transform = `translateY(${scrollY * 0.12}px)`;
                    heroContent.style.opacity = Math.max(1 - scrollY / 650, 0);
                }
            }
        }, { passive: true });
    }

    // ─── 12. Contact Form AJAX Submission ───
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            contactForm.querySelectorAll('.form-control').forEach(el => el.classList.remove('error'));
            const msgBox = contactForm.querySelector('.form-message');
            if (msgBox) { msgBox.style.display = 'none'; msgBox.className = 'form-message'; }

            let valid = true;
            const name = contactForm.querySelector('[name="name"]');
            const email = contactForm.querySelector('[name="email"]');
            const phone = contactForm.querySelector('[name="phone"]');
            const message = contactForm.querySelector('[name="message"]');

            if (!name.value.trim() || name.value.trim().length < 2) {
                name.classList.add('error'); valid = false;
            }
            if (!email.value.trim() || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
                email.classList.add('error'); valid = false;
            }
            if (phone.value.trim() && !/^(\+91|91|0)?[6-9]\d{9}$/.test(phone.value.replace(/[\s\-()]/g, ''))) {
                phone.classList.add('error'); valid = false;
            }
            if (!message.value.trim() || message.value.trim().length < 10) {
                message.classList.add('error'); valid = false;
            }

            if (!valid) {
                showFormMessage(msgBox, 'Please fill in all required fields correctly.', 'error');
                return;
            }

            const submitBtn = contactForm.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.disabled = true;
            submitBtn.textContent = 'Submitting Enquiry...';

            try {
                const formData = new FormData(contactForm);
                const baseUrl = window.APP_BASE_URL || '';
                const response = await fetch(baseUrl + '/pages/submit-enquiry.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();

                if (result.success) {
                    showFormMessage(msgBox, 'Thank you! Your enquiry has been received. Our architect will reach out within 24 hours.', 'success');
                    contactForm.reset();
                } else {
                    showFormMessage(msgBox, result.message || 'Something went wrong. Please try again.', 'error');
                }
            } catch (err) {
                showFormMessage(msgBox, 'Network error. Please call us or reach out via WhatsApp.', 'error');
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            }
        });
    }

    function showFormMessage(box, text, type) {
        if (!box) return;
        box.textContent = text;
        box.className = `form-message form-message--${type}`;
        box.style.display = 'block';
        box.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    // ✦ 13. Auto-Demo Query Parameter Support & Live Showcase ✦
    const urlParams = new URLSearchParams(window.location.search);
    const filterParam = urlParams.get('filter');
    const demoParam = urlParams.get('demo');

    if (urlParams.get('section') === 'types' || filterParam || demoParam === 'tilt') {
        const typesSec = document.getElementById('typesSection');
        if (typesSec) {
            typesSec.scrollIntoView({ behavior: 'instant' });
        }
    }

    if (filterParam) {
        setTimeout(() => {
            const pill = document.querySelector(`.filter-pill[data-filter="${filterParam}"]`);
            if (pill) pill.click();
        }, 300);
    }

    if (demoParam === 'tilt') {
        setTimeout(() => {
            const card = document.querySelector('.type-card');
            if (card) {
                const glare = card.querySelector('.card-glare');
                card.style.transition = 'none';
                card.style.transform = 'perspective(1000px) rotateX(-6.5deg) rotateY(7.2deg) scale3d(1.03, 1.03, 1.03) translateY(-10px)';
                card.style.boxShadow = '0 28px 60px -10px rgba(11, 28, 22, 0.35), 0 0 35px -4px rgba(212, 175, 55, 0.45)';
                card.style.borderColor = 'rgba(212, 175, 55, 0.8)';
                if (glare) {
                    glare.style.opacity = '1';
                    glare.style.background = 'radial-gradient(circle at 75% 25%, rgba(255,255,255,0.45) 0%, rgba(212,175,55,0.2) 35%, transparent 70%)';
                }
            }
        }, 300);
    } else if (demoParam === 'magnetic') {
        setTimeout(() => {
            const btn = document.querySelector('.btn-magnetic');
            if (btn) {
                btn.style.transform = 'translate(12px, -6px) scale(1.05)';
                btn.style.boxShadow = '0 18px 38px var(--color-gold-glow), 0 6px 16px rgba(11,28,22,0.22)';
            }
        }, 300);
    }

    // ✦ 14. Testing / Diagnostic Motion Harness ✦
    window.__testMotion = {
        simulateHover: function(selector, relativeX = 0.75, relativeY = 0.25) {
            const el = document.querySelector(selector);
            if (!el) return null;
            const rect = el.getBoundingClientRect();
            const evt = new MouseEvent('mousemove', {
                clientX: rect.left + rect.width * relativeX,
                clientY: rect.top + rect.height * relativeY,
                bubbles: true
            });
            el.dispatchEvent(evt);
            return {
                selector: selector,
                transform: window.getComputedStyle(el).transform,
                transition: window.getComputedStyle(el).transition
            };
        },
        filterCategory: function(group, category) {
            const pill = document.querySelector(`.filter-bar[data-filter-group="${group}"] .filter-pill[data-filter="${category}"]`);
            if (pill) {
                pill.click();
                return true;
            }
            return false;
        }
    };

    // ─── 15. Content & Source Code Protection (Copy & Inspect Guard) ───
    function initContentProtection() {
        let toastEl = null;
        let toastTimeout = null;

        function showCopyAlert() {
            if (!toastEl) {
                toastEl = document.createElement('div');
                toastEl.id = 'copyAlertToast';
                toastEl.className = 'copy-alert-toast';
                toastEl.setAttribute('role', 'alert');
                toastEl.setAttribute('aria-live', 'assertive');
                toastEl.innerHTML = `
                    <div class="copy-alert-toast__icon" aria-hidden="true">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2.5L1.5 21H22.5L12 2.5Z" fill="#F4B400" stroke="#C98A00" stroke-width="1.5" stroke-linejoin="round"/>
                            <path d="M12 8.5V14" stroke="#1F2937" stroke-width="2.2" stroke-linecap="round"/>
                            <circle cx="12" cy="17.5" r="1.3" fill="#1F2937"/>
                        </svg>
                    </div>
                    <div class="copy-alert-toast__content">
                        <div class="copy-alert-toast__text">
                            <strong>ALERT:</strong> You are not allowed to copy content or view source
                        </div>
                    </div>
                `;
                document.body.appendChild(toastEl);
            }

            // Trigger animation
            toastEl.classList.add('active');

            if (toastTimeout) {
                clearTimeout(toastTimeout);
            }
            toastTimeout = setTimeout(() => {
                if (toastEl) {
                    toastEl.classList.remove('active');
                }
            }, 3000);
        }

        // Helper to check if active element is a form control
        function isInputActive(e) {
            const target = e.target || document.activeElement;
            if (!target) return false;
            const tag = (target.tagName || '').toUpperCase();
            return tag === 'INPUT' || tag === 'TEXTAREA' || target.isContentEditable;
        }

        // 1. Right Click (Context Menu) Prevention
        document.addEventListener('contextmenu', (e) => {
            e.preventDefault();
            showCopyAlert();
            return false;
        });

        // 2. Clipboard Copy & Cut Prevention (Allow within form inputs)
        document.addEventListener('copy', (e) => {
            if (isInputActive(e)) return;
            e.preventDefault();
            showCopyAlert();
            return false;
        });

        document.addEventListener('cut', (e) => {
            if (isInputActive(e)) return;
            e.preventDefault();
            showCopyAlert();
            return false;
        });

        // 3. Developer Tools & View-Source Shortcut Interception
        document.addEventListener('keydown', (e) => {
            const isCtrlOrCmd = e.ctrlKey || e.metaKey;
            const key = (e.key || '').toLowerCase();
            const keyCode = e.keyCode || e.which;

            // F12 key (DevTools)
            if (key === 'f12' || keyCode === 123) {
                e.preventDefault();
                showCopyAlert();
                return false;
            }

            if (isCtrlOrCmd) {
                // Ctrl+U (View Source)
                // Ctrl+S (Save Page)
                // Ctrl+Shift+I / Ctrl+Shift+J / Ctrl+Shift+C (Inspect Element / Console / Picker)
                if (key === 'u' || key === 's' || (e.shiftKey && (key === 'i' || key === 'j' || key === 'c'))) {
                    e.preventDefault();
                    showCopyAlert();
                    return false;
                }

                // Ctrl+C / Ctrl+X outside text inputs
                if (!isInputActive(e) && (key === 'c' || key === 'x')) {
                    e.preventDefault();
                    showCopyAlert();
                    return false;
                }
            }
        });

        // Diagnostic hook for testing
        window.__showCopyAlert = showCopyAlert;
    }

    initContentProtection();
});

