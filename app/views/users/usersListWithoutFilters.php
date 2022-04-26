<?php
ob_start();
?>
<?php MensajesFlash::imprimir_mensajes(); ?>

<table class="table" id="table">
    <thead>
        <tr>
            <th scope="col">Nombre</th>
            <th scope="col">Apellidos</th>
            <th scope="col">Email</th>
            <th scope="col">Rol</th>
            <th scope="col">Foto</th>
            <th scope="col">Options</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($usersList as $u): ?>
        <tr>
            <th id="userInfo"><?= $u->getNombre() ?></th>
            <th id="userInfo"><?= $u->getSurname() ?></th>
            <th id="userInfo"><?= $u->getEmail() ?></th>
            <th id="userInfo"><?= $u->getRol() ?></th>
            <th> <?php if ($u->getPhoto() != null): ?>
                <!-- we check the photo exists in the gallery -->

                <img id="photo_usuario" style="background-image: url(<?= RUTA?>web/images/users/<?= $u->getPhoto() ?>)"
                    class="img-thumbnail" alt="" width="100" height="100">
                <?php else: ?>
                <img style="background-image: url(<?= RUTA?>web/images/users/user_generico.png)" class="img-thumbnail"
                    alt="" width="100" height="100">
                <?php endif; ?>
            </th>
            <th>
                <!--buttons bootstrap to edit the user with call to modalEditUser windowsDialog Modal to edit user with id="id="modalEditUser" -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#editUserModal" onclick="findByUserId($u->getUserId())">Editar</button>
                <button type="button" class="btn btn-danger" data-toggle="modal"
                    data-target="#deleteUserModal">Eliminar</button>

            </th>
        </tr>

        <?php endforeach; ?>
        <!-- include modal windows to edit or delete user -->

</table>

<?php
 $contenido = ob_get_clean();
 $titulo = "Web Registro Trabajos Ayto. Argamasilla de Alba";
 $titulo2 = "Detalle de Articulos";
 require '../app/views/template.php';
 ?>

<!-- Modal to edit user -->
<div class="modal fade" id="editUserModal" tabindex="1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Editar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= RUTA?>editar_usuario/<?= $u->getId() ?>" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre"
                            value="<?= $u->getNombre() ?>">
                    </div>
                    <div class="form-group">
                        <label for="apellidos">Apellidos</label>
                        <input type="text" class="form-control" id="apellidos" name="apellidos"
                            value="<?= $u->getSurname() ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= $u->getEmail() ?>">
                    </div>
                    <div class="form-group">
                        <label for="rol">Rol</label>
                        <select class="form-control" id="rol" name="rol">

                            <option value="admin">Administrador</option>
                            <option value="user">Usuario</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="photo">Foto</label>
                        <input type="file" class="form-control" id="photo" name="photo">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Editar Usuario</button>
            </div>
        </div>
    </div>
</div>