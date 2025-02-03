<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda de Usuarios</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <header>
        <nav>
            <div>
                <h1>Agenda de Usuarios</h1>
            </div>
            <div>
                <form action="index.php" method="post">
                    <button type="submit" name="action" value="usuariosAdmin" class="btn off">Usuarios</button>
                    <button type="submit" name="action" value="amigosAdmin" class="btn off">Amigos</button>
                    <button type="submit" name="action" value="cerrarSesion" class="btn off red">Cerrar Sesión</button>
                    <input type="hidden" name="usuario" value="<?php echo $usuario; ?>">
                </form>
            </div>
        </nav>
    </header>