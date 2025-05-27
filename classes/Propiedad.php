<?php 

namespace App;

use Intervention\Image\Colors\Hsv\Channels\Value;

//Se va a tulizar active record, es el responsable de trabajar con datos

class Propiedad extends ActiveRecord {

        protected static $tabla = 'propiedades';
            //Arrelo que permite mapear en crear.php
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedores_id'];

    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedores_id;

        public function __construct($args = [])
    {

        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('y/m/d');
        $this->vendedores_id = $args['vendedores_id'] ?? '';
    }

     public function validar(){
            //Mensajes de error 
    if(!$this->titulo) {
        self::$errores[] = "El titulo es obligatorio";
    }

    if(!$this->precio) {
        self::$errores[] = "El precio es obligatorio";
    }

    if( strlen ($this->descripcion) < 50) {
        self::$errores[] = "Debes colocar una descripcion de al menos 50 carcteres";
    }

    if(!$this->habitaciones) {
        self::$errores[] = "Debes de colcar el numero de habitaciones de manera obligatora";
    }

    if(!$this->wc) {
        self::$errores[] = "Debes de colcar el numero de baños de manera obligatora";
    }

    if(!$this->estacionamiento) {
        self::$errores[] = "Debes de colcar el numero de estacionamientos de manera obligatora";
    }

    if(!$this->vendedores_id) {
        self::$errores[] = "Debes seleccionar un vendedor";
    }

    //validacion imagen obligatoria
    if(!$this->imagen){
        self::$errores[] = 'La imagen es obligatoria';
    }



    return self::$errores;
    }

}


