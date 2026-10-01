<?php

session_start();

function mostrarHistorial(int $saldo, array $tiradas): void
{   


    echo "<form>Saldo actual: " . $saldo . "</br>";

    echo "Historial de transacciones hasta el momento:</br>";

    foreach ($tiradas as $key => $tirada) {

        echo "Tirada: " . ($key + 1) . "</br>";

        echo "Saldo: " . $tirada[0] . "</br>";

        echo "Apostado: " . (count($tirada[2]) > 0 ? implode(", ", $tirada[2]) : "Ninguna") . "</br>";

        echo "Resultado: " . (count($tirada[1]) > 0 ? implode(", ", $tirada[1]) : "Sin apuestas") . "</br>";

        echo "---------------------------------</br><form>";

    }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <?php
        if (isset($_SESSION["mostrar"])&& $_SESSION["mostrar"]===true) {
             $_SESSION["mostrar"]=false;
            mostrarHistorial($_SESSION["saldo"],$_SESSION["tiradas"]);
           
        }
    ?>
    <form action="rule.php" method="post">
        <?php  echo"Saldo actual:". $_SESSION["saldo"]."</br>"; ?>
        Escoje un numeo de opcion
        <p>1.Apostar numero</br>
           2.Apostar color</br>
           3.Girar ruleta</br>
           4.Apostar docena</br>
        </p>
        <label><input type="text" name="opcion"></label> 
        <button type="submit">enviar</button>
    </form>
</body>
</html>