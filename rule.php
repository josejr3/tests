<?php
session_start();
pedir("saldo","index.php");

$_SESSION["mensajes"] ??= "";
$_SESSION["saldoEnjuego"] ??= 0;
$_SESSION["cantidadesApostadas"] ??= [];
$_SESSION["elecciones"] ??= [];
$_SESSION["tiradas"] ??= [];
$_SESSION["transacciones"] ??= [];
$_SESSION["mostrar"] ??=false;

$saldo = &$_SESSION["saldo"];
$saldoEnjuego = &$_SESSION["saldoEnjuego"];
$cantidadesApostadas = &$_SESSION["cantidadesApostadas"];
$elecciones = &$_SESSION["elecciones"];
$tiradas = &$_SESSION["tiradas"];
$transacciones = &$_SESSION["transacciones"];


function pedir(string $variable, string $url) {
    if (!empty($_POST[$variable])) {
        $_SESSION[$variable] = $_POST[$variable];
    } elseif (!isset($_SESSION[$variable])) {
        header('Location: ' . $url);
        exit;
    }
    return $_SESSION[$variable];
}

function color(int $numero): string{

    $rojos = [1, 3, 5, 7, 9, 12, 14, 16, 18, 19, 21, 23, 25, 27, 30, 32, 34, 36];

    $negros = [2, 4, 6, 8, 10, 11, 13, 15, 17, 20, 22, 24, 26, 28, 29, 31, 33, 35];

    if ($numero === 0) {

        return "verde";

    } elseif (in_array($numero, $rojos, true)) {

        return "rojo";

    } elseif (in_array($numero, $negros, true)) {

        return "negro";

    }

    return "";

}
function apostar(&$saldo, &$saldoEnjuego): int
{
    $cantidaAapuesta = -1;
    while ($cantidaAapuesta != 0) {
        echo "Cantidad a apostar (disponible " . ($saldo - $saldoEnjuego) . "): ";
        $cantidaAapuesta = (int) pedir("cantidaAapuesta", "cantidad.php");

        if ($cantidaAapuesta > $saldo - $saldoEnjuego) {

            echo "La apuesta no puede ser mayor que tu saldo\n";
            $cantidaAapuesta = 0;
        } elseif ($cantidaAapuesta <= 0) {

            echo "La apuesta no puede ser 0 o menor a 0\n";
            $cantidaAapuesta = 0;
        } else {
            return $cantidaAapuesta;
        }
    }
    return -1;
}
function apostarDocena(int $saldo, &$cantidadesApostadas, &$elecciones, &$saldoEnjuego): void
{
    $docena = (int) pedir("docena", "docena.php");

    if ($docena >= 1 && $docena <= 3) {
        $apuesta = apostar($saldo, $saldoEnjuego);
        $cantidadesApostadas[] = $apuesta;
        $elecciones[] = "docena" . $docena;
        $saldoEnjuego += $apuesta;
    } else {
        echo "opcion invalida\n";
    }
}



function mostrarMenu(): void{
    header('location:menu.php');
    exit;
}


function resultadoApuesta(int &$saldo, array &$transacciones, int $cantidad, bool $gana, int $multiplicador): void{

    if ($gana) {

        $transacciones[] = "+" . ($cantidad * $multiplicador);

        $saldo = $saldo + ($cantidad * $multiplicador);

        echo "Has ganado\n";

    } else {

        $transacciones[] = "-" . $cantidad;

        $saldo = $saldo - $cantidad;

        echo "Has perdido\n";

    }

}


function giraRuleta(int &$saldo, array &$transacciones, &$cantidadesApostadas, &$elecciones): array
{
    $ruleta = rand(0, 36);
    echo "Numero ganador: " . $ruleta . "\n";

    for ($i = 0; $i < count($cantidadesApostadas); $i++) {
        if (is_int($elecciones[$i])) {
            resultadoApuesta($saldo, $transacciones, $cantidadesApostadas[$i], $elecciones[$i] === $ruleta, 36);
        } elseif (is_string($elecciones[$i]) && strpos($elecciones[$i], "docena") !== false) {
            $docenaElegida = (int) $elecciones[$i][-1];
            $docenaGanadora = (int) ceil($ruleta / 12);

            if ($ruleta > 0 && $docenaElegida === $docenaGanadora) {
                resultadoApuesta($saldo, $transacciones, $cantidadesApostadas[$i], true, 2);
            } else {
                resultadoApuesta($saldo, $transacciones, $cantidadesApostadas[$i], false, 2);
            }
        } else {
            resultadoApuesta($saldo, $transacciones, $cantidadesApostadas[$i], $elecciones[$i] === color($ruleta), 1);
        }
    }

    return [$saldo, $transacciones, $cantidadesApostadas];
}



function apostarcolor(int &$saldo, &$cantidadesApostadas, &$elecciones, &$saldoEnjuego): void {

    $cantidaAapuesta = (int) pedir("cantidaAapuesta", "cantidad.php");

    if ($cantidaAapuesta > $saldo - $saldoEnjuego) {

        echo "La apuesta no puede ser mayor que tu saldo\n";

    } elseif ($cantidaAapuesta <= 0) {

        echo "La apuesta no puede ser 0 o menor a 0\n";

    } else {

       
        $eleccion = strtolower(trim((string) pedir("eleccion", "color.php")));

        echo "\n";

        if ($eleccion !== "rojo" && $eleccion !== "negro") {

            echo "Color no valido, escribe rojo o negro\n";

        } else {

            $cantidadesApostadas[] = $cantidaAapuesta;

            $elecciones[] = $eleccion;

            $saldoEnjuego += $cantidaAapuesta;

            echo "Apuesta registrada: $cantidaAapuesta al $eleccion\n";

        }

    }


}


function apostarNumero(int &$saldo, &$cantidadesApostadas, &$elecciones, &$saldoEnjuego): void {
    
    $cantidaAapuesta = (int) pedir("cantidaAapuesta", "cantidad.php");

    if ($cantidaAapuesta > $saldo - $saldoEnjuego) {

        $_SESSION["mensaje"]="<pre>La apuesta no puede ser mayor que tu saldo\n</pre>";
        $cantidaAapuesta = (int) pedir("cantidaAapuesta", "cantidad.php");
    } elseif ($cantidaAapuesta <= 0) {

        $_SESSION["mensaje"]="La apuesta no puede ser 0 o menor a 0</br>";
        $cantidaAapuesta = (int) pedir("cantidaAapuesta", "cantidad.php");

    } else {

     
        $eleccion = (int) pedir("eleccion", "numero.php");

        echo "\n";

        if ($eleccion < 0 || $eleccion > 36) {
            $_SESSION["mensaje"]="Numero no valido, escribe un numero del 0 al 36</br>";
            $eleccion = (int) pedir("eleccion", "numero.php");

        } else {

            $cantidadesApostadas[] = $cantidaAapuesta;

            $elecciones[] = $eleccion;

            $saldoEnjuego += $cantidaAapuesta;

            echo "Apuesta registrada: $cantidaAapuesta al $eleccion\n";

        }

    }

}




if ($saldo > 0) {
   
    $opcion = (int) pedir("opcion", "menu.php");

    switch ($opcion) {

        case 1:

            apostarNumero($saldo, $cantidadesApostadas, $elecciones, $saldoEnjuego);

            break;

        case 2:

            apostarcolor($saldo, $cantidadesApostadas, $elecciones, $saldoEnjuego);

            break;

        case 3:

            $tiradas[] = giraRuleta($saldo, $transacciones, $cantidadesApostadas, $elecciones);

            $transacciones = [];

            $cantidadesApostadas = [];

            $elecciones = [];

            $saldoEnjuego = 0;
            
            $_SESSION["mostrar"]=true;
            header("location:menu.php");
            exit;

            break;

        case 4:
            apostarDocena($saldo, $cantidadesApostadas, $elecciones, $saldoEnjuego);
            break;

        default:

            echo "Opcion no valida\n";

            break;

    }
    unset($_SESSION["opcion"], $_SESSION["cantidaAapuesta"], $_SESSION["eleccion"], $_SESSION["docena"]);
    mostrarMenu();


}


if ($saldo <= 0) {

    echo "Te has quedado sin saldo, no puedes apostar\n";

}

?>