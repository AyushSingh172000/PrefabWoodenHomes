<?php
require_once __DIR__ . '/init.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php echo $pageMeta ?? seoMeta('Premium Wooden Homes', SITE_DESCRIPTION); ?>
    <link rel="icon" type="image/png" href="<?= htmlspecialchars(getSetting('site_favicon', asset('images/favicon.png'))) ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
    <?php echo businessSchema(); ?>
</head>
<body>
    <!-- Skip Navigation -->
    <a href="#main-content" class="skip-link">Skip to main content</a>

    <!-- Main Navigation -->
    <header class="header" id="header">
        <div class="container header__inner">
            <a href="<?= url() ?>" class="header__logo" aria-label="<?= htmlspecialchars(getSetting('site_name', SITE_NAME)) ?> - Home">
                <img src="<?= htmlspecialchars(getSetting('site_logo', asset('images/logo.jpeg'))) ?>" alt="<?= htmlspecialchars(getSetting('site_name', SITE_NAME)) ?> Logo" class="header__logo-img">
                <span class="logo-text">
                    <span class="logo-text__name"><?= htmlspecialchars(getSetting('site_name', SITE_NAME)) ?></span>
                    <span class="logo-text__tagline"><?= htmlspecialchars(getSetting('site_tagline', SITE_TAGLINE)) ?></span>
                </span>
            </a>

            <nav class="nav" id="mainNav" aria-label="Main navigation">
                <ul class="nav__list">
                    <li><a href="<?= url() ?>" class="nav__link <?= isActivePage('home') ?>">Home</a></li>
                    <li><a href="<?= url('pages/about.php') ?>" class="nav__link <?= isActivePage('about') ?>">About Us</a></li>
                    <li class="nav__dropdown">
                        <a href="<?= url('pages/construction.php') ?>" class="nav__link <?= isActivePage('construction') ?>">
                            Construction <i class="fas fa-chevron-down"></i>
                        </a>
                        <ul class="nav__dropdown-menu">
                            <?php 
                            $navServices = getActiveServices();
                            if (!empty($navServices)):
                                foreach ($navServices as $nServ): ?>
                                    <li><a href="<?= url('pages/construction.php#' . htmlspecialchars($nServ['slug'])) ?>"><?= htmlspecialchars($nServ['title']) ?></a></li>
                                <?php endforeach;
                            else: ?>
                                <li><a href="<?= url('pages/construction.php#prefab-houses') ?>">Prefab Wooden Houses</a></li>
                                <li><a href="<?= url('pages/construction.php#cottages') ?>">Wooden Cottages</a></li>
                                <li><a href="<?= url('pages/construction.php#farmhouses') ?>">Wooden Farmhouses</a></li>
                                <li><a href="<?= url('pages/construction.php#villas') ?>">Wooden Villas</a></li>
                                <li><a href="<?= url('pages/construction.php#stilt-houses') ?>">Wooden Stilt Houses</a></li>
                                <li><a href="<?= url('pages/construction.php#resort-cottages') ?>">Resort Cottages</a></li>
                                <li><a href="<?= url('pages/construction.php#tree-houses') ?>">Wooden Tree Houses</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                    <li><a href="<?= url('pages/projects.php') ?>" class="nav__link <?= isActivePage('projects') ?>">Projects</a></li>
                    <li><a href="<?= url('pages/process.php') ?>" class="nav__link <?= isActivePage('process') ?>">Process</a></li>
                    <li><a href="<?= url('pages/why-wooden.php') ?>" class="nav__link <?= isActivePage('why-wooden') ?>">Why Wood</a></li>
                    <li><a href="<?= url('pages/faq.php') ?>" class="nav__link <?= isActivePage('faq') ?>">FAQ</a></li>
                    <li><a href="<?= url('pages/contact.php') ?>" class="nav__link <?= isActivePage('contact') ?>">Contact</a></li>
                </ul>
            </nav>

            <div class="header__actions">
                <a href="<?= url('pages/contact.php') ?>" class="btn btn--primary btn--sm btn-magnetic">Get a Quote</a>
                <button class="hamburger" id="hamburger" aria-label="Toggle menu" aria-expanded="false">
                    <span></span><span></span><span></span>
                </button>
            </div>
        </div>
    </header>

    <!-- Mobile Menu Overlay -->
    <div class="mobile-overlay" id="mobileOverlay"></div>

    <main id="main-content">
