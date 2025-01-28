<!-- VISTA DE JUEGOS :) -->
<div id="bodyAmigos">
    <section class="amigos">
        <h2>Juegos de <span><?php if(isset($usuario)) echo $usuario ?></span></h2>
        <?php
            
            $cont = 0;
            echo "<form action='index.php' method='post'>"; 
            if (count($juegos) == 0) {
                echo "NO TIENE JUEGOS ACTUALMENTE";
            }else{
                echo "<table class='table'>";
                    echo "<tr><th>JUEGO</th><th>TITULO</th><th>PLATAFORMA</th><th>AÑO</th><th></th></tr>";
                    
                    foreach ($juegos as $juego) {
                        echo "<tr>";
                        echo "<input type='hidden' name='id_usuario".$cont."' value='" . $juego["id_usuario"] . "'>";
                        echo "<input type='hidden' name='id".$cont."' value='" . $juego["id"] . "'>"; 
                        echo "<input type='hidden' name='" . $cont . "' value='" . $cont . "'>"; 
                        echo "<td><div class='divImg'><img src='" . $juego["url"] . "'></div></td>";
                        echo "<td>" . $juego["juego"] . "</td>";
                        echo "<td>" . $juego["plataforma"] . "</td>";
                        echo "<td>" . $juego["anio"] . "</td>";
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