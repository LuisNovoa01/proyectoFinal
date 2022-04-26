<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Session
 * Clase para manejo de sesiones de usuario en nuestra página (inicio de sesión, cierre de sesión, si existe la sesión)
 * @author Juanmi 2º DAW
 */
class Session {
    static public function iniciar($id){
        $_SESSION['id_usuario_sesion']=$id;
    }
    
    static public function existe(){
        return isset($_SESSION['id_usuario_sesion']);
    }
    
    static public function cerrar(){
        unset($_SESSION['id_usuario_sesion']);
    }
    
    static public function obtener(){
        if(isset($_SESSION['id_usuario_sesion']))
            return $_SESSION['id_usuario_sesion'];
        else
            return false;
    }
}
