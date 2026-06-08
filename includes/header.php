<?php
require_once __DIR__ . '/auth.php';
$pageTitle = $pageTitle ?? 'Arena Pronosticurilor';
$user = currentUser();
$isAdminPage = str_contains($_SERVER['SCRIPT_NAME'] ?? '', '/admin/');
$basePrefix = $isAdminPage ? '../' : '';
?>
<!doctype html>
<html lang="ro">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle) ?></title>
    <link rel="stylesheet" href="<?= $basePrefix ?>assets/css/style.css">
</head>
<body>
<header class="topbar">
    <a class="brand" href="<?= $basePrefix ?>index.php">⚽ Arena Pronosticurilor</a>
    <nav class="nav">
        <?php if ($user): ?>
            <?php if (isAdmin($user)): ?>
                <a href="<?= $basePrefix ?>admin/dashboard.php">Administrare</a>
                <a href="<?= $basePrefix ?>admin/users.php">Utilizatori</a>
                <a href="<?= $basePrefix ?>admin/matches.php">Meciuri</a>
            <?php endif; ?>
            <a href="<?= $basePrefix ?>leaderboard.php">Clasament</a>
            <a href="<?= $basePrefix ?>predictions_matrix.php">Pronosticuri</a>
            <span class="user-chip"><?= e($user['display_name']) ?></span>
            <a class="btn btn-small" href="<?= $basePrefix ?>logout.php">Ieșire</a>
        <?php endif; ?>
    </nav>
</header>
<main class="container">
