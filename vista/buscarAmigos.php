<!-- VISTA DE BUSCAR USUARIOS :( -->
<div id="bodyAmigos">
    <section class="amigos">
        <h2>Amigos de <span><?php if(isset($usuario)) echo $usuario ?></span></h2>
            <form class="buscador" action="index.php" method='post'>    
                <input class="busca" type="text" name="buscador" placeholder="Buscar...">
                <input type="submit" class="btn" value="Enviar">
                <input type="hidden" name="usuario" value="<?php echo $usuario ?>">
                <input type="hidden" name="action" value="amigos">
            </form>
    </section>
</div>