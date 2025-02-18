<!-- VISTA DE PRESTAMOS :) -->
<div id="bodyAmigos">
    <section class="amigos">
        <h2>Prestamos de <span><?php if(isset($usuario)) echo $usuario ?></span></h2>
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
            
            $cont = 0;
            echo "<form action='index.php' method='post'>"; 
            if (count($prestamos) == 0) {
                echo "NO TIENE PRESTAMOS ACTUALMENTE";
            }else{
                echo "<table class='table'>";
                    echo "<tr><th>AMIGO</th><th>JUEGO</th><th>IMG</th><th>FECHA</th><th>DEVUELTO</th><th></th></tr>";
                    
                    foreach ($prestamos as $prestamo) {
                        echo "<tr>";
                        echo "<input type='hidden' name='id_prestamo".$cont."' value='" . $prestamo["id"] . "'>";
                        echo "<input type='hidden' name='id_usuario".$cont."' value='" . $prestamo["id_usuario"] . "'>"; 
                        echo "<input type='hidden' name='id_amigo".$cont."' value='" . $prestamo["id_amigo"] . "'>"; 
                        echo "<td>" . $prestamo["nombreAmigo"] . "</td>";
                        echo "<td>" . $prestamo["nombreJuego"] . "</td>";
                        echo "<td><div class='divImg'><img src='" . $prestamo["urlFoto"] . "'></div></td>";
                        echo "<td>" . $prestamo["fecha_prestamo"] . "</td>";
                        if($prestamo["devuelto"] == 1){ 
                            echo "<td>SI</td>";
                            echo "<td>".$prestamo["puntuacion"]."</td>";
                        }else{
                            echo "<td>NO</td>";
                            echo "<td><input type='submit' class='btn off' name='action' value='Devolver ".$cont."'></td>";
                        }
                        
                        echo "</tr>";
                        $cont++;
                    }
                echo "</table>";
            }
                echo "<div style= 'display:flex; gap:1rem;margin-top: 1.5rem;'> <input type='submit' class='btn' name='action' value='Buscar prestamos'>
                    <input type='hidden' name='usuario' value='".$usuario."'>";
                echo "<input type='submit' class='btn' name='action' value='Insertar Prestamos'>";
                echo "</div></form>";
            
            
            ?>
            <form class="buscador" action="index.php" method='post'>    
            </form>
    </section>
    
</div>
</body>
</html>