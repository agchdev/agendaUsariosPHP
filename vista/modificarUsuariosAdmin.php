<!-- VISTA DE MODIFICAR AMIGOS :) -->
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
            <form class="buscador" action="index.php" method='post'>    
                <input class="busca" type="text" name="nuevoUsu" placeholder="usuario..." value="<?php echo $user["usuario"] ?>">
                <input class="busca" type="password" name="nuevaCon" placeholder="Nueva contraseña...">
                <input type="hidden" name="idUsu" value="<?php echo $user["id"] ?>">
                <button type="submit" class="btn" name="action" value="guardarCambiosUsu">Guardar Cambios</button>
                <input type="hidden" name="usuario" value="<?php echo $usuario ?>">
            </form>
    </section>
</div>
</body>
</html>