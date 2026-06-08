<?php
require_once __DIR__ . '/includes/auth.php';

if (currentUser()) {
    $user = currentUser();
    redirect($user['role'] === 'admin' ? '/admin/dashboard.php' : '/index.php');
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = getDb()->prepare('SELECT * FROM users WHERE login = ? LIMIT 1');
    $stmt->execute([$login]);
    $foundUser = $stmt->fetch();

    if ($foundUser && password_verify($password, $foundUser['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $foundUser['id'];
        redirect($foundUser['role'] === 'admin' ? '/admin/dashboard.php' : '/index.php');
    }

    $error = 'Неверный логин или пароль.';
}

$pageTitle = 'Вход';
$basePrefix = '';
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Вход — Football Predictions</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="login-body">
<main class="login-shell">
    <section class="login-card">
        <div class="login-ball">⚽</div>
        <h1>World Cup Forecast</h1>
        <p>Войдите, чтобы делать прогнозы и бороться за первое место.</p>
        <?php if ($error): ?><div class="alert alert-error"><?= e($error) ?></div><?php endif; ?>
        <form method="post" class="stack-form">
            <label>Логин<input type="text" name="login" required autofocus></label>
            <label>Пароль<input type="password" name="password" required></label>
            <button class="btn btn-primary" type="submit">Войти</button>
        </form>
        <p class="muted">Тестовый админ: <strong>admin</strong> / <strong>admin123</strong></p>
    </section>
</main>
</body>
</html>
