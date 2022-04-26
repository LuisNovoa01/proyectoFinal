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


if (isset($_COOKIE['uid']) && Session::existe() == false) {//si existe una cookie de uid lo identificamos
    $uid = filter_var($_COOKIE['uid'], FILTER_SANITIZE_SPECIAL_CHARS); //para sanear el código introducido
    $usuarioDAO = new UsuarioDAO(ConexionBD::conectar());
    $usuario = $usuarioDAO->findByCookie($uid);
    if ($usuario != false) {
        Session::iniciar(usu);
        MensajesFlash::anadir_mensaje(imprimir_datos($_COOKIE['uid']));
    }
    imprimir_datos($_COOKIE['uid']);
}
$error = false;

if (isset($_GET['fecha'])) {
    //$reservas = $reservaDAO->findallReservasByFecha($_GET['fecha']);
    //$reservas = $reservaDAO->findallReservasByFechaEInstalacion($_GET['fecha']);
    //  imprimir_datos($reservas);
    $reservaDAO = new ReservaDAO(ConexionBD::conectar());
    $usuDAO = new UsuarioDAO(ConexionBD::conectar());
}

//Calculamos un token
$token = md5(time() + rand(0, 999));
$_SESSION['token'] = $token;
?>
<!DOCTYPE html>
<html>
 <?php if (Session::existe()): ?>
            <?php
            $conn = ConexionBD::conectar();
            $usuDAO = new UsuarioDAO($conn);
            $usuario = $usuDAO->find(Session::obtener());
            ?>
    <?php endif; ?>
    
    <link rel="stylesheet" type="text/css" href="utilidades/styleGestionReservas.css">
    <title>Gestion Reservas</title>


    <body>
        <menu>
            <?php include ('utilidades/menu.php') ?>
        </menu>
        <?php mensajesFlash::imprimir_mensajes() ?>

        <h2>Introduce tus datos de Reserva</h2>
        <p>Selecciona en la siguiente casilla la fecha que quieres reservar:</p>
        <input type="date" name="fecha_reserva" min="<?php echo date('Y-m-d') ?>" value="<?php date('Y-m-d') ?>"
        <?php
        if (isset($_GET['fecha'])) {
            echo 'value="' . $_GET['fecha'] . '"';
        }
        ?> id="fecha" onchange="setFecha()">


        <?php if (isset($_GET['fecha'])) { ?><!-- si hay fecha-->
            <br>
            <?php
            $instalacionDAO = new InstalacionDAO(ConexionBD::conectar());
            $instalaciones = $instalacionDAO->findallInstalaciones();
            // imprimir_datos($instalaciones);

            foreach ($instalaciones as $instalacion) {
                $reservaDAO = new ReservaDAO(ConexionBD::conectar());
                //echo $instalacion->getId_instalacion();
                $reservas = $reservaDAO->findallReservasByFechaEInstalacion($_GET['fecha'], $instalacion->getId_instalacion());
                // imprimir_datos($reservas);
                $horas_reservadas = Array();
                foreach ($reservas as $reserva) {
                    $hora = intval($reserva->getHora_inicio()); //intval para pasar String a int en PHP
                    //echo $hora;
                    $horas_reservadas[$hora] = $usuDAO->find($reserva->getId_usuario())->getEmail();
                    //   imprimir_datos($instalacion);
                    //    imprimir_datos($horas_reservadas);
                }
                ?>

                <div id="tables">
                    <table>
                        <h1><?php print($instalacion->getNombre_instalacion()) ?></h1>


                        <thead>
                        <br>
                        <?php print_r($instalacion->getDescripcion_instalacion()) ?><br>
                        <?php print_r($instalacion->getPrecio_hora_instalacion()) ?>€/hora
                        <tr>
                            <th>Hora</th>
                            <th>Disponibilidad</th>
                            <th>Usuario Reserva</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                            for ($i = 9; $i <= 15; $i++) {
                                ?>

                                <?php if (isset($horas_reservadas[$i])) { ?>
                                    <tr style="background: lightcoral;">
                                    <?php } else { ?>
                                    <tr style="background: lightgreen;" onclick="reservar(<?php echo $i; ?>,<?php echo $instalacion->getId_instalacion(); ?>)">
                                    <?php } ?>
                                    <td><?php echo $i . ":00" ?> </td>
                                    <?php if (isset($horas_reservadas[$i])) { ?>
                                        <td>No Disponible</td>
                                        <?php if ($usuario->getEmail() == $horas_reservadas[$i]) { ?>
                                            <td id="reserva_propia"><?php echo $horas_reservadas[$i] ?></td>
                                        <?php } else { ?>
                                            <td>reservado por otra persona</td>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <td>Disponible</td>
                                        <td></td>
                                    <?php } ?>
                                </tr>


                            <?php } ?>
                        </tbody>

                    </table>




                    <!-- <div class="botones">
                         <input type="button" value="volver" onclick="location.href = 'index.php'">
                     </div>-->
                </div>
            <?php } ?>
        <?php } else { ?><!-- si no hay fecha-->
            <?php
            $instalacionDAO = new InstalacionDAO(ConexionBD::conectar());
            $instalaciones = $instalacionDAO->findallInstalaciones();
            // imprimir_datos($instalaciones);
            ?>
        <?php } ?>
    </body>



    <script>
        function setFecha() {
            let fecha = document.getElementById("fecha").value;
            window.location.href = "reservar.php?fecha=" + fecha.toLocaleString();
        }
<?php if (isset($_GET['fecha'])) { ?>
            function reservar(hora, instalacion) {
                window.location.href = "confirmacion.php?id_instalacion=" + instalacion + "&fecha=<?php echo $_GET['fecha']; ?>&hora=" + hora;
            }
<?php } ?>

<?php

function imprimir_datos($data) {
    echo sprintf('<pre>%s</pre>', print_r($data, true));
}
?>
    </script>

</html>
