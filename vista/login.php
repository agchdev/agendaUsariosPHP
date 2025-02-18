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
            <input type="text" name="usuario" id="usuario" placeholder="Introduce tu usuario" value="<?php
                if(isset($_COOKIE["usuario"])) echo $_COOKIE["usuario"];
            ?>" required>
            <label for="contrasenia">Contraseña:</label>
            <input type="password" name="contrasenia" id="contrasenia" placeholder="Introduce tu contraseña" required>
            <div>
                <input type="checkbox" name="rec" <?php if(isset($_COOKIE["usuario"])) echo "checked"; ?>>
                <label for="recordar">Recordarme</label>
            </div>
            
            <input type="submit" class="btn" value="Iniciar sesión">
            <input type="hidden" name="action" value="login">
        </form>
    </main>
    <script src="../scripts/main.js"></script>
</body>
</html>