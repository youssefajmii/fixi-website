<?php
declare(strict_types=1);

/*
 * Configuration locale XAMPP.
 * Valeurs habituelles de XAMPP : utilisateur root, mot de passe vide.
 * En production, utiliser des identifiants forts stockés hors du dossier public.
 */
$host = 'localhost';
$dbname = 'fixi';
$username = 'root';
$password = '';

try {
    $pdo = new PDO(
        "mysql:host={$host};dbname={$dbname};charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (PDOException $e) {
    exit('Connexion à la base de données impossible. Vérifiez XAMPP et config/database.php.');
}
