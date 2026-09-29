<?php
$page = ($page ?? []) + ['title' => '', 'description' => '', 'slug' => '', 'body_class' => ''];
$fullTitle = $page['title'] !== '' ? $page['title'] . ' | ' . SITE_NAME : SITE_NAME;
$description = $page['description'] !== '' ? $page['description'] : site('meta_description', '');
?>
<!doctype html>
<html lang="en-GB" class="no-js">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($fullTitle) ?></title>
    <meta name="description" content="<?= e($description) ?>">
    <meta name="theme-color" content="#FEFEFE">
    <meta property="og:site_name" content="<?= e(SITE_NAME) ?>">
    <meta property="og:title" content="<?= e($fullTitle) ?>">
    <meta property="og:description" content="<?= e($description) ?>">
    <link rel="icon" href="<?= e(asset('img/brand/favicon-64.png')) ?>" type="image/png">
    <link rel="apple-touch-icon" href="<?= e(asset('img/brand/apple-touch-icon.png')) ?>">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400;0,500;1,400&family=Noto+Sans:wght@400;500&display=swap">

    <link rel="stylesheet" href="<?= e(asset('css/tokens.css')) ?>">
    <link rel="stylesheet" href="<?= e(asset('css/base.css')) ?>">
    <link rel="stylesheet" href="<?= e(asset('css/layout.css')) ?>">
    <link rel="stylesheet" href="<?= e(asset('css/components.css')) ?>">
    <link rel="stylesheet" href="<?= e(asset('css/pages.css')) ?>">

    <script>document.documentElement.classList.replace('no-js', 'js');</script>
    <script src="<?= e(asset('js/main.js')) ?>" defer></script>
</head>
<body class="<?= e(trim('page-' . ($page['slug'] ?: 'default') . ' ' . $page['body_class'])) ?>">
<a class="skip-link" href="#main">Skip to content</a>
