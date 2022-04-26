<!--Version buena, editada: 05/11/2021 -->
<?php
session_start(); //Permite utilizar variables de sesión

require 'utilidades/ConexionBD.php';
require 'modelos/Usuario.php';
require 'modelos/UsuarioDAO.php';
require 'modelos/Reserva.php';
require 'modelos/ReservaDAO.php';
require 'utilidades/Session.php';
require 'utilidades/MensajesFlash.php';

if (isset($_COOKIE['uid']) && Session::existe() == false) {//si existe una cookie de uid lo identificamos
    $uid = filter_var($_COOKIE['uid'], FILTER_SANITIZE_SPECIAL_CHARS); //para sanear el código introducido
    $usuarioDAO = new UsuarioDAO(ConexionBD::conectar());

    /* La siguiente linea funcionaba, pero la cambio para dejarlo como Samuel
      if ($usuarioDAO->findByCookie($_COOKIE['uid'])) {
      Session::iniciar($_COOKIE['uid']);
      } */
    $usuario = $usuarioDAO->findByCookie($uid);
    if ($usuario != false) {
        Session::iniciar($usuario);
    }
}

//GENERAMOS TOKEN para seguridad del borrado
$_SESSION['token'] = md5(time() + rand(0, 999));
$token = $_SESSION['token'];
//$token = $_SESSION['token']=md5(time()+rand(0,999));

$conn = ConexionBD::conectar();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
        <title>Gestion Reservas</title>
    </head>
    <body>
        <nav>
            <?php
            $titulo = "Indice";
            $titulo2="";
            include ('utilidades/menu.php') ?>
        </nav>
        <main>
            <?php MensajesFlash::imprimir_mensajes(); ?>
        </main>
    </body>
</html>