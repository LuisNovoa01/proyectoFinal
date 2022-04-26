<?php
ob_start();
?>
<?php MensajesFlash::imprimir_mensajes(); ?>

<div class="table-responsive" id="mydatatable-container">
    <table class="records_list table table-striped table-bordered table-hover" id="mydatatable">
        <thead>
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Descripcion</th>
                <th scope="col">Localización</th>
                <th scope="col">Departamento</th>
                <th scope="col">Servicio</th>
                <th scope="col">Atendido por:</th>
                <th scope="col">Cliente</th>
                <th scope="col">Foto</th>
                <th scope="col">Estado</th>
                <th scope="col">Fecha</th>
                <th scope="col">Hora</th>
                <th scope="col">Options</th>
            </tr>
        </thead>
        <tfoot style="display: table-header-group !important">
            <tr>
                <th>Filter..</th>
                <th>Filter..</th>
                <th>Filter..</th>
                <th>Filter..</th>
                <th>Filter..</th>
                <th>Filter..</th>
                <th>Filter..</th>
                <th>Filter..</th>
                <th>Filter..</th>
                <th>Filter..</th>
                <th>Filter..</th>
                <th>Filter..</th>
            </tr>
        </tfoot>
        <tbody>
            <?php foreach ($items as $i): ?>
            <tr>
                <th id="userInfo"><?= $i->getName() ?></th>
                <th id="userInfo"><?= $i->getDescription() ?></th>
                <th id="userInfo"><?= $i->getLocation() ?></th>
                <th id="userInfo"><?= $i->getId_department() ?></th>
                <th id="userInfo"><?= $i->getId_service() ?></th>
                <th id="userInfo"><?= $i->getId_attendUser() ?></th>
                <th id="userInfo"><?= $i->getId_clientUser() ?></th>
                <th> <?php if ($i->getPhotosItem() != null): ?>
                    <!-- we check the photo exists in the gallery -->
                    <?php if(count($i->getPhotosItem())>=1): ?>
                    <div class="photos_articulo" style="background-image:url('<?= RUTA?>web/images/items/<?= $i->getPhotosItem()[0]->getFile_name() ?>');
                        background-size: contain;
                        background-position: center;
                        background-repeat: no-repeat;
                        height:100px;">
                    </div>
                    <?php else: ?>
                    <div class="photos_articulo"
                        style="background-image:url('<?= RUTA?>web/images/items/item_generico.jpg')"></div>
                    <?php endif; ?>
                    <?php endif; ?>
                </th>
                <th id="userInfo"><?= $i->getState() ?></th>
                <th id="dateInfo"><?= $i->getDate() ?></th>
                <th id="hourInfo"><?= $i->getHour() ?></th>
                <th>
                    <!--buttons bootstrap to edit the user with call to modalEditUser windowsDialog Modal to edit user with id="id="modalEditUser" -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editItemModal"
                        onclick="findByUserId($i->getUserId())">Editar <?= $i->getId() ?></button>
                    <button type="button" class="btn btn-danger" data-toggle="modal"
                        data-target="#deleteUserModal">Eliminar <?= $i->getId() ?></button>
                </th>
            </tr>
            <?php endforeach; ?>
            <!-- include modal windows to edit or delete user -->
        </tbody>
    </table>
</div>

<?php
 $contenido = ob_get_clean();
 $titulo = "Web Registro Trabajos Ayto. Argamasilla de Alba";
 $titulo2 = "Detalle de Items";

                        
    
 require '../app/views/template.php';
 ?>

<script type="text/javascript">
$(document).ready(function() {
    $('#mydatatable tfoot th').each(function() {
        var title = $(this).text();
        $(this).html('<input type="text" placeholder="Filtrar.." />');
    });

    var table = $('#mydatatable').DataTable({
        "dom": 'B<"float-left"i><"float-right"f>t<"float-left"l><"float-right"p><"clearfix">',
        "responsive": false,
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
        "order": [
            [0, "desc"]
        ],
        "initComplete": function() {
            this.api().columns().every(function() {
                var that = this;

                $('input', this.footer()).on('keyup change', function() {
                    if (that.search() !== this.value) {
                        that
                            .search(this.value)
                            .draw();
                    }
                });
            })
        }
    });
});

var buttonCommon = {
        exportOptions: {
            format: {
                body: function ( data, row, column, node ) {
                    // Strip $ from salary column to make it numeric
                    return column === 5 ?
                        data.replace( /[$,]/g, '' ) :
                        data;
                }
            }
        }
    };
 
    $('#example').DataTable( {
        ajax: '../../../../examples/ajax/data/objects.txt',
        columns: [
            { data: 'name' },
            { data: 'position' },
            { data: 'office' },
            { data: 'extn' },
            { data: 'start_date' },
            { data: 'salary' }
        ],
        dom: 'Bfrtip',
        buttons: [
            $.extend( true, {}, buttonCommon, {
                extend: 'copyHtml5'
            } ),
            $.extend( true, {}, buttonCommon, {
                extend: 'excelHtml5'
            } ),
            $.extend( true, {}, buttonCommon, {
                extend: 'pdfHtml5'
            } )
        ]
    } );
</script>



<!-- Modal to edit Item -->
<div class="modal fade" id="editItemModal" tabindex="1" aria-labelledby="editItemModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editItemModalLabel">Editar Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editItemForm" method="POST" action="<?= RUTA ?>items/editItem" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nombre"
                            value="<?= $i->getName() ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Descripción</label>
                        <input type="text" class="form-control" id="description" name="description"
                            placeholder="Descripción" value="<?= $i->getDescription() ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="location">Ubicación</label>
                        <input type="text" class="form-control" id="location" name="location" placeholder="Ubicación"
                            value="<?= $i->getLocation() ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="id_department">Departamento</label>
                        <select class="form-control" id="id_department" name="id_department" required>
                            <option value="">Seleccione un departamento</option>
                            <?php foreach ($departments as $d): ?>
                            <option value="<?= $d->getId() ?>" <?= $i->getId_department() == $d->getId() ? 'selected' : '' ?>>
                                <?= $d->getName() ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="id_service">Servicio</label>
                        <select class="form-control" id="id_service" name="id_service" required>
                            <option value="">Seleccione un servicio</option>
                            <?php foreach ($services as $s): ?>
                            <option value="<?= $s->getId() ?>" <?= $i->getId_service() == $s->getId() ? 'selected' : '' ?>>
                                <?= $s->getName() ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Editar Usuario</button>
            </div>
        </div>
    </div>
</div>
