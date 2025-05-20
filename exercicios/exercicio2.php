<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercicio2</title>
    <!--
    2- Escreva um algoritmo que calcule e apresente o volume de uma caixa retangular por meio da seguinte fórmula: volume = comprimento x largura x altura
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
        <label for="comprimento">comprimento :</label>
        <input type="number" name="comprimento" id="comprimento" required><br><br>

        <label for="largura">largura:</label>
        <input type="number" name="largura" id="largura" required><br><br>

        <label for="altura">altura:</label>
        <input type="number" name="altura" id="altura" required><br><br>

        <input type="submit" value="Enviar">
    </form>

    <?php
        if(! (isset($_GET['comprimento']) and isset($_GET['largura']) and isset($_GET['altura']))){
            return;
        }

        $nota1 = $_GET['comprimento'];
        $nota2 = $_GET['largura'];
        $nota3 = $_GET['altura'];


        $media = $nota1 * $nota2 * $nota3;
        echo "<h3>Volume: $media</h3>";

        
    ?>
</body>
</html>