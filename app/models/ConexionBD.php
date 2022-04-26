<?php
/**
 * Description of ConexionBD
 *
 * @author Juan Miguel Hurtado Montejano -> jmhurtadomontejano@gmail.com
 */
class ConexionBD {
    public static function conectar(): mysqli{
        $conn = new mysqli('localhost','root','','proyectoFinal');
        if($conn->connect_error){
            die("Error al conectar con MySQL: " . $conn->error);
        }
        return $conn;
    }
}

