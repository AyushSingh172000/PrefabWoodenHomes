<?php
require_once __DIR__ . '/../includes/init.php';
$pageMeta = seoMeta(
    'Design & Construction Process',
    'Learn about our transparent wooden home construction process — from initial consultation and 3D design to manufacturing, on-site installation and handover.',
    'wooden house construction process, prefab home building steps, wooden house design process, wooden home manufacturing'
);
require_once __DIR__ . '/../includes/header.php';
?>

    <section class="page-banner">
        <div class="container reveal-up">
            <h1 class="page-banner__title">Design &amp; Construction Process</h1>
            <div class="page-banner__breadcrumb">
                <a href="<?= url() ?>">Home</a> &nbsp;/&nbsp; Our Process
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="section__header reveal-up">
                <span class="section__label">How We Work</span>
                <h2 class="section__title">From Vision to Reality</h2>
                <p class="section__subtitle">A transparent, step-by-step journey that takes your dream wooden home from concept to keys in your hand.</p>
            </div>

            <div class="process-steps reveal-stagger">
                <div class="process-step tilt-card">
                    <h3 class="process-step__title">Consultation</h3>
                    <p class="process-step__desc">We start with a detailed conversation about your vision, requirements, budget and timeline. This can happen over a call, WhatsApp or an in-person meeting.</p>
                </div>
                <div class="process-step tilt-card">
                    <h3 class="process-step__title">Site Visit</h3>
                    <p class="process-step__desc">Our team visits your site to evaluate terrain, access roads, soil conditions, local building regulations and environmental factors.</p>
                </div>
                <div class="process-step tilt-card">
                    <h3 class="process-step__title">3D Design</h3>
                    <p class="process-step__desc">Our architects create detailed architectural plans, floor layouts, elevations and a 3D model so you can visualise your home before construction begins.</p>
                </div>
                <div class="process-step tilt-card">
                    <h3 class="process-step__title">BOQ &amp; Quotation</h3>
                    <p class="process-step__desc">We prepare a detailed Bill of Quantities and a transparent cost breakdown. No hidden charges — you know exactly what you're paying for.</p>
                </div>
                <div class="process-step tilt-card">
                    <h3 class="process-step__title">Manufacturing</h3>
                    <p class="process-step__desc">All wooden components are manufactured in our controlled factory environment. Each piece is cut, treated and prepared to precise specifications.</p>
                </div>
                <div class="process-step tilt-card">
                    <h3 class="process-step__title">Transportation</h3>
                    <p class="process-step__desc">Finished components are carefully packed and transported to your site. We coordinate logistics to ensure safe, timely delivery anywhere in India.</p>
                </div>
                <div class="process-step tilt-card">
                    <h3 class="process-step__title">Installation</h3>
                    <p class="process-step__desc">Our experienced on-site team assembles the structure, installs roofing, doors, windows, insulation, electrical wiring and plumbing to complete the build.</p>
                </div>
                <div class="process-step tilt-card">
                    <h3 class="process-step__title">Finishing</h3>
                    <p class="process-step__desc">Exterior staining, interior finishing, painting, UV protection, flooring and all final touches are completed to deliver a move-in-ready home.</p>
                </div>
                <div class="process-step tilt-card">
                    <h3 class="process-step__title">Handover</h3>
                    <p class="process-step__desc">A final inspection walkthrough with you, followed by keys handover. We also provide a maintenance guide and after-care support documentation.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Materials & Technology -->
    <section class="section section--alt" id="materials">
        <div class="container">
            <div class="section__header reveal-up">
                <span class="section__label">Materials &amp; Technology</span>
                <h2 class="section__title">What Goes Into Your Wooden Home</h2>
                <p class="section__subtitle">Every element is carefully selected for performance, durability and beauty.</p>
            </div>
            <div class="materials-grid reveal-stagger">
                <div class="material-card tilt-card">
                    <div class="material-card__icon"><i class="fas fa-tree"></i></div>
                    <h3 class="material-card__title">Structural Wood</h3>
                    <p class="material-card__text">Premium pine and spruce sourced from managed forests in British Columbia and Scandinavia. PEFC &amp; FSC certified.</p>
                </div>
                <div class="material-card tilt-card">
                    <div class="material-card__icon"><i class="fas fa-layer-group"></i></div>
                    <h3 class="material-card__title">Exterior Cladding</h3>
                    <p class="material-card__text">Weather-resistant timber cladding with UV-protective stains for a lasting, beautiful exterior finish.</p>
                </div>
                <div class="material-card tilt-card">
                    <div class="material-card__icon"><i class="fas fa-snowflake"></i></div>
                    <h3 class="material-card__title">Insulation</h3>
                    <p class="material-card__text">High-performance thermal and acoustic insulation for year-round comfort and energy efficiency.</p>
                </div>
                <div class="material-card tilt-card">
                    <div class="material-card__icon"><i class="fas fa-home"></i></div>
                    <h3 class="material-card__title">Roofing</h3>
                    <p class="material-card__text">Architectural shingles, metal roofing or wooden shakes — selected based on climate and design preferences.</p>
                </div>
                <div class="material-card tilt-card">
                    <div class="material-card__icon"><i class="fas fa-door-open"></i></div>
                    <h3 class="material-card__title">Doors &amp; Windows</h3>
                    <p class="material-card__text">Custom wooden doors and double-glazed windows for thermal performance, security and aesthetics.</p>
                </div>
                <div class="material-card tilt-card">
                    <div class="material-card__icon"><i class="fas fa-tint"></i></div>
                    <h3 class="material-card__title">Waterproofing</h3>
                    <p class="material-card__text">Multi-layer waterproofing systems including membranes, sealants and treated wood to protect against moisture.</p>
                </div>
                <div class="material-card tilt-card">
                    <div class="material-card__icon"><i class="fas fa-bug"></i></div>
                    <h3 class="material-card__title">Termite Protection</h3>
                    <p class="material-card__text">Pressure-treated timber with anti-termite chemicals and physical barriers for long-term pest protection.</p>
                </div>
                <div class="material-card tilt-card">
                    <div class="material-card__icon"><i class="fas fa-plug"></i></div>
                    <h3 class="material-card__title">Electrical &amp; Plumbing</h3>
                    <p class="material-card__text">Complete MEP installation with concealed wiring, modern fixtures and efficient plumbing systems.</p>
                </div>
                <div class="material-card tilt-card">
                    <div class="material-card__icon"><i class="fas fa-paint-roller"></i></div>
                    <h3 class="material-card__title">Interior Finishing</h3>
                    <p class="material-card__text">Laminate flooring, wooden wall panels, cabinetry, painting and all finishing touches for a move-in-ready home.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="cta-banner section--dark">
        <div class="cta-banner__bg">
            <img src="https://images.unsplash.com/photo-1513584684374-8bab748fbf90?w=1920&q=60" alt="" loading="lazy">
        </div>
        <div class="container cta-banner__content">
            <h2 class="cta-banner__title">Start Your Project Today</h2>
            <p class="cta-banner__text">Every great home begins with a conversation. Let's discuss your vision and create something extraordinary.</p>
            <div class="cta-banner__actions">
                <a href="<?= url('pages/contact.php') ?>" class="btn btn--primary btn--lg btn-magnetic">Request a Free Consultation</a>
            </div>
        </div>
    </section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>