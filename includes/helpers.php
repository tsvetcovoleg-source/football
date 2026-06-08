<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/scoring.php';

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function redirect(string $url): void
{
    header('Location: ' . $url);
    exit;
}

function formatMatchDate(string $dateTime): string
{
    $date = new DateTime($dateTime, new DateTimeZone(APP_TIMEZONE));
    $months = [
        1 => 'ianuarie', 2 => 'februarie', 3 => 'martie', 4 => 'aprilie',
        5 => 'mai', 6 => 'iunie', 7 => 'iulie', 8 => 'august',
        9 => 'septembrie', 10 => 'octombrie', 11 => 'noiembrie', 12 => 'decembrie',
    ];

    return $date->format('j') . ' ' . $months[(int) $date->format('n')] . ' ' . $date->format('Y, H:i');
}

function isMatchLocked(string $dateTime): bool
{
    $now = new DateTime('now', new DateTimeZone(APP_TIMEZONE));
    $matchTime = new DateTime($dateTime, new DateTimeZone(APP_TIMEZONE));
    return $now >= $matchTime;
}

function secondsUntilMatch(string $dateTime): int
{
    $now = new DateTime('now', new DateTimeZone(APP_TIMEZONE));
    $matchTime = new DateTime($dateTime, new DateTimeZone(APP_TIMEZONE));
    return max(0, $matchTime->getTimestamp() - $now->getTimestamp());
}

function statusBadge(string $status): string
{
    $labels = [
        'scheduled' => 'Programat',
        'live' => 'În direct',
        'finished' => 'Finalizat',
    ];
    $label = $labels[$status] ?? ucfirst($status);
    return '<span class="badge badge-' . e($status) . '">' . e($label) . '</span>';
}

function validateScore($value): bool
{
    return filter_var($value, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0, 'max_range' => 20]]) !== false;
}

function recalculateMatchPredictions(PDO $pdo, int $matchId): void
{
    $matchStmt = $pdo->prepare('SELECT home_score, away_score FROM matches WHERE id = ?');
    $matchStmt->execute([$matchId]);
    $match = $matchStmt->fetch();

    if (!$match) {
        return;
    }

    $predictions = $pdo->prepare('SELECT id, predicted_home_score, predicted_away_score FROM predictions WHERE match_id = ?');
    $predictions->execute([$matchId]);
    $update = $pdo->prepare('UPDATE predictions SET points = ?, updated_at = NOW() WHERE id = ?');

    foreach ($predictions as $prediction) {
        $points = calculatePoints(
            $prediction['predicted_home_score'],
            $prediction['predicted_away_score'],
            $match['home_score'],
            $match['away_score']
        );
        $update->execute([$points, $prediction['id']]);
    }
}

function recalculateAllPredictions(PDO $pdo): void
{
    $matches = $pdo->query('SELECT id FROM matches WHERE home_score IS NOT NULL AND away_score IS NOT NULL');
    foreach ($matches as $match) {
        recalculateMatchPredictions($pdo, (int) $match['id']);
    }
}

function generatePassword(int $length = 8): string
{
    $alphabet = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz23456789';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $alphabet[random_int(0, strlen($alphabet) - 1)];
    }
    return $password;
}
