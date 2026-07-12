<?php
/**
 * Dees Boutique Hotel — Database Connection (PDO)
 * Update the credentials below to match your local/hosting environment.
 */

define('DB_HOST', 'localhost');
define('DB_NAME', 'dees_hotel');
define('DB_USER', 'root');
define('DB_PASS', '');

// Base URL / site path — used for image paths & links. Adjust for your server.
define('BASE_URL', '/dees_hotel/');

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    );
} catch (PDOException $e) {
    // In production, log this instead of exposing details.
    die('Database connection failed: ' . $e->getMessage());
}
