<?php
require 'utilidades/ConexionBD.php';
require 'modelos/Foto.php';
require 'modelos/Usuario.php';
require 'modelos/UsuarioDAO.php';
require 'utilidades/mensajesFlash.php';
require 'utilidades/Session.php';
define('MB', 1048576);

session_start();
$conn = ConexionBD::conectar();


$nombre = '';
$apellidos = '';
$email = '';
$password = '';
$passwordRep = '';
$foto = '';

// Comprobación & caducidad de cookie
if (isset($_COOKIE['uid'])) {
    $uid = filter_var($_COOKIE['uid'], FILTER_SANITIZE_SPECIAL_CHARS);
    $userDAO = new UserDAO($conn);
    if ($usuario_nuevo = $userDAO->findByCookie($uid)) {
        if (!Session::exists()) {
            Session::start($usuario_nuevo->getId());
        }
        setcookie('uid', $usuario_nuevo->getCookie(), time() + 60 * 60 * 24 * 7);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') { //Cuando se envíe el formulario entramos aquí
    $error = false;
    $usuDAO = new UsuarioDAO(ConexionBD::conectar());
//Comprobamos el token
// imprimir_datos($_POST['token']);
// imprimir_datos($_SESSION['token']);

    /* if ($_POST['token'] != $_SESSION['token']) {
      //    header('Location: index.php');
      MensajesFlash::anadir_mensaje("Token incorrecto para registrar");
      die();
      }
     */

    /* LIMPIO LOS DATOS QUE RECIBO */
    $nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_SPECIAL_CHARS);
    $apellidos = filter_var($_POST['apellidos'], FILTER_SANITIZE_SPECIAL_CHARS);
    $telefono = filter_var($_POST['telefono'], FILTER_SANITIZE_NUMBER_INT);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    /*  $foto = filter_var($_POST['foto'], FILTER_SANITIZE_SPECIAL_CHARS);
      print_r([$_POST['foto']]); */
    $password = $_POST['password'];
    $passwordRep = $_POST['passwordRep'];

//Validaciones
    if ($nombre == "" || $apellidos == "" || $telefono == "" || $email == "" || $password == "" || $passwordRep == "") {
        $error = true;
        $errores = "Debes introducir todos los datos.";
        mensajesFlash::anadir_mensaje("Debes introducir todos los datos");
    }

    if ($password != $passwordRep) {
        $error = true;
        $errores = "Las Contraseñas no coinciden.";
        mensajesFlash::anadir_mensaje("Las Contraseñas no coinciden.");
    }

    if ($usuDAO->findByEmail($email)) {
        $error = true;
        $errores = "El email ya se encuentra registrado en la base de datos";
        mensajesFlash::anadir_mensaje($errores);
    }

    if ($_FILES['foto']['name'] != null) {
        if ($_FILES['foto']['type'] != 'image/png' && $_FILES['foto']['type'] != 'image/gif' && $_FILES['foto']['type'] != 'image/jpeg') {
            Message::addErrorMessage("La imagen no tiene el formato adecuado");
            $error = true;
        }
        if ($_FILES['foto']['size'] > 5 * MB) {
            Message::addErrorMessage("La imagen tiene un tamaño demasiado grande, el límite es de 5MB");
            $error = true;
        }
    }

    //si no hay error, envio los datos
    if (!$error) {
        $usuario_nuevo = new Usuario();
        $usuario_nuevo->setNombre($nombre);
        $usuario_nuevo->setApellidos($apellidos);
        $usuario_nuevo->setTelefono($telefono);
        $usuario_nuevo->setEmail($email);
        /*   $usuario_nuevo->setFoto($foto); LO COMENTO PORQUE SE RELLENA DESPUES DE VALIDAR Y GUARDAR LA FOTO */
        $usuario_nuevo->setPassword(password_hash($password, PASSWORD_BCRYPT));


        /* CODIGO PARA INSERTAR FOTO */
        if ($_FILES['foto']['name'] != null) {
            $nombreTemporal = filter_var($_FILES['foto']['tmp_name'], FILTER_SANITIZE_SPECIAL_CHARS);
            $nombreFoto = filter_var($_FILES['foto']['name'], FILTER_SANITIZE_SPECIAL_CHARS);
            $extensionFoto = substr($nombreFoto, strrpos($nombreFoto, '.'));
            $nuevoNombreFoto = md5(time() + rand(0, 999999)) . $extensionFoto;

            while (file_exists($nuevoNombreFoto)) {
                $nuevoNombreFoto = md5(time() + rand(0, 999999)) . $extensionFoto;
            }

            // Redimensionar imagen 
            list($width, $height, $type) = getimagesize($nombreTemporal);
            $width = ($width * 150) / $height;
            $height = 150;

            if ($type == IMAGETYPE_JPEG) {
                $img = imagecreatefromjpeg($nombreTemporal);
                $imgResized = imagescale($img, $width, $height);
                imagejpeg($imgResized, "imagenes/fotosUsuarios/" . $nuevoNombreFoto);
            } elseif ($type == IMAGETYPE_PNG) {
                $img = imagecreatefrompng($nombreTemporal);
                $imgResized = imagescale($img, $width, $height);
                imagepng($imgResized, "imagenes/fotosUsuarios/" . $nuevoNombreFoto);
            } elseif ($type == IMAGETYPE_GIF) {
                $img = imagecreatefromgif($nombreTemporal);
                $imgResized = imagescale($img, $width, $height);
                imagejpeg($imgResized, "imagenes/fotosUsuarios/" . $nuevoNombreFoto);
            }

            $usuario_nuevo->setFoto($nuevoNombreFoto);
        } else {
            $usuario_nuevo->setFoto('foto.jpg');
        }
        if ($usuDAO->insert($usuario_nuevo)) {
            MensajesFlash::anadir_mensaje("Usuario creado");
        } else {
            MensajesFlash::anadir_mensaje('No se ha podido crear el usuario');
        }
    }
}

//Calculamos un token
$token = md5(time() + rand(0, 999));
$_SESSION['token'] = $token;
?>


<!DOCTYPE html>
<html>
    <head>
        <title>Registrate</title>
        <link rel="stylesheet" type="text/css" href="utilidades/styleGestionReservas.css">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
    </head>
    <menu>
        <?php
        $titulo = "Registrar Usuario";
        $titulo2 = "";
        include ('utilidades/menu.php')
        ?>
    </menu>
    <body>
        <?php mensajesFlash::imprimir_mensajes() ?>
        <form action="" method="post" class="formulario" enctype="multipart/form-data">
            <p hidden="hidden">token: <input type="text" name="token" value="<?php echo $token ?>"> </p>
            <h2>Introduce tus datos de Registro</h2>
            <div><p>Introduce tu nombre:</p></div>
            <input type="text" name="nombre" value="<?php echo $nombre ?>" placeholder="Nombre">
            <div><p>Introduce tus apellidos:</p></div>
            <input type="text" name="apellidos" value="<?php echo $apellidos ?>" placeholder="Apellidos">
            <div><p>Introduce tu telefono:</p></div>
            <input type="number" name="telefono" value="<?php echo $telefono ?>" placeholder="Telefono">
            <div><p>Introduce tu email:</p></div>
            <input type="email" name="email" value="<?php echo $email ?>" placeholder="Email">
            <div><p>Selecciona tu foto a continuación</p> </div>
            <input type="file" name="foto" accept="image/*"><br>
            <div><p>Introduce tu contraseña:</p></div>
            <input type="password" name="password" placeholder="Password">
            <input type="password" name="passwordRep" placeholder="Repite Password">
            <div class="botones">
                <input type="submit" value="registrar">
                <input type="button" value="volver" onclick="location.href = 'index.php'">
            </div>
        </form>
    </body>
    <script>

<?php

function imprimir_datos($data) {
    echo sprintf('<pre>%s</pre>', print_r($data, true));
}
?>
    </script>
</html>
