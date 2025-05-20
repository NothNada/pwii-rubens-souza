<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercicio1</title>
    <!--
    1 - Escreva um algoritmo que receba de entrada a distância total (em km) percorrida por um automóvel 
    e a quantidade de combustível (em litros) consumida para percorrê-la, calcule e imprima o consumo médio de combustível.  Fórmula: Consumo médio = Km / litros
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
        <label for="dst">distancia :</label>
        <input type="number" name="dst" id="dst" required><br><br>

        <label for="combustivel">combustível:</label>
        <input type="number" name="combustivel" id="combustivel" required><br><br>

        <input type="submit" value="Enviar">
    </form>

    <?php
        if(! (isset($_GET['dst']) and isset($_GET['combustivel']))){
            return;
        }

        $nota1 = $_GET['dst'];
        $nota2 = $_GET['combustivel'];

        $media = $nota1 / $nota2;
        echo "<h3>Consumo medio: $media L / Hora</h3>";

        
    ?>
</body>
</html>