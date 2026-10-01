<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <form action="rule.php" method="post">
        <?php echo "Cantidad a apostar (disponible " . ($_SESSION["saldo"] - $_SESSION["saldoEnjuego"]) . ") ";?>
        <label><input type="text" name="cantidaAapuesta"></label> 
        <button type="submit">enviar</button>
        </form>
</body>
</html>