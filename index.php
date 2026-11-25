<?php
$pageTitle = 'Accueil';
require __DIR__ . '/includes/header.php';
?>
<main>
    <section class="hero-section">
        <div class="container py-5 py-lg-6">
            <div class="row align-items-center g-5">
                <div class="col-lg-7">
                    <span class="eyebrow">LES BONS ARTISANS, PRÈS DE CHEZ VOUS</span>
                    <h1 class="hero-title mt-3">Trouvez le bon artisan.<br><span>Simplement.</span></h1>
                    <p class="hero-text mt-3">Plomberie, électricité, climatisation et bien plus : découvrez des professionnels, consultez leurs profils et contactez-les directement.</p>
                    <form class="search-panel row g-2 mt-4" action="artisans.php" method="get">
                        <div class="col-md-5">
                            <label class="form-label small fw-semibold" for="metier">Quel service recherchez-vous ?</label>
                            <input class="form-control" id="metier" name="metier" placeholder="Ex. Plombier">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-semibold" for="ville">Dans quelle ville ?</label>
                            <input class="form-control" id="ville" name="ville" placeholder="Ex. Sousse">
                        </div>
                        <div class="col-md-3 d-grid align-self-end">
                            <button class="btn btn-fixi btn-lg" type="submit">Rechercher</button>
                        </div>
                    </form>
                    <div class="hero-note mt-3">Gratuit pour les clients et les artisans.</div>
                </div>
                <div class="col-lg-5">
                    <div class="hero-card">
                        <div class="hero-card-icon">🔧</div>
                        <div class="hero-card-label">FIXI vous connecte</div>
                        <div class="hero-card-title">Compétence locale.<br>Contact direct.</div>
                        <div class="hero-card-line"></div>
                        <div class="d-flex justify-content-between small text-secondary">
                            <span>Artisans vérifiés par FIXI</span><strong>✓</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container py-5">
        <div class="section-heading">
            <span class="eyebrow">NOS DOMAINES</span>
            <h2>Quel professionnel vous faut-il ?</h2>
            <p>Explorez les métiers et trouvez un artisan selon votre besoin.</p>
        </div>
        <div class="row g-3 mt-2">
            <?php
            $categories = [
                ['Plomberie', 'Réparation et installation', '🔧'],
                ['Électricité', 'Installation et dépannage', '⚡'],
                ['Climatisation', 'Entretien et réparation', '❄️'],
                ['Menuiserie', 'Bois, portes et meubles', '🪚'],
                ['Peinture', 'Peinture et finition', '🖌️'],
                ['Maçonnerie', 'Construction et rénovation', '🧱'],
            ];
            foreach ($categories as $category):
            ?>
            <div class="col-6 col-lg-4">
                <a class="category-card" href="artisans.php?metier=<?= urlencode($category[0]) ?>">
                    <span class="category-icon"><?= $category[2] ?></span>
                    <strong><?= htmlspecialchars($category[0]) ?></strong>
                    <small><?= htmlspecialchars($category[1]) ?></small>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="how-section py-5" id="how-it-works">
        <div class="container">
            <div class="section-heading">
                <span class="eyebrow">COMMENT ÇA MARCHE ?</span>
                <h2>Trois étapes, en toute simplicité.</h2>
            </div>
            <div class="row g-4 mt-2">
                <div class="col-md-4"><div class="step-card"><span>01</span><h3>Recherchez</h3><p>Choisissez un métier et une ville pour trouver les professionnels disponibles.</p></div></div>
                <div class="col-md-4"><div class="step-card"><span>02</span><h3>Comparez</h3><p>Consultez les profils, les expériences, les tarifs et les évaluations.</p></div></div>
                <div class="col-md-4"><div class="step-card"><span>03</span><h3>Contactez</h3><p>Contactez directement l'artisan par le moyen qu'il a choisi.</p></div></div>
            </div>
        </div>
    </section>

    <section class="container py-5 text-center">
        <h2 class="cta-title">Vous êtes artisan ?</h2>
        <p class="text-secondary">Présentez votre savoir-faire et faites-vous connaître auprès de nouveaux clients.</p>
        <a class="btn btn-fixi btn-lg px-4" href="auth/register.php?type=artisan">Rejoindre FIXI</a>
    </section>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
