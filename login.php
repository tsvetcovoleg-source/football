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

    $error = 'Login sau parolă incorectă.';
}

$pageTitle = 'Autentificare';
$basePrefix = '';
?>
<!doctype html>
<html lang="ro">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Autentificare — Arena Pronosticurilor</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="login-body">
<main class="login-shell">
    <section class="login-card">
        <div class="login-ball">⚽</div>
        <h1>Arena Pronosticurilor</h1>
        <p>Intră în platformă, alege scorurile și luptă pentru primul loc în clasamentul turneului.</p>
        <?php if ($error): ?><div class="alert alert-error"><?= e($error) ?></div><?php endif; ?>
        <form method="post" class="stack-form">
            <label>Login<input type="text" name="login" required autofocus></label>
            <label>Parolă<input type="password" name="password" required></label>
            <button class="btn btn-primary" type="submit">Intră în joc</button>
        </form>
    </section>
</main>
</body>
</html>
