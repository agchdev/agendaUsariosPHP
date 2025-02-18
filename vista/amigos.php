<!-- VISTA DE AMIGOS :) -->
<div id="bodyAmigos">
    <section class="amigos">
        <h2>Amigos de <span><?php if(isset($usuario)) echo $usuario ?></span></h2>
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
            if (count($amigosUsu) == 0) {
                echo "<p style='margin-bottom:1rem'>NO TIENE AMIGOS :(</p>";
            }else{
                $cont = 0;
                echo "<form action='index.php' method='post'>"; 
                echo "<table class='table'>";
                    echo "<tr><th>NOMBRE</th><th>APELLIDOS</th><th>FECHA NACIMIENTO</th><th>VERIFICADO</th><th>MEDIA</th><th></th></tr>";
                    
                    foreach ($amigosUsu as $amig) {
                        echo "<tr>";
                        echo "<input type='hidden' name='id_usuario".$cont."' value='" . $amig["id_usuario"] . "'>";
                        echo "<input type='hidden' name='id".$cont."' value='" . $amig["id"] . "'>"; 
                        echo "<input type='hidden' name='" . $cont . "' value='" . $cont . "'>"; 
                        echo "<td>" . $amig["nombre"] . "</td>";
                        echo "<td>" . $amig["apellidos"] . "</td>";
                        echo "<td>" . $amig["fecha_nac"] . "</td>";
                        // echo "<td>" . $amig["verificado"] . "</td>";
                        if($amig["verificado"] == 1){ 
                            echo "<td> SI </td>";
                        }else{   
                            echo "<td> NO </td>";
                        }
                        // echo "<td>" . $amig["media"] . "</td>";
                        echo "<td><button type='submit' class='btn off' name='action' value='ModificarAmigo ".$cont."'>Modificar</button></td>";
                        echo "</tr>";
                        $cont++;
                    }
                echo "</table></form>";
            }
                echo "<form action='index.php' method='post'><div style= 'display:flex; gap:1rem;margin-top: 1.5rem;'>
                    <input type='submit' class='btn' name='action' value='Buscar Amigos'>
                    <button type='submit' class='btn' name='action' value='ordenarNom'>Ordenador Nombre</button>
                    <button type='submit' class='btn' name='action' value='ordenarNomInv'>Ordenador Nombre inv</button>
                    <button type='submit' class='btn' name='action' value='ordenarFech'>Ordenador Fecha</button>
                    <button type='submit' class='btn' name='action' value='ordenarFechInv'>Ordenador Fecha inv</button>
                    <input type='hidden' name='usuario' value='".$usuario."'>";
                
                echo "<input type='submit' class='btn' name='action' value='Insertar Amigo'>";
                echo "</div></form>";
            
            
            
            ?>
            <form class="buscador" action="index.php" method='post'>    
            </form>
    </section>
    
</div>