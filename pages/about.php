<?php
require_once __DIR__ . '/../includes/init.php';
$pageMeta = seoMeta(
    'About Us — Our Story',
    'Learn about Prefab Wooden Homes — 15+ years of experience in wooden house construction across India. Founded by Aman Jha, we design, manufacture and construct premium wooden homes.',
    'prefab wooden homes about, wooden house company India, Aman Jha wooden homes, wooden house manufacturer'
);
require_once __DIR__ . '/../includes/header.php';
?>

    <section class="page-banner">
        <div class="container reveal-up">
            <h1 class="page-banner__title">About Us</h1>
            <div class="page-banner__breadcrumb">
                <a href="<?= url() ?>">Home</a> &nbsp;/&nbsp; About Us
            </div>
        </div>
    </section>

    <!-- Founder & Story -->
    <section class="section">
        <div class="container">
            <div class="about-grid">
                <div class="about-img reveal-up">
                    <img src="https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=600&q=80" alt="Prefab Wooden Homes workshop" loading="lazy">
                </div>
                <div class="about-text reveal-up">
                    <span class="about-text__label">Our Story</span>
                    <h2 class="about-text__title">Crafting Wooden Homes Since 2008</h2>
                    <p>Prefab Wooden Homes is one of India's leading manufacturers of eco-friendly wooden houses, specialising in customisable log homes and timber frame buildings. Founded by Mr. Aman Jha, we have grown from a passion for sustainable living into a company that has delivered over 25 successful projects across the country.</p>
                    <p>We plan to deliver the most eco-friendly and elegant wooden house designs that can be customised according to our customers' exact requirements, while giving the utmost importance to the environment and its resources.</p>
                    <p>Our wood is sourced directly from the managed forests of British Columbia and Scandinavian countries, and is PEFC and FSC certified — ensuring responsible forestry and premium quality in every log.</p>
                    <div class="mt-8">
                        <a href="<?= url('pages/contact.php') ?>" class="btn btn--primary btn-magnetic">Start Your Project</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats -->
    <section class="section section--dark">
        <div class="container">
            <div class="stats-row reveal-stagger">
                <div class="stat-item tilt-card">
                    <div class="stat-item__value" data-counter="15">15+</div>
                    <div class="stat-item__label">Years of Experience</div>
                </div>
                <div class="stat-item tilt-card">
                    <div class="stat-item__value" data-counter="25">25+</div>
                    <div class="stat-item__label">Projects Delivered</div>
                </div>
                <div class="stat-item tilt-card">
                    <div class="stat-item__value">Pan-India</div>
                    <div class="stat-item__label">Project Reach</div>
                </div>
                <div class="stat-item tilt-card">
                    <div class="stat-item__value" data-counter="100">100%</div>
                    <div class="stat-item__label">Customisable Designs</div>
                </div>
            </div>
        </div>
    </section>

    <!-- What We Offer -->
    <section class="section">
        <div class="container">
            <div class="section__header reveal-up">
                <span class="section__label">End-to-End Service</span>
                <h2 class="section__title">Design. Manufacture. Construct.</h2>
                <p class="section__subtitle">We handle every stage of your wooden home project — from the first architectural sketch to the final handover and beyond.</p>
            </div>
            <div class="benefits-grid reveal-stagger">
                <div class="benefit-card tilt-card">
                    <div class="benefit-card__icon"><i class="fas fa-drafting-compass"></i></div>
                    <h3 class="benefit-card__title">3D Design &amp; Modelling</h3>
                    <p class="benefit-card__text">Our skilled architects create detailed 3D designs and blueprints, allowing you to visualise your home before construction begins. Every design is customised to your preferences.</p>
                </div>
                <div class="benefit-card tilt-card">
                    <div class="benefit-card__icon"><i class="fas fa-industry"></i></div>
                    <h3 class="benefit-card__title">Factory Manufacturing</h3>
                    <p class="benefit-card__text">All components are manufactured in a controlled factory environment, ensuring precision, consistency and protection from weather damage during production.</p>
                </div>
                <div class="benefit-card tilt-card">
                    <div class="benefit-card__icon"><i class="fas fa-hard-hat"></i></div>
                    <h3 class="benefit-card__title">On-Site Construction</h3>
                    <p class="benefit-card__text">Our experienced teams transport and assemble your home on-site. Pre-fabricated components mean faster assembly, less waste and minimal site disturbance.</p>
                </div>
                <div class="benefit-card tilt-card">
                    <div class="benefit-card__icon"><i class="fas fa-tools"></i></div>
                    <h3 class="benefit-card__title">Maintenance &amp; After-Care</h3>
                    <p class="benefit-card__text">We provide comprehensive maintenance services including re-staining, waxing, UV protection, roofing shingle replacement and caulking to keep your home in top condition.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Products -->
    <section class="section section--alt">
        <div class="container">
            <div class="section__header reveal-up">
                <span class="section__label">What We Build</span>
                <h2 class="section__title">Our Product Range</h2>
                <p class="section__subtitle">We deliver high-quality wooden structures ranging from small custom builds to magnificent, luxurious hospitality projects.</p>
            </div>
            <div class="materials-grid reveal-stagger">
                <div class="material-card tilt-card">
                    <div class="material-card__icon"><i class="fas fa-home"></i></div>
                    <h3 class="material-card__title">Residential Houses</h3>
                    <p class="material-card__text">Log homes, timber frame houses, and A-frame designs for permanent living.</p>
                </div>
                <div class="material-card tilt-card">
                    <div class="material-card__icon"><i class="fas fa-hotel"></i></div>
                    <h3 class="material-card__title">Resorts &amp; Hotels</h3>
                    <p class="material-card__text">Wooden resort cottages, beach houses and hospitality structures.</p>
                </div>
                <div class="material-card tilt-card">
                    <div class="material-card__icon"><i class="fas fa-store"></i></div>
                    <h3 class="material-card__title">Bars &amp; Restaurants</h3>
                    <p class="material-card__text">Custom wooden bars, restaurant structures and outdoor dining spaces.</p>
                </div>
                <div class="material-card tilt-card">
                    <div class="material-card__icon"><i class="fas fa-umbrella-beach"></i></div>
                    <h3 class="material-card__title">Gazebos &amp; Pergolas</h3>
                    <p class="material-card__text">Modern gazebo designs, pergola rooftops and pool-side structures.</p>
                </div>
                <div class="material-card tilt-card">
                    <div class="material-card__icon"><i class="fas fa-tree"></i></div>
                    <h3 class="material-card__title">Tree Houses</h3>
                    <p class="material-card__text">Elevated woodland retreats and adventure tree houses for resorts.</p>
                </div>
                <div class="material-card tilt-card">
                    <div class="material-card__icon"><i class="fas fa-paw"></i></div>
                    <h3 class="material-card__title">Pet Houses</h3>
                    <p class="material-card__text">Custom wooden houses for dogs, cats and small animals.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta-banner section--dark">
        <div class="cta-banner__bg">
            <img src="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=1920&q=60" alt="Wooden home" loading="lazy">
        </div>
        <div class="container cta-banner__content">
            <h2 class="cta-banner__title">Let's Build Something Beautiful Together</h2>
            <p class="cta-banner__text">Share your wooden home ideas with us and we will transform them into reality. Our door is always open for a good conversation.</p>
            <div class="cta-banner__actions">
                <a href="<?= url('pages/contact.php') ?>" class="btn btn--primary btn--lg btn-magnetic">Get a Free Quote</a>
                <a href="https://wa.me/<?= CONTACT_WHATSAPP ?>" class="btn btn--outline btn--lg" target="_blank" rel="noopener">
                    <i class="fab fa-whatsapp"></i> Chat on WhatsApp
                </a>
            </div>
        </div>
    </section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>