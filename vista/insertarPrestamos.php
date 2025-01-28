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
            <input class="busca" type="text" name="juego" placeholder="Titulo del juego..." required>
            <select name="plataforma" id="">
                <option value="PC">PC</option>
                <option value="PS5">PS5</option>
                <option value="XBOX">XBOX</option>
                <option value="NINTENDO">NINTENDO</option>
            </select>
            <input class="busca" type="file" name="img" required>
            <input class="busca" type="number" name="anio" value="2025" required>
            <input type="submit" class="btn" name="action" value="Añadir prestamo">
            <input type="hidden" name="usuario" value="<?php echo $usuario ?>">
        </form>
    </section>
</div>