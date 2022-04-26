
<!DOCTYPE html>
<html>
    <title>Gestion Reservas</title>
    <script src="https://use.fontawesome.com/2a534a9a61.js"></script>
    <link rel="stylesheet" type="text/css" href="utilidades/styleGestionReservas.css">
    <header>
        <meta charset="UTF-8">
        <?php if (Session::existe()): ?>
            <?php
            $conn = ConexionBD::conectar();
            $usuDAO = new UsuarioDAO($conn);
            $usuario = $usuDAO->find(Session::obtener());
            ?>
            <div id="usuario"> 
                <div id="foto_usuario" style="background-image: url(imagenes/fotosUsuarios/<?= $usuario->getFoto() ?>)"></div>
                <!--<form id="formulario_actualizar_foto" action="subir_foto.php" method="post" enctype="multipart/form-data">
                <input type="file" name="foto" id="input_foto">
                <input type="submit">-->
                </form>
                <div id="datos_usuario"><?= $usuario->getNombre() ?> <br>
                    <?= $usuario->getEmail() ?> <br>
                    <a href="logout.php">cerrar sesión</a>
                </div>
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
            <h1><?php echo $titulo ?></h1>
            <h3><?php echo $titulo2 ?></h3>
        </div>            
    </header>
    <div class="menu">
        <menus>
            <ul id="menu_usuario">
                <li><a href="index.php">Inicio</a></li>
                <li><a href="reservar.php">Hacer una reserva</a></li>
                <li><a href="mis_reservas.php">Mis Reservas</a></li>


                <!-- QUIERO QUE LAS INSTALACIONES SOLO LAS VEAN LOS ADMIN -->
                <?php if (Session::existe()) { ?>
                    <?php
                    $usuDAO = new UsuarioDAO($conn);
                    $usuario = $usuDAO->find(Session::obtener());
                    ?>
                    <?php if ($usuario->getPrivilegios() == 'admin') { ?>
                        <li><a href="gestionReservas.php">Gestion de todas las Reservas</a></li>
                        <li><a href="instalaciones.php">Instalaciones</a></li>
                    <?php } ?>
                <?php } ?>
            </ul>
        </menus>
    </div>
    <div class="MensajesFlash"><?php mensajesFlash::imprimir_mensajes() ?></div>
