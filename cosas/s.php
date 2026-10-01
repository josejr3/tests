<?php
$saldo = (int) readline("Cuanto es tu saldo: ");
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


function mostrarMenu(): void
{
   echo "Escoje una opcion\n1.Apostar numero\n2.Apostar color\n3.Girar ruleta\n4.Salir\n";
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


function giraRuleta(int &$saldo, array &$transacciones, &$cantidadesApostadas,&$elecciones): array
{
   $ruleta = rand(0, 36);
   echo "Numero ganador: " . $ruleta . "\n";
   for ($i = 0; $i < (count($cantidadesApostadas)); $i++) {


       if (is_int($elecciones[$i])) {
           resultadoApuesta($saldo, $transacciones, $cantidadesApostadas[$i], $elecciones[$i] === $ruleta, 36);
       } else {
           resultadoApuesta($saldo, $transacciones, $cantidadesApostadas[$i], $elecciones[$i] === color($ruleta), 1);
       }


   }
   return [$saldo, $transacciones, $cantidadesApostadas];


}


function apostarcolor(int &$saldo, &$cantidadesApostadas,&$elecciones,&$saldoEnjuego) : void {
   $cantidaAapuesta = (int) readline("Cantidad a apostar (disponible " . ($saldo - $saldoEnjuego) . "): ");
   if ($cantidaAapuesta > $saldo - $saldoEnjuego) {
       echo "La apuesta no puede ser mayor que tu saldo\n";
   } elseif ($cantidaAapuesta <= 0) {
       echo "La apuesta no puede ser 0 o menor a 0\n";
   } else {
       $eleccion = strtolower(trim((string) readline("A que color vas a apostar (rojo o negro): ")));
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

function apostarDocena(){
    
}


function apostarNumero(int &$saldo, &$cantidadesApostadas, &$elecciones,&$saldoEnjuego): void
{
   $cantidaAapuesta = (int) readline("Cantidad a apostar (disponible " . ($saldo - $saldoEnjuego) . "): ");
   if ($cantidaAapuesta > $saldo - $saldoEnjuego) {
       echo "La apuesta no puede ser mayor que tu saldo\n";
   } elseif ($cantidaAapuesta <= 0) {
       echo "La apuesta no puede ser 0 o menor a 0\n";
   } else {
       $eleccion = (int) readline("A que numero vas a apostar (0-36): ");
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


function mostrarHistorial(int $saldo, array $tiradas): void
{
   echo "Saldo actual: " . $saldo . "\n";
   echo "Historial de transacciones hasta el momento:\n";
   foreach ($tiradas as $key => $tirada) {
       echo "Tirada: " . ($key + 1) . "\n";
       echo "Saldo: " . $tirada[0] . "\n";
       echo "Apostado: " . implode(", ", $tirada[2]) . "\n";
       echo "Resultado: " .implode(", ", $tirada[1]) . "\n";
       echo "---------------------------------\n";
   }
}


while ($saldo > 0) {


   mostrarMenu();
   $opcion = readline();
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
           mostrarHistorial($saldo, $tiradas);
           break;
       case 4:
           break 2;
       default:
           echo "Opcion no valida\n";
           break;
   }


}

if ($saldo <= 0) {
   echo "Te has quedado sin saldo, no puedes apostar\n";
}
