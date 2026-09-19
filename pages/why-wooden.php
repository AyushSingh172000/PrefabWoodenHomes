<?php
require_once __DIR__ . '/../includes/init.php';
$pageMeta = seoMeta(
    'Why Choose a Wooden Home?',
    'Discover the benefits of wooden homes — faster construction, energy efficiency, natural aesthetics, sustainability and more. Learn why wood is the smart choice.',
    'benefits of wooden homes, why wooden house, wooden house advantages, eco-friendly homes India, sustainable construction, wooden house benefits'
);
require_once __DIR__ . '/../includes/header.php';
?>

    <section class="page-banner">
        <div class="container reveal-up">
            <h1 class="page-banner__title">Why Wooden Homes</h1>
            <div class="page-banner__breadcrumb">
                <a href="<?= url() ?>">Home</a> &nbsp;/&nbsp; Why Wooden Homes
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="section__header reveal-up">
                <span class="section__label">The Case for Wood</span>
                <h2 class="section__title">Why Choose a Wooden Home?</h2>
                <p class="section__subtitle">Wooden homes offer a unique combination of beauty, performance and sustainability that no other building material can match.</p>
            </div>
            <div class="why-grid reveal-stagger">
                <div class="why-card tilt-card">
                    <div class="why-card__icon"><i class="fas fa-bolt"></i></div>
                    <div>
                        <h3 class="why-card__title">Faster Construction</h3>
                        <p class="why-card__text">Prefabricated wooden components are manufactured off-site and assembled in weeks rather than months. A standard cottage can be move-in ready in 8–12 weeks — a fraction of conventional construction time.</p>
                    </div>
                </div>
                <div class="why-card tilt-card">
                    <div class="why-card__icon"><i class="fas fa-thermometer-half"></i></div>
                    <div>
                        <h3 class="why-card__title">Energy Efficiency</h3>
                        <p class="why-card__text">Wood is a natural insulator — 15 times more efficient than masonry. Wooden homes stay warm in winters and cool in summers, reducing your reliance on artificial heating and cooling and lowering energy bills.</p>
                    </div>
                </div>
                <div class="why-card tilt-card">
                    <div class="why-card__icon"><i class="fas fa-mountain"></i></div>
                    <div>
                        <h3 class="why-card__title">Natural Aesthetics</h3>
                        <p class="why-card__text">The warmth, texture and character of natural wood creates an atmosphere that simply cannot be replicated with concrete or steel. Every wooden home has a unique, timeless beauty.</p>
                    </div>
                </div>
                <div class="why-card tilt-card">
                    <div class="why-card__icon"><i class="fas fa-pencil-ruler"></i></div>
                    <div>
                        <h3 class="why-card__title">Fully Customisable</h3>
                        <p class="why-card__text">Wood is one of the most versatile building materials. From floor plans to finishes, every element of a wooden home can be tailored to your exact specifications and lifestyle.</p>
                    </div>
                </div>
                <div class="why-card tilt-card">
                    <div class="why-card__icon"><i class="fas fa-feather"></i></div>
                    <div>
                        <h3 class="why-card__title">Lightweight Construction</h3>
                        <p class="why-card__text">Wooden structures are lighter than concrete, which means simpler and more cost-effective foundations, easier transportation to remote sites, and less structural load on the terrain.</p>
                    </div>
                </div>
                <div class="why-card tilt-card">
                    <div class="why-card__icon"><i class="fas fa-umbrella-beach"></i></div>
                    <div>
                        <h3 class="why-card__title">Perfect for Retreats</h3>
                        <p class="why-card__text">Wooden homes are ideally suited for farmhouses, resorts, hill stations and holiday retreats. They blend naturally with the landscape and create inviting, calming spaces.</p>
                    </div>
                </div>
                <div class="why-card tilt-card">
                    <div class="why-card__icon"><i class="fas fa-leaf"></i></div>
                    <div>
                        <h3 class="why-card__title">Sustainable &amp; Eco-Friendly</h3>
                        <p class="why-card__text">Wood is a renewable resource with the lowest carbon footprint of any major building material. Our timber is certified from managed forests, making your home a choice that's good for the planet.</p>
                    </div>
                </div>
                <div class="why-card tilt-card">
                    <div class="why-card__icon"><i class="fas fa-shield-alt"></i></div>
                    <div>
                        <h3 class="why-card__title">Durable &amp; Long-Lasting</h3>
                        <p class="why-card__text">With proper treatment and maintenance, a wooden home can last 100–150 years. Modern preservation techniques protect against moisture, UV, termites and fire.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="cta-banner section--dark">
        <div class="cta-banner__bg">
            <img src="https://images.unsplash.com/photo-1449158743715-0a90ebb6d2d8?w=1920&q=60" alt="" loading="lazy">
        </div>
        <div class="container cta-banner__content">
            <h2 class="cta-banner__title">Convinced? Let's Get Started.</h2>
            <p class="cta-banner__text">Your dream wooden home is closer than you think. Talk to our team today and take the first step.</p>
            <div class="cta-banner__actions">
                <a href="<?= url('pages/contact.php') ?>" class="btn btn--primary btn--lg btn-magnetic">Get a Free Quote</a>
                <a href="https://wa.me/<?= CONTACT_WHATSAPP ?>" class="btn btn--outline btn--lg" target="_blank" rel="noopener">
                    <i class="fab fa-whatsapp"></i> WhatsApp Us
                </a>
            </div>
        </div>
    </section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>