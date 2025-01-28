<!-- VISTA DE INSERTAR PRESTAMOS :) -->
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
        <h2>Insertar juego de <span><?php if(isset($usuario)) echo $usuario ?></span></h2>
        <form class="insertar" action="index.php" method='post' enctype="multipart/form-data">    
            <select name="nombreAmigo" id="">
            <?php
                foreach ($amigosdeUsuario as $amigo) {
                    echo "<option value=".$amigo["id"].">".$amigo["nombre"]."</option>";
                }
            ?>
            </select>
            <select name="plataforma" id="">
            <?php
                foreach ($juegosdeUsuario as $juego) {
                    echo "<option value=".$juego["id"].">".$juego["juego"]."</option>";
                }
            ?>
            </select>
            <input class="busca" type="file" name="img" required>
            <input class="busca" type="number" name="anio" value="2025" required>
            <input type="submit" class="btn" name="action" value="Añadir prestamo">
            <input type="hidden" name="usuario" value="<?php echo $usuario ?>">
        </form>
    </section>
</div>