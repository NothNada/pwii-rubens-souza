

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body{
            background-color:#000;
            color:#fff;
            font-size:50px;
        }
    </style>
</head>
<body>
<?php
    echo "Hello World!<br>";
    echo "Hello World!<br>";
    echo "Hello World!<br>";

    $nome = "Rubens";
    $sobrenome = "Gabriel";
    $numero = 4;

    echo $nome . " triste " . "<br>";
    echo "${nome} <h1> ${sobrenome} </h1>";
    echo $numero . "<p> " . $nome . 
    " " . $sobrenome . "</p>";
?>
</body>
</html>
