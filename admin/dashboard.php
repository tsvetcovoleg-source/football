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
$pageTitle = 'Panou de administrare';
require __DIR__ . '/../includes/header.php';
?>
<section class="hero">
    <div><p class="eyebrow">Administrare</p><h1>Panou de control</h1><p>Gestionează participanții, meciurile și calculul punctelor.</p></div>
</section>
<div class="stats-grid">
    <div class="stat-card"><span><?= $stats['users'] ?></span><p>Utilizatori</p></div>
    <div class="stat-card"><span><?= $stats['matches'] ?></span><p>Meciuri</p></div>
    <div class="stat-card"><span><?= $stats['finished'] ?></span><p>Finalizate</p></div>
    <div class="stat-card"><span><?= $stats['predictions'] ?></span><p>Pronosticuri</p></div>
</div>
<div class="action-grid">
    <a class="action-card" href="users.php">👥 Gestionare utilizatori</a>
    <a class="action-card" href="matches.php">🏟️ Gestionare meciuri</a>
    <a class="action-card" href="../predictions_matrix.php">📊 Matricea pronosticurilor</a>
    <a class="action-card" href="../leaderboard.php">🏆 Clasamentul turneului</a>
    <a class="action-card" href="recalculate.php">🔁 Recalculează punctele</a>
</div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
