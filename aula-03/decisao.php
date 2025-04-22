<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Condição</title>
    <style>
        body {
            flex-direction: column;
            background-color: #333;
            color: #fff;
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
        }
    </style>
</head>
<body>
    <?php
        $nota1 = 5;
        $nota2 = 9;
        $media = ($nota1 + $nota2) / 2;
        echo "<h3>A média é: $media</h3>";
        if ($media >= 6) {
            echo "<h3>Aprovado!</h3>";
        } elseif ($media > 4 && $media < 6) {
            echo "<h3>Recuperação!</h3>";
        } else {
            echo "<h3>Reprovado!</h3>";
        }

    ?>
</body>
</html>