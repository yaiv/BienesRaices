<?php 

    require '../../includes/app.php';   //Se modifica ruta para que se cargue 
    
 use App\Propiedad;
use App\Vendedor;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager as Image;

   estaAutenticado();

    $propiedad = new Propiedad; //Para qie esten limpios las entradas del form

    //Consulta para obtener todos los vendedores 
    $vendedores = Vendedor::all();

    //Arreglo con mensajes de errores 
    $errores = Propiedad::getErrores();

    //Ejecuta el codigo despues de que el usuario envia el formulario 
    if($_SERVER['REQUEST_METHOD'] === 'POST'){

    //Crea una nueva instancia con los datos enviados 
    $propiedad = new Propiedad($_POST['propiedad']);


    //Generar nombre de imagen unico 
    $nombreImagen = md5( uniqid( rand(), true) ) . ".jpg";

    //Procesar imagen solo si se subio
    //Satear la imagen
    //Realizar un resize a la imagen con intervention
    if($_FILES['propiedad']['tmp_name']['imagen']){ //Se revisa si existe la imagen 
        //  Asignar nombre del objeto
        $propiedad->setImagen($nombreImagen);
        //crear imagen usando intervention
        $manager = new Image(Driver::class); //Configuracion Driver
        $imagen = $manager->read($_FILES['propiedad']['tmp_name']['imagen'])->cover(800, 600); //Se leer la imagen y se le realiza una transformacion
        
    }

        //Validar campos
     $errores = $propiedad->validar();
     //debuguear($propiedad);

   // debuguear($_FILES);
    
    if(empty($errores)){
        //Subida de archivos (imagenes)
        //Se tiene en funciones 
        //Se verifica que exista la carpeta, si no se crea  
        if(!is_dir(CARPETA_IMAGENES)){
        mkdir(CARPETA_IMAGENES);
        }

      // Guardar imagen en el servidor si fue procesada
      //  if (isset($imagen)) {
            $imagen->save(CARPETA_IMAGENES . $nombreImagen);
     //   }

            //Se gurda en la BD 
        $propiedad->guardar();

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