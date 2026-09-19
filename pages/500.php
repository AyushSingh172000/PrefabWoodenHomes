<?php
http_response_code(500);
$page_title = "Server Error";
$page_description = "Something went wrong. Please try again or contact us directly.";
$page_keywords = "wooden homes, server error";
$current_page = "500";
require_once __DIR__ . '/../includes/init.php';
$pageMeta = seoMeta(
    'Server Error — 500',
    'We are experiencing a temporary issue. Please contact us directly for immediate assistance.',
    'wooden homes 500, server error'
);
require_once __DIR__ . '/../includes/header.php';
?>

<section class="page-banner" style="min-height: 70vh; display: flex; align-items: center; justify-content: center; text-align: center;">
    <div class="container reveal-up">
        <div style="max-width: 620px; margin: 0 auto;">
            <h1 style="font-size: clamp(4.5rem, 12vw, 8.5rem); font-family: var(--font-display); color: var(--color-gold); margin-bottom: 0.15em; line-height: 1;">500</h1>
            <h2 style="font-size: clamp(1.5rem, 3.5vw, 2.25rem); font-family: var(--font-display); margin-bottom: 0.75em; color: var(--color-cream);">Unexpected Interruption</h2>
            <p style="color: rgba(251, 248, 243, 0.75); margin-bottom: 1rem; font-size: var(--text-lg); line-height: 1.6;">
                We are experiencing a temporary system delay. Please try refreshing or reach our team directly.
            </p>
            <p style="color: var(--color-gold); margin-bottom: 2rem; font-weight: 600;">
                Direct Line: <a href="tel:<?= formatPhoneLink(CONTACT_PHONE_AMAN) ?>" style="color: var(--color-gold); text-decoration: underline;"><?= CONTACT_PHONE_AMAN ?></a>
            </p>
            <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                <a href="<?= url() ?>" class="btn btn--primary btn-magnetic">Return Home</a>
                <a href="https://wa.me/<?= CONTACT_WHATSAPP ?>" class="btn btn--outline btn-magnetic" target="_blank" rel="noopener">WhatsApp Us</a>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>