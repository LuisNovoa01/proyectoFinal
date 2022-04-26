   <!-- Modal to edit user -->
   <div class="modal fade" id="editChildren<?php echo $id; ?>" tabindex="-1" role="dialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editUserModalLabel">Editar Usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="<?= RUTA?>update_user/<?= $u->getId() ?>" method="POST"
                            enctype="multipart/form-data">
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
                                <input type="email" class="form-control" id="email" name="email"
                                    value="<?= $u->getEmail() ?>">
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