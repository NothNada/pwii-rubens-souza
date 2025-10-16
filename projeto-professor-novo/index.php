<?php

// session_start(), serve para inciar uma sessão
// serve basicamente para salvar informações dentro do servidor para cada cliente q acessar o site
// ele salva um token no lado do cliente, um token nos COOKIES
// e fica salvo um arquivo dentro do servidor, um arquivo com cada informação de cada usuario

session_start();

// aqui eu pego a variavel $pdo q serve para a conekção do banco de dados
require 'db.php';

// aqui faço a verificação se o usuario está logado, se não redireciono para o login.php
// isset(), serve para ver se a variavel tem algum coisa, se tiver vai ser True, se não vai ser False
// o ' ! ', serve para inverter o sinal, então se a variavel não estiver iniciada, então vai retornar False
// porcausa do ' ! ', retorna True, e redireciona
// o $_SESSION[], serve para pegar informações da sessão do usuario
if (!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

try{

    $stmt = $pdo->prepare("select * from usuarios where id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

}catch (PDOException $e){
    die("ERRO: " . $e->GetMessage());
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 12px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 450px;
            padding: 40px;
            position: relative;
            overflow: hidden;
        }

        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
            font-weight: 600;
            font-size: 28px;
        }

        .btn-submit {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 7px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-submit:active {
            transform: translateY(0);
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- estes campos servem para mostrar variaveis do php, sem q uma falha de segurança chamada xss -->

        <h1> Olá <?= htmlspecialchars($usuario['nome'], ENT_QUOTES, 'UTF-8') ?> </h1>
        
        <h1> Email: <?= htmlspecialchars($usuario['email'], ENT_QUOTES, 'UTF-8') ?> </h1>
        
        <h1> CPF: <?= htmlspecialchars($usuario['cpf'], ENT_QUOTES, 'UTF-8') ?> </h1>

        <!-- aqui no botão o windo.location.href, serve para mandar para outra pagina do site -->

        <button class="btn-submit" onclick="window.location.href = 'logout.php' ">Deslogar</button>
    </div>
</body>
</html>