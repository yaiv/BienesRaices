<?php 

//Archivo principal: es que va a llamar funciones y clases 
//Usa Autoload para que cada vez que se generen nuevas clases se vayan agregando automaticamente lo mismo ocurre con nuevas funciones, se van agregando y van a estar disponibles en todos los archivos 

require 'funciones.php';
//Se incluye la conexion a la BD 
require 'config/database.php';
require __DIR__ . '/../vendor/autoload.php';

//Conectarnos a la BD 
$db = conectarDB();

use App\ActiveRecord;
 
ActiveRecord::setDB($db);