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

    <?php
    $servicesList = getActiveServices();
    if (!empty($servicesList)):
        foreach ($servicesList as $idx => $service):
            $imgSrc = $service['image'] ?? '';
            if (empty($imgSrc)) {
                $imgSrc = 'https://images.unsplash.com/photo-1449158743715-0a90ebb6d2d8?w=700&q=80';
            } elseif (!preg_match('#^https?://#i', $imgSrc)) {
                $imgSrc = asset($imgSrc);
            }
            $features = array_filter(array_map('trim', explode("\n", (string)($service['features'] ?? ''))));
            $isReverse = ($idx % 2 === 1) ? 'construction-grid--reverse' : '';
    ?>
    <div id="<?= htmlspecialchars($service['slug']) ?>" class="construction-section">
        <div class="container">
            <div class="construction-grid <?= $isReverse ?> reveal-up">
                <div class="construction-img tilt-card">
                    <img src="<?= htmlspecialchars($imgSrc) ?>" alt="<?= htmlspecialchars($service['title']) ?>" loading="lazy">
                </div>
                <div class="construction-text">
                    <h2 class="construction-text__title"><?= htmlspecialchars($service['title']) ?></h2>
                    <?php if (!empty($service['subtitle'])): ?>
                        <p style="font-weight: 600; color: var(--color-gold, #c89d5c); margin-top: -0.25rem; margin-bottom: 0.8rem;"><?= htmlspecialchars($service['subtitle']) ?></p>
                    <?php endif; ?>
                    
                    <?php if (!empty($service['description'])): ?>
                        <p><?= nl2br(htmlspecialchars($service['description'])) ?></p>
                    <?php endif; ?>

                    <?php if (!empty($features)): ?>
                        <ul>
                            <?php foreach ($features as $feat): ?>
                                <li><?= htmlspecialchars($feat) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

                    <a href="<?= url('pages/contact.php') ?>" class="btn btn--primary btn-magnetic">Enquire About <?= htmlspecialchars($service['title']) ?></a>
                </div>
            </div>
        </div>
    </div>
    <?php 
        endforeach;
    else: 
    ?>
    <div class="container py-5 text-center">
        <p>No construction types are currently listed. Please check back shortly.</p>
    </div>
    <?php endif; ?>

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