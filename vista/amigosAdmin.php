<!-- VISTA DE AMIGOS :) -->
<div id="bodyAmigos">
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
    ?>
    <section class="amigos">
        <h2>PANEL DE CONTROL <span>AMIGOS</span></h2>
        <?php
            if (count($amigos) == 0) {
                echo "NO TIENE AMIGOS ACTUALMENTE";
            }else{
                $cont = 0;
                echo "<form action='index.php' method='post'>"; 
                echo "<table class='table'>";
                    echo "<tr><th>NOMBRE</th><th>APELLIDOS</th><th>FECHA NACIMIENTO</th><th>DUEÑO</th><th>VERIFICADO</th><th></th></tr>";
                    
                    foreach ($amigos as $amig) {
                        echo "<tr>";
                        echo "<input type='hidden' name='id_usuario".$cont."' value='" . $amig["id_usuario"] . "'>";
                        echo "<input type='hidden' name='id".$cont."' value='" . $amig["id"] . "'>"; 
                        echo "<input type='hidden' name='" . $cont . "' value='" . $cont . "'>"; 
                        echo "<td>" . $amig["nombre"] . "</td>";
                        echo "<td>" . $amig["apellidos"] . "</td>";
                        echo "<td>" . $amig["fecha_nac"] . "</td>";
                        echo "<td>" . $amig["usuario"] . "</td>";
                        if($amig["verificado"] == 1){ 
                            echo "<td> SI </td>";
                        }else{   
                            echo "<td><button type='submit' class='btn off' name='action' value='verificar ".$cont."'>VERIFICAR</button></td>";
                        }
                        echo "<td><button type='submit' class='btn off' name='action' value='ModificarAmigo ".$cont."'>Modificar</button></td>";
                        echo "</tr>";
                        $cont++;
                    }
                echo "</table>";
                echo "<div style= 'display:flex; gap:1rem;margin-top: 1.5rem;'> <input type='submit' class='btn' name='action' value='Buscar Amigos Admin'>
                    <input type='hidden' name='usuario' value='".$usuario."'>";
                echo "<button type='submit' class='btn' name='action' value='insertAmiAdmin'>Insertar Amigo</button>";
                echo "</div></form>";
            }
            
            ?>
            <form class="buscador" action="index.php" method='post'>    
            </form>
    </section>
    <script src="../scripts/main.js"></script>
    
</div>