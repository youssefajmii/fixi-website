<?php
$pageTitle = 'Trouver un artisan';
require __DIR__ . '/includes/header.php';
$metier = trim($_GET['metier'] ?? '');
$ville = trim($_GET['ville'] ?? '');
?>
<main class="container py-5">
    <span class="eyebrow">ANNUAIRE FIXI</span>
    <h1 class="page-title">Trouver un artisan</h1>
    <p class="text-secondary">Recherchez par métier et par ville. Les profils seront affichés après validation par l'administration.</p>
    <form class="search-panel row g-3 mt-3" method="get">
        <div class="col-md-5"><label class="form-label" for="metier">Métier</label><input class="form-control" id="metier" name="metier" value="<?= htmlspecialchars($metier, ENT_QUOTES, 'UTF-8') ?>" placeholder="Plomberie, électricité..."></div>
        <div class="col-md-5"><label class="form-label" for="ville">Ville</label><input class="form-control" id="ville" name="ville" value="<?= htmlspecialchars($ville, ENT_QUOTES, 'UTF-8') ?>" placeholder="Sousse, Monastir..."></div>
        <div class="col-md-2 d-grid align-self-end"><button class="btn btn-fixi" type="submit">Rechercher</button></div>
    </form>
    <div class="empty-state mt-4">
        <div class="display-6">🧰</div>
        <h2 class="h5 mt-3">Les profils artisans arrivent bientôt</h2>
        <p class="text-secondary mb-0">La recherche sera connectée à la base de données dans la prochaine étape.</p>
    </div>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
