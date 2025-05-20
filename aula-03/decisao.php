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


    <form type="get" action="decisao.php">
        <label for="nota1">Nota 1:</label>
        <input type="number" name="nota1" id="nota1" required><br><br>

        <label for="nota2">Nota 2:</label>
        <input type="number" name="nota2" id="nota2" required><br><br>

        <input type="submit" value="Enviar">
    </form>


    <?php
        if(! isset($_GET['nota1'])){
            return;
        }
        $nota1 = $_GET['nota1'];
        $nota2 = $_GET['nota2'];
        

        $media = ($nota1 + $nota2) / 2;
        $resultado = ($media > 6) ? "Aprovado" : (($media > 4 && $media < 6) ? "Recuperação" : "Reprovado");
        echo "<h3>A média é: $media</h3>";
        echo "<h3>Resultado: $resultado</h3>";

    ?>
</body>
</html>
