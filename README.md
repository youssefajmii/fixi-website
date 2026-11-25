# FIXI — Plateforme tunisienne de mise en relation

Prototype web en PHP 8+, MySQL, HTML, CSS, JavaScript et Bootstrap 5.

## Choix fonctionnels confirmés
- Deux types de comptes séparés : Client ou Artisan.
- Français par défaut, arabe (RTL) et anglais prévus.
- Inscription réservée aux personnes de 18 ans et plus.
- Profil artisan soumis à validation par l'administration avant publication.
- CV PDF + informations d'expérience affichées dans le profil.
- Recherche par métier et ville, filtres prix/disponibilité/note.
- Contact direct selon les moyens choisis par l'artisan.
- Avis après confirmation de la prestation par les deux parties.
- Zones d'intervention visibles, sans afficher l'adresse privée de l'artisan.
- Prix fixe ou « sur devis ».

## Installation locale (Windows + XAMPP)
1. Installer et démarrer Apache et MySQL depuis XAMPP.
2. Copier le dossier `FIXI` dans `C:\xampp\htdocs\`.
3. Ouvrir `http://localhost/phpmyadmin`.
4. Créer/importer la base en important `database/fixi.sql`.
5. Vérifier les paramètres dans `config/database.php`.
6. Ouvrir `http://localhost/FIXI/`.

## Compte administrateur
La création du premier administrateur sera ajoutée dans une étape dédiée avec un mot de passe hashé. Ne pas créer un compte admin public via le formulaire d'inscription.

## Sécurité à compléter avant une mise en production
Ce dossier est un point de départ de développement, pas encore une version prête à publier.
Avant le déploiement, ajouter notamment : vérification d'email réelle, CSRF, limitation des tentatives de connexion, validation stricte des fichiers téléversés, journalisation, sauvegardes, HTTPS et tests de sécurité.
