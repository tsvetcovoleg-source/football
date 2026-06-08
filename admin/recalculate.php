<?php
require_once __DIR__ . '/../includes/auth.php';
requireAdmin();
recalculateAllPredictions(getDb());
$pageTitle = 'Пересчёт очков';
require __DIR__ . '/../includes/header.php';
?>
<section class="hero"><div><p class="eyebrow">Готово</p><h1>Очки пересчитаны</h1><p>Все матчи с введённым результатом обработаны заново.</p></div><a class="btn btn-primary" href="dashboard.php">Вернуться в админку</a></section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
