<?php
require_once __DIR__ . '/../includes/init.php';
$pageMeta = seoMeta(
    'Our Projects — Wooden Home Portfolio',
    'Browse our portfolio of completed wooden home projects across India — farmhouses, cottages, resort cottages, villas and more.',
    'wooden house projects India, prefab home portfolio, wooden cottage project, wooden farmhouse gallery'
);
require_once __DIR__ . '/../includes/header.php';
?>

    <section class="page-banner">
        <div class="container reveal-up">
            <h1 class="page-banner__title">Our Projects</h1>
            <div class="page-banner__breadcrumb">
                <a href="<?= url() ?>">Home</a> &nbsp;/&nbsp; Projects
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="section__header reveal-up">
                <span class="section__label">Portfolio</span>
                <h2 class="section__title">Our Work Speaks for Itself</h2>
                <p class="section__subtitle">Our award-winning team transforms dreams into reality. Explore some of our finest wooden home constructions across India.</p>
            </div>

            <!-- Interactive Project Filter Bar -->
            <div class="filter-bar reveal-up" data-filter-group="projects">
                <button class="filter-pill active" data-filter="all">
                    <span>All Projects</span>
                    <span class="filter-pill__count">6</span>
                </button>
                <button class="filter-pill" data-filter="resort">
                    <span>Resort Stays</span>
                    <span class="filter-pill__count">2</span>
                </button>
                <button class="filter-pill" data-filter="cottage">
                    <span>Cottages &amp; Cabins</span>
                    <span class="filter-pill__count">1</span>
                </button>
                <button class="filter-pill" data-filter="farmhouse">
                    <span>Farmhouses</span>
                    <span class="filter-pill__count">1</span>
                </button>
                <button class="filter-pill" data-filter="villa">
                    <span>Luxury Villas</span>
                    <span class="filter-pill__count">1</span>
                </button>
                <button class="filter-pill" data-filter="aframe">
                    <span>A-Frame</span>
                    <span class="filter-pill__count">1</span>
                </button>
            </div>

            <div class="projects-grid reveal-stagger" id="projectsGrid">
                <div class="project-card tilt-card" data-category="resort">
                    <img class="project-card__img" src="https://images.unsplash.com/photo-1542718610-a1d656d1884c?w=600&q=75" alt="Mountain Resort Cottage" loading="lazy">
                    <div class="project-card__body">
                        <span class="project-card__tag">Resort Cottage</span>
                        <h3 class="project-card__title">Mountain Resort Cottage</h3>
                        <div class="project-card__meta">
                            <span><i class="fas fa-map-marker-alt"></i> Manali, HP</span>
                            <span><i class="fas fa-ruler-combined"></i> 1,200 sq ft</span>
                        </div>
                        <p style="margin-top: var(--space-3); font-size: var(--text-sm); color: var(--color-text-muted);">A cluster of three resort cottages built with imported pine logs, designed for year-round mountain hospitality.</p>
                        <div class="project-card__cta">
                            <span class="btn btn--sm btn--primary">View Architecture <i class="fas fa-arrow-right"></i></span>
                        </div>
                    </div>
                </div>

                <div class="project-card tilt-card" data-category="farmhouse">
                    <img class="project-card__img" src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=600&q=75" alt="Premium Farmhouse" loading="lazy">
                    <div class="project-card__body">
                        <span class="project-card__tag">Farmhouse</span>
                        <h3 class="project-card__title">Premium Wooden Farmhouse</h3>
                        <div class="project-card__meta">
                            <span><i class="fas fa-map-marker-alt"></i> Lonavala, Maharashtra</span>
                            <span><i class="fas fa-ruler-combined"></i> 2,500 sq ft</span>
                        </div>
                        <p style="margin-top: var(--space-3); font-size: var(--text-sm); color: var(--color-text-muted);">A European-style wooden farmhouse with wrap-around veranda, built on a 2-acre plot with panoramic valley views.</p>
                        <div class="project-card__cta">
                            <span class="btn btn--sm btn--primary">View Architecture <i class="fas fa-arrow-right"></i></span>
                        </div>
                    </div>
                </div>

                <div class="project-card tilt-card" data-category="villa">
                    <img class="project-card__img" src="https://images.unsplash.com/photo-1588880331179-bc9b93a8cb5e?w=600&q=75" alt="Timber Villa" loading="lazy">
                    <div class="project-card__body">
                        <span class="project-card__tag">Villa</span>
                        <h3 class="project-card__title">Luxury Timber Villa</h3>
                        <div class="project-card__meta">
                            <span><i class="fas fa-map-marker-alt"></i> Goa</span>
                            <span><i class="fas fa-ruler-combined"></i> 3,200 sq ft</span>
                        </div>
                        <p style="margin-top: var(--space-3); font-size: var(--text-sm); color: var(--color-text-muted);">A premium two-storey timber villa with high ceilings, open-plan living areas and an outdoor deck overlooking a tropical garden.</p>
                        <div class="project-card__cta">
                            <span class="btn btn--sm btn--primary">View Architecture <i class="fas fa-arrow-right"></i></span>
                        </div>
                    </div>
                </div>

                <div class="project-card tilt-card" data-category="cottage">
                    <img class="project-card__img" src="https://images.unsplash.com/photo-1510798831971-661eb04b3739?w=600&q=75" alt="Hill Station Cottage" loading="lazy">
                    <div class="project-card__body">
                        <span class="project-card__tag">Cottage</span>
                        <h3 class="project-card__title">Hill Station Log Cabin</h3>
                        <div class="project-card__meta">
                            <span><i class="fas fa-map-marker-alt"></i> Shimla, HP</span>
                            <span><i class="fas fa-ruler-combined"></i> 800 sq ft</span>
                        </div>
                        <p style="margin-top: var(--space-3); font-size: var(--text-sm); color: var(--color-text-muted);">A cosy log cabin retreat in the Shimla hills, designed as a weekend getaway with traditional notch-corner log construction.</p>
                        <div class="project-card__cta">
                            <span class="btn btn--sm btn--primary">View Architecture <i class="fas fa-arrow-right"></i></span>
                        </div>
                    </div>
                </div>

                <div class="project-card tilt-card" data-category="resort">
                    <img class="project-card__img" src="https://images.unsplash.com/photo-1587061949409-02df41d5e562?w=600&q=75" alt="Eco Resort" loading="lazy">
                    <div class="project-card__body">
                        <span class="project-card__tag">Resort</span>
                        <h3 class="project-card__title">Eco Resort Cluster</h3>
                        <div class="project-card__meta">
                            <span><i class="fas fa-map-marker-alt"></i> Wayanad, Kerala</span>
                            <span><i class="fas fa-ruler-combined"></i> 6 units</span>
                        </div>
                        <p style="margin-top: var(--space-3); font-size: var(--text-sm); color: var(--color-text-muted);">Six eco-friendly wooden cottages built for a boutique resort, blending into the rainforest canopy with minimal environmental impact.</p>
                        <div class="project-card__cta">
                            <span class="btn btn--sm btn--primary">View Architecture <i class="fas fa-arrow-right"></i></span>
                        </div>
                    </div>
                </div>

                <div class="project-card tilt-card" data-category="aframe">
                    <img class="project-card__img" src="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=600&q=75" alt="A-Frame Cabin" loading="lazy">
                    <div class="project-card__body">
                        <span class="project-card__tag">A-Frame</span>
                        <h3 class="project-card__title">A-Frame Mountain Cabin</h3>
                        <div class="project-card__meta">
                            <span><i class="fas fa-map-marker-alt"></i> Mussoorie, Uttarakhand</span>
                            <span><i class="fas fa-ruler-combined"></i> 1,000 sq ft</span>
                        </div>
                        <p style="margin-top: var(--space-3); font-size: var(--text-sm); color: var(--color-text-muted);">A striking A-frame design with floor-to-ceiling glass and a loft bedroom, ideal for snow-prone mountain locations.</p>
                        <div class="project-card__cta">
                            <span class="btn btn--sm btn--primary">View Architecture <i class="fas fa-arrow-right"></i></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-8 reveal-up">
                <a href="<?= url('pages/contact.php') ?>" class="btn btn--primary btn--lg btn-magnetic">Discuss Your Project</a>
            </div>
        </div>
    </section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>