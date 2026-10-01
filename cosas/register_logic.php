<?php
include_once "connection.php";

$name =  empty($_POST["email"]) ? false : $_POST["email"] ;
$email = empty($_POST["email"]) ? false : $_POST["email"] ;
$pass =  empty($_POST["pass"])  ? false : $_POST["pass"];
$pass2 = empty($_POST["pass2"]) ? false : $_POST["pass"] ;

$name_msg=$name ? "El nombre no puede estar vacio" : "" ;
$email_msg=$email ? "El correo no puede estar vacio" : "";
$email_msg=filter_var($email,FILTER_VALIDATE_EMAIL) ?  "El correo no es valido" : $email_msg ;
$pass_msg=$pass ? "Las contraseña es obligatoria" : "";

if ($pass &&$pass != $pass2 ) {
    $pass_msg="Las contraseñas no coinsiden";
}

if ($name_msg==="" && $email_msg==="" && $pass_msg==="") {
    $hash= password_hash($pass,PASSWORD_BCRYPT);
    $conn->
}

