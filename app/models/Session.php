<?php


/**
 * Clase para manejo de sesiones de usuario en nuestra página (inicio de sesión, cierre de sesión, si existe la sesión, etc.)
 *
 * @author Juan Miguel Hurtado Montejano -> jmhurtadomontejano@gmail.com
 */
class Session {
    static public function iniciar($usuario){
        $_SESSION['usuario_sesion']= serialize($usuario);
    }
    
    static public function existe() {
        return isset($_SESSION['usuario_sesion']);
    }
    
    static public function cerrar(){
        unset($_SESSION['usuario_sesion']);
    }
    
    /**
     * Devuelve el objeto usuario conectado o false si no ha iniciado sesión
     * @return boolean
     */
    static public function obtener(){
        if(isset($_SESSION['usuario_sesion']))
            return unserialize($_SESSION['usuario_sesion']);
        else
            return false;
    }

    
}
