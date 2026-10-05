<?php
session_start();

$_SESSION["semilla"] ??= random_int(1, 999999);
$_SESSION["entradas"] ??= [];

if (isset($_POST["entrada"])) {
    $_SESSION["entradas"][] = $_POST["entrada"];
    header('Location: ' . $_SERVER["REQUEST_URI"]);
    exit;
}

mt_srand($_SESSION["semilla"]);
$posicion = 0;
echo "<pre>";

function leer(string $prompt = ""): string
{
    global $posicion;
    echo $prompt;

    if (!isset($_SESSION["entradas"][$posicion])) {
        echo '</pre><form method="post"><input type="text" name="entrada" autofocus><button>enviar</button></form>';
        exit;
    }

    $respuesta = $_SESSION["entradas"][$posicion++];
    echo $respuesta . "\n";
    return $respuesta;
}

$saldo = (int) leer("Cuanto es tu saldo: ");

$saldoEnjuego=0;

echo "\n";

$transacciones = [];

$cantidadesApostadas = [];

$tiradas = [];

$elecciones=[];


function color(int $numero): string

{

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
function apostar(&$saldo,&$saldoEnjuego):int{
  $cantidaAapuesta=-1;
  while ($cantidaAapuesta!=0){
  $cantidaAapuesta = (int) leer("Cantidad a apostar (disponible " . ($saldo - $saldoEnjuego));

   if ($cantidaAapuesta > $saldo - $saldoEnjuego) {

       echo "La apuesta no puede ser mayor que tu saldo\n";
      $cantidaAapuesta=0;
   } elseif ($cantidaAapuesta <= 0) {

       echo "La apuesta no puede ser 0 o menor a 0\n";
        $cantidaAapuesta=0;
   } else {
     return $cantidaAapuesta;
   }
  }
  return -1;
}
function apostarDocena(int $saldo, &$cantidadesApostadas, &$elecciones, &$saldoEnjuego): void{
  echo "cuan docena \n 1. (1-12)\n2. (13-24)\n 3. (25-36)\n";
  $docena = (int) leer();
  
  if ($docena >= 1 && $docena <= 3) {
      $apuesta = apostar($saldo, $saldoEnjuego);
      $cantidadesApostadas[] = $apuesta;
      $elecciones[] = "docena" . $docena;
      $saldoEnjuego += $apuesta;
  } else {
      echo "opcion invalida\n";
  }
}



function mostrarMenu(): void {

   echo "Escoje una opcion\n1.Apostar numero\n2.Apostar color\n3.Girar ruleta\n4.Apprtar docena\n";

}


function resultadoApuesta(int &$saldo, array &$transacciones, int $cantidad, bool $gana, int $multiplicador): void

{

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



function apostarcolor(int &$saldo, &$cantidadesApostadas,&$elecciones,&$saldoEnjuego) : void {

   $cantidaAapuesta = (int) leer("Cantidad a apostar (disponible " . ($saldo - $saldoEnjuego) . "): ");

   if ($cantidaAapuesta > $saldo - $saldoEnjuego) {

       echo "La apuesta no puede ser mayor que tu saldo\n";

   } elseif ($cantidaAapuesta <= 0) {

       echo "La apuesta no puede ser 0 o menor a 0\n";

   } else {

       $eleccion = strtolower(trim((string) leer("A que color vas a apostar (rojo o negro): ")));

       echo "\n";

       if ($eleccion !== "rojo" && $eleccion !== "negro") {

           echo "Color no valido, escribe rojo o negro\n";

       } else {

           $cantidadesApostadas[] = $cantidaAapuesta;

           $elecciones[]= $eleccion;

           $saldoEnjuego += $cantidaAapuesta;

           echo "Apuesta registrada: $cantidaAapuesta al $eleccion\n";

       }

   }


}


function apostarNumero(int &$saldo, &$cantidadesApostadas, &$elecciones,&$saldoEnjuego): void

{

   $cantidaAapuesta = (int) leer("Cantidad a apostar (disponible " . ($saldo - $saldoEnjuego) . "): ");

   if ($cantidaAapuesta > $saldo - $saldoEnjuego) {

       echo "La apuesta no puede ser mayor que tu saldo\n";

   } elseif ($cantidaAapuesta <= 0) {

       echo "La apuesta no puede ser 0 o menor a 0\n";

   } else {

       $eleccion = (int) leer("A que numero vas a apostar (0-36): ");

       echo "\n";

       if ($eleccion < 0 || $eleccion > 36) {

           echo "Numero no valido, escribe un numero del 0 al 36\n";

       } else {

           $cantidadesApostadas[]= $cantidaAapuesta;

           $elecciones[]= $eleccion;

           $saldoEnjuego += $cantidaAapuesta;

           echo "Apuesta registrada: $cantidaAapuesta al $eleccion\n";

       }

   }

}




while ($saldo > 0) {


   mostrarMenu();

   $opcion = leer();

   switch ($opcion) {

       case 1:

           apostarNumero($saldo, $cantidadesApostadas,$elecciones,$saldoEnjuego);

           break;

       case 2:

           apostarcolor($saldo,$cantidadesApostadas,$elecciones,$saldoEnjuego);

           break;

       case 3:

           $tiradas[] = giraRuleta($saldo, $transacciones, $cantidadesApostadas, $elecciones);

           $transacciones = [];

           $cantidadesApostadas = [];

           $elecciones = [];

           $saldoEnjuego=0;

           mostrarHistorial($saldoEnjuego-$saldo, $tiradas);

           break;
              
       case 4:
          apostarDocena($saldo,$cantidadesApostadas, $elecciones,$saldoEnjuego);
           break;

       default:

           echo "Opcion no valida\n";

           break;

   }


}


if ($saldo <= 0) {

   echo "Te has quedado sin saldo, no puedes apostar\n";

}
echo "</pre>";
session_destroy();
echo '<p><a href="">Jugar de nuevo</a></p>';