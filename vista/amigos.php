<!-- VISTA DE AMIGOS :) -->
<div id="bodyAmigos">
    <section class="amigos">
        <h2>Amigos de <span><?php if(isset($usuario)) echo $usuario ?></span></h2>
        <?php
            if (count($amigosUsu) == 0) {
                echo "NO TIENE AMIGOS ACTUALMENTE";
            }else{
                ?>
                <?php
                echo "<form action='index.php' method='post'>"; 
                echo "<table class='table'>";
                    echo "<tr><th>NOMBRE</th><th>APELLIDOS</th><th>FECHA NACIMIENTO</th><th></th></tr>";
                    
                    foreach ($amigosUsu as $amig) {
                        echo "<tr>";
                        echo "<input type='hidden' name='id_usuario' value='" . $amig["id_usuario"] . "'>";
                        echo "<input type='hidden' name='id' value='" . $amig["id"] . "'>"; 
                        echo "<td class='nombre'>" . $amig["nombre"] . "</td>";
                        echo "<td class='apellidos'>" . $amig["apellidos"] . "</td>";
                        echo "<td>" . $amig["fecha_nac"] . "</td>";
                        echo "<td><input type='submit' class='btn off' name='action' value='Modificar'></td>";
                        echo "</tr>";
                    }
                    
                echo "</table>";
                echo "<div style= 'display:flex; gap:1rem;margin-top: 1.5rem;'> <input type='submit' class='btn' name='action value='Buscar Amigos'>
                    <input type='hidden' name='usuario' value='".$usuario."'>";
                echo "<input type='submit' class='btn' name='action' value='Insertar Amigo'>";
                echo "</div></form>";
            }
            
            ?>
            <form class="buscador" action="index.php" method='post'>    
            </form>
    </section>
    
</div>
</body>
</html>