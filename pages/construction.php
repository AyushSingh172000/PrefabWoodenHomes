<?php
require_once __DIR__ . '/../includes/init.php';
$pageMeta = seoMeta(
    'Wooden House Construction in India',
    'Explore our range of wooden home construction — prefab houses, cottages, farmhouses, villas, stilt houses, resort cottages and tree houses. Premium construction across India.',
    'wooden house construction India, prefab wooden houses, wooden cottages, wooden farmhouse construction, wooden villas India, wooden stilt houses, resort cottages, tree houses India'
);
require_once __DIR__ . '/../includes/header.php';
?>

    <section class="page-banner">
        <div class="container reveal-up">
            <h1 class="page-banner__title">Wooden House Construction</h1>
            <div class="page-banner__breadcrumb">
                <a href="<?= url() ?>">Home</a> &nbsp;/&nbsp; Construction
            </div>
        </div>
    </section>

    <div id="prefab-houses" class="construction-section">
        <div class="container">
            <div class="construction-grid reveal-up">
                <div class="construction-img tilt-card">
                    <img src="https://images.unsplash.com/photo-1449158743715-0a90ebb6d2d8?w=700&q=80" alt="Prefab Wooden Houses" loading="lazy">
                </div>
                <div class="construction-text">
                    <h2 class="construction-text__title">Prefab Wooden Houses</h2>
                    <p>Prefabricated wooden homes are designed and manufactured off-site in a controlled factory environment, then transported and assembled at your chosen location. This method ensures consistent quality, reduced waste and significantly faster construction timelines compared to traditional building.</p>
                    <p>Our prefab homes range from compact single-bedroom cottages to spacious family residences, all fully customisable in layout, design and finish.</p>
                    <ul>
                        <li>Factory-built precision with on-site assembly</li>
                        <li>Move-in ready in 8–12 weeks</li>
                        <li>Fully customisable floor plans and interiors</li>
                        <li>Transportable to any location across India</li>
                    </ul>
                    <a href="<?= url('pages/contact.php') ?>" class="btn btn--primary btn-magnetic">Enquire About Prefab Homes</a>
                </div>
            </div>
        </div>
    </div>

    <div id="cottages" class="construction-section">
        <div class="container">
            <div class="construction-grid construction-grid--reverse reveal-up">
                <div class="construction-img tilt-card">
                    <img src="https://images.unsplash.com/photo-1510798831971-661eb04b3739?w=700&q=80" alt="Wooden Cottages" loading="lazy">
                </div>
                <div class="construction-text">
                    <h2 class="construction-text__title">Wooden Cottages</h2>
                    <p>Our wooden cottages are charming, compact structures that blend beautifully with natural surroundings. Whether nestled in the hills, by a lake, or on a farm, these cottages offer a cosy retreat with modern comforts.</p>
                    <p>Built with premium imported pine and engineered to handle India's diverse climatic conditions, our cottages are both beautiful and practical.</p>
                    <ul>
                        <li>Ideal for hill stations, farms and weekend getaways</li>
                        <li>Compact yet comfortable living spaces</li>
                        <li>Designed for Indian weather conditions</li>
                        <li>Log and timber frame construction options</li>
                    </ul>
                    <a href="<?= url('pages/contact.php') ?>" class="btn btn--primary btn-magnetic">Enquire About Cottages</a>
                </div>
            </div>
        </div>
    </div>

    <div id="farmhouses" class="construction-section">
        <div class="container">
            <div class="construction-grid reveal-up">
                <div class="construction-img tilt-card">
                    <img src="https://images.unsplash.com/photo-1564013799919-ab600027ffc6?w=700&q=80" alt="Wooden Farmhouses" loading="lazy">
                </div>
                <div class="construction-text">
                    <h2 class="construction-text__title">Wooden Farmhouses</h2>
                    <p>A wooden farmhouse is the ultimate expression of country living — spacious, elegant and deeply connected to nature. Our farmhouse designs combine European chalet aesthetics with practical features suited to Indian farmland and climate.</p>
                    <ul>
                        <li>Expansive layouts with open-plan living areas</li>
                        <li>Wrap-around verandas and terraces</li>
                        <li>Suitable for large farm plots across India</li>
                        <li>Premium wood with complete waterproofing and termite treatment</li>
                    </ul>
                    <a href="<?= url('pages/contact.php') ?>" class="btn btn--primary btn-magnetic">Enquire About Farmhouses</a>
                </div>
            </div>
        </div>
    </div>

    <div id="villas" class="construction-section">
        <div class="container">
            <div class="construction-grid construction-grid--reverse reveal-up">
                <div class="construction-img tilt-card">
                    <img src="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=700&q=80" alt="Wooden Villas" loading="lazy">
                </div>
                <div class="construction-text">
                    <h2 class="construction-text__title">Wooden Villas</h2>
                    <p>Our wooden villas are luxury timber residences designed for those who want the finest in wooden architecture. With high ceilings, premium finishes and intelligent use of natural light, these homes are a statement of refined living.</p>
                    <ul>
                        <li>Luxury specifications and premium finishes</li>
                        <li>Multi-level designs with panoramic views</li>
                        <li>Ideal for resort locations and premium residential plots</li>
                        <li>Complete interior and exterior design packages</li>
                    </ul>
                    <a href="<?= url('pages/contact.php') ?>" class="btn btn--primary btn-magnetic">Enquire About Villas</a>
                </div>
            </div>
        </div>
    </div>

    <div id="stilt-houses" class="construction-section">
        <div class="container">
            <div class="construction-grid reveal-up">
                <div class="construction-img tilt-card">
                    <img src="https://images.unsplash.com/photo-1499793983690-e29da59ef1c2?w=700&q=80" alt="Wooden Stilt Houses" loading="lazy">
                </div>
                <div class="construction-text">
                    <h2 class="construction-text__title">Wooden Stilt Houses</h2>
                    <p>Stilt houses are elevated on sturdy wooden or steel stilts, making them ideal for flood-prone areas, waterfront properties, sloped terrain and beach locations. These structures are both functional and architecturally striking.</p>
                    <ul>
                        <li>Elevated foundation for flood and moisture protection</li>
                        <li>Perfect for beach, lakefront and hillside locations</li>
                        <li>Under-house space for parking or storage</li>
                        <li>Engineered for structural stability and longevity</li>
                    </ul>
                    <a href="<?= url('pages/contact.php') ?>" class="btn btn--primary btn-magnetic">Enquire About Stilt Houses</a>
                </div>
            </div>
        </div>
    </div>

    <div id="resort-cottages" class="construction-section">
        <div class="container">
            <div class="construction-grid construction-grid--reverse reveal-up">
                <div class="construction-img tilt-card">
                    <img src="https://images.unsplash.com/photo-1587061949409-02df41d5e562?w=700&q=80" alt="Resort Cottages" loading="lazy">
                </div>
                <div class="construction-text">
                    <h2 class="construction-text__title">Wooden Resort Cottages</h2>
                    <p>Purpose-built for the hospitality industry, our resort cottages combine the warmth of wood with the durability and practicality that commercial operations demand. We have delivered resort projects across multiple Indian states.</p>
                    <ul>
                        <li>Hospitality-grade specifications and durability</li>
                        <li>Designed for guest comfort and operational efficiency</li>
                        <li>Multiple unit configurations for resort clusters</li>
                        <li>Full project management from design to handover</li>
                    </ul>
                    <a href="<?= url('pages/contact.php') ?>" class="btn btn--primary btn-magnetic">Enquire About Resort Cottages</a>
                </div>
            </div>
        </div>
    </div>

    <div id="tree-houses" class="construction-section">
        <div class="container">
            <div class="construction-grid reveal-up">
                <div class="construction-img tilt-card">
                    <img src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=700&q=80" alt="Tree Houses" loading="lazy">
                </div>
                <div class="construction-text">
                    <h2 class="construction-text__title">Wooden Tree Houses</h2>
                    <p>Tree houses are one of the most exciting and visually captivating wooden structures we build. These elevated retreats are popular with resorts, adventure parks and private estates looking for something truly unique.</p>
                    <ul>
                        <li>Elevated platforms with tree-integrated designs</li>
                        <li>Safe, structurally engineered construction</li>
                        <li>Ideal for resorts, eco-tourism and private estates</li>
                        <li>Custom designs to suit the site's trees and terrain</li>
                    </ul>
                    <a href="<?= url('pages/contact.php') ?>" class="btn btn--primary btn-magnetic">Enquire About Tree Houses</a>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA -->
    <section class="cta-banner section--dark">
        <div class="cta-banner__bg">
            <img src="https://images.unsplash.com/photo-1513584684374-8bab748fbf90?w=1920&q=60" alt="" loading="lazy">
        </div>
        <div class="container cta-banner__content">
            <h2 class="cta-banner__title">Not Sure Which Type Suits You?</h2>
            <p class="cta-banner__text">Our team will guide you to the right construction type based on your site, budget and vision. Let's talk.</p>
            <div class="cta-banner__actions">
                <a href="<?= url('pages/contact.php') ?>" class="btn btn--primary btn--lg btn-magnetic">Get a Free Consultation</a>
            </div>
        </div>
    </section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>