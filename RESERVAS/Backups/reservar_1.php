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


if(Session::existe()==false){
    header("Location: index.php");
    MensajesFlash::anadir_mensaje("No puedes añadir mensajes si no inicias sesión");
    die();
}
$error = false;

/*$id_usuario = '';
$fecha_reserva = '';
$hora_inicio = '';
$hora_fin = '';
$fecha_hora_registro = '';*/


if ($_SERVER['REQUEST_METHOD'] == 'POST') { //Cuando se envíe el formulario entramos aquí
    $id_usuario = $_SESSION['id_usuario_sesion'];
    $fecha_reserva = $_POST['fecha_reserva'];
    $hora_inicio = $_POST['hora_inicio'];
    $hora_fin = $_POST['hora_fin'];

    $reservaDAO = new ReservaDAO(ConexionBD::conectar());
    if ($id_usuario == "" || $fecha_reserva == "" || $hora_inicio == "" || $hora_fin == "") {
        $error = true;
        $errores = "Debes introducir todos los datos.";
        mensajesFlash::anadir_mensaje("Debes introducir todos los datos");
    } else {
     //   if ($fecha_reserva> date_diff($fecha_reserva, $datetime2) ) {
            $reserva_nueva = new Reserva();
            $reserva_nueva->setId_usuario($id_usuario);
            $reserva_nueva->setFecha_reserva($fecha_reserva);
            $reserva_nueva->setHora_inicio($hora_inicio);
            $reserva_nueva->setHora_fin($hora_fin);
            print_r($reserva_nueva);
            $reservaDAO->insert($reserva_nueva);
            header('Location: index.php');
      //  } else {
            $error = true;
            $errores = "No puedes hacer reservas anteriores a hoy";
            mensajesFlash::anadir_mensaje("No puedes hacer reservas anteriores a hoy");
        }
      //      print_r($reserva_nueva);}
   
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>

    <style>
        input {
            box-sizing: border-box;
            padding: 5px;
            margin: 10px;
            width: 100%;
        }
        .formulario{       
            box-sizing: border-box;
            display: block;
            justify-content: center;
            display: table;
            text-align: center;
            width: 90%;
        }
        .formulario p{
            text-align: left;
            margin-bottom: 0px;
        }

        .botones{
            display: flex;
            justify-content: space-around;

        }
    </style>
    <body>
        <?php mensajesFlash::imprimir_mensajes() ?>
        <form action="" method="post" class="formulario">
            <h2>Introduce tus datos de Reserva</h2>
            <p>Introduce la fecha que quieres reservar:</p>
            <input type="date" name="fecha_reserva" placeholder="Fecha Reserva">
            <p>Introduce la Hora de Inicio de la Reserva:</p>
            <input type="time" name="hora_inicio" placeholder="Introduce la Hora de Inicio de la Reserva">
            <p>Introduce la hora de Fin de la Reserva:</p>
            <input type="time" name="hora_fin" placeholder="Hora de Fin de Reserva">
        
            <div class="botones">
                <input type="submit" value="Reservar">
                <input type="button" value="volver" onclick="location.href = 'index.php'">
            </div>
        </form>
    </body>
</html>
