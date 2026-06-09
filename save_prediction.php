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
    redirect('/index.php?error=' . urlencode('Scorul trebuie să fie un număr întreg între 0 și 20.'));
}

$stmt = $pdo->prepare('SELECT id, match_datetime FROM matches WHERE id = ?');
$stmt->execute([$matchId]);
$match = $stmt->fetch();

if (!$match) {
    redirect('/index.php?error=' . urlencode('Meciul nu a fost găsit.'));
}

if (isMatchLocked($match['match_datetime'])) {
    redirect('/index.php?error=' . urlencode('Pronosticul nu mai poate fi modificat: meciul a început.'));
}

$existing = $pdo->prepare('SELECT id FROM predictions WHERE user_id = ? AND match_id = ? LIMIT 1');
$existing->execute([$user['id'], $matchId]);

if ($existing->fetch()) {
    redirect('/index.php?error=' . urlencode('Pronosticul a fost deja salvat și nu mai poate fi modificat.'));
}

$sql = 'INSERT IGNORE INTO predictions (user_id, match_id, predicted_home_score, predicted_away_score, points)
        VALUES (?, ?, ?, ?, NULL)';
$save = $pdo->prepare($sql);
$save->execute([$user['id'], $matchId, (int) $home, (int) $away]);

if ($save->rowCount() !== 1) {
    redirect('/index.php?error=' . urlencode('Pronosticul a fost deja salvat și nu mai poate fi modificat.'));
}

redirect('/index.php?saved=1');
