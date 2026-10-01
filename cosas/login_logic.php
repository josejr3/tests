<?php
include_once "connection.php";

$email = !empty($_POST["email"]) ? $_POST["email"] :  false;
$pass = !empty($_POST["pass"]) ? $_POST["pass"] :  false;