<?php 

namespace App;

use Intervention\Image\Colors\Hsv\Channels\Value;

//Se va a tulizar active record, es el responsable de trabajar con datos

class Vendedor extends ActiveRecord {

        protected static $tabla = 'vendedores';
            //Arrelo que permite mapear en crear.php
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'telefono'];

    public $id;
    public $nombre;
    public $apellido;
    public $telefono;

        public function __construct($args = [])
    {

        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
    }

         public function validar(){
        //Mensajes de error 
        if(!$this->nombre) {
            self::$errores[] = "El nombre es obligatorio";
            }
        
        if(!$this->apellido) {
            self::$errores[] = "El apellido es obligatorio";
            }

        if(!$this->telefono) {
            self::$errores[] = "El telefono es obligatorio";
            }

        if(!preg_match('/[0-9]{10}/', $this->telefono)){ //Buscar un patron dentro de un texto, mediante esta expresion regular
            self::$errores[] = "Formato no valido";
        }

        return self::$errores;
    
    }

}
