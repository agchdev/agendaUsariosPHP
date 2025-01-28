<!-- VISTA DE JUEGOS :) -->
<div id="bodyAmigos">
    <section class="amigos">
        <h2>Prestamos de <span><?php if(isset($usuario)) echo $usuario ?></span></h2>
        <?php
            
            $cont = 0;
            echo "<form action='index.php' method='post'>"; 
            if (count($prestamos) == 0) {
                echo "NO TIENE JUEGOS ACTUALMENTE";
            }else{
                echo "<table class='table'>";
                    echo "<tr><th>AMIGO</th><th>JUEGO</th><th>IMG</th><th>FECHA</th><th>DEVUELTO</th><th></th></tr>";
                    
                    foreach ($prestamos as $prestamo) {
                        echo "<tr>";
                        echo "<input type='hidden' name='id_usuario".$cont."' value='" . $prestamos["id_usuario"] . "'>";
                        echo "<input type='hidden' name='id".$cont."' value='" . $prestamos["id"] . "'>"; 
                        echo "<input type='hidden' name='" . $cont . "' value='" . $cont . "'>"; 
                        echo "<td>" . $prestamos["prestamos"] . "</td>";
                        echo "<td><div class='divImg'><img src='" . $prestamos["url"] . "'></div></td>";
                        echo "<td>" . $prestamos["plataforma"] . "</td>";
                        echo "<td>" . $prestamos["anio"] . "</td>";
                        echo "<td><input type='submit' class='btn off' name='action' value='ModificarJuego ".$cont."'></td>";
                        echo "</tr>";
                        $cont++;
                    }
                echo "</table>";
            }
                echo "<div style= 'display:flex; gap:1rem;margin-top: 1.5rem;'> <input type='submit' class='btn' name='action' value='Buscar Juegos'>
                    <input type='hidden' name='usuario' value='".$usuario."'>";
                echo "<input type='submit' class='btn' name='action' value='Insertar Juegos'>";
                echo "</div></form>";
            
            
            ?>
            <form class="buscador" action="index.php" method='post'>    
            </form>
    </section>
    
</div>
</body>
</html>