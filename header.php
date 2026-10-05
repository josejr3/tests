<?php
//agregar un foter y un header en todas las webs
//agregar un secion para subir un pd que justiqieque que tu cuenta es tulla para retirar  saldo y que verifique que si es un pdf

session_start();

function mostrarHistorial(int $saldoActual, array $tiradas): void
{

    echo "<form>Saldo actual: " . $saldoActual . "</br>";

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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>