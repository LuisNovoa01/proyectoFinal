<?php ob_start() ?>
        <link href="<?= RUTA?>web/js/jQuery-TE_v.1.4.0/jquery-te-1.4.0.css" rel="stylesheet" type="text/css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="<?= RUTA?>web/js/jQuery-TE_v.1.4.0/jquery-te-1.4.0.min.js"></script>
         

        <script type="text/javascript">
            $(function () {
                $("#descripcion").jqte();
            });
        </script>

        <form action="" method="post" enctype="multipart/form-data">
            <input type="text" name="titulo" placeholder="Titulo..."><br>
            <textarea name="descripcion" id="descripcion" placeholder="Descripción..."></textarea>
            <input type="number" name="precio" placeholder="Precio..."><br>
            <input type="file" name="photo[]" multiple="multiple" ><br><br>
            <input type="submit" value="Poner a la venta">
        </form>

<?php
$contenido = ob_get_clean();
$titulo = "Web Registro Trabajos Ayto. Argamasilla de Alba";
$titulo2 = "Insertar Articulos";
require '../app/views/template.php';
?>
