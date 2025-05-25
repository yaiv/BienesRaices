<?php



//Se les colocaca DIR  a los templates para que PHP tome la ubicacion actual del archivo 
//DIR define la ubicacion y se sepa donde buscar los archivos 
define('TEMPLATES_URL', __DIR__ . '/templates');
define('FUNCIONES_URL', __DIR__ . 'funciones.php');

function incluirTemplate ( string $nombre, bool $inicio = false ) {
    include TEMPLATES_URL . "/" . $nombre . ".php";
}

function estaAutenticado() : bool {
    session_start();

    $auth = $_SESSION['login'];
    if($auth){
        return true;
    }
     return false;


}