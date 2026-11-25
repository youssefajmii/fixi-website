<?php
if (!isset($pageTitle)) {
    $pageTitle = 'FIXI';
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?> | FIXI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="assets/img/fixi-logo.png" alt="FIXI" class="brand-logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-label="Ouvrir le menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                <li class="nav-item"><a class="nav-link" href="index.php">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="artisans.php">Trouver un artisan</a></li>
                <li class="nav-item"><a class="nav-link" href="#how-it-works">Comment ça marche</a></li>
                <li class="nav-item">
                    <select class="form-select form-select-sm language-select" id="languageSelect" aria-label="Langue">
                        <option value="fr" selected>FR</option>
                        <option value="ar">عربي</option>
                        <option value="en">EN</option>
                    </select>
                </li>
                <li class="nav-item"><a class="btn btn-outline-dark btn-sm px-3" href="auth/login.php">Connexion</a></li>
                <li class="nav-item"><a class="btn btn-fixi btn-sm px-3" href="auth/register.php">Inscription</a></li>
            </ul>
        </div>
    </div>
</nav>
