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
          <button type="submit" name="docena" value="1"> 1 - 12 </button>
          <button type="submit" name="docena" value="2"> 13 - 24</button>
          <button type="submit" name="docena" value="3"> 25 - 36 </button>
       </br>

</form>
    
</body>
</html>