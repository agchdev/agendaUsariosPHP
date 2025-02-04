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
        <h2>Insertar prestamo de <span><?php if(isset($usuario)) echo $usuario ?></span></h2>
        <form class="insertar" action="index.php" method='post'>    
            <select class="select" name="nombreAmigo" id="">
            <?php
                foreach ($amigosdeUsuario as $amigo) {
                    echo "<option value=".$amigo["id"].">".$amigo["nombre"]."</option>";
                }
            ?>
            </select>
            <select class="select" name="juego" id="">
            <?php
                foreach ($juegosdeUsuario as $juego) {
                    echo "<option value=".$juego["id"].">".$juego["juego"]."</option>";
                }
            ?>
            </select>
            <input class="busca" type="date" name="fech" required>
            <input type="submit" class="btn" name="action" value="Añadir prestamo">
            <input type="hidden" name="usuario" value="<?php echo $usuario ?>">
        </form>
        <form class="insertar" action="index.php" method='post'>    
            <button style="margin-top:1rem" class="btn" type="submit" name="action" value="prestamos">Volver</button>
        </form>
    </section>
</div>