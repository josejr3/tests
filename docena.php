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
         Cual docena</br>
         1. (1-12)</br>
         2. (13-24)</br>
         3. (25-36)</br>
        <label><input type="text" name="docena"></label> 
        <button type="submit">enviar</button>
</form>
    
    
</body>
</html>