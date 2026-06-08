<?php
require_once __DIR__ . '/includes/auth.php';
requireLogin();
$pdo = getDb();

$rows = $pdo->query(
    "SELECT u.id, u.display_name,
            COALESCE(SUM(p.points), 0) AS total_points,
            SUM(CASE WHEN p.points = 3 THEN 1 ELSE 0 END) AS exact_scores,
            SUM(CASE WHEN p.points = 2 THEN 1 ELSE 0 END) AS two_points,
            SUM(CASE WHEN p.points = 1 THEN 1 ELSE 0 END) AS one_points,
            COUNT(p.id) AS predictions_count,
            COALESCE(AVG(p.points), 0) AS average_points
     FROM users u
     LEFT JOIN predictions p ON p.user_id = u.id AND p.points IS NOT NULL
     WHERE u.role = 'user'
     GROUP BY u.id, u.display_name
     ORDER BY total_points DESC, exact_scores DESC, two_points DESC, average_points DESC, u.display_name ASC"
)->fetchAll();

$pageTitle = 'Clasamentul turneului';
require __DIR__ . '/includes/header.php';
?>
<section class="hero leaderboard-hero">
    <div>
        <p class="eyebrow">Ratingul pronosticatorilor</p>
        <h1>Clasamentul turneului</h1>
        <p>Sortare după puncte, scoruri exacte, pronosticuri de 2 puncte și media punctelor.</p>
    </div>
</section>
<div class="table-wrap">
<table class="data-table leaderboard-table">
    <thead><tr><th>Loc</th><th>Pronosticator</th><th>Puncte</th><th>Exacte</th><th>2 puncte</th><th>1 punct</th><th>Total</th><th>Media</th></tr></thead>
    <tbody>
    <?php foreach ($rows as $index => $row): ?>
        <?php $place = $index + 1; $medal = [1 => '🥇', 2 => '🥈', 3 => '🥉'][$place] ?? $place; ?>
        <tr class="place-<?= $place <= 3 ? $place : 'other' ?>">
            <td class="place"><?= e((string) $medal) ?></td>
            <td><?= e($row['display_name']) ?></td>
            <td><strong><?= (int) $row['total_points'] ?></strong></td>
            <td><?= (int) $row['exact_scores'] ?></td>
            <td><?= (int) $row['two_points'] ?></td>
            <td><?= (int) $row['one_points'] ?></td>
            <td><?= (int) $row['predictions_count'] ?></td>
            <td><?= number_format((float) $row['average_points'], 2, '.', '') ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
