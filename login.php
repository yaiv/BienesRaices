<?php 

require 'includes/config/database.php';
    $db = conectarDB();

    // Se inicializa arreglo de errores desde el principio
    $errores = []; 

    //Autneticar el usuario 
    //var_dump($_POST);
    //ver resultados de post 
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        // echo "<pre>";
        // var_dump($_POST); //UNA VEZ QUE SE ENVIA EL FORMULARIO se genera la superglobal con email y pass
        // echo "</pre>";


        //Asignar los valores de post a las variables con filtro 
        //Se usa mysqli_real_escape_string para que se puedan sanitizar antes de entrar a BD 
        $email = mysqli_real_escape_string($db,  filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL) );
        $password = mysqli_real_escape_string($db, $_POST['password']);

    //Arreglo de errores 
    $errores = [];
    if (!$email){
        $errores[] = "El email es obligatorio o no es valido";
    }
    if (!$password){
        $errores[] = "El password es obligatorio";
    }
    
    if (empty($errores)){ //Si las validaciones estan vacias

        //revisar si el usuario existe 
        $query = "SELECT * FROM usuarios WHERE email = '{$email}'";
        $resultado = mysqli_query($db, $query);


        if($resultado->num_rows ){
            //Revisar si el password es correcto 
            $usuario = mysqli_fetch_assoc($resultado);

            //Verificar si el password es correcto o no 
            $auth = password_verify($password, $usuario['password']);

            if($auth){
                //El usuario esta autenticado 
                //Se hace uso de la super global sesion 
                session_start();

                //Llenar el arreglo de la sesion 
                $_SESSION['usuario'] = $usuario['email'];
                $_SESSION['login'] = true;

                header('Location: /admin');


            }else {
                $errores[] = "El password es incorrecto";
            }
        } else {
            $errores[] = "El Usuario no existe";
        }
    }

    } //SE DEBEN COLOCAR LOS NAMES A LOS INPUT 


//Se incluye el header 
require 'includes/funciones.php';
    incluirTemplate('header');
?>    
    <main class="contenedor seccion contenido-centrado">
        <h1>Iniciar Sesión</h1>

        <?php foreach($errores as $error): //Mostrar errores del arreglo ?>

        <div class="alerta error">
            <?php echo $error; ?>
        </div>

        <?php endforeach; ?>
      

        <form method="POST" class="formulario">
            <fieldset>
                <legend>Email y Password</legend>

                <label for="email">E-mail</label>
                <input type="email" name="email" placeholder="Tu Email" id="email">

                <label for="password">Password</label>
                <input type="password" name="password" placeholder="Tu password" id="password">

            </fieldset>

            <input type="submit" value="Iniciar Sesión" class="boton boton-verde">

        </form>
    </main>

    <?php 
        incluirTemplate('footer');
    ?>