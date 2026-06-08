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

$pageTitle = 'Все прогнозы';
require __DIR__ . '/includes/header.php';
?>
<section class="hero">
    <div>
        <p class="eyebrow">Матрица прогнозов</p>
        <h1>Все прогнозы по матчам</h1>
        <p>Приватность: чужие счета открываются только после вашего прогноза на конкретный матч.</p>
    </div>
</section>
<div class="table-wrap matrix-wrap">
<table class="data-table matrix-table">
    <thead>
        <tr><th>Матч</th><th>Результат</th><?php foreach ($users as $contestUser): ?><th><?= e($contestUser['display_name']) ?></th><?php endforeach; ?></tr>
    </thead>
    <tbody>
    <?php foreach ($matches as $match): ?>
        <?php $canSee = isAdmin($user) || !empty($userPredictedMatch[$match['id']]); ?>
        <tr>
            <td>
                <strong><?= e($match['team_home']) ?> — <?= e($match['team_away']) ?></strong><br>
                <span class="muted"><?= e($match['group_name'] ?: $match['tournament_stage']) ?> · <?= e(formatMatchDate($match['match_datetime'])) ?></span>
            </td>
            <td><?= $match['home_score'] !== null ? (int) $match['home_score'] . ':' . (int) $match['away_score'] : '—' ?></td>
            <?php foreach ($users as $contestUser): ?>
                <?php $prediction = $byMatchUser[$match['id']][$contestUser['id']] ?? null; ?>
                <?php $isOwn = (int) $contestUser['id'] === (int) $user['id']; ?>
                <td class="prediction-cell <?= $prediction && $prediction['points'] !== null ? 'points-' . (int) $prediction['points'] : '' ?>">
                    <?php if (!$prediction): ?>
                        <span class="muted">Нет прогноза</span>
                    <?php elseif ($canSee || $isOwn): ?>
                        <strong><?= (int) $prediction['predicted_home_score'] ?>:<?= (int) $prediction['predicted_away_score'] ?></strong>
                        <?php if ($prediction['points'] !== null): ?><br><span class="points">+<?= (int) $prediction['points'] ?></span><?php endif; ?>
                    <?php else: ?>
                        <span class="status-text">Есть прогноз</span>
                    <?php endif; ?>
                </td>
            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
