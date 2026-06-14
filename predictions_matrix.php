<?php
require_once __DIR__ . '/includes/auth.php';
$user = requireLogin();
$pdo = getDb();

$users = $pdo->query("SELECT id, display_name FROM users WHERE role = 'user' ORDER BY display_name ASC")->fetchAll();
$matches = $pdo->query('SELECT * FROM matches ORDER BY match_datetime ASC, id ASC')->fetchAll();
$predictions = $pdo->query('SELECT * FROM predictions')->fetchAll();

$byMatchUser = [];
$userPredictedMatch = [];
foreach ($predictions as $prediction) {
    $byMatchUser[$prediction['match_id']][$prediction['user_id']] = $prediction;
    if ((int) $prediction['user_id'] === (int) $user['id']) {
        $userPredictedMatch[$prediction['match_id']] = true;
    }
}

$pageTitle = 'Toate pronosticurile';
require __DIR__ . '/includes/header.php';
?>
<section class="hero">
    <div>
        <p class="eyebrow">Matricea pronosticurilor</p>
        <h1>Toate pronosticurile pe meciuri</h1>
        <p>Confidențialitate: scorurile celorlalți se afișează doar după ce ai trimis pronosticul tău pentru meciul respectiv.</p>
    </div>
</section>
<div class="score-legend" aria-label="Legendă punctaj">
    <span class="legend-item legend-3">3 puncte · scor exact</span>
    <span class="legend-item legend-2">2 puncte · diferență exactă</span>
    <span class="legend-item legend-1">1 punct · rezultat corect</span>
    <span class="legend-item legend-0">0 puncte · fără punctaj</span>
</div>
<div class="table-wrap matrix-wrap">
<table class="data-table matrix-table">
    <thead>
        <tr><th>Meci</th><th>Rezultat</th><?php foreach ($users as $contestUser): ?><th><?= e($contestUser['display_name']) ?></th><?php endforeach; ?></tr>
    </thead>
    <tbody>
    <?php foreach ($matches as $match): ?>
        <?php $canSee = isAdmin($user) || !empty($userPredictedMatch[$match['id']]); ?>
        <tr>
            <td>
                <strong><?= e($match['team_home']) ?> — <?= e($match['team_away']) ?></strong>
            </td>
            <td><?= $match['home_score'] !== null ? (int) $match['home_score'] . ':' . (int) $match['away_score'] : '—' ?></td>
            <?php foreach ($users as $contestUser): ?>
                <?php $prediction = $byMatchUser[$match['id']][$contestUser['id']] ?? null; ?>
                <?php $isOwn = (int) $contestUser['id'] === (int) $user['id']; ?>
                <td class="prediction-cell <?= $prediction && $prediction['points'] !== null ? 'points-' . (int) $prediction['points'] : '' ?>">
                    <?php if (!$prediction): ?>
                        <span class="muted">Fără pronostic</span>
                    <?php elseif ($canSee || $isOwn): ?>
                        <strong><?= (int) $prediction['predicted_home_score'] ?>:<?= (int) $prediction['predicted_away_score'] ?></strong>
                        <?php if ($prediction['points'] !== null): ?><br><span class="points">+<?= (int) $prediction['points'] ?></span><?php endif; ?>
                    <?php else: ?>
                        <span class="status-text">Pronostic trimis</span>
                    <?php endif; ?>
                </td>
            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
