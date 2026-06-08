<?php
require_once __DIR__ . '/includes/auth.php';
$user = requireLogin();
$pdo = getDb();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('/index.php');
}

$matchId = filter_input(INPUT_POST, 'match_id', FILTER_VALIDATE_INT);
$home = $_POST['predicted_home_score'] ?? null;
$away = $_POST['predicted_away_score'] ?? null;

if (!$matchId || !validateScore($home) || !validateScore($away)) {
    redirect('/index.php?error=' . urlencode('Счёт должен быть целым числом от 0 до 20.'));
}

$stmt = $pdo->prepare('SELECT id, match_datetime FROM matches WHERE id = ?');
$stmt->execute([$matchId]);
$match = $stmt->fetch();

if (!$match) {
    redirect('/index.php?error=' . urlencode('Матч не найден.'));
}

if (isMatchLocked($match['match_datetime'])) {
    redirect('/index.php?error=' . urlencode('Прогноз уже нельзя изменить: матч начался.'));
}

$sql = 'INSERT INTO predictions (user_id, match_id, predicted_home_score, predicted_away_score, points)
        VALUES (?, ?, ?, ?, NULL)
        ON DUPLICATE KEY UPDATE predicted_home_score = VALUES(predicted_home_score), predicted_away_score = VALUES(predicted_away_score), points = NULL, updated_at = NOW()';
$save = $pdo->prepare($sql);
$save->execute([$user['id'], $matchId, (int) $home, (int) $away]);

redirect('/index.php?saved=1');
