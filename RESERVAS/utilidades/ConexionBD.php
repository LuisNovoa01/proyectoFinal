<?php
/**
 * Description of ConexionBD
 *
 * @author DAW2
 */
class ConexionBD {
    public static function conectar(): mysqli{
        $conn = new mysqli('localhost','admin','admin','gestion_reservas');
        if($conn->connect_error){
            die("Error al conectar con MySQL: " . $conn->error);
        }
        return $conn;
    }
}
