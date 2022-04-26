<?php
session_start();

require 'utilidades/ConexionBD.php';
require 'modelos/Foto.php';
require 'modelos/Usuario.php';
require 'modelos/UsuarioDAO.php';
require 'modelos/Reserva.php';
require 'modelos/ReservaDAO.php';
require 'utilidades/mensajesFlash.php';
require 'utilidades/Session.php';

$error=false;
if (isset($_COOKIE['uid']) && Session::existe() == false) {//si existe una cookie de uid lo identificamos
    $uid = filter_var($_COOKIE['uid'], FILTER_SANITIZE_SPECIAL_CHARS); //para sanear el código introducido
    $usuarioDAO = new UsuarioDAO(ConexionBD::conectar());
    $usuario = $usuarioDAO->findByCookie($uid);
    if ($usuario != false) {
        Session::iniciar(usu);
        imprimir_datos($_COOKIE['uid']);
    }else{
        $error=false;
    }
    
}
//Comprobamos que el token recibido es igual al que tenemos en la variable de sesión para evitar ataques CSRF
if($_GET['t']!=$_SESSION['token']){
    header("Location:index.php");
    MensajesFlash::anadir_mensaje("El token no es correcto. Prueba a refrescar con Ctrl+F5");
    $error=false;
    die();
}

$reservaDAO = new ReservaDAO(ConexionBD::conectar());

$reservaPaEliminar = $reservaDAO->findByIdReserva($_GET['id']);
$reservaEliminada = $reservaPaEliminar;
//MensajesFlash::anadir_mensaje(print_r($reservaPaEliminar->getId_reserva()));

//Comprobamos el el usuario es propietario de la reserva
if ( $reservaPaEliminar->getId_usuario() == Session::obtener()) {
    //MensajesFlash::anadir_mensaje("Reserva".$mensaje);
    if ($resultado = $reservaDAO->delete($reservaPaEliminar)) {
        MensajesFlash::anadir_mensaje("Reserva borrada satisfactoriamente. Datos de la reserva. Nº reserva:". $reservaEliminada->getId_reserva()." , fecha:".$reservaEliminada->getFecha_reserva());
    } else {
        MensajesFlash::anadir_mensaje("Reserva no borrada");
    }
} else {
    MensajesFlash::anadir_mensaje("¡La reserva no es tuya!");
}
header("Location: mis_reservas.php");
    
 
    


