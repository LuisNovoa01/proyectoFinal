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

//Comprobamos que el token recibido es igual al que tenemos en la variable de sesión para evitar ataques CSRF
if($_GET['t']!=$_SESSION['token']){
    header("Location:index.php");
    MensajesFlash::anadir_mensaje("El token no es correcto");
    die();
}

$reservaDAO = new ReservaDAO(ConexionBD::conectar());

$reservaPaEliminar = $reservaDAO->findByIdReserva($_GET['id']);
//MensajesFlash::anadir_mensaje(print_r($reservaPaEliminar->getId_reserva()));

//Comprobamos el el usuario es propietario de la reserva
if ( $reservaPaEliminar->getId_usuario() == Session::obtener()) {
  $numeroReservaEliminado = $reservaPaEliminar;
 
    if ($resultado = $reservaDAO->delete($reservaPaEliminar)) {
        MensajesFlash::anadir_mensaje("Reserva borrada satisfactoriamente. Datos de la reserva. Nº reserva:". $numeroReservaEliminado->getId_reserva()." , fecha:".$numeroReservaEliminado->getFecha_reserva());
    } else {
        MensajesFlash::anadir_mensaje("Reserva no borrada");
    }
} else {
    MensajesFlash::anadir_mensaje("¡La reserva no es tuya!");
}
header("Location: index.php");
    
 
    


