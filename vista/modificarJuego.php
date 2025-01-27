<!-- VISTA DE MODIFICAR AMIGOS :) -->
<?php

?>
<div id="bodyAmigos">
    <section class="amigos">
        <h2>Amigos de <span><?php if(isset($usuario)) echo $usuario ?></span></h2>
            <form class="buscador" action="index.php" method='post'>    
                <input class="busca" type="text" name="nuevoNom" placeholder="nombre..." value="<?php echo $juego["juego"] ?>">
                <select name="plataforma" id="">
                    <option value="PC" default>PC</option>
                    <option value="PS5">PS5</option>
                    <option value="XBOX">XBOX</option>
                    <option value="NINTENDO">NINTENDO</option>
                </select>
                <input type="file" name="img">
                <input class="busca" type="number" name="nuevoAnio" value="<?php echo $juego["anio"] ?>">
                <input type="hidden" name="idAmi" value="<?php echo $juego["id"] ?>">
                <input type="hidden" name="idUsu" value="<?php echo $juego["id_usuario"] ?>">
                <input type="hidden" name="url" value="<?php echo $juego["url"] ?>">
                <input type="submit" class="btn" value="Guardar Cambios">
                <input type="hidden" class="btn" name="action" value="cambiosJuego">
                <input type="hidden" name="usuario" value="<?php echo $usuario ?>">
            </form>
    </section>
</div>