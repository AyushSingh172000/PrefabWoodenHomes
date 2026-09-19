<?php
/**
 * Admin Topbar & HTML Head
 */
require_once __DIR__ . '/auth.php';
requireAdminLogin();

$flash = getFlash();
$user = currentAdmin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Dashboard' ?> | Admin Console - Prefab Wooden Homes</title>
    <link rel="icon" type="image/png" href="<?= htmlspecialchars(getSetting('site_favicon', asset('images/favicon.png'))) ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?= url('admin/assets/css/admin.css') ?>">
</head>
<body>
<div class="adm-wrapper">
    <?php require_once __DIR__ . '/admin-sidebar.php'; ?>

    <div class="adm-main">
        <header class="adm-topbar">
            <div class="adm-topbar__left">
                <button class="adm-topbar__toggle" id="admSidebarToggle" aria-label="Toggle Menu">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="adm-topbar__title"><?= htmlspecialchars($pageTitle ?? 'Admin Dashboard') ?></h1>
            </div>

            <div class="adm-topbar__right">
                <a href="<?= url() ?>" target="_blank" class="adm-btn adm-btn--outline adm-btn--sm" title="Open Public Website">
                    <i class="fas fa-external-link-alt"></i> View Live Site
                </a>
                <a href="<?= url('admin/profile.php') ?>" class="adm-btn adm-btn--outline adm-btn--sm">
                    <i class="fas fa-user-circle"></i> <?= htmlspecialchars($user['username']) ?>
                </a>
                <a href="<?= url('admin/logout.php') ?>" class="adm-btn adm-btn--danger adm-btn--sm" title="Log Out">
                    <i class="fas fa-power-off"></i>
                </a>
            </div>
        </header>

        <main class="adm-body">
            <?php if ($flash): ?>
                <div class="adm-alert adm-alert--<?= $flash['type'] === 'success' ? 'success' : 'error' ?>">
                    <i class="fas fa-<?= $flash['type'] === 'success' ? 'check-circle' : 'exclamation-triangle' ?>"></i>
                    <span><?= htmlspecialchars($flash['message']) ?></span>
                </div>
            <?php endif; ?>
