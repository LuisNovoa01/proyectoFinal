<?php
ob_start();
?>
<?php MensajesFlash::imprimir_mensajes(); ?>

    <div class="col-sm-12">
<div class="table-responsive" id="mydatatable-container">
        <table class="records_list table table-striped table-bordered table-hover" id="mydatatable">
            <thead>
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Descripcion</th>
                    <th scope="col">Departamento</th>
                    <th scope="col">Servicio</th>
                    <th scope="col">Atendido por:</th>
                    <th scope="col">Cliente</th>
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
                </tr>
            </tfoot>
            <tbody>
                <?php foreach ($items as $i): ?>
                <tr>
                <td id="userInfo"><?= $i->getName() ?></td>
                    <td id="userInfo"><?= $i->getDescription() ?></td>
                    <td id="userInfo"><?= $i->getId_department() ?></td>
                    <td id="userInfo"><?= $i->getId_service() ?></td>
                    <td id="userInfo"><?= $i->getId_attendUser() ?></td>
                    <td id="userInfo"><?= $i->getId_clientUser() ?></td>
                    <td id="userInfo"><?= $i->getState() ?></td>
                    <td id="dateInfo"><?= $i->getDate() ?></td>
                    <td id="hourInfo"><?= $i->getHour() ?></td>
                    <th>
                        <!--buttons bootstrap to edit the user with call to modalEditUser windowsDialog Modal to edit user with id="id="modalEditUser" -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editItemModal"
                        data-id="<?= $i->getId()?>" id="boton_editar">Editar <?= $i->getId() ?></button>
                        <button type="button" class="btn btn-danger" data-toggle="modal"
                            data-target="#deleteUserModal" data-id="<?= $i->getId()?>">Eliminar <?= $i->getId() ?></button>
                    </th>
                </tr>
                <?php endforeach; ?>
                <!-- include modal windows to edit or delete user -->
            </tbody>
        </table>
    </div>

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
                        <label for="name">ID</label>
                        <input type="text" class="form-control" id="id" name="id" placeholder="Id"
                            value="" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nombre"
                            value="" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Descripción</label>
                        <input type="text" class="form-control" id="description" name="description"
                            placeholder="Descripción" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="location">Ubicación</label>
                        <input type="text" class="form-control" id="location" name="location" placeholder="Ubicación"
                            value="" required>
                    </div>
                    <div class="form-group">
                        <label for="id_department">Departamento</label>
                        <select class="form-control" id="id_department" name="id_department" required>
                            <option value="" selected="">Seleccione un departamento</option>
                            <?php foreach ($departments as $d): ?>
                            <option value="<?= $d->getId() ?>"
                                <?= $d->getId_department() == $d->getId() ?>>
                                <?= $d->getName() ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="id_service">Servicio</label>
                        <select class="form-control" id="id_service" name="id_service" required>
                            <option value="">Seleccione un servicio</option>
                            <?php foreach ($services as $s): ?>
                            <option value="<?= $s->getId() ?>"
                                <?= $i->getId_service() == $s->getId() ? 'selected' : '' ?>>
                                <?= $s->getName() ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
            </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Editar Item</button>
            </div>
        </div>
    </div>
</div>




<script type="text/javascript">
    $(document).on('click','#boton_editar',function(){
        
        let id = $(this).attr('data-id');

        //Enviamos la informacion por ajax 
        $.ajax({
            url: 'pb',
            type: 'POST',
            data: {id},
            //Recuperamos la información 
            success: function(e) {
                let traer = JSON.parse(e);
                
                //Imprimimos la información en la ventana modal 
                traer.forEach((valor)=>{
                    $("#id").val(valor.id);
                    $("#name").val(valor.name);
                    $("#description").val(valor.description);
                    $("#location").val(valor.location);
                    //$("#id_department").val(valor.id_department);
                });

            }
        });
    });
  
</script>   
