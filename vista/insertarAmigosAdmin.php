<!-- VISTA DE INSERTAR USUARIOS ADMIN :) -->
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
        <h2>Insertar amigos de <span><?php if(isset($usuario)) echo $usuario ?></span></h2>
        <form class="insertar" action="index.php" method='post'>    
            <input class="busca" type="text" name="nombre" placeholder="nombre de usuario..." required>
            <input class="busca" type="text" name="apellido" placeholder="apellido del usuario..." required>
            <input class="busca" type="date" name="fecha" required>
            <select class="select" name="user">
                <?php
                    foreach ($usuarios as $usu) {
                        echo "<option class='opt' value=".$usu["id"].">".$usu["usuario"]."</option>";
                    }
                ?>
            </select>
            <button type="submit" class="btn" name="action" value="añadirAmigosAdmin">Añadir amigo</button>
            <input type="hidden" name="usuario" value="<?php echo $usuario ?>">
        </form>
        <form class="insertar" action="index.php" method='post'>    
            <button style="margin-top:1rem" class="btn" type="submit" name="action" value="volverAmigosAdmin">Volver</button>
        </form>
    </section>
</div>