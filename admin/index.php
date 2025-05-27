<?php 

    require '../includes/app.php';   //Se modifica ruta para que se cargue 
    estaAutenticado();
    use App\Propiedad;

//Se importa la conexion de la BD a traves de app.php

//Implementar un metodo para obtener todas las propiedades utilizando active record
//Cuando se visita el index.php se manda a llamar la clase y el metodo all
    $propiedades = Propiedad::all();

//Muestra mensaje condicional
$resultado = $_GET['resultado'] ?? null; //Se revisa que hay un get si no se muestra nada 


//El post no va a existir hasta que se me mande el request medhod 
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $id = $_POST['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if($id){
        
        $propiedad = Propiedad::find($id);

        $propiedad->eliminar();

    }
}

//Se incluye un template 
    incluirTemplate('header');
?>    
    <main class="contenedor seccion">
        <h1>Administrador de bienes raices</h1>

        <?php 
        if(intval ($resultado) ===1): ?>
            <p class="alerta exito">Anuncio Creado Correctamente</p>
            <?php elseif( intval ($resultado) ===2): ?>
            <p class="alerta exito">Anuncio Actualizado Correctamente</p>
            <?php elseif( intval ($resultado) ===3): ?>
            <p class="alerta exito">Propiedad Eliminada</p>


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
                <?php foreach( $propiedades as $propiedad): ?> 
                    <tr>
                        <td> <?php echo $propiedad->id; ?> </td>
                        <td> <?php echo $propiedad->titulo; ?> </td>
                        <td> <img src="/imagenes/<?php echo $propiedad->imagen; ?>" class="imagen-tabla"> </td>
                        <td>$ <?php echo $propiedad->precio; ?> </td>
                        <td>
                            <form method="POST" class="w-100">

                                <input type="hidden" name="id" value="<?php echo $propiedad->id; ?>" >

                                <input type="submit" class="boton-rojo-block" value="Eliminar">
                            </form>
                            <a href="/admin/propiedades/actualizar.php? id=<?php echo $propiedad->id; ?>" class="boton-amarillo-block ">Actualizar</a>
                        </td>
                    </tr>
                    
                    <?php  endforeach; ?>

                </tbody>
            </table>

    </main>

    <?php 
    //Se cierra la conexion de la BD 
    mysqli_close($db);
    
        //Se tiene template 
        incluirTemplate('footer');
    ?>