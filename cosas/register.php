<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <title>Registro</title>
</head>
<body>
    <form action="register_logic.php" method="post">
        <label>Nombre<input type="text" name="name"></label>
        <label>Correo<input type="text" name="email"></label>
        <label>Contraseña<input type="password" name="pass"></label>
        <label>Repita la contraseña<input type="password" name="pass2"></label>
        <button type="submit">Registrarse</button>
        <a href="index.php">Volver al login</a>
    </form>
    
</body>
</html>