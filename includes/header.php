<?php
require_once __DIR__ . '/auth.php';
$pageTitle = $pageTitle ?? 'Football Predictions';
$user = currentUser();
$isAdminPage = str_contains($_SERVER['SCRIPT_NAME'] ?? '', '/admin/');
$basePrefix = $isAdminPage ? '../' : '';
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle) ?></title>
    <link rel="stylesheet" href="<?= $basePrefix ?>assets/css/style.css">
</head>
<body>
<header class="topbar">
    <a class="brand" href="<?= $basePrefix ?>index.php">⚽ World Cup Forecast</a>
    <nav class="nav">
        <?php if ($user): ?>
            <?php if (isAdmin($user)): ?>
                <a href="<?= $basePrefix ?>admin/dashboard.php">Админка</a>
                <a href="<?= $basePrefix ?>admin/users.php">Пользователи</a>
                <a href="<?= $basePrefix ?>admin/matches.php">Матчи</a>
            <?php endif; ?>
            <a href="<?= $basePrefix ?>leaderboard.php">Таблица</a>
            <a href="<?= $basePrefix ?>predictions_matrix.php">Прогнозы</a>
            <span class="user-chip"><?= e($user['display_name']) ?></span>
            <a class="btn btn-small" href="<?= $basePrefix ?>logout.php">Выйти</a>
        <?php endif; ?>
    </nav>
</header>
<main class="container">
