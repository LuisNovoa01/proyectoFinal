<?php
session_start();
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$datosPost = $_POST;
//print_r($datosPost);
$horasReservadas = '';

foreach ($_POST as $clave => $valor) {
    if (is_int($clave)) {//esto recorre los valores enteros recibidos
        $horasReservadas = $horasReservadas . $clave . ":00,";
        // echo $clave;
    }
}


require 'utilidades/ConexionBD.php';
require 'modelos/Foto.php';
require 'modelos/Usuario.php';
require 'modelos/UsuarioDAO.php';
require 'modelos/Reserva.php';
require 'modelos/ReservaDAO.php';
require 'utilidades/mensajesFlash.php';
require 'utilidades/Session.php';

if (Session::existe() == false) {
    header("Location: index.php");
    MensajesFlash::anadir_mensaje("No puedes añadir mensajes si no inicias sesión");
    die();
}


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    //print_r($_GET);
    foreach ($_GET as $clave => $valor) {
        if (is_int($clave)) {
            $id_instalacion = filter_var($_GET['id_instalacion'], FILTER_SANITIZE_NUMBER_INT);
            $fecha_reserva = filter_var($_GET['fecha'], FILTER_SANITIZE_SPECIAL_CHARS);
            $hora_reserva = filter_var($_GET['hora_reserva'], FILTER_SANITIZE_SPECIAL_CHARS);
            $usuario_reserva = filter_var($_GET['usuario_reserva'], FILTER_SANITIZE_NUMBER_INT);
            //  imprimir_datos($usuario_reserva);
            if ($usuario_reserva == Session::obtener()) {
                $reserva_nueva = new Reserva();
                $reserva_nueva->setId_instalacion($id_instalacion);
                $reserva_nueva->setFecha_reserva($fecha_reserva);
                $reserva_nueva->setHora_inicio($clave . ":00:00");
                $reserva_nueva->setHora_fin(($clave + 1) . ":00:00");
                $reserva_nueva->setId_usuario($usuario_reserva);

                $reserDAO = new ReservaDAO(ConexionBD::conectar());
                if ($reserDAO->insert($reserva_nueva)) {
                    MensajesFlash::anadir_mensaje("Reserva añadida correctamente el dia: " . $fecha_reserva . ", a las " . $hora_reserva . ":00");
                    header("location:reservar.php", MensajesFlash::anadir_mensaje("Reserva añadida correctamente el dia: " . $fecha_reserva . ", a las " . $hora_reserva . ":00"));
                } else {
                    MensajesFlash::anadir_mensaje("No se pudo añadir la reserva");
                }
            }
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //  print_r($_POST);
    //  print_r($_POST['id_instalacion']);
    //  print_r($_POST['fecha']);
    $id_instalacion = filter_var($_POST['id_instalacion'], FILTER_SANITIZE_NUMBER_INT);
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
        <?php mensajesFlash::imprimir_mensajes() ?>
        <?php if ($_SERVER['REQUEST_METHOD'] == 'POST') { ?>
            <form action="confirmacionMultiple.php" method="GET" id="formulario">
                <label ><b>Id Instalacion:  <?php echo $_POST['id_instalacion'] ?> </label>
                <input class="displayNone" type="text" name="id_instalacion" value="<?php echo $_POST['id_instalacion'] ?>" >
                <br><label><b>Fecha: <?php echo $_POST['fecha'] ?> </label>
                <br><input hidden type="text" name="fecha" value="<?php echo $_POST['fecha']; ?>" >
                <br><label><b>Hora: </b> <?php echo $horasReservadas; ?></label>
                <?php foreach ($_POST as $clave => $valor) { ?>
                    <?php if (is_int($clave)) {//esto recorre los valores enteros recibidos ?>
                        <br><input hidden="" type="text" name="<?php echo $clave; ?>" value="<?php echo $clave; ?>" >
                        <?php
                    }
                }
                ?>
                <br><label><b>Usuario: </b> <?php echo Session::obtener(); ?></label>
                <br><input type="text" name="usuario_reserva" value="<?php echo Session::obtener(); ?>" hidden>
                <br><button>Confirmar Reserva</button>
            </form>
        <?php } ?>
    </body>
    <script>

<?php

function imprimir_datos($data) {
    echo sprintf('<pre>%s</pre>', print_r($data, true));
}
?>
    </script>
</html>

