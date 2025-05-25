<?php 

    //Validar id 
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if(!$id){
        header('Location: /');
    }

    require 'includes/app.php';

    //importar la conexion por medio de app.php

    $db = conectarDB();

    //realizar consulta
    $query = "SELECT * FROM propiedades WHERE id = {$id}";

    //Obtener el resultado 

    $resultado = mysqli_query($db, $query);

    //validar que exista un registro con ese id  y si no se redirecciona

    // echo "<pre>";
    // var_dump($resultado->num_rows); //Es objeto por ello se entra con flecha
    // echo "</pre>";

    if(!$resultado->num_rows){
        header('Location: /');
    }


    $propiedad = mysqli_fetch_assoc($resultado);


    incluirTemplate('header');
?>
    
    <main class="contenedor seccion contenido-centrado">
        <h1><?php echo $propiedad['titulo'];?></h1>

            <img loading="lazy" src="/imagenes/<?php echo $propiedad['imagen'];?>" alt="imagen de la propiedad">

        <div class="resumen-propiedad">
            <p class="precio">$<?php echo $propiedad['precio'];?></p>
            <ul class="iconos-caracteristicas">
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
                    <p><?php echo $propiedad['wc'];?></p>
                </li>
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                    <p><?php echo $propiedad['estacionamiento'];?></p>
                </li>
                <li>
                    <img class="icono"  loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono habitaciones">
                    <p><?php echo $propiedad['habitaciones'];?></p>
                </li>
            </ul>
                <p>  <?php echo $propiedad['descripcion'];?> </p>
        </div>
    </main>

    <?php 

        //Se cierra la conexion de la bd
        mysqli_close($db);

        incluirTemplate('footer');
    ?>