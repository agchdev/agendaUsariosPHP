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
            <input type="submit" class="btn" name="action" value="Amigos">
            <input type="submit" class="btn" name="action" value="Juegos">
            <input type="submit" class="btn" name="action" value="Prestamos">
            <input type="submit" class="btn red" name="action" value="Cerrar Sesion">
        </form>
    </section>
</body>
</html>