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


if (Session::existe() == false) {
    header("Location: index.php");
    MensajesFlash::anadir_mensaje("No puedes ver tus reservas si no inicias sesión");
    die();
}

if (isset($_COOKIE['uid']) && Session::existe() == false) { //Si existe la cookie lo identificamos
    $uid = filter_var($_COOKIE['uid'], FILTER_SANITIZE_SPECIAL_CHARS);
    $usuarioDAO = new UsuarioDAO(ConexionBD::conectar());
    $usuario = $usuarioDAO->findByCookie_id($uid);
    if ($usuario != false) {   //Si existe un usuario con la cookie iniciamos sesión
        Sesion::iniciar($usuario->getId());
    }
}
/*
  //Comprobamos que el token recibido es igual al que tenemos en la variable de sesión para evitar ataques CSRF
  if($_GET['t']!=$_SESSION['token']){
  header("Location:index.php");
  MensajesFlash::anadir_mensaje("El token no es correcto");
  die();
  } */

if (Session::existe() == true) {
    /*     $conn = ConexionBD::conectar();
      $reservaDAO = new ReservaDAO($conn);
      $usuario = $reservaDAO->find(Session::obtener()); */
    $reservaDAO = new ReservaDAO(ConexionBD::conectar()); //conecto con la base de datos
    $reservas = $reservaDAO->findByUser(Session::obtener()); //
    //imprimir_datos($reservas); //esto muestra la impresion del contenido de $reservas
    //Generamos Token para seguridad del borrado
    $_SESSION['token'] = md5(time() + rand(0, 999));
    $token = $_SESSION['token'];
}
?>
<!DOCTYPE html>
<html>
    <head>


        <title>Gestion Reservas</title>

    </head>


    <body>
        <div>
            <?php
            $titulo = "Mis Reservas";
            $titulo2 = "";
            include ('utilidades/menu.php')
            ?>
        </div>


        <h2>Estas son las reservas que ya tienes realizadas a fecha <?php echo date('Y-m-d') ?></h2>
        <?php if (Session::existe()) { ?><!-- he intentado -> if ($reservas->getId_usuario() == Sesion::obtener())-->
        <table id="tables">
                <thead>
                    <tr>
                        <th>Dia reserva   </th>
                        <th>Hora Inicio Reserva</th>
                        <th>Hora Fin Reserva</th>
                        <th>Usuario Reserva</th>
                        <th>ID_reserva</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($reservas as $reservasByUser) {
                        $usuarioDAO = new UsuarioDAO(ConexionBD::conectar());
                        $usuario = $usuarioDAO->find($reservasByUser->getId_usuario());
                        ?>

                        <tr>
                            <td><?php echo $reservasByUser->getFecha_reserva(); ?></td>
                            <td><?php echo $reservasByUser->getHora_inicio(); ?> </td>
                            <td><?php echo $reservasByUser->getHora_fin(); ?> </td>
                            <td><?php echo $usuario->getNombre() . " " . $usuario->getApellidos(); ?> </td>
                            <td><?php echo $reservasByUser->getId_reserva(); ?> </td>
                            <td><?php if ($reservasByUser->getFecha_reserva() <= date('Y-m-d')) { ?> 
                                    <?php echo 'No se puede borrar. Fecha de la reserva pasada. '; ?>
                                <?php } else { ?>
                                    <a href="borrarReserva.php?id=<?= $reservasByUser->getId_reserva() ?>&t=<?= $token ?>"><img src="imagenes/iconos/trash.svg" class="papelera"></a>
                                </td>
                            <?php } ?> 
                        <?php } ?> 
                    </tr>


                </tbody>
            </table>
        <?php } ?>



    </body>
    <script>
        function setFecha() {
            let fecha = document.getElementById("fecha").value;
            window.location.href = "reservar.php?fecha=" + fecha.toLocaleString();
        }
<?php if (isset($_GET['fecha'])) { ?>
            function reservar(hora) {
                window.location.href = "confirmacion.php?fecha=<?php echo $_GET['fecha']; ?>&hora=" + hora;
            }
<?php } ?>
<?php

function imprimir_datos($data) {
    echo sprintf('<pre>%s</pre>', print_r($data, true));
}
?>
    </script>
</html>
