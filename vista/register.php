<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body id="bodyInicio">
    <?php
        if(isset($msg)){
            ?>
            <div class="popup">
                <?php
                    echo $msg;
                ?>
                <button class="btn">Cerrar</button>
            </div>
            <?php
        }
    ?>
    <main id="inicio" class="modal">
        <h2>LOGIN</h2>
        <form class="formInicio" action="index.php" method="post">
            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario" id="usuario" placeholder="Introduce tu usuario" required>
            <label for="contrasenia">Contraseña:</label>
            <input type="password" name="contrasenia" placeholder="Introduce tu contraseña" required>
            <input type="password" name="contrasenia2" placeholder="Repite tu contraseña" required>
            <button  class="btn" type="submit" name="action" value="registarUsuario">Registrarse</button>
        </form>
        <form class="insertar" action="index.php" method='post'>    
            <button style="margin-top:1rem" class="btn" type="submit" name="action" value="usuariosAdmin">Volver</button>
        </form>
    </main>
    <script src="../scripts/main.js"></script>
</body>
</html>