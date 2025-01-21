<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <section>
        <h2>Amigos de <?php if(isset($u)) echo $u ?></h2>
        <?php
            if (count($amigosUsu) == 0) {
                echo "NO TIENE AMIGOS ACTUALMENTE";
            }else{
                echo "<form action='index.php' method='post'>";
                echo "<input type='hidden' name='id_usuario' value='" . $amig["id_usuario"] . "'>"; 
                echo "<table>";
                    echo "<tr><th>NOMBRE</th><th>APELLIDOS</th><th>FECHA NACIMIENTO</th></tr>";
                    echo "<tr>";
                    foreach ($amigosUsu as $amig) {
                        echo "<input type='hidden' name='id' value='" . $amig["id"] . "'>"; 
                        echo "</td>" . $amig["nombre"] . "</td>";
                        echo "</td>" . $amig["apellidos"] . "</td>";
                        echo "</td>" . $amig["fecha_nac"] . "</td>";
                    }
                    echo "</tr>";
                echo "</table>";
                echo "</form>";
            }
            ?>
    </section>
</body>
</html>