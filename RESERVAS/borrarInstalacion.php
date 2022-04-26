<?php

session_start();

require 'utilidades/ConexionBD.php';
require 'modelos/Foto.php';
require 'modelos/Usuario.php';
require 'modelos/UsuarioDAO.php';
require 'modelos/Instalacion.php';
require 'modelos/InstalacionDAO.php';
require 'modelos/Reserva.php';
require 'modelos/ReservaDAO.php';
require 'utilidades/mensajesFlash.php';
require 'utilidades/Session.php';

$error = false;
if (isset($_COOKIE['uid']) && Session::existe() == false) {//si existe una cookie de uid lo identificamos
    $uid = filter_var($_COOKIE['uid'], FILTER_SANITIZE_SPECIAL_CHARS); //para sanear el código introducido
    $usuarioDAO = new UsuarioDAO(ConexionBD::conectar());
    $usuario = $usuarioDAO->findByCookie($uid);
    if ($usuario != false) {
        Session::iniciar(usu);
        imprimir_datos($_COOKIE['uid']);
    } else {
        $error = true;
        MensajesFlash::anadir_mensaje("No se puede borrar una instalacion sin iniciar sesión");
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $error==false) {
    $instalacionDAO = new InstalacionDAO(ConexionBD::conectar());
    $instalacionPaEliminar = $instalacionDAO->findByInstalacion($_POST['id']);
    $instalacionEliminada = $instalacionPaEliminar;
//MensajesFlash::anadir_mensaje(print_r($reservaPaEliminar->getId_reserva()));
    $usuarioDAO = new UsuarioDAO(ConexionBD::conectar());
    $usuario = $usuarioDAO->findByCookie($_COOKIE['uid']);
//Comprobamos el el usuario es administrador
//imprimir_datos($usuario);
    if ($usuario->getPrivilegios() == 'admin' && $usuario->getId()==Session::obtener()) {
        //MensajesFlash::anadir_mensaje("Reserva".$mensaje);
        if ($resultado = $instalacionDAO->delete($instalacionPaEliminar)) {
            MensajesFlash::anadir_mensaje("Instalacion borrada satisfactoriamente. Datos de la instalacion. Nº instalacion:" . $instalacionEliminada->getId_instalacion() . " , nombre:" . $instalacionEliminada->getNombre_instalacion());
        } else {
            MensajesFlash::anadir_mensaje("Instalacion no borrada");
        }
    } else {
        MensajesFlash::anadir_mensaje("No tienes privilegios de ADMIN. No se como coño has llegado aqui");
    }
    header("Location: borrarInstalacion.php");
}

if (isset($_GET['id'])) {
    $instalacionDAO = new InstalacionDAO(ConexionBD::conectar());
    $instalacionPaEliminar = $instalacionDAO->findByInstalacion($_GET['id']);
    $instalacionEliminada = $instalacionPaEliminar;
//MensajesFlash::anadir_mensaje(print_r($reservaPaEliminar->getId_reserva()));
    $usuarioDAO = new UsuarioDAO(ConexionBD::conectar());
    $usuario = $usuarioDAO->findByCookie($_COOKIE['uid']);
//Comprobamos el el usuario es administrador
//imprimir_datos($usuario);
    if ($usuario->getPrivilegios() == 'admin') {
        //MensajesFlash::anadir_mensaje("Reserva".$mensaje);
        if ($resultado = $instalacionDAO->delete($instalacionPaEliminar)) {
            MensajesFlash::anadir_mensaje("Instalacion borrada satisfactoriamente. Datos de la instalacion eliminada: Nº instalacion:" . $instalacionEliminada->getId_instalacion() . " , nombre:" . $instalacionEliminada->getNombre_instalacion());
        } else {
            MensajesFlash::anadir_mensaje("Instalacion no borrada");
        }
    } else {
        MensajesFlash::anadir_mensaje("No tienes privilegios de ADMIN. No se como coño has llegado aqui");
    }
    header("Location: instalaciones.php");
}
    
 
    


