<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body id="bodyHome">
    <section class="home">
        <h2>Bienvenid@ <?php if(isset($usuario)) echo $usuario ?></h2>
        <form action="index.php" method="post">
            <input type="hidden" name="usuario" value="<?php echo $usuario ?>">
            <button type="submit" class="btn off" name="action" value="Amigos ADMIN">Amigos</button>
            <button type="submit" name="action" value="usuariosAdmin" class="btn off">Usuarios</button>
        </form>
    </section>
</body>
</html>