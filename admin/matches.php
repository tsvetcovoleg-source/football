<?php
require_once __DIR__ . '/../includes/auth.php';
requireAdmin();
$pdo = getDb();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? 'save';
    if ($action === 'delete') {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        if ($id) {
            $stmt = $pdo->prepare('DELETE FROM matches WHERE id = ?');
            $stmt->execute([$id]);
        }
        redirect('/admin/matches.php');
    }

    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $stage = trim($_POST['tournament_stage'] ?? '');
    $group = trim($_POST['group_name'] ?? '');
    $homeTeam = trim($_POST['team_home'] ?? '');
    $awayTeam = trim($_POST['team_away'] ?? '');
    $dateTime = trim($_POST['match_datetime'] ?? '');
    $status = $_POST['status'] ?? 'scheduled';
    $homeScore = $_POST['home_score'] === '' ? null : $_POST['home_score'];
    $awayScore = $_POST['away_score'] === '' ? null : $_POST['away_score'];

    $scoreValid = ($homeScore === null && $awayScore === null) || (validateScore($homeScore) && validateScore($awayScore));
    if ($stage === '' || $homeTeam === '' || $awayTeam === '' || $dateTime === '' || !in_array($status, ['scheduled', 'live', 'finished'], true) || !$scoreValid) {
        $error = 'Проверьте обязательные поля и счёт (0–20).';
    } else {
        $group = $group === '' ? null : $group;
        $homeScore = $homeScore === null ? null : (int) $homeScore;
        $awayScore = $awayScore === null ? null : (int) $awayScore;
        $mysqlDate = (new DateTime($dateTime, new DateTimeZone(APP_TIMEZONE)))->format('Y-m-d H:i:s');

        if ($id) {
            $stmt = $pdo->prepare('UPDATE matches SET tournament_stage=?, group_name=?, team_home=?, team_away=?, match_datetime=?, home_score=?, away_score=?, status=?, updated_at=NOW() WHERE id=?');
            $stmt->execute([$stage, $group, $homeTeam, $awayTeam, $mysqlDate, $homeScore, $awayScore, $status, $id]);
            recalculateMatchPredictions($pdo, $id);
        } else {
            $stmt = $pdo->prepare('INSERT INTO matches (tournament_stage, group_name, team_home, team_away, match_datetime, home_score, away_score, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
            $stmt->execute([$stage, $group, $homeTeam, $awayTeam, $mysqlDate, $homeScore, $awayScore, $status]);
            recalculateMatchPredictions($pdo, (int) $pdo->lastInsertId());
        }
        redirect('/admin/matches.php');
    }
}

$edit = null;
if (!empty($_GET['edit'])) {
    $stmt = $pdo->prepare('SELECT * FROM matches WHERE id = ?');
    $stmt->execute([(int) $_GET['edit']]);
    $edit = $stmt->fetch();
}
$matches = $pdo->query('SELECT * FROM matches ORDER BY match_datetime ASC, id ASC')->fetchAll();
$pageTitle = 'Матчи';
require __DIR__ . '/../includes/header.php';
?>
<section class="hero"><div><p class="eyebrow">Админка</p><h1>Управление матчами</h1><p>Добавляйте календарь, статусы и реальные результаты.</p></div></section>
<?php if ($error): ?><div class="alert alert-error"><?= e($error) ?></div><?php endif; ?>
<section class="panel">
    <h2><?= $edit ? 'Редактировать матч' : 'Добавить матч' ?></h2>
    <form method="post" class="admin-form grid-form">
        <input type="hidden" name="id" value="<?= $edit ? (int) $edit['id'] : '' ?>">
        <label>Стадия<input type="text" name="tournament_stage" required value="<?= e($edit['tournament_stage'] ?? 'Group Stage') ?>"></label>
        <label>Группа<input type="text" name="group_name" value="<?= e($edit['group_name'] ?? '') ?>"></label>
        <label>Первая команда<input type="text" name="team_home" required value="<?= e($edit['team_home'] ?? '') ?>"></label>
        <label>Вторая команда<input type="text" name="team_away" required value="<?= e($edit['team_away'] ?? '') ?>"></label>
        <label>Дата и время<input type="datetime-local" name="match_datetime" required value="<?= $edit ? e((new DateTime($edit['match_datetime']))->format('Y-m-d\TH:i')) : '' ?>"></label>
        <label>Статус<select name="status">
            <?php foreach (['scheduled', 'live', 'finished'] as $status): ?><option value="<?= $status ?>" <?= ($edit['status'] ?? 'scheduled') === $status ? 'selected' : '' ?>><?= ucfirst($status) ?></option><?php endforeach; ?>
        </select></label>
        <label>Счёт 1<input type="number" name="home_score" min="0" max="20" value="<?= e((string) ($edit['home_score'] ?? '')) ?>"></label>
        <label>Счёт 2<input type="number" name="away_score" min="0" max="20" value="<?= e((string) ($edit['away_score'] ?? '')) ?>"></label>
        <button class="btn btn-primary" type="submit">Сохранить матч</button>
        <?php if ($edit): ?><a class="btn" href="matches.php">Отмена</a><?php endif; ?>
    </form>
</section>
<div class="table-wrap"><table class="data-table"><thead><tr><th>Матч</th><th>Дата</th><th>Статус</th><th>Счёт</th><th>Действия</th></tr></thead><tbody>
<?php foreach ($matches as $match): ?><tr>
    <td><strong><?= e($match['team_home']) ?> — <?= e($match['team_away']) ?></strong><br><span class="muted"><?= e($match['group_name'] ?: $match['tournament_stage']) ?></span></td>
    <td><?= e(formatMatchDate($match['match_datetime'])) ?></td><td><?= statusBadge($match['status']) ?></td>
    <td><?= $match['home_score'] !== null ? (int) $match['home_score'] . ':' . (int) $match['away_score'] : '—' ?></td>
    <td class="actions"><a class="btn btn-small" href="?edit=<?= (int) $match['id'] ?>">Редактировать</a><form method="post" onsubmit="return confirm('Удалить матч?')"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= (int) $match['id'] ?>"><button class="btn btn-small btn-danger" type="submit">Удалить</button></form></td>
</tr><?php endforeach; ?>
</tbody></table></div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
