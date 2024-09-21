<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=otakuopine_login', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Verbindung zur Datenbank fehlgeschlagen: " . $e->getMessage());
}
?>