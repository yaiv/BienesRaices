<?php 

require '../includes/funciones.php';   //Se modifica ruta para que se cargue 
    incluirTemplate('header');
?>    
    <main class="contenedor seccion">
        <h1>Administrador de bienes raices</h1>

        <a href="/admin//propiedades/crear.php" class="boton boton-verde">Nueva Propiedad</a>
    </main>

    <?php 
        incluirTemplate('footer');
    ?>