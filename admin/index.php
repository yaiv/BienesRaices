<?php 

//Se importa la conexion de la BD 
require '../includes/config/database.php'; 
$db = conectarDB();

//Se escribe el query 
$query = "SELECT * FROM propiedades";

//Se consulta la BD 
$resultadoConsulta =mysqli_query($db, $query); //Se usa mysqli_query para que se tomen conexiones 

//Muestra mensaje condicional
$resultado = $_GET['resultado'] ?? null; //Se revisa que hay un get si no se muestra nada 

//Se incluye un template 
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

            <table class="propiedades">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Titulo</th>
                        <th>Imagen</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody> <!--Se muestran los resultados de la BD-->
                <!--Se crea codigo que va a iterar en la BD -->
                <?php while( $propiedad = mysqli_fetch_assoc($resultadoConsulta)): //el while va a permitir generarcontenido para tr  ?> 
                    <tr>
                        <td> <?php echo $propiedad['id']; ?> </td>
                        <td> <?php echo $propiedad['titulo']; ?> </td>
                        <td> <img src="/imagenes/<?php echo $propiedad['imagen']; ?>" class="imagen-tabla"> </td>
                        <td>$ <?php echo $propiedad['precio']; ?> </td>
                        <td>
                        <a href="#" class="boton-rojo-block">Eliminar</a>
                            <a href="#" class="boton-amarillo-block ">Actualizar</a>
                        </td>
                    </tr>
                    
                    <?php  endwhile; ?>

                </tbody>
            </table>

    </main>

    <?php 
    //Se cierra la conexion de la BD 
    mysqli_close($db);
    
        //Se tiene template 
        incluirTemplate('footer');
    ?>