<?php
require_once __DIR__ . '/../includes/auth.php';
requireAdmin();
$pdo = getDb();
$createdPassword = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $displayName = trim($_POST['display_name'] ?? '');
    $role = $_POST['role'] ?? 'user';

    if ($login === '' || $displayName === '' || !in_array($role, ['admin', 'user'], true)) {
        $error = 'Completează corect toate câmpurile.';
    } else {
        $createdPassword = generatePassword(8);
        try {
            $stmt = $pdo->prepare('INSERT INTO users (login, password_hash, role, display_name) VALUES (?, ?, ?, ?)');
            $stmt->execute([$login, password_hash($createdPassword, PASSWORD_DEFAULT), $role, $displayName]);
        } catch (PDOException $exception) {
            $createdPassword = '';
            $error = 'Utilizatorul nu a putut fi creat. Este posibil ca loginul să fie deja folosit.';
        }
    }
}

$users = $pdo->query('SELECT id, login, role, display_name, created_at FROM users ORDER BY created_at DESC')->fetchAll();
$roleLabels = ['admin' => 'Administrator', 'user' => 'Participant'];
$pageTitle = 'Utilizatori';
require __DIR__ . '/../includes/header.php';
?>
<section class="hero"><div><p class="eyebrow">Administrare</p><h1>Utilizatori</h1><p>Creează participanți și transmite-le parola generată.</p></div></section>
<?php if ($createdPassword): ?><div class="alert alert-success">Utilizator creat. Parolă: <strong><?= e($createdPassword) ?></strong></div><?php endif; ?>
<?php if ($error): ?><div class="alert alert-error"><?= e($error) ?></div><?php endif; ?>
<section class="panel">
    <h2>Creează utilizator</h2>
    <form method="post" class="admin-form grid-form">
        <label>Login<input type="text" name="login" required></label>
        <label>Nume afișat în tabele<input type="text" name="display_name" required></label>
        <label>Rol<select name="role"><option value="user">Participant</option><option value="admin">Administrator</option></select></label>
        <button class="btn btn-primary" type="submit">Generează parola automat</button>
    </form>
</section>
<div class="table-wrap"><table class="data-table"><thead><tr><th>ID</th><th>Login</th><th>Nume</th><th>Rol</th><th>Creat</th></tr></thead><tbody>
<?php foreach ($users as $row): ?><tr><td><?= (int) $row['id'] ?></td><td><?= e($row['login']) ?></td><td><?= e($row['display_name']) ?></td><td><?= e($roleLabels[$row['role']] ?? $row['role']) ?></td><td><?= e($row['created_at']) ?></td></tr><?php endforeach; ?>
</tbody></table></div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
