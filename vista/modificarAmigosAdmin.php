<!-- VISTA DE MODIFICAR AMIGOS :) -->
 <?php

?>
<div id="bodyAmigos">
    <section class="amigos">
        <h2>Amigos de <span><?php if(isset($usuario)) echo $usuario ?></span></h2>
            <form class="buscador" action="index.php" method='post'>    
                <input class="busca" type="text" name="nuevoNom" placeholder="nombre..." value="<?php echo $amigoUsu["nombre"] ?>">
                <input class="busca" type="text" name="nuevoApe" placeholder="apellido..." value="<?php echo $amigoUsu["apellidos"] ?>">
                <input class="busca" type="date" name="nuevaFech" value="<?php echo $amigoUsu["fecha_nac"] ?>">
                <select class="select" name="user">
                <?php
                    foreach ($usuarios as $usu) {
                        echo "<option value=".$usu["id"].">".$usu["usuario"]."</option>";
                    }
                ?>
                </select>
                <input type="hidden" name="idAmi" value="<?php echo $amigoUsu["id"] ?>">
                <input type="hidden" name="idUsu" value="<?php echo $amigoUsu["id_usuario"] ?>">
                <button type="submit" class="btn" name="action" value="confirmarCambiosAdmin">Guardar Cambios</button>
                <input type="hidden" name="usuario" value="<?php echo $usuario ?>">
            </form>
            <form class="insertar" action="index.php" method='post'>    
                <button style="margin-top:1rem" class="btn" type="submit" name="action" value="amigosAdmin">Volver</button>
            </form>
    </section>
</div>
</body>
</html>