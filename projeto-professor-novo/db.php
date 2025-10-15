<?php

$host = '127.0.0.1';
$dbname = 'mysql';
$username_db = 'root';
$password_db = '12345678';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username_db, $password_db, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("Erro na conexão PDO: " . $e->getMessage());
}

?>