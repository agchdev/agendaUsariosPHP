<div id="bodyAmigos">
    <section class="amigos">
        <h2>Amigos de <span><?php if(isset($usuario)) echo $usuario ?></span></h2>
        <?php
            if (count($amigosUsu) == 0) {
                echo "NO TIENE AMIGOS ACTUALMENTE";
            }else{
                ?>
                <form class="buscador" action="index.php" method='post'>    
                    <input class="busca" type="text" name="buscador" placeholder="Buscar...">
                    <input type="submit" class="btn" value="Enviar">
                    <input type="hidden" name="usuario" value="<?php $usuario ?>">
                    <input type="hidden" name="action" value="amigos">
                </form>
                <?php
                echo "<form action='index.php' method='post'>"; 
                echo "<table>";
                    echo "<tr><th>NOMBRE</th><th>APELLIDOS</th><th>FECHA NACIMIENTO</th></tr>";
                    
                    foreach ($amigosUsu as $amig) {
                        echo "<tr>";
                        echo "<input type='hidden' name='id_usuario' value='" . $amig["id_usuario"] . "'>";
                        echo "<input type='hidden' name='id' value='" . $amig["id"] . "'>"; 
                        echo "<td class='nombre'>" . $amig["nombre"] . "</td>";
                        echo "<td class='apellidos'>" . $amig["apellidos"] . "</td>";
                        echo "<td>" . $amig["fecha_nac"] . "</td>";
                        echo "</tr>";
                    }
                    
                echo "</table>";
                echo "</form>";
            }
            ?>
    </section>
</div>
</body>
</html>