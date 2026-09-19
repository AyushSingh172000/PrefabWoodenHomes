<?php
require_once __DIR__ . '/../includes/init.php';
$pageMeta = seoMeta(
    'Our Projects — Wooden Home Portfolio',
    'Browse our portfolio of completed wooden home projects across India — farmhouses, cottages, resort cottages, villas and more.',
    'wooden house projects India, prefab home portfolio, wooden cottage project, wooden farmhouse gallery'
);
require_once __DIR__ . '/../includes/header.php';
?>

<?php
// Load dynamic projects from database
$dbProjects = [];
$counts = ['all' => 0, 'resort' => 0, 'cottage' => 0, 'farmhouse' => 0, 'villa' => 0, 'aframe' => 0];

try {
    require_once __DIR__ . '/../config/database.php';
    $db = Database::getConnection();
    $dbProjects = $db->query("SELECT * FROM projects WHERE is_active = 1 ORDER BY sort_order ASC, created_at DESC")->fetchAll();
    if (!empty($dbProjects)) {
        $counts['all'] = count($dbProjects);
        foreach ($dbProjects as $p) {
            $cat = $p['project_type'];
            $counts[$cat] = ($counts[$cat] ?? 0) + 1;
        }
    }
} catch (\Throwable $e) {
    $dbProjects = [];
}
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
                    <span class="filter-pill__count"><?= $counts['all'] ?: 6 ?></span>
                </button>
                <button class="filter-pill" data-filter="resort">
                    <span>Resort Stays</span>
                    <span class="filter-pill__count"><?= $counts['resort'] ?? 2 ?></span>
                </button>
                <button class="filter-pill" data-filter="cottage">
                    <span>Cottages &amp; Cabins</span>
                    <span class="filter-pill__count"><?= $counts['cottage'] ?? 1 ?></span>
                </button>
                <button class="filter-pill" data-filter="farmhouse">
                    <span>Farmhouses</span>
                    <span class="filter-pill__count"><?= $counts['farmhouse'] ?? 1 ?></span>
                </button>
                <button class="filter-pill" data-filter="villa">
                    <span>Luxury Villas</span>
                    <span class="filter-pill__count"><?= $counts['villa'] ?? 1 ?></span>
                </button>
                <button class="filter-pill" data-filter="aframe">
                    <span>A-Frame</span>
                    <span class="filter-pill__count"><?= $counts['aframe'] ?? 1 ?></span>
                </button>
            </div>

            <div class="projects-grid reveal-stagger" id="projectsGrid">
                <?php if (!empty($dbProjects)): ?>
                    <?php foreach ($dbProjects as $proj): ?>
                        <div class="project-card tilt-card" data-category="<?= htmlspecialchars($proj['project_type']) ?>">
                            <img class="project-card__img" src="<?= htmlspecialchars($proj['image_primary'] ?: asset('images/logo.jpeg')) ?>" alt="<?= htmlspecialchars($proj['title']) ?>" loading="lazy">
                            <div class="project-card__body">
                                <span class="project-card__tag"><?= htmlspecialchars(ucwords(str_replace('-', ' ', $proj['project_type']))) ?></span>
                                <h3 class="project-card__title"><?= htmlspecialchars($proj['title']) ?></h3>
                                <div class="project-card__meta">
                                    <?php if (!empty($proj['location'])): ?>
                                        <span><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($proj['location']) ?></span>
                                    <?php endif; ?>
                                    <?php if (!empty($proj['built_area'])): ?>
                                        <span><i class="fas fa-ruler-combined"></i> <?= htmlspecialchars($proj['built_area']) ?></span>
                                    <?php endif; ?>
                                </div>
                                <?php if (!empty($proj['description'])): ?>
                                    <p style="margin-top: var(--space-3); font-size: var(--text-sm); color: var(--color-text-muted);">
                                        <?= htmlspecialchars($proj['description']) ?>
                                    </p>
                                <?php endif; ?>
                                <div class="project-card__cta">
                                    <a href="<?= url('pages/contact.php') ?>" class="btn btn--sm btn--primary">Inquire About This <i class="fas fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Fallback Static Items if Database is empty -->
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
                                <a href="<?= url('pages/contact.php') ?>" class="btn btn--sm btn--primary">View Architecture <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="text-center mt-8 reveal-up">
                <a href="<?= url('pages/contact.php') ?>" class="btn btn--primary btn--lg btn-magnetic">Discuss Your Project</a>
            </div>
        </div>
    </section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>