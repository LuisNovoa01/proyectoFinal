<?php ob_start() ?>
<link href="<?= RUTA?>web/js/jQuery-TE_v.1.4.0/jquery-te-1.4.0.css" rel="stylesheet" type="text/css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="<?= RUTA?>web/js/jQuery-TE_v.1.4.0/jquery-te-1.4.0.min.js"></script>


<script type="text/javascript">
$(function() {
    $("#descripcion").jqte();
});
</script>
<form class="row g-3 col-md-11" action="" method="post" enctype="multipart/form-data">
    <div class="col-md-3 col-6">
        <label for="inputUser" class="form-label">Usuario</label>
        <input type="text" class="form-control" id="inputUser"  readonly>
    </div>
    <div class="col-md-3 col-6">
        <label for="inputState" class="form-label">Estado</label>
        <select id="inputState" name="inputState" class="form-select">
            <option selected>Registrada</option>
            <option>Iniciada</option>
            <option>En Proceso</option>
            <option>Finalizada</option>
        </select>
    </div>
    <div class="col-md-2 col-3">
        <label for="inputDate" class="form-label">Fecha</label>
        <input type="text" class="form-control" name="inputDate" value="<?php echo date("Y-m-d");?>">
    </div>
    <div class="col-md-2 col-3">
        <label for="inputHour" class="form-label">Hora</label>
        <input type="text" class="form-control" name="inputHour" value="<?php echo date("H:i");?>">
    </div>
    <div class="col-md-2 col-3">
        <label for="inputDuration" class="form-label">Duracion</label>
        <input type="text" class="form-control" name="inputDuration">
    </div>
    <div class="col-md-6">
        <label for="inputName" class="form-label">Titulo</label>
        <input type="text" name="inputName" class="form-control" placeholder="Titulo del Item">
    </div>

    <div class="col-md-6">
        <label for="inputDescription" class="form-label">Descripcion</label>
        <textarea type="textarea" class="form-control" name="inputDescription" id="description"
            placeholder="Descripción..."></textarea>
    </div>
    <div class="col-12" hidden>
        <label for="inputLocation" class="form-label">Localización</label>
        <input type="text" class="form-control" name="inputLocation" placeholder="Ubicación">
    </div>
    <div class="col-6">
        <label for="inputDepartment" class="form-label">Departamento</label>
        <select class="form-control" id="inputDepartment" name="inputDepartment" required>
                            <option value="">Seleccione un departamento</option>
                            <?php foreach ($departments as $d): ?>
                            <option value="<?= $d->getId() ?>"
                                <?= $d->getId_department() == $d->getId() ?>>
                                <?= $d->getName() ?></option>
                            <?php endforeach; ?>
                        </select>
    </div>
    <div class="col-6">
        <label for="inputService" class="form-label">Servicio</label>
        <input type="text" class="form-control" name="inputService" placeholder="Selecciona el servicio">
    </div>
    <div class="col-6">
        <label for="inputAttendUser" class="form-label">Atendido por:</label>
        <input type="number" class="form-control" name="inputAttendUser" value="<?php Session::obtener()->getId() ?>">
    </div>
    <div class="col-6">
        <label for="inputClientUser" class="form-label">Cliente:</label>
        <input type="number" class="form-control" name="inputClientUser" placeholder="Selecciona el cliente">
    </div>
    <div class="col-12">
        <label for="inputPhotoItem" class="form-label">Sube una foto del Item</label>
        <input type="file" class="form-control" name="inputPhotoItem[]" id="photoItem" multiple="multiple">
    </div>


    <div class="col-12">
        <button type="submit" class="btn btn-primary">Agregar Item</button>
    </div>
</form>
<?php
$contenido = ob_get_clean();
$titulo = "Web Registro Trabajos Ayto. Argamasilla de Alba";
$titulo2 = "Insertar Items";
require '../app/views/template.php';
?>