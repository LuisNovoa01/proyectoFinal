<?php ob_start() ?>

<div class="d-flex align-items-center justify-content-center bg-br-primary ht-100v">
    <button type="button" >
        <section class="">
            <?php if (Session::existe()): ?>
            <div id="userInfo">
                <div id="photo_usuario"
                    style="background-image: url(<?= RUTA?>web/images/users/<?= Session::obtener()->getPhoto() ?>)">
                </div>
                <form id="formulario_actualizar_photo" action="subir_photo" method="post" enctype="multipart/form-data">
                    <input type="file" name="photo" id="input_photo">
                    <input type="submit">
                </form>
                <div id="userInfo"><?= Session::obtener()->getNombre() ?>
                    <?= Session::obtener()->getSurname() ?>
                    <br>
                    <a href="logout">cerrar sesión</a>
                </div>
            </div>
            <?php else: ?>
            <form id="login" action="login" method="post">
                <input type="text" placeholder="email" name="email">
                <input type="password" placeholder="password" name="password"><br>
                <input type="submit" value="login" class="boton_formulario">
                <input type="button" onclick="location.href = '<?= RUTA?>registrar'" value="registrar"
                    class="boton_formulario">
            </form>
        </section>
        <?php endif; ?>
    </button>

    <?php
$contenido = ob_get_clean();
$titulo = "Web Registro Trabajos Ayto. Argamasilla de Alba";
$titulo2 = "INICIO";
require '../app/views/template.php';
?>