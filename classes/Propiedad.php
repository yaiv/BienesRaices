<?php 

namespace App;

use Intervention\Image\Colors\Hsv\Channels\Value;

//Se va a tulizar active record, es el responsable de trabajar con datos

class Propiedad {

    //Base de Datos
    protected static $db;
    //Arrelo que permite mapear en crear.php
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedores_id'];

    //Errores o validaciones 
    protected static $errores = [];


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

     //Definir la conexion a BD 
    //Se usa self ya que es estatico
    public static function setDB($database){
        self::$db = $database;

      //  debuguear($resultado);

    } 

    public function __construct($args = [])
    {

        $this->id = $args['id'] ?? '';
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('y/m/d');
        $this->vendedores_id = $args['vendedores_id'] ?? 1;
    }

    public function guardar() {

        //Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        //$string = join(', ', array_values($atributos) ); //Separador + keys a llamar 

        //insertar en la BD 
           $query = " INSERT INTO propiedades ( ";
           $query .= join(', ', array_keys($atributos) );
           $query.= " ) VALUES (' ";
           $query .= join("', '", array_values($atributos) );
           $query .= " ') ";
       
           $resultado = self::$db->query($query);
           return $resultado;
    }

    //para iterar sobre columnasDB
    //Identificar y unir los atributos de la BD 
    public function atributos(){
        $atributos = [];
        foreach(self::$columnasDB as $columna){
            if($columna === 'id') continue; //esto sirve para cuando se cumpla la condicion deja de ejecutar el if 
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    public function sanitizarAtributos(){
        $atributos = $this->atributos();
        $sanitizado = [];

        //Arreglo asociativo, lo que ingresa el usuario 
        foreach($atributos as $key => $value ){
            $sanitizado[$key] = self::$db->escape_string($value);
        }
       // debuguear($sanitizado);
       return $sanitizado;

    }

    //Validacion
    //Funcion que va a leer los errores, inicia como un arreglo vacio 
    public static function getErrores(){
        return self::$errores;
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

    public function setImagen($imagen){
        if($imagen){
            $this->imagen = $imagen;
        }
    }

    //Lista todas las propiedades METODO all
    public static function all() {
        $query = "SELECT * FROM propiedades"; //Aqui esta como arreglo 

           $resultado = self::consultarSQL($query);  //Se pasa la consulta al metodo de consultarSQL
           return $resultado; //YA CON OBJETOS INSTANCIADOS Y MAPEADOS
    }

    public static function consultarSQL($query){ //aQUI SE CONSULTA LA BD 
        //Consultar la BD 
        $resultado = self::$db->query($query);

        //Se iteran los resultaos 
        $array = [];
        while($registro = $resultado->fetch_assoc()){  //Trae un arreglo asociativo 
            $array[]= self::crearObjeto($registro); //Se crea nuevo metodo que va a generar el objeto  //SE AGREGA AL FINAL DEL ARREGLO VACIO YA COMO OBJETO 
            
        }
       // debuguear($array);

        //Liberar la memoria 
        $resultado->free();

        //Retornar los resultados
        return $array;

    }

    protected static function crearObjeto($registro){
        $objeto = new self;

        foreach($registro as $key => $value) {
            if( property_exists( $objeto, $key ) ){ //Se tienen declarado ya los campos al inicio, entonces el if mapea los datos de arreglo a objetos 
                $objeto->$key = $value;
            }
        }

        return $objeto; //Se retorna como objeto 
    
    }
}


