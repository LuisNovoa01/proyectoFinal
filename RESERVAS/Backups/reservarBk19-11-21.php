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
    MensajesFlash::anadir_mensaje("No puedes a�adir mensajes si no inicias sesi�n");
    die();
}
$error = false;

if (isset($_GET['fecha'])) {
    $reservaDAO = new ReservaDAO(ConexionBD::conectar());
    $reservas = $reservaDAO->findallReservasByFecha($_GET['fecha']);
    //print_r($reservas);

    $horas_reservadas = Array();
    $usuDAO = new UsuarioDAO(ConexionBD::conectar());
    foreach ($reservas as $reserva) {
        $hora = intval($reserva->getHora_inicio()); //intval para pasar String a int en PHP
        //echo $hora;
        $horas_reservadas[$hora] = $usuDAO->find($reserva->getId_usuario())->getEmail();
    }
}
?>
<!DOCTYPE html>
<html>

    <link rel="stylesheet" type="text/css" href="utilidades/styleGestionReservas.css">

</style>
<header>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
    <?php if (Session::existe()): ?>
        <?php
        $conn = ConexionBD::conectar();
        $usuDAO = new UsuarioDAO($conn);
        $usuario = $usuDAO->find(Session::obtener());
        ?>
        <div id="usuario"> 
            <div id="foto_usuario" style="background-image: url(imagenes/<?= $usuario->getFoto() ?>)"></div>
            <!--<form id="formulario_actualizar_foto" action="subir_foto.php" method="post" enctype="multipart/form-data">
            <input type="file" name="foto" id="input_foto">
            <input type="submit">
            </form>-->
            <div id="datos_usuario"><?= $usuario->getNombre() ?> <br>
                <?= $usuario->getEmail() ?> <br>
                <a href="logout.php">cerrar sesi�n</a></div>
        </div>
    <?php else: ?>
        <form id="login" action="login.php" method="post">
            <input type="text" placeholder="email" name="email">
            <input type="password" placeholder="password" name="password"><br>
            <input type="submit" value="login" class="boton_formulario">
            <input type="button" onclick="location.href = 'registrar.php'" value="registrar" class="boton_formulario">
        </form>
    <?php endif; ?>
    <div id="titulo">
        <h1>P�gina para hacer una Reserva Nueva</h1>
    </div>            
</header>
<menu>
    <ul id="menu_usuario">
        <li><a href="index.php">Inicio</a></li>
        <li><a href="reservar.php">Hacer una reserva</a></li>
        <li><a href="mis_reservas.php">Mis Reservas</a></li>

        <!-- QUIERO QUE LAS PISTAS SOLO LAS VEAN LOS ADMIN -->
        <?php if (Session::existe()) { ?>
            <?php
            $usuDAO = new UsuarioDAO($conn);
            $usuario = $usuDAO->find(Session::obtener());
            ?>
            <?php if ($usuario->getPrivilegios() == 'admin') { ?>
                <li><a href="instalaciones.php">Instalaciones</a></li>
            <?php } ?>
        <?php } ?>
    </ul>
</menu>

<body>
    <?php mensajesFlash::imprimir_mensajes() ?>

    <h2>Introduce tus datos de Reserva</h2>
    <p>Selecciona en la siguiente casilla la fecha que quieres reservar:</p>
    <input type="date" name="fecha_reserva" min="<?php echo date('Y-m-d') ?>"
    <?php
    if (isset($_GET['fecha'])) {
        echo 'value="' . $_GET['fecha'] . '"';
    }
    ?> id="fecha" onchange="setFecha()">


<?php if (isset($_GET['fecha'])) { ?>
        <table>
            <thead>
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
                        <tr style="background: lightgreen;" onclick="reservar(<?php echo $i; ?>)">
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
        <?php } ?>
                    </tr>


    <?php } ?>
            </tbody>

        </table>


        <div class="botones">
            <input type="button" value="volver" onclick="location.href = 'index.php'">
        </div>
<?php } ?>
</form>
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
</script>
</body>
</html>
