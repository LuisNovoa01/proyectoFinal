<?php

session_start(); //Permite utilizar variables de sesión

require 'models/ConexionBD.php';
require 'models/Articulo.php';
require 'models/Foto.php';
require 'models/Usuario.php';
require 'models/UsuarioDAO.php';
require 'models/MensajesFlash.php';
require 'models/Session.php';
require 'models/articles/ArticuloDAO.php';


if (($_FILES['foto']['type'] != 'image/png' &&
        $_FILES['foto']['type'] != 'image/gif' &&
        $_FILES['foto']['type'] != 'image/jpeg')) {
    MensajesFlash::add_message('La imagen no tiene el formato adecuado');
    header('Location: index.php');
    die();
}
//Generamos un nombre para la foto
$nombre_foto = md5(time() + rand(0, 999999));
$extension_foto = substr($_FILES['foto']['name'], strrpos($_FILES['foto']['name'], '.') + 1);
//Comprobamos que no exista ya una foto con el mismo nombre, si existe calculamos uno nuevo
while (file_exists("imagenes/$nombre_foto.$extension_foto")) {
    $nombre_foto = md5(time() + rand(0, 999999));
}
//movemos la foto a la carpeta que queramos guardarla y con el nombre original
move_uploaded_file($_FILES['foto']['tmp_name'], "images/$nombre_foto.$extension_foto");
//Actualizamos en la BD
$conn = ConexionBD::conectar();
$usuarioDAO = new UsuarioDAO($conn);
$usuario = $usuarioDAO->find(Sesion::obtener());
$usuario->setFoto("$nombre_foto.$extension_foto");
$usuarioDAO->update($usuario);

header('Location: index.php');


