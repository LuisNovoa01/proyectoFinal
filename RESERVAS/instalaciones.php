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
$id_instalacion = '';
$nombre_instalacion = '';
$descripcion_instalacion = '';
$precio = '';
$foto = '';


if (isset($_COOKIE['uid']) && Session::existe() == true) {//si existe una cookie de uid lo identificamos
    $uid = filter_var($_COOKIE['uid'], FILTER_SANITIZE_SPECIAL_CHARS); //para sanear el código introducido
    $usuarioDAO = new UsuarioDAO(ConexionBD::conectar());
    $usuario = $usuarioDAO->findByCookie($uid);
    if ($usuario != false) {
        Session::iniciar($usuario->getId());
        // imprimir_datos($_COOKIE['uid']);
    } else {
        $error = true;
    }
} else {//antes tenia if (Session::existe() == false)
    header("Location: index.php");
    MensajesFlash::anadir_mensaje("No puedes ver instalaciones si no inicias sesión");
    die();
}
/* echo ($_GET['token']);
  imprimir_datos($_GET['token']);
  imprimir_datos($_SESSION['token']);
 */
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $error = false;

    //Comprobamos que el token recibido es igual al que tenemos en la variable de sesión para evitar ataques CSRF
    /*  if ($_GET['t'] != $_SESSION['token']) {
      header("Location:instalaciones.php");
      MensajesFlash::anadir_mensaje("El token no es correcto en la comprobacion de entrada");
      $errorPOST = true;
      die();
      } */
    $nombre_instalacion = filter_var($_POST['nombre_instalacion'], FILTER_SANITIZE_SPECIAL_CHARS);
    $descripcion_instalacion = filter_var($_POST['descripcion_instalacion'], FILTER_SANITIZE_SPECIAL_CHARS);
    $precio = filter_var($_POST['precio'], FILTER_SANITIZE_SPECIAL_CHARS);
    $id_instalacion = $_POST["id_instalacion"];
    // imprimir_datos($nombre_instalacion);
    //  imprimir_datos($descripcion_instalacion);
    //  imprimir_datos($precio);

    if ($nombre_instalacion == '' || $descripcion_instalacion == "" || $precio == '' || $error != false) {
        $error = true;
        $errores = "Debes introducir todos los datos.";
        mensajesFlash::anadir_mensaje("Debes introducir todos los datos");
    }
    // print_r($nombre_instalacion);
    $instalDAO = new InstalacionDAO(ConexionBD::conectar());
    if ($instalDAO->findByNombreInstalacion($nombre_instalacion)) {
        $error = true;
        $errores = "Ya existe ese nombre de instalación.";
        mensajesFlash::anadir_mensaje("Ya existe ese nombre de instalación.");
    }
    if (!$error) {
        $instalDAO = new InstalacionDAO(ConexionBD::conectar());

        ; //si la consulta no encuentra ese nombre de pista
        $instalacionNueva = new Instalacion();
        $instalacionNueva->setNombre_instalacion($nombre_instalacion);
        $instalacionNueva->setDescripcion_instalacion($descripcion_instalacion);
        $instalacionNueva->setPrecio_hora_instalacion($precio);


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
                imagejpeg($imgResized, "imagenes/instalaciones/" . $nuevoNombreFoto);
            } elseif ($type == IMAGETYPE_PNG) {
                $img = imagecreatefrompng($nombreTemporal);
                $imgResized = imagescale($img, $width, $height);
                imagepng($imgResized, "imagenes/instalaciones/" . $nuevoNombreFoto);
            } elseif ($type == IMAGETYPE_GIF) {
                $img = imagecreatefromgif($nombreTemporal);
                $imgResized = imagescale($img, $width, $height);
                imagejpeg($imgResized, "imagenes/instalaciones/" . $nuevoNombreFoto);
            }

            $instalacionNueva->setFoto_instalacion($nuevoNombreFoto);
        } else {
            $instalacionNueva->setFoto_instalacion("");
        }





        if ($instalDAO->insert($instalacionNueva)) {
            MensajesFlash::anadir_mensaje("Pista añadida correctamente");
            //despues de añadir la pista, tengo que limpiar sus datos
            $id_instalacion = '';
            $nombre_instalacion = '';
            $descripcion_instalacion = '';
            $precio = '';
        } else {
            MensajesFlash::anadir_mensaje("Problema al añadir la instalación: " . $nombre_instalacion . "");
        }
    }
}

if (Session::existe() == true) {
    $instalacionDAO = new InstalacionDAO(ConexionBD::conectar());
    $instalaciones = $instalacionDAO->findallInstalaciones();
}

//Generamos Token para seguridad del borrado
$_SESSION['token'] = md5(time() + rand(0, 999));
$token = $_SESSION['token'];
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Gestion Reservas</title>
        <script src="https://use.fontawesome.com/2a534a9a61.js"></script>
        <link rel="stylesheet" type="text/css" href="utilidades/styleGestionReservas.css">
        <meta charset="UTF-8">
    </head>

    <body>
        <menu>
            <?php
            $titulo = "Instalaciones";
            $titulo2 = "";
            include ('utilidades/menu.php')
            ?>
        </menu>


        <?php if (Session::existe() && $usuario->getPrivilegios() == 'admin') { ?><!-- he intentado -> if ($reservas->getId_usuario() == Sesion::obtener())-->
            <?php
            $instalacionDAO = new InstalacionDAO(ConexionBD::conectar()); //conecto con la base de datos
            $instalaciones = $instalacionDAO->findallInstalaciones(); //
            //  imprimir_datos($instalaciones);
            ?>
            <h2>Estas son las pistas existentes a dia: <?php print_r(date('d-m-Y')); ?></h2>
            <br>
            <div id="tables">
                <table>
                    <thead>
                        <tr>
                            <th>Id Pista  </th>
                            <th>Nombre Instalacion</th>
                            <th>Descripcion</th>
                            <th>precio</th>
                            <th>Foto</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($instalaciones as $instalacion) { ?>
                            <tr>
                                <td><?php echo $instalacion->getId_instalacion(); ?></td>
                                <td><?php echo $instalacion->getNombre_instalacion(); ?> </td>
                                <td><?php echo $instalacion->getDescripcion_instalacion(); ?> </td>
                                <td><?php echo $instalacion->getPrecio_hora_instalacion(); ?> </td>
                                <td><div id="foto_instalacion" style="background-image: url(imagenes/instalaciones/<?= $instalacion->getFoto_instalacion() ?>)"></div> </td>

                                <td><a href="borrarInstalacion.php?id=<?= $instalacion->getId_instalacion() ?>&t=<?= $token ?>"><img src="imagenes/iconos/trash.svg" class="papelera"></a></td>
                            <?php } ?> 

                        </tr>


                    </tbody>
                </table>
            </div>
            <br>
            <div id="formulario">
                <?php mensajesFlash::imprimir_mensajes() ?>
                <form action="" method="post" class="formulario" enctype="multipart/form-data">
                    <h2>En las casillas inferiores puedes añadir una nueva instalación</h2>
                    <p hidden="">Id de la Instalación
                        <input type="number" placeholder="ID Instalación" value="<?php echo $id_instalacion; ?>" name="id_instalacion" hidden=""></p>
                    <p>Nombre de la Instalación:
                        <input type="text" placeholder="Nombre de la Instalación" value="<?php echo $nombre_instalacion; ?>" name="nombre_instalacion"></p>
                    <p>Descripcion de la Instalación
                        <input type="text" placeholder="Descripcion de la instalación" value="<?php echo $descripcion_instalacion; ?>" name="descripcion_instalacion"></p>
                    <p>Precio de la Instalación
                        <input type="number" placeholder="Precio" name="precio" width="10" value="<?php echo $precio; ?>">€</p>
                    <div><p>Selecciona foto de la Instalación</p> </div>
                    <input type="file" name="foto" accept="image/*"><br>
                    <p hidden="hidden">token
                        <input type="text" placeholder="token" value="<?php echo $token; ?>" name="token" hidden=""></p>
                    <input type="submit" value="Registrar Instalación" name="registrar_instalacion" />
                </form>
            </div>
        <?php } ?>
        <script>
<?php

function imprimir_datos($data) {
    echo
    sprintf('<pre>%s</pre>', print_r($data, true));
}
?>

        </script>
    </body>
</html>
