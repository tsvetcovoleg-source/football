<?php
require_once __DIR__ . '/includes/auth.php';
$user = requireLogin();
$pdo = getDb();

$stmt = $pdo->prepare(
    'SELECT m.*, p.predicted_home_score, p.predicted_away_score, p.points
     FROM matches m
     LEFT JOIN predictions p ON p.match_id = m.id AND p.user_id = ?
     ORDER BY m.match_datetime ASC, m.id ASC'
);
$stmt->execute([$user['id']]);
$matches = $stmt->fetchAll();

$pageTitle = 'Meciuri';
require __DIR__ . '/includes/header.php';
?>
<section class="hero">
    <div>
        <p class="eyebrow">Centrul turneului</p>
        <h1>Meciuri și pronosticurile tale</h1>
        <p>Alege scorul exact o singură dată înainte de fluierul de start. După salvare, pronosticul nu mai poate fi modificat.</p>
    </div>
    <a class="btn btn-primary" href="leaderboard.php">Vezi clasamentul</a>
</section>

<?php if (!empty($_GET['error'])): ?><div class="alert alert-error"><?= e($_GET['error']) ?></div><?php endif; ?>
<?php if (!empty($_GET['saved'])): ?><div class="alert alert-success">Pronosticul a fost salvat și nu mai poate fi modificat.</div><?php endif; ?>

<div class="match-grid">
<?php foreach ($matches as $match): ?>
    <?php
    $locked = isMatchLocked($match['match_datetime']);
    $secondsLeft = secondsUntilMatch($match['match_datetime']);
    $hasPrediction = $match['predicted_home_score'] !== null;
    $finished = $match['home_score'] !== null && $match['away_score'] !== null;
    ?>
    <article class="match-card">
        <div class="match-card-head">
            <div>
                <span class="stage"><?= e($match['tournament_stage']) ?></span>
                <?php if ($match['group_name']): ?><span class="group"><?= e($match['group_name']) ?></span><?php endif; ?>
            </div>
            <?= statusBadge($match['status']) ?>
        </div>
        <h2><?= e($match['team_home']) ?> <span>—</span> <?= e($match['team_away']) ?></h2>
        <div class="match-time">
            <?php if (!$locked && $secondsLeft <= 86400): ?>
                Până la start: <strong class="countdown" data-start="<?= e((new DateTime($match['match_datetime'], new DateTimeZone(APP_TIMEZONE)))->format(DateTime::ATOM)) ?>">--:--:--</strong>
            <?php else: ?>
                <?= e(formatMatchDate($match['match_datetime'])) ?>
            <?php endif; ?>
        </div>

        <?php if ($finished): ?>
            <div class="result-box">Rezultat: <strong><?= (int) $match['home_score'] ?>:<?= (int) $match['away_score'] ?></strong></div>
        <?php endif; ?>

        <?php if (!$locked && !$hasPrediction): ?>
            <form action="save_prediction.php" method="post" class="prediction-form">
                <input type="hidden" name="match_id" value="<?= (int) $match['id'] ?>">
                <label>Pronosticul tău</label>
                <div class="score-inputs">
                    <input type="number" name="predicted_home_score" min="0" max="20" required>
                    <span>:</span>
                    <input type="number" name="predicted_away_score" min="0" max="20" required>
                </div>
                <button class="btn btn-primary" type="submit">Salvează pronosticul</button>
            </form>
        <?php else: ?>
            <div class="locked-box">
                <?php if ($hasPrediction): ?>
                    Pronosticul tău: <strong><?= (int) $match['predicted_home_score'] ?>:<?= (int) $match['predicted_away_score'] ?></strong>
                    <span>Nu mai poate fi modificat.</span>
                    <?php if ($match['points'] !== null): ?><span class="points">+<?= (int) $match['points'] ?></span><?php endif; ?>
                <?php else: ?>
                    Nu ai setat un pronostic. Meciul a început deja.
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </article>
<?php endforeach; ?>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
