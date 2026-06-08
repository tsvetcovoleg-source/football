<?php
require_once __DIR__ . '/../includes/auth.php';
requireAdmin();
$pdo = getDb();

$stats = [
    'users' => (int) $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'user'")->fetchColumn(),
    'matches' => (int) $pdo->query('SELECT COUNT(*) FROM matches')->fetchColumn(),
    'finished' => (int) $pdo->query("SELECT COUNT(*) FROM matches WHERE status = 'finished' OR (home_score IS NOT NULL AND away_score IS NOT NULL)")->fetchColumn(),
    'predictions' => (int) $pdo->query('SELECT COUNT(*) FROM predictions')->fetchColumn(),
];
$pageTitle = 'Админ-панель';
require __DIR__ . '/../includes/header.php';
?>
<section class="hero">
    <div><p class="eyebrow">Администрирование</p><h1>Панель управления</h1><p>Управляйте участниками, матчами и расчётом очков.</p></div>
</section>
<div class="stats-grid">
    <div class="stat-card"><span><?= $stats['users'] ?></span><p>Пользователей</p></div>
    <div class="stat-card"><span><?= $stats['matches'] ?></span><p>Матчей</p></div>
    <div class="stat-card"><span><?= $stats['finished'] ?></span><p>Завершено</p></div>
    <div class="stat-card"><span><?= $stats['predictions'] ?></span><p>Прогнозов</p></div>
</div>
<div class="action-grid">
    <a class="action-card" href="users.php">👥 Управление пользователями</a>
    <a class="action-card" href="matches.php">🏟️ Управление матчами</a>
    <a class="action-card" href="../predictions_matrix.php">📊 Таблица прогнозов</a>
    <a class="action-card" href="../leaderboard.php">🏆 Турнирная таблица</a>
    <a class="action-card" href="recalculate.php">🔁 Пересчитать очки</a>
</div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
