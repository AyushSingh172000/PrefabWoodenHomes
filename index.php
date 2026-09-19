<?php
require_once __DIR__ . '/includes/init.php';
$pageMeta = seoMeta(
    'Luxury Wooden Houses, Cottages & Farmhouses in India',
    'Prefab Wooden Homes designs, manufactures, and constructs premium eco-friendly wooden houses, log cottages, farmhouses, and luxury timber villas across India.',
    'prefab wooden homes India, wooden house manufacturer, wooden cottages, timber villas, wooden farmhouse construction'
);
require_once __DIR__ . '/includes/header.php';
?>

    <!-- Hero Section -->
    <section class="hero" id="heroSection">
        <div class="hero__slider" id="heroSlider">
            <div class="hero__slide active">
                <img src="https://images.unsplash.com/photo-1542718610-a1d656d1884c?w=1920&q=80" alt="Luxury Prefab Wooden Chalet in Forest" loading="eager">
            </div>
            <div class="hero__slide">
                <img src="https://images.unsplash.com/photo-1510798831971-661eb04b3739?w=1920&q=80" alt="Modern Scandinavian Timber Home" loading="lazy">
            </div>
            <div class="hero__slide">
                <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=1920&q=80" alt="Contemporary Wooden Farmhouse at Sunset" loading="lazy">
            </div>
            <div class="hero__slide">
                <img src="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=1920&q=80" alt="Architectural Timber Villa with Glass Facade" loading="lazy">
            </div>
        </div>
        <div class="hero__overlay"></div>
        <div class="hero__indicators" id="heroIndicators">
            <button class="hero__dot active" aria-label="Slide 1" data-slide="0"></button>
            <button class="hero__dot" aria-label="Slide 2" data-slide="1"></button>
            <button class="hero__dot" aria-label="Slide 3" data-slide="2"></button>
            <button class="hero__dot" aria-label="Slide 4" data-slide="3"></button>
        </div>
        <div class="container hero__content">
            <div class="hero__badge hero-entrance--1">
                <i class="fas fa-award"></i>
                <?= htmlspecialchars(getSetting('experience_years', '15')) ?>+ Years of Trusted Craftsmanship
            </div>
            <h1 class="hero__title hero-entrance--2"><?= nl2br(htmlspecialchars(getSetting('hero_title', "Build Your Dream\nWooden Home"))) ?></h1>
            <p class="hero__subtitle hero-entrance--3"><?= htmlspecialchars(getSetting('hero_subtitle', 'Custom-designed, premium wooden homes engineered for comfort, durability and timeless beauty. From concept to handover, we manage every detail.')) ?></p>
            <div class="hero__actions hero-entrance--4">
                <a href="<?= url('pages/contact.php') ?>" class="btn btn--primary btn--lg btn-magnetic">Get a Free Quote</a>
                <a href="https://wa.me/<?= getSetting('contact_whatsapp', CONTACT_WHATSAPP) ?>?text=Hi%2C%20I%27m%20interested%20in%20a%20wooden%20home."
                   class="btn btn--whatsapp btn--lg btn-magnetic" target="_blank" rel="noopener">
                    <i class="fab fa-whatsapp"></i> WhatsApp Us
                </a>
            </div>
            <div class="hero__stats hero-entrance--5">
                <div class="hero__stat">
                    <div class="hero__stat-value" data-counter="25">25+</div>
                    <div class="hero__stat-label">Projects Completed</div>
                </div>
                <div class="hero__stat">
                    <div class="hero__stat-value" data-counter="<?= (int)getSetting('experience_years', '15') ?>"><?= (int)getSetting('experience_years', '15') ?>+</div>
                    <div class="hero__stat-label">Years Experience</div>
                </div>
                <div class="hero__stat">
                    <div class="hero__stat-value">Pan-India</div>
                    <div class="hero__stat-label">Project Delivery</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Types of Wooden Homes -->
    <section class="section" id="typesSection">
        <div class="container">
            <div class="section__header reveal-up">
                <span class="section__label">What We Build</span>
                <h2 class="section__title">Types of Wooden Homes</h2>
                <p class="section__subtitle">From cosy cottages to luxurious villas, we design and construct a wide range of wooden structures tailored to your vision.</p>
            </div>

            <?php
            $homeServices = getActiveServices();
            $counts = ['all' => count($homeServices), 'cottage' => 0, 'farmhouse' => 0, 'villa' => 0, 'resort' => 0, 'treehouse' => 0];
            foreach ($homeServices as $s) {
                $sl = $s['slug'];
                if (strpos($sl, 'farm') !== false) $counts['farmhouse']++;
                elseif (strpos($sl, 'villa') !== false) $counts['villa']++;
                elseif (strpos($sl, 'resort') !== false) $counts['resort']++;
                elseif (strpos($sl, 'tree') !== false) $counts['treehouse']++;
                else $counts['cottage']++;
            }
            ?>

            <!-- Filter / Sort Bar -->
            <div class="filter-bar reveal-up" data-filter-group="types">
                <button class="filter-pill active" data-filter="all">
                    <span>All Structures</span>
                    <span class="filter-pill__count"><?= $counts['all'] ?></span>
                </button>
                <button class="filter-pill" data-filter="cottage">
                    <span>Cottages &amp; Cabins</span>
                    <span class="filter-pill__count"><?= $counts['cottage'] ?></span>
                </button>
                <button class="filter-pill" data-filter="farmhouse">
                    <span>Farmhouses</span>
                    <span class="filter-pill__count"><?= $counts['farmhouse'] ?></span>
                </button>
                <button class="filter-pill" data-filter="villa">
                    <span>Luxury Villas</span>
                    <span class="filter-pill__count"><?= $counts['villa'] ?></span>
                </button>
                <button class="filter-pill" data-filter="resort">
                    <span>Resort Stays</span>
                    <span class="filter-pill__count"><?= $counts['resort'] ?></span>
                </button>
                <button class="filter-pill" data-filter="treehouse">
                    <span>Tree Houses</span>
                    <span class="filter-pill__count"><?= $counts['treehouse'] ?></span>
                </button>
            </div>

            <!-- Types Grid (Asymmetrical Bento with Breakout Panel) -->
            <div class="types-grid reveal-stagger" id="typesGrid">
                <?php
                if (!empty($homeServices)):
                    foreach ($homeServices as $hIdx => $hServ):
                        $slug = $hServ['slug'];
                        $cat = 'cottage';
                        if (strpos($slug, 'farm') !== false) $cat = 'farmhouse';
                        elseif (strpos($slug, 'villa') !== false) $cat = 'villa';
                        elseif (strpos($slug, 'resort') !== false) $cat = 'resort';
                        elseif (strpos($slug, 'tree') !== false) $cat = 'treehouse';

                        $img = $hServ['image'] ?? '';
                        if (empty($img)) {
                            $img = 'https://images.unsplash.com/photo-1449158743715-0a90ebb6d2d8?w=900&q=80';
                        } elseif (!preg_match('#^https?://#i', $img)) {
                            $img = asset($img);
                        }

                        $isFeatured = ($hIdx === 0);
                        if ($isFeatured):
                ?>
                <a href="<?= url('pages/construction.php#' . htmlspecialchars($slug)) ?>" class="type-card type-card--featured tilt-card" data-category="<?= htmlspecialchars($cat) ?>">
                    <span class="type-card__tag"><i class="fas fa-sparkles"></i> <?= htmlspecialchars($hServ['subtitle'] ?: 'Signature Architectural') ?></span>
                    <img class="type-card__img" src="<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($hServ['title']) ?>" loading="lazy">
                    <div class="type-card__overlay">
                        <div class="type-card__featured-badge">Turnkey Precision</div>
                        <div class="type-card__title"><?= htmlspecialchars($hServ['title']) ?></div>
                        <div class="type-card__desc"><?= htmlspecialchars(truncateText((string)$hServ['description'], 130)) ?></div>
                        <div class="type-card__specs">
                            <span><i class="fas fa-stopwatch"></i> 8–12 Wks Assembly</span>
                            <span><i class="fas fa-shield-alt"></i> 100% Termite Treated</span>
                            <span><i class="fas fa-leaf"></i> FSC Pine</span>
                        </div>
                    </div>
                    <div class="type-card__arrow"><i class="fas fa-arrow-right"></i></div>
                </a>
                <?php else: ?>
                <a href="<?= url('pages/construction.php#' . htmlspecialchars($slug)) ?>" class="type-card tilt-card" data-category="<?= htmlspecialchars($cat) ?>">
                    <img class="type-card__img" src="<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($hServ['title']) ?>" loading="lazy">
                    <div class="type-card__overlay">
                        <div class="type-card__title"><?= htmlspecialchars($hServ['title']) ?></div>
                        <div class="type-card__desc"><?= htmlspecialchars(truncateText((string)$hServ['description'], 90)) ?></div>
                    </div>
                    <div class="type-card__arrow"><i class="fas fa-arrow-right"></i></div>
                </a>
                <?php endif; endforeach; endif; ?>
            </div>
        </div>
    </section>

    <!-- Organic Wave Divider to Dark Section -->
    <div class="section-divider section-divider--wave-bottom">
        <svg viewBox="0 0 1440 64" fill="none" preserveAspectRatio="none">
            <path d="M0,32 C360,64 720,0 1080,48 C1240,68 1360,30 1440,32 L1440,64 L0,64 Z" fill="var(--color-forest-950)"></path>
        </svg>
    </div>

    <!-- Why Choose Us (Living Engineering) -->
    <section class="section section--dark" style="padding-top: var(--space-8);">
        <div class="container">
            <div class="section__header reveal-up">
                <span class="section__label">Why Choose Us</span>
                <h2 class="section__title">The Living Engineering Advantage</h2>
                <p class="section__subtitle">We blend sustainable European craftsmanship with cutting-edge engineering suited for India's diverse climate.</p>
            </div>
            <div class="benefits-grid reveal-stagger">
                <div class="benefit-card tilt-card">
                    <div class="benefit-card__icon"><i class="fas fa-bolt"></i></div>
                    <h3 class="benefit-card__title">Fast Assembly</h3>
                    <p class="benefit-card__text">Factory precision manufacturing allows on-site assembly in a fraction of traditional construction time. Move in months earlier.</p>
                </div>
                <div class="benefit-card tilt-card benefit-card--offset">
                    <div class="benefit-card__icon"><i class="fas fa-leaf"></i></div>
                    <h3 class="benefit-card__title">Eco-Friendly &amp; Sustainable</h3>
                    <p class="benefit-card__text">Sourced from sustainably managed, PEFC- and FSC-certified forests in British Columbia and Scandinavia with a negative carbon footprint.</p>
                </div>
                <div class="benefit-card tilt-card">
                    <div class="benefit-card__icon"><i class="fas fa-thermometer-half"></i></div>
                    <h3 class="benefit-card__title">Natural Thermal Insulation</h3>
                    <p class="benefit-card__text">Wood is 15x more insulating than masonry. Naturally warm in winter, refreshingly cool in summer, saving up to 40% on heating and cooling bills.</p>
                </div>
                <div class="benefit-card tilt-card benefit-card--offset">
                    <div class="benefit-card__icon"><i class="fas fa-shield-alt"></i></div>
                    <h3 class="benefit-card__title">Waterproof &amp; Anti-Termite</h3>
                    <p class="benefit-card__text">Kiln-dried, pressure-treated timber with multi-layer waterproof coatings and anti-termite protection engineered for India's monsoons.</p>
                </div>
                <div class="benefit-card tilt-card">
                    <div class="benefit-card__icon"><i class="fas fa-drafting-compass"></i></div>
                    <h3 class="benefit-card__title">100% Custom Designs</h3>
                    <p class="benefit-card__text">Every project is custom-designed with detailed 3D models before manufacturing begins. Your space, exactly as you envision it.</p>
                </div>
                <div class="benefit-card tilt-card benefit-card--offset">
                    <div class="benefit-card__icon"><i class="fas fa-map-marked-alt"></i></div>
                    <h3 class="benefit-card__title">Pan-India Delivery</h3>
                    <p class="benefit-card__text">Delivered and assembled anywhere in India — from mountain slopes in Himachal to coastal beaches in Goa, farms in Maharashtra, and retreats in Kerala.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Organic Wave Divider to Light Section -->
    <div class="section-divider section-divider--wave-top">
        <svg viewBox="0 0 1440 64" fill="none" preserveAspectRatio="none">
            <path d="M0,0 L1440,0 L1440,32 C1200,60 840,4 480,48 C240,68 120,24 0,32 Z" fill="var(--color-forest-950)"></path>
        </svg>
    </div>

    <!-- Process -->
    <section class="section">
        <div class="container">
            <div class="section__header reveal-up">
                <span class="section__label">How It Works</span>
                <h2 class="section__title">From Vision to Handover</h2>
                <p class="section__subtitle">A streamlined, transparent process from initial concept to the day you turn the key.</p>
            </div>
            <div class="process-steps reveal-stagger">
                <div class="process-step tilt-card">
                    <h3 class="process-step__title">Consultation &amp; Vision</h3>
                    <p class="process-step__desc">We understand your requirements, site conditions, preferences and budget.</p>
                </div>
                <div class="process-step tilt-card">
                    <h3 class="process-step__title">3D Architectural Design</h3>
                    <p class="process-step__desc">Our architects create detailed 3D models and blueprints for your review.</p>
                </div>
                <div class="process-step tilt-card">
                    <h3 class="process-step__title">Factory Precision Build</h3>
                    <p class="process-step__desc">Components are precision-manufactured and treated in a controlled facility.</p>
                </div>
                <div class="process-step tilt-card">
                    <h3 class="process-step__title">On-Site Assembly</h3>
                    <p class="process-step__desc">Our specialist team transports and assembles the structure on your site.</p>
                </div>
                <div class="process-step tilt-card">
                    <h3 class="process-step__title">Key Handover</h3>
                    <p class="process-step__desc">Move-in ready with complete documentation, warranty and maintenance guide.</p>
                </div>
            </div>
            <div class="text-center mt-8 reveal-up">
                <a href="<?= url('pages/process.php') ?>" class="btn btn--primary btn-magnetic">Explore Full Process</a>
            </div>
        </div>
    </section>

    <!-- Recent Projects -->
    <section class="section section--alt">
        <div class="container">
            <div class="section__header reveal-up">
                <span class="section__label">Featured Work</span>
                <h2 class="section__title">Recent Projects</h2>
                <p class="section__subtitle">Take a look at some of the wooden homes we've designed, manufactured and delivered across India.</p>
            </div>
            <div class="projects-grid reveal-stagger">
                <div class="project-card tilt-card">
                    <img class="project-card__img" src="https://images.unsplash.com/photo-1542718610-a1d656d1884c?w=600&q=75" alt="Resort Cottage in Manali" loading="lazy">
                    <div class="project-card__body">
                        <span class="project-card__tag">Resort Cottage</span>
                        <h3 class="project-card__title">Mountain Resort Cottage</h3>
                        <div class="project-card__meta">
                            <span><i class="fas fa-map-marker-alt"></i> Manali, HP</span>
                            <span><i class="fas fa-ruler-combined"></i> 1,200 sq ft</span>
                        </div>
                    </div>
                </div>
                <div class="project-card tilt-card">
                    <img class="project-card__img" src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=600&q=75" alt="Wooden Farmhouse in Lonavala" loading="lazy">
                    <div class="project-card__body">
                        <span class="project-card__tag">Farmhouse</span>
                        <h3 class="project-card__title">Premium Wooden Farmhouse</h3>
                        <div class="project-card__meta">
                            <span><i class="fas fa-map-marker-alt"></i> Lonavala, Maharashtra</span>
                            <span><i class="fas fa-ruler-combined"></i> 2,500 sq ft</span>
                        </div>
                    </div>
                </div>
                <div class="project-card tilt-card">
                    <img class="project-card__img" src="https://images.unsplash.com/photo-1588880331179-bc9b93a8cb5e?w=600&q=75" alt="Wooden Villa in Goa" loading="lazy">
                    <div class="project-card__body">
                        <span class="project-card__tag">Villa</span>
                        <h3 class="project-card__title">Luxury Timber Villa</h3>
                        <div class="project-card__meta">
                            <span><i class="fas fa-map-marker-alt"></i> Goa</span>
                            <span><i class="fas fa-ruler-combined"></i> 3,200 sq ft</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-8 reveal-up">
                <a href="<?= url('pages/projects.php') ?>" class="btn btn--outline-dark btn-magnetic">View All Projects</a>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="section">
        <div class="container">
            <div class="section__header reveal-up">
                <span class="section__label">Testimonials</span>
                <h2 class="section__title">What Our Clients Say</h2>
            </div>
            <div class="testimonials-grid reveal-stagger">
                <div class="testimonial-card tilt-card">
                    <div class="testimonial-card__quote">&ldquo;</div>
                    <p class="testimonial-card__text">Prefab Wooden Homes delivered our resort cottages on time and the quality is outstanding. Their team was professional from design to handover. Highly recommended for anyone looking for premium wooden construction.</p>
                    <div class="testimonial-card__author">Rajesh Sharma</div>
                    <div class="testimonial-card__role">Resort Owner, Himachal Pradesh</div>
                </div>
                <div class="testimonial-card tilt-card">
                    <div class="testimonial-card__quote">&ldquo;</div>
                    <p class="testimonial-card__text">We wanted a wooden farmhouse that felt like a European chalet but suited Indian weather. Aman and his team understood our vision perfectly and the result exceeded our expectations. The house stays naturally cool even in peak summer.</p>
                    <div class="testimonial-card__author">Priya &amp; Vikram Mehta</div>
                    <div class="testimonial-card__role">Homeowner, Maharashtra</div>
                </div>
                <div class="testimonial-card tilt-card">
                    <div class="testimonial-card__quote">&ldquo;</div>
                    <p class="testimonial-card__text">The 3D design process was wonderful — we could visualise exactly what our cottage would look like before a single log was placed. The construction was remarkably fast and the craftsmanship is excellent.</p>
                    <div class="testimonial-card__author">Anand Krishnamurthy</div>
                    <div class="testimonial-card__role">Cottage Owner, Kerala</div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Banner -->
    <section class="cta-banner section--dark">
        <div class="cta-banner__bg">
            <img src="https://images.unsplash.com/photo-1513584684374-8bab748fbf90?w=1920&q=60" alt="Wooden home background" loading="lazy">
        </div>
        <div class="container cta-banner__content">
            <h2 class="cta-banner__title">Ready to Build Your Wooden Home?</h2>
            <p class="cta-banner__text">Share your ideas with us and we will transform them into reality. Our team is ready to guide you from the very first conversation.</p>
            <div class="cta-banner__actions">
                <a href="<?= url('pages/contact.php') ?>" class="btn btn--primary btn--lg btn-magnetic">Request a Site Visit</a>
                <a href="https://wa.me/<?= CONTACT_WHATSAPP ?>" class="btn btn--outline btn--lg btn-magnetic" target="_blank" rel="noopener">
                    <i class="fab fa-whatsapp"></i> WhatsApp Us
                </a>
            </div>
        </div>
    </section>

    <!-- Brief FAQ on Home -->
    <section class="section">
        <div class="container">
            <div class="section__header reveal-up">
                <span class="section__label">Common Questions</span>
                <h2 class="section__title">Frequently Asked Questions</h2>
            </div>
            <div class="faq-list reveal-up">
                <div class="faq-item">
                    <button class="faq-item__question">
                        How much does a wooden house cost in India?
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-item__answer">
                        <div class="faq-item__answer-inner">The cost of a wooden house in India varies depending on size, design complexity, wood species and location. As a general range, prefab wooden homes start from approximately ₹2,500 per sq ft and can go up to ₹6,000+ per sq ft for premium custom builds. Contact us with your requirements for a precise, no-obligation quotation.</div>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-item__question">
                        How long does construction take?
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-item__answer">
                        <div class="faq-item__answer-inner">Prefab wooden homes are significantly faster to build than conventional construction. After design approval, manufacturing takes 4–6 weeks and on-site assembly typically takes 2–4 weeks depending on the project size. A standard cottage can be move-in ready in as little as 8–10 weeks from approval.</div>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-item__question">
                        Can you construct anywhere in India?
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-item__answer">
                        <div class="faq-item__answer-inner">Yes, we deliver and construct wooden homes across India. Our prefabricated components are manufactured at our facility and transported to any location — be it the Himalayas, Goa's coastline, a farm in Maharashtra, or a resort site in Kerala. We have completed projects in multiple states.</div>
                    </div>
                </div>
                <div class="faq-item">
                    <button class="faq-item__question">
                        Is a wooden house waterproof and termite resistant?
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-item__answer">
                        <div class="faq-item__answer-inner">Absolutely. We treat all timber with industrial-grade waterproof stains, sealants and anti-termite chemicals. Our wood is kiln-dried and pressure-treated to resist moisture, fungi and termite infestation. With proper maintenance, these protections last for decades.</div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-8 reveal-up">
                <a href="<?= url('pages/faq.php') ?>" class="btn btn--outline-dark btn-magnetic">View All FAQs</a>
            </div>
        </div>
    </section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
