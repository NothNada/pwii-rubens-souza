<?php

// Esse arquivo ele é separado, para não precisar escrever o mesmo codigo varias vezes
// Ele já cria uma variavel $pdo, que é responsavel pela connection com o banco de dados
// Eu não consigo escrever a letra q vem depois do  e na palavra conekção pq meu teclado tá fodido

// Essas são as variaveis para a conekção
$host = '127.0.0.1';
$dbname = 'teste';
$username_db = 'root';
$password_db = '12345678';

// o try ele é necessario para caso ocorra algum erro

try {
    
    // Variavel para conekção ao banco de dados
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username_db, $password_db, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);


} catch (PDOException $e) {

    // se ocorrer algum erro, ele mostra o erro

    die("Erro na conexão PDO: " . $e->getMessage());
}

?>