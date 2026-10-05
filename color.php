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
          A que color vas a apostar
        <button type="submit" name="eleccion" value="negro">Negro</button>
        <button type="submit" name="eleccion" value="rojo">rojo</button>
</form>
    
    
</body>
</html>