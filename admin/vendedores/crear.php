<?php
    
        require '../../includes/app.php';   //Se modifica ruta para que se cargue         use App\Vendedor;
        use App\Vendedor;

        estaAutenticado();

     $vendedor = new Vendedor; 
     //debuguear($vendedor);

    //Arreglo con mensajes de errores 
    $errores = Vendedor::getErrores();

    //Ejecuta el codigo despues de que el usuario envia el formulario 
    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        //Crear una nueva instancia 
        $vendedor = new Vendedor($_POST['vendedor']);
       // debuguear($vendedor);

        //Validar que no haya campos vacios 
        $errores = $vendedor->validar();

        //No hay errores
        if(empty($errores)){
            $vendedor->guardar();
        }

    }
        incluirTemplate('header');

?>

    <main class="contenedor seccion">
        <h1>Registrar Vendedor(a)</h1>

        <a href="/admin/" class="boton boton-verde">volver</a>

        <?php foreach ($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
            <?php endforeach; ?>


        <form class ="formulario" method="post" action="/admin/vendedores/crear.php">  <!--Se habilita enctype para que se lean los archivos-->

            <?php include '../../includes/templates/formulario_vendedores.php'  ?>

            <input type="submit" value="Registrar Vendedores" class="boton boton-verde"> 

        </form>

    </main>

<?php
        incluirTemplate('footer');


?>    
    