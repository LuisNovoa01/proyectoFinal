<?php
require 'utilidades/ConexionBD.php';
require 'modelos/Foto.php';
require 'modelos/Usuario.php';
require 'modelos/UsuarioDAO.php';
require 'modelos/Reserva.php';
require 'modelos/ReservaDAO.php';
require 'utilidades/mensajesFlash.php';
require 'utilidades/Session.php';


session_start();
$conn = ConexionBD::conectar();


if (Session::existe() == false) {
    header("Location: index.php");
    MensajesFlash::anadir_mensaje("No puedes añadir mensajes si no inicias sesión");
    die();
}

// Comprobación & caducidad de cookie
if (isset($_COOKIE['uid'])) {
    $uid = filter_var($_COOKIE['uid'], FILTER_SANITIZE_SPECIAL_CHARS);
    $usuarioDAO = new UsuarioDAO($conn);
    if ($user = $usuarioDAO->findByCookie($uid)) {
        if (!Session::existe()) {
            Session::iniciar($user->getId());
        }
        setcookie('uid', $user->getCookie_id(), time() + 60 * 60 * 24 * 7);
    }
}

//Comprobamos que el token recibido es igual al que tenemos en la variable de sesión para evitar ataques CSRF
/* if ($_GET['t'] != $_SESSION['token']) {
  echo ($_GET['t']);
  echo ($_SESSION['token']);
  header("Location:reservar.php");
  MensajesFlash::anadir_mensaje("El token no es correcto");
  $errorPOST = true;
  die();
  }
 */

$error = false;

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $usuDAO = new UsuarioDAO(ConexionBD::conectar());
    $id_instalacion = $_GET['id_instalacion'];
    $fecha_reserva = $_GET['fecha'];
    $hora_reserva = $_GET['hora'];
    $usuario_reserva = $usuDAO->find(Session::obtener())->getEmail();
}

//Compruebo la cookie del usuario con la de la sesion
$uid = filter_var($_COOKIE['uid'], FILTER_SANITIZE_SPECIAL_CHARS); //para sanear el código introducido
if (isset($_COOKIE['uid']) && Session::existe() == false) {//si existe una cookie de uid lo identificamos
    $usuarioDAO = new UsuarioDAO(ConexionBD::conectar());
    $usuario = $usuarioDAO->findByCookie($uid);
    if ($usuario != false) {
        Session::iniciar(usu);
// imprimir_datos($_COOKIE['uid']);
    } else {
        $error = true;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !$error) {
    $id_instalacion = filter_var($_POST['id_instalacion'], FILTER_SANITIZE_NUMBER_INT);
    $fecha_reserva = filter_var($_POST['fecha_reserva'], FILTER_SANITIZE_SPECIAL_CHARS);
    $hora_reserva = filter_var($_POST['hora_reserva'], FILTER_SANITIZE_SPECIAL_CHARS);
    $usuario_reserva = filter_var($_POST['usuario_reserva'], FILTER_SANITIZE_NUMBER_INT);
//  imprimir_datos($usuario_reserva);
    if ($usuario_reserva == Session::obtener()) {
        $reserva_nueva = new Reserva();
        $reserva_nueva->setId_instalacion($id_instalacion);
        $reserva_nueva->setFecha_reserva($fecha_reserva);
        $reserva_nueva->setHora_inicio($hora_reserva . ":00:00");
        $reserva_nueva->setHora_fin(($hora_reserva + 1) . ":00:00");
        $reserva_nueva->setId_usuario($usuario_reserva);

        $reserDAO = new ReservaDAO(ConexionBD::conectar());
        if ($result = $reserDAO->insert($reserva_nueva)) {
    
    

            $to = $user->getEmail();
            $subject = "Confirmación de Reserva";
            $message = "Este email es una confirmación de la reserva de la pista ".$instalacion.", el dia " . $fecha_reserva . " a las " . $hora_reserva;
            $headers = "From: jmhurtadomontejano@gmail.com" . "\r\n";
            
            mail($to, $subject, $message, $headers);
            MensajesFlash::anadir_mensaje("Reserva añadida correctamente el dia: " . $fecha_reserva . ", a las " . $hora_reserva . ":00");
            header("location:reservar.php", MensajesFlash::anadir_mensaje("Reserva añadida correctamente el dia: " . $fecha_reserva . ", a las " . $hora_reserva . ":00"));
        } else {
            MensajesFlash::anadir_mensaje("No se puedo añadir la reserva");
        }
    }
}
?>

<!DOCTYPE html>
<html>
    <link rel="stylesheet" type="text/css" href="utilidades/styleGestionReservas.css">

</style>
<header>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 


    <body>
        <menu>
            <?php
            $titulo = "Confirmación de Reserva";
            include ('utilidades/menu.php')
            ?>
        </menu>

        <form action="confirmacion.php" method="POST" id="formulario">
            <h2>Verifica los datos y pulsa el botón de Confirmación</h2>

            <div> <label ><b>Id Instalacion:  <?php echo $id_instalacion; ?> </label>
                <input hidden="" type="text" name="id_instalacion" value="<?php echo $id_instalacion; ?>" ></div>
            <div><label><b>Fecha: <?php echo date($fecha_reserva); ?> </label>
                <input hidden type="text" name="fecha_reserva" value="<?php echo $fecha_reserva; ?>" ></div>
            <div><label><b>Hora: </b> <?php echo $hora_reserva; ?>:00</label>
                <input hidden type="text" name="hora_reserva" value="<?php echo $hora_reserva; ?>"></div>
            <div><label><b>Usuario: </b> <?php echo $usuario_reserva; ?></label>
                <input hidden="" type="text" name="usuario_reserva" value="<?php echo Session::obtener(); ?>"></div>
            <div><button>Confirmar Reserva</button></div>
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

