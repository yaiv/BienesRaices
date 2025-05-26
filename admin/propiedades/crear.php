<?php 

    require '../../includes/app.php';   //Se modifica ruta para que se cargue 
    
    use App\Propiedad;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager as Image;

   estaAutenticado();

   //Se importa la conexion de la BD desde app.php
    $db = conectarDB();

    $propiedad = new Propiedad; //Para qie esten limpios las entradas del form

//Consulta para obtener los vendedores 
$consulta = "SELECT * FROM vendedores";
$resultado = mysqli_query($db, $consulta); //Se toman dos parametros la conexion a la BD y la consulta 

//Arreglo con mensajes de errores 
$errores = Propiedad::getErrores();

//Ejecuta el codigo despues de que el usuario envia el formulario 
if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $propiedad = new Propiedad($_POST);
   // debuguear($propiedad);
    //Generar nombre de imagen unico 
    $nombreImagen = md5( uniqid( rand(), true) ) . ".jpg";
    if($_FILES['imagen']['tmp_name']){ //Se revisa si existe la imagen 
        $manager = new Image(Driver::class); //Configuracion Driver
        $imagen = $manager->read($_FILES['imagen']['tmp_name'])->cover(800, 600); //Se leer la imagen y se le realiza una transformacion
        $propiedad->setImagen($nombreImagen);
    }

    $errores = $propiedad->validar();

   // debuguear($_FILES);
    
    if(empty($errores)){




        //Subida de archivos (imagenes)
        //Se tiene en funciones 
        //Se verifica que exista la carpeta, si no se crea  
        if(!is_dir(CARPETA_IMAGENES)){
        mkdir(CARPETA_IMAGENES);
        }

        //Guardar la imagen en el servidor 
        //Save pertenece a intervencion image y permite guardar una ubicacion
        $imagen->save(CARPETA_IMAGENES . $nombreImagen);
        //Se gurda en la BD 
        $resultado = $propiedad->guardar();
        if($resultado){
       // echo 'Insertado Correctamente';
       //Se redirecciona al usuario 
       header("Location: /admin?resultado=1");  //Se paso con query string 
    }

    }



}


    incluirTemplate('header');
?>    
    <main class="contenedor seccion">
        <h1>Crear</h1>

        <a href="/admin/" class="boton boton-verde">volver</a>

        <?php foreach ($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
            <?php endforeach; ?>


        <form class ="formulario" method="post" action="/admin/propiedades/crear.php" enctype="multipart/form-data">  <!--Se habilita enctype para que se lean los archivos-->

            <?php include '../../includes/templates/formulario_propiedades.php'  ?>

            <input type="submit" value="Crear Propiedad" class="boton boton-verde"> 

        </form>

    </main>

    <?php 
        incluirTemplate('footer');
    ?>