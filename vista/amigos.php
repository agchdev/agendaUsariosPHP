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
                echo "<table>";
                    echo "<tr><th>NOMBRE</th><th>APELLIDOS</th><th>FECHA NACIMIENTO</th></tr>";
                    echo "<tr>";
                    foreach ($amigosUsu as $amig) {
                        echo "<input type='hidden' name='alumno' value='" . $amig["id"] . "'>"; 
                        echo "<input type='hidden' name='dniAlum' value='" . $amig["nombre"] . "'>"; 
                        echo "<input type='hidden' name='dniAlum' value='" . $amig["apellidos"] . "'>"; 
                        echo "<input type='hidden' name='nomAlum' value='" . $amig["fecha_nac"] . "'>";
                        echo "<td>";
                    }
                    echo "</td>" . $amig["nombre"] . "</td>";
                echo "</table>";
                echo "</form>";
            }
            ?>
    </section>
</body>
</html>