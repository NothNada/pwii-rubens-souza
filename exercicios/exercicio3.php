<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercicio3</title>
    <!--
    Escreva um algoritmo que receba dois valores, calcule e apresente a área de um trapézio.
    -->
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


    <form type="get">
        <label for="bme">base menor :</label>
        <input type="number" name="bme" id="bme" required><br><br>

        <label for="bma">base maior:</label>
        <input type="number" name="bma" id="bma" required><br><br>

        <label for="alt">altura:</label>
        <input type="number" name="alt" id="alt" required><br><br>

        <input type="submit" value="Enviar">
    </form>

    <?php
        if(! (isset($_GET['bme']) and isset($_GET['bma']) and isset($_GET['alt']))){
            return;
        }

        $nota1 = $_GET['bme'];
        $nota2 = $_GET['bma'];
        $nota3 = $_GET['alt'];

        $media = ($nota1 + $nota2) * $nota3;
        $media = $media / 2;
        echo "<h3>Area do trapezio: $media </h3>";

        
    ?>
</body>
</html>