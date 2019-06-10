<?php require_once 'includes/redireccion.php'; ?>
<?php require_once 'includes/cabecera.php'; ?>     
<!-- BARRA LATERAL -->
 <?php require_once 'includes/lateral.php'; ?>
<!-- CAJA PRINCIPAL-->
<div id="principal">
    <h1>Crear categorías</h1>
    <p>
        Añade nuevas categorias al blog para que los usuarios puedan
        usarlas al crear sus entradas.
    </p>
    <br/>
    <form action="guardar-categoria.php" method="POST">
        <label for="nombre">Nombre de la categoría:</label>
        <input type="text" name="nombre" />
        
        <input type="submit" value="Guardar"/>
    </form>
</div><!-- FIN PRINCIPAL-->

<?php require_once 'includes/pie.php'; ?>