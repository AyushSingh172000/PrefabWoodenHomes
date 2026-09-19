<?php
http_response_code(404);
$page_title = "Page Not Found";
$page_description = "The page you're looking for doesn't exist. Explore our premium wooden home construction services.";
$page_keywords = "wooden homes, page not found";
$current_page = "404";
require_once __DIR__ . '/../includes/init.php';
$pageMeta = seoMeta(
    'Page Not Found — 404',
    'The page you are looking for does not exist. Explore our premium wooden home construction services across India.',
    'wooden homes 404, page not found'
);
require_once __DIR__ . '/../includes/header.php';
?>

<section class="page-banner" style="min-height: 70vh; display: flex; align-items: center; justify-content: center; text-align: center;">
    <div class="container reveal-up">
        <div style="max-width: 620px; margin: 0 auto;">
            <h1 style="font-size: clamp(4.5rem, 12vw, 8.5rem); font-family: var(--font-display); color: var(--color-gold); margin-bottom: 0.15em; line-height: 1;">404</h1>
            <h2 style="font-size: clamp(1.5rem, 3.5vw, 2.25rem); font-family: var(--font-display); margin-bottom: 0.75em; color: var(--color-cream);">Sanctuary Not Found</h2>
            <p style="color: rgba(251, 248, 243, 0.75); margin-bottom: 2rem; font-size: var(--text-lg); line-height: 1.6;">
                The pathway you were exploring seems to have shifted into the woods. Let us guide you back to our living spaces.
            </p>
            <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                <a href="<?= url() ?>" class="btn btn--primary btn-magnetic">Return Home</a>
                <a href="<?= url('pages/contact.php') ?>" class="btn btn--outline btn-magnetic">Contact Us</a>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>