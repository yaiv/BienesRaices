<?php

use App\Propiedad;
use App\Vendedor;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager as Image;

    require '../../includes/app.php';   //Se modifica ruta para que se cargue 
    estaAutenticado();

//Se  valida que el valor obtenido de la url sea un numero 
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

if(!$id){
    header('Location: /admin');
}

//optener los datos de la propiedad 
$propiedad = Propiedad::find($id);
//debuguear($propiedad);

//Consulta para obtener todos los vendedores 
$vendedores = Vendedor::all();

//Arreglo con mensajes de errores 
$errores = Propiedad::getErrores();
//debuguear($propiedad);



//Ejecuta el codigo despues de que el usuario envia el formulario 
if($_SERVER['REQUEST_METHOD'] === 'POST'){

   // debuguear($_POST);

   //Asignar los atributos 
    $args = $_POST['propiedad'];

    $propiedad->sincronizar($args);

    //Validacion
    $errores = $propiedad->validar();

    //Subida de archivos 

    //Generar nombre de imagen unico 
    $nombreImagen = md5( uniqid( rand(), true) ) . ".jpg";

     // Declarar variable fuera del if
    $imagen = null;

    if($_FILES['propiedad']['tmp_name']['imagen']){
    $manager = new Image(Driver::class); //Configuracion Driver
    $imagen = $manager->read($_FILES['propiedad']['tmp_name']['imagen'])->cover(800, 600); //Se leer la imagen y se le realiza una transformacion
    $propiedad->setImagen($nombreImagen);
        }
    //En caso de que no haya errores guardar 
    if(empty($errores)){
        //Almacenar la imagen 
        if($imagen){
        $imagen->save(CARPETA_IMAGENES . $nombreImagen);
        }
        $propiedad->guardar();
    }
}

    incluirTemplate('header');
?>    
    <main class="contenedor seccion">
        <h1>Actualizar Propiedad</h1>

        <a href="/admin/" class="boton boton-verde">volver</a>

        <?php foreach ($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
            <?php endforeach; ?>


        <form class ="formulario" method="post" enctype="multipart/form-data">  <!--Se habilita enctype para que se lean los archivos-->

            <?php include '../../includes/templates/formulario_propiedades.php'  ?>

            <input type="submit" value="Actualizar Propiedad" class="boton boton-verde"> 

        </form>

    </main>

    <?php 
        incluirTemplate('footer');
    ?>