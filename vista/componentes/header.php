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
                    <input type="submit" name="action" value="amigos" class="btn off"></input>
                    <input type="submit" name="action" value="juegos" class="btn off"></input>
                    <input type="submit" name="action" value="prestamos" class="btn off"></input>
                    <input type="submit" name="action" value="cerrarSesion" class="btn off red"></input>
                    <input type="hidden" name="usuario" value="<?php echo $usuario; ?>">
                </form>
            </div>
        </nav>
    </header>