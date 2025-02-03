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
        <h2>Amigos de <span><?php if(isset($usuario)) echo $usuario ?></span></h2>
        <?php
            if (count($usuarios) == 0) {
                echo "NO TIENE AMIGOS ACTUALMENTE";
            }else{
                $cont = 0;
                echo "<form action='index.php' method='post'>"; 
                echo "<table class='table'>";
                    echo "<tr><th>USUARIO</th><th>CONTRASEÑA</th><th></th></tr>";
                    
                    foreach ($usuarios as $usu) {
                        echo "<tr>";
                        echo "<input type='hidden' name='id".$cont."' value='" . $usu["id"] . "'>"; 
                        echo "<input type='hidden' name='" . $cont . "' value='" . $cont . "'>"; 
                        echo "<td>" . $usu["usuario"] . "</td>";
                        echo "<td>" . $usu["contrasenia"] . "</td>";
                        echo "<td><button type='submit' class='btn off' name='action' value='ModificarUsuario ".$cont."'>Modificar</button></td>";
                        echo "</tr>";
                        $cont++;
                    }
                echo "</table>";
                echo "<div style= 'display:flex; gap:1rem;margin-top: 1.5rem;'> <button type='submit' class='btn' name='action' value='buscaUsuario'>Buscar Usuario</button>
                    <input type='hidden' name='usuario' value='".$usuario."'>";
                echo "<button type='submit' class='btn' name='action' value='insertUsu'>Insertar Usuario</button>";
                echo "</div></form>";
            }
            
            ?>
            <form class="buscador" action="index.php" method='post'>    
            </form>
    </section>
    
</div>