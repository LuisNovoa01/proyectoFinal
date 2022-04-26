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
    <div class="col-md-6">
        <label for="inputName" class="form-label">Nombre</label>
        <input type="text" name="inputName" class="form-control" placeholder="Titulo del Item">
    </div>

    <div class="col-12">
        <label for="inputDescription" class="form-label">Descripcion</label>
        <textarea type="textarea" class="form-control" name="inputDescription" id="description" placeholder="Descripción..."></textarea>
    </div>
    <div class="col-12">
        <button type="submit" class="btn btn-primary">Agregar Departamento</button>
    </div>
</form>
<?php
$contenido = ob_get_clean();
$titulo = "Web Registro Trabajos Ayto. Argamasilla de Alba";
$titulo2 = "Insertar Departamentos";
require '../app/views/template.php';
?>