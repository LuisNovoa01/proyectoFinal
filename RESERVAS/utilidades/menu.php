<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>


    <!--Title -->
    <title>Gestion Trabajos Ayuntamiento Argamasilla de Alba</title>
</head>


<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Menu</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="reservar.php">Hacer una reserva</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="mis_reservas.php">Mis reservas</a>
                </li>

                <!-- QUIERO QUE LAS INSTALACIONES SOLO LAS VEAN LOS ADMIN -->
                <?php if (Session::existe()) { ?>
                <?php
                $conn = ConexionBD::conectar();
                    $usuDAO = new UsuarioDAO($conn);
                    $usuario = $usuDAO->find(Session::obtener());
                    ?>
                <?php if ($usuario->getPrivilegios() == 'admin') { ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Administradores
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="gestionReservas.php">Gestion Reservas</a></li>
                        <li><a class="dropdown-item" href="instalaciones.php">Instalaciones</a></li>
                        <li>
                            <hr class="dropdown-divider" hidden>
                        </li>
                        <li><a class="dropdown-item" href="#" hidden>Something else here</a></li>
                    </ul>
                </li>
                <?php } ?>
                <?php } ?>
            </ul>
            <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" hidden>
                <button class="btn btn-outline-success" type="submit" hidden>Search</button>
            </form>
            <?php if (Session::existe()): ?>
            <?php
            $conn = ConexionBD::conectar();
            $usuDAO = new UsuarioDAO($conn);
            $usuario = $usuDAO->find(Session::obtener());
            ?>
            <div id="usuario">
                <img width="120" height="120" id="foto_usuario"
                    style="background-image: url(imagenes/fotosUsuarios/<?= $usuario->getFoto() ?>); background-size:cover; background-position:center"></img>
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
                <input type="button" onclick="location.href = 'registrar.php'" value="registrar"
                    class="boton_formulario">
            </form>
            <?php endif; ?>
        </div>
    </div>
</nav>

<header>
    <div id="titulo">
        <h1><?php echo $titulo ?></h1>
        <h3><?php echo $titulo2 ?></h3>
    </div>
</header>
<div class="MensajesFlash"><?php mensajesFlash::imprimir_mensajes() ?></div>