<?php
require "header.php";
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
    if (isset($_SESSION["mostrar"]) && $_SESSION["mostrar"] === true) {
        $_SESSION["mostrar"] = false;
        mostrarHistorial($_SESSION["saldoEnjuego"]-$_SESSION["saldo"], $_SESSION["tiradas"]);

    }
    ?>
    <form action="rule.php" method="post">
        <?php echo "Saldo actual:" . $_SESSION["saldo"] . "</br>"; ?>
        Escoje un numeo de opcion
        <form action="rule.php" method="post">
            <p>Saldo actual: <?php echo $_SESSION["saldo"]; ?></p>

            <p>Escoge un número de opción:</p>
            <button type="submit" name="opcion" value="1"> Apostar número</button>
            <button type="submit" name="opcion" value="2"> Apostar color</button>
            <button type="submit" name="opcion" value="3"> Girar ruleta</button>
            <button type="submit" name="opcion" value="4"> Apostar docena</button>
        </form>

    </form>
</body>

</html>