<?php 

$resultado = $_GET['resultado'] ?? null; //Se revisa que hay un get si no se muestra nada 

require '../includes/funciones.php';   //Se modifica ruta para que se cargue 
    incluirTemplate('header');
?>    
    <main class="contenedor seccion">
        <h1>Administrador de bienes raices</h1>

        <?php 
        if(intval ($resultado) ===1): ?>
            <p class="alerta exito">Anuncio creado correctamente</p>
        <?php endif;?>

        <a href="/admin//propiedades/crear.php" class="boton boton-verde">Nueva Propiedad</a>
    </main>

    <?php 
        incluirTemplate('footer');
    ?>