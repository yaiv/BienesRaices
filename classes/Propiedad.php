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

        $this->id = $args['id'] ?? null;
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
//Ver si se tiene id y en base a ello actualizar o crear 
    public function guardar(){
        if(!is_null($this->id)){
            //Actualizar 
            $this->actualizar();
        }else {
            //Creando un nuevo registro 
            $this->crear();
        }

    }

    public function crear() {

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
           
        //Mensaje de exito
        if($resultado){
       // echo 'Insertado Correctamente';
       //Se redirecciona al usuario 
       header("Location: /admin?resultado=1");  //Se paso con query string 

            }
    }

    public function actualizar(){
        //Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        $valores = [];
        foreach($atributos as $key => $value){
            $valores[] = "{$key} ='{$value}'";
        }

        $query = " UPDATE propiedades SET ";
        $query .= (join(', ', $valores));
        $query .= " WHERE id= '" . self ::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1";

        $resultado = self::$db->query($query);

            if($resultado){
               // echo 'Insertado Correctamente';
               //Se redirecciona al usuario 
               header("Location: /admin?resultado=2");  //Se paso con query string 
            }

        return $resultado;
    }

    //Eliminar un registro 
    public function eliminar(){
                //eliminar propiedad
        $query = "DELETE FROM propiedades WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($query);
            if($resultado){
            $this->borrarImagen();
            header('location: /admin?resultado=3');
        }
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
        //Comprobar si la imagen existe y eliminar antes de asignar otra 
        //Elimina la imagen previa 

        //debuguear($this->imagen);
        if(!is_null($this->id)){
            $this->borrarImagen();
        }


        //Asignar el atributo de imagen el nombre imagen 
        if($imagen){
            $this->imagen = $imagen;
        }
    }

    //Elimina el archivo 
    public function borrarImagen(){
        
            //Comprobar si el archivo existe 
            $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
            if($existeArchivo){
                unlink(CARPETA_IMAGENES . $this->imagen);
            }
    }

    //Lista todas las propiedades METODO all
    public static function all() {
        $query = "SELECT * FROM propiedades"; //Aqui esta como arreglo 

           $resultado = self::consultarSQL($query);  //Se pasa la consulta al metodo de consultarSQL
           return $resultado; //YA CON OBJETOS INSTANCIADOS Y MAPEADOS
    }

    //Busca un registro por su ID 
    public static function find($id){
        $query = "SELECT * FROM propiedades WHERE id = {$id}";
        $resultado = self::consultarSQL($query);

        return ( array_shift($resultado));

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

    //Sincroniza el objeto en memoria con los cambios realizados por el usuario 
    public function sincronizar( $args=[] ){
        foreach($args as $key => $value){
            if(property_exists($this, $key) && !is_null($value) ){
                $this->$key = $value;
            }
        }
    }
}


