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
        $error = 'Заполните все поля корректно.';
    } else {
        $createdPassword = generatePassword(8);
        try {
            $stmt = $pdo->prepare('INSERT INTO users (login, password_hash, role, display_name) VALUES (?, ?, ?, ?)');
            $stmt->execute([$login, password_hash($createdPassword, PASSWORD_DEFAULT), $role, $displayName]);
        } catch (PDOException $exception) {
            $createdPassword = '';
            $error = 'Не удалось создать пользователя. Возможно, логин уже занят.';
        }
    }
}

$users = $pdo->query('SELECT id, login, role, display_name, created_at FROM users ORDER BY created_at DESC')->fetchAll();
$pageTitle = 'Пользователи';
require __DIR__ . '/../includes/header.php';
?>
<section class="hero"><div><p class="eyebrow">Админка</p><h1>Пользователи</h1><p>Создавайте участников и передавайте им сгенерированный пароль.</p></div></section>
<?php if ($createdPassword): ?><div class="alert alert-success">Пользователь создан. Пароль: <strong><?= e($createdPassword) ?></strong></div><?php endif; ?>
<?php if ($error): ?><div class="alert alert-error"><?= e($error) ?></div><?php endif; ?>
<section class="panel">
    <h2>Создать пользователя</h2>
    <form method="post" class="admin-form grid-form">
        <label>Логин<input type="text" name="login" required></label>
        <label>Имя в таблицах<input type="text" name="display_name" required></label>
        <label>Роль<select name="role"><option value="user">user</option><option value="admin">admin</option></select></label>
        <button class="btn btn-primary" type="submit">Создать пароль автоматически</button>
    </form>
</section>
<div class="table-wrap"><table class="data-table"><thead><tr><th>ID</th><th>Логин</th><th>Имя</th><th>Роль</th><th>Создан</th></tr></thead><tbody>
<?php foreach ($users as $row): ?><tr><td><?= (int) $row['id'] ?></td><td><?= e($row['login']) ?></td><td><?= e($row['display_name']) ?></td><td><?= e($row['role']) ?></td><td><?= e($row['created_at']) ?></td></tr><?php endforeach; ?>
</tbody></table></div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
