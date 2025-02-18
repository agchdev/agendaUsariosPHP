<!-- VISTA DE MODIFICAR AMIGOS :) -->
<?php

?>
<div id="bodyAmigos">
    <section class="amigos">
        <h2>PUNTUAR<span> PRESTAMO</span></h2>
            <form class="buscador" action="index.php" method='post'>    
                <input type="number" name="puntuacion" step=".01" max="5" min="0">
                <input type="hidden" name="id" value="<?php echo $id?>">
                <button type="submit" class="btn" name="action" value="puntuarPrestamo">Puntuar</button>
            </form>
    </section>
</div>
</body>
</html>