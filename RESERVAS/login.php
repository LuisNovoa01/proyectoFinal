<?php

session_start();

require 'utilidades/ConexionBD.php';
require 'modelos/Foto.php';
require 'modelos/Usuario.php';
require 'modelos/UsuarioDAO.php';
require 'utilidades/Session.php';
require 'utilidades/MensajesFlash.php';

//Obtendo el usuario, si no existe vuelvo a index con un parámetro de error
$usuDAO = new UsuarioDAO(ConexionBD::conectar());
if (!$usuario = $usuDAO->findByEmail($_POST['email'])) {
    //Usuario no encontrado
    MensajesFlash::anadir_mensaje("Usuario o password incorrectos. email");
    header('Location: index.php');
    die();
}
//Compruebo la contraseña, si no existe vuelvo a index con un parámetro de error
if (!password_verify($_POST['password'], $usuario->getPassword())) {
    //password incorrecto
    MensajesFlash::anadir_mensaje("Usuario o password incorrectos. pass");
    header('Location: index.php');
    die();
}
//Usuario y password correctos, redirijo al listado de anuncios
Session::iniciar($usuario->getId());

//Generamos códiog sha1 aleatorio y lo actualizamos en el usuario
$usuario->setCookie_id(sha1(time() + rand()));
$usuDAO->update($usuario);

//Creamos cookie en el navegador cliente
setcookie('uid',$usuario->getCookie_id(), time()+60*60*24*7);

setcookie('uid', $usuario->getCookie_id(), time() + 60 * 60 * 24 * 7); //con esto creamos la cookie con el id de usuario
header("Location: reservar.php");
die();
