<?php 

namespace App;

use Intervention\Image\Colors\Hsv\Channels\Value;

//Se va a tulizar active record, es el responsable de trabajar con datos

class ActiveRecord {

    //Base de Datos
    protected static $db;
    //Arrelo que permite mapear en crear.php
    protected static $columnasDB = [];

    //Se coloca protected para que solo se pueda acceder en esta clase y no se modifique desde los objetos 

    protected static $tabla = '';

    //Errores o validaciones 
    protected static $errores = [];




     //Definir la conexion a BD 
    //Se usa self ya que es estatico
    public static function setDB($database){
        self::$db = $database;

      //  debuguear($resultado);

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
           $query = " INSERT INTO " . static::$tabla . " ( ";
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

        $query = " UPDATE " . static::$tabla . " SET ";
        $query .= (join(', ', $valores));
        $query .= " WHERE id= '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1";

        //Resultado de la consulta 
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
        $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
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
        foreach(static::$columnasDB as $columna){
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
        return static::$errores;
    }

        public function validar(){
            //Mensajes de error 
        static::$errores = [];
        return static::$errores;
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

    //Lista todas los registros  METODO all
    public static function all() {
        $query = "SELECT * FROM " . static::$tabla; //Aqui esta como arreglo 

           $resultado = self::consultarSQL($query);  //Se pasa la consulta al metodo de consultarSQL
           return $resultado; //YA CON OBJETOS INSTANCIADOS Y MAPEADOS
    }

    //Busca un registro por su ID 
    public static function find($id){
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = {$id}";
        $resultado = self::consultarSQL($query);

        return ( array_shift($resultado));

    }


    public static function consultarSQL($query){ //aQUI SE CONSULTA LA BD 
        //Consultar la BD 
        $resultado = self::$db->query($query);

        //Se iteran los resultaos 
        $array = [];
        while($registro = $resultado->fetch_assoc()){  //Trae un arreglo asociativo 
            $array[]= static::crearObjeto($registro); //Se crea nuevo metodo que va a generar el objeto  //SE AGREGA AL FINAL DEL ARREGLO VACIO YA COMO OBJETO 
            
        }
       // debuguear($array);

        //Liberar la memoria 
        $resultado->free();

        //Retornar los resultados
        return $array;

    }

    protected static function crearObjeto($registro){
        $objeto = new static;

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


