<?php
require_once __DIR__ . '/../includes/auth.php';
requireAdmin();
recalculateAllPredictions(getDb());
$pageTitle = 'Recalcularea punctelor';
require __DIR__ . '/../includes/header.php';
?>
<section class="hero"><div><p class="eyebrow">Gata</p><h1>Punctele au fost recalculate</h1><p>Toate meciurile cu rezultat introdus au fost procesate din nou.</p></div><a class="btn btn-primary" href="dashboard.php">Înapoi la administrare</a></section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
