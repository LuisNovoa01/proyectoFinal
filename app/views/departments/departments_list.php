<?php
ob_start();
?>
<?php MensajesFlash::imprimir_mensajes(); ?>
<div class="table-responsive" id="mydatatable-container">
    <table class="records_list table table-striped table-bordered table-hover" id="mydatatable">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Descripcion</th>
                <th scope="col">Opciones</th>
            </tr>
        </thead>
        <tfoot style="display: table-header-group !important">
            <tr>
                <th>Filter..</th>
                <th>Filter..</th>
                <th>Filter..</th>
                <th>Filter..</th>
            </tr>
        </tfoot>
        <tbody>
            <?php foreach ($departments as $d): ?>
            <tr>
            <th id="departmentInfo"><?= $d->getIdDepartment() ?></th>
                <th id="departmentInfo"><?= $d->getName() ?></th>
                <th id="departmentInfo"><?= $d->getDescription() ?></th>
                <th>
                       <!-- buttons bootstrap to edit the Department with call to modalEditDepartment windowsDialog Modal to edit Department with id="id="modalEditDepartment" -->                                                      
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editDepartmentModal"
                        >Editar </button>
                    <button type="button" class="btn btn-danger" data-toggle="modal"
                        data-target="#deleteDepartmentModal">Eliminar</button>
                </th>
            </tr>
            <?php endforeach; ?>
            <!-- include modal windows to edit or delete Department -->
        </tbody>
    </table>
</div>

<?php
 $contenido = ob_get_clean();
 $titulo = "Web Registro Trabajos Ayto. Argamasilla de Alba";
 $titulo2 = "Detalle de Departamentos";
 ?>
 <button type="button" class="btn btn-primary" data-bs> <a class="dropdown-item" href="<?=RUTA?>insert_department">Insertar Departamentos</a></button>
 
 <?php require '../app/views/template.php';
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



<!-- Modal to edit Department -->
<div class="modal fade" id="editDepartmentModal" tabindex="1" aria-labelledby="editDepartmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDepartmentModalLabel">Editar Departamento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= RUTA?>update_Department/<?= $d->getIdDepartment() ?>" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre"
                            value="<?= $d->getNombre() ?>">
                    </div>
                    <div class="form-group">
                        <label for="apellidos">Descripcion</label>
                        <input type="text" class="form-control" id="apellidos" name="apellidos"
                            value="<?= $d->getSurname() ?>">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Editar Departamento</button>
            </div>
        </div>
    </div>
</div>
