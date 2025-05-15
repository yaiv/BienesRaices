<?php 

    require '../../includes/funciones.php';   //Se modifica ruta para que se cargue 
    $auth = estaAutenticado();

    if(!$auth){
        header('Location: /');
    }

//Se importa la conexion de la BD 
require '../../includes/config/database.php'; //Se sale dos veces ya que crear esta dentro de la carpeta de propiedades 

$db = conectarDB();

//Consulta para obtener los vendedores 
$consulta = "SELECT * FROM vendedores";
$resultado = mysqli_query($db, $consulta); //Se toman dos parametros la conexion a la BD y la consulta 

//Arreglo con mensajes de errores 
$errores = [];
//Se inician vacias para que se le pueda colocar value del form y no se pierdan los datos 
$titulo = '';
$precio = '';
$descripcion = '';
$habitaciones = '';
$wc = '';
$estacionamiento = '';
$vendedores_id = '';
$creado = date('y/m/d');



//Ejecuta el codigo despues de que el usuario envia el formulario 
if($_SERVER['REQUEST_METHOD'] === 'POST'){

    //Se hace uso de FILES ya que asi se puede mover la imagen a un lugar en el servidor 
    //Se genero carpeta llamada imagenes 
    //Pero el nombre (solo el nombre) si se almacena en la BD  
    $imagen = $_FILES['imagen'];
    // echo "<pre>";
    // var_dump($_POST);
    // echo "</pre>";

    // echo "<pre>";
    // var_dump($_FILES);
    // echo "</pre>";
    // exit;


    //NO CONFIES EN LOS USUARIOS 
    //Se ocupa  mysqli_real_escape_string para sanitizar y validar entrada de datos de usuario 
    //escapa los datos 
    $titulo = mysqli_real_escape_string($db, $_POST['titulo']);
    $precio = mysqli_real_escape_string($db, $_POST['precio']);
    $descripcion = mysqli_real_escape_string($db, $_POST['descripcion']);
    $habitaciones = mysqli_real_escape_string($db, $_POST['habitaciones']);
    $wc = mysqli_real_escape_string($db, $_POST['wc']);
    $estacionamiento = mysqli_real_escape_string($db, $_POST['estacionamiento']);
    $vendedores_id = mysqli_real_escape_string($db, $_POST['vendedor']);


    //Mensajes de error 
    if(!$titulo) {
        $errores[] = "El titulo es obligatorio";
    }

    if(!$precio) {
        $errores[] = "El precio es obligatorio";
    }

    if( strlen ($descripcion) < 50) {
        $errores[] = "Debes colocar una descripcion de al menos 50 carcteres";
    }

    if(!$habitaciones) {
        $errores[] = "Debes de colcar el numero de habitaciones de manera obligatora";
    }

    if(!$wc) {
        $errores[] = "Debes de colcar el numero de baños de manera obligatora";
    }

    if(!$estacionamiento) {
        $errores[] = "Debes de colcar el numero de estacionamientos de manera obligatora";
    }

    if(!$vendedores_id) {
        $errores[] = "Debes seleccionar un vendedor";
    }

    //validacion imagen obligatoria
    if(!$imagen['name'] || $imagen['error']){
        $errores[] = 'La imagen es obligatoria';
    }

    //validar por tamaño (1000mb maximo)
    //convertir bites a kilobits
    $medida = 10000 * 10000;

    if($imagen['size'] > $medida ){
        $errores[] = 'La imagen es muy pesada';
    }



    //  echo "<pre>";
    // var_dump($errores);
    // echo "</pre>";

    //revisar que el array de errores este vacio 
    if(empty($errores)){

        //Subida de archivos (imagenes)
        //Crear carpeta
        $carpetaImagenes = '../../imagenes/';
        //Se verifica que exista la carpeta, si no se crea  
        if(!is_dir($carpetaImagenes)){
        mkdir($carpetaImagenes);
        }

        //Generar nombre de imagen unico 
        $nombreImagen = md5( uniqid( rand(), true) ) . ".jpg";

        //Subir imagen con nombre aleatorio 
        move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);
//        exit;

            //insertar en la BD 
    $query = " INSERT INTO propiedades (titulo, precio, imagen, descripcion, habitaciones, wc, estacionamiento, creado,
    vendedores_id ) VALUES ( '$titulo', '$precio', '$nombreImagen', '$descripcion', '$habitaciones', '$wc', '$estacionamiento', '$creado',
    '$vendedores_id' ) ";

    //echo $query;  //

    $resultado = mysqli_query($db, $query);

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

            <fieldset>
                <legend>Informacion General:</legend>

                <label for="titulo">Titutlo:</label>
                <input type="text" id="titulo" name="titulo" placeholder="Titulo Propiedad" value="<?php echo $titulo;?>">

                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" placeholder="Precio Propiedad" value="<?php echo $precio;?>">

                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen"> 

                <label for="descripcion">Descripcion:</label>
                <textarea id="descripcion" name="descripcion"><?php echo $descripcion;?></textarea>

            </fieldset>

            <fieldset>
                <legend>Informacion Propiedad</legend>

                <label for="habitaciones">Habitaciones:</label>
                <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej: 3" min="1"  max="10" value="<?php echo $habitaciones;?>" >

                <label for="wc">Baños:</label>
                <input type="number" id="wc" name="wc" placeholder="Ej: 3" min="1"  max="15" value="<?php echo $wc;?>">

                <label for="estacionamiento">Estacionamiento:</label>
                <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ej: 3" min="1"  max="10" value="<?php echo $estacionamiento;?>">
            </fieldset>
            
            <fieldset>
                <legend>Vendedor</legend>

                <select name="vendedor">
                <option value="">--Selecione--</option> <!--Se trae el resultado de vendedor desde la base de datos -->
                    <?php while($vendedor = mysqli_fetch_assoc($resultado)): ?>
                        <option  <?php echo $vendedores_id === $vendedor['id'] ? 'selected' : '';?>   value="<?php echo $vendedor['id']; ?>"> <?php echo $vendedor['nombre'] . " " . $vendedor ['apellido'];?> </option>

                    <?php endwhile; ?>
                </select>
            </fieldset>

            <input type="submit" value="Crear Propiedad" class="boton boton-verde"> 

        </form>

    </main>

    <?php 
        incluirTemplate('footer');
    ?>