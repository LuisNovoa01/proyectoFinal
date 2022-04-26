<?php ob_start() ?>

<div class="d-flex align-items-center justify-content-center bg-br-primary ht-100v">
    <div class="col-sm-8 col-11">

        <form action="" method="post" enctype="multipart/form-data"
            style="justify-content: center; align-items: center">
            <fieldset class=" border border-primary" style="border-radius: 35px; background-color:#CCCCCC">
                <div style="paddin:20px; margin:20px">
                    <legend class="text-center">Formulario de Registro de Usuarios Nuevos</legend>

                    <input type="hidden" name="token" value="<?= $token ?>">
                    <div class="mb-3" style="justify-content: center; align-items: center">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="name" placeholder="Introduce aqui tu nombre" class="form-control"
                            aria-describedby="nameHelp">
                    </div>
                    <div class="mb-3" style="justify-content: center; align-items: center">
                        <label class="form-label">Apellidos</label>
                        <input type="text" name="surname" placeholder="Introduce aqui tus apellidos"
                            class="form-control" aria-describedby="surnameHelp">
                    </div>
                    <div class="mb-3" style="justify-content: center; align-items: center">
                        <label class="form-label">DNI</label>
                        <input type="dni" name="dni" placeholder="Introduce aqui el DNI o NIF" class="form-control"
                            aria-describedby="dniHelp">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email/Direccion de correo electrónico</label>
                        <input type="email" name="email" placeholder="Introduce aqui tu em@il" class="form-control"
                            aria-describedby="emailHelp">
                        <div id="emailHelp" class="form-text">Nunca compartas tu email con nadie</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Teléfono</label>
                        <input type="number" name="phone" placeholder="Introduce aqui tu numero de telefono"
                            class="form-control" max=999999999>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Código Postal</label>
                        <!--        <input type="number" name="postalCode" placeholder="Introduce los 5 dígitos de tu Código Postal" class="form-control" max=99999> -->
                        <input type="select" name="postalCode" placeholder="Introduce los 5 dígitos de tu Código Postal"
                            class="form-control" max=99999>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control"
                            placeholder="Introduce aqui tu password">
                        <div id="passwordHelp" class="form-text">Pon una Contraseña Segura: Con al menos 8 caracteres,
                            Mayusculas y minusculas</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Vuelve a escribir la Password para comprobación</label>
                        <input type="password" name="password2" id="password2" class="form-control"
                            placeholder="Introduce aqui tu password">
                        <div id="passwordHelp" class="form-text">Escribe la misma contraseña que en la casilla anterior
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Foto del Usuario</label>
                        <input type="file" name="photo" class="form-control" accept="image/*"
                            aria-describedby="photoHelp">
                        <div id="photoHelp" class="form-text">Añade aqui tu foto</div>
                    </div>
                    <?php if (Session::existe()) { ?>
                        <?php
                            $conn = ConexionBD::conectar();
                            $usuDAO = new UsuarioDAO($conn);
                            $usuario = $usuDAO->findUserById(Session::obtener()->getId());
                        ?>
                        <?php if ($usuario->getRol() == 'admin') { ?>
                            <div class="mb-3">
                                <label class="form-label">Rol</label>
                                <select name="rol" class="form-control">
                                    <option value="user">Usuario</option>
                                    <?php if ($usuario->getRol() =='superAdmin') { ?>
                                    <option value="admin">Administrador</option>
                                    <option value="superAdmin">Super Administrador</option>
                                </select>
                            </div>
                        </li>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="datesConsent" name="datesConsent"
                            checked>
                        <label class="form-check-label" for="flexCheckChecked">Doy mi Consentimiento según Ley de
                            Protección de Datos
                        </label>
                    </div>
                    <div style="justify-content:center; align-items:center">
                        <button type="submit" value="registrar" class="btn btn-primary w-75">Registrar Usuario</button>
                    </div>
                </div>
        </form>
    </div>
</div>

<?php
$contenido = ob_get_clean();
$titulo = "Web Registro Trabajos Ayto. Argamasilla de Alba";
$titulo2 = "Registrar Usuario Nuevo";
require '../app/views/template.php';
?>
<script>
window.onload = function() {
    var myInput = document.getElementById('password2');
    myInput.onpaste = function(e) {
        e.preventDefault();
        alert("no se puede pegar en esta casilla");
    }

    myInput.oncopy = function(e) {
        e.preventDefault();
        alert("no se puede copiar de esta casilla");
    }
}
</script>

<!-- script to control when the user change the cell email, check the email is correct or not -->
<script>
$(document).ready(function() {
    $("#email").change(function() {
        var email = $("#email").val();
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (regex.test(email)) {
            $("#emailHelp").html("");
        } else {
            $("#emailHelp").html("El email no es correcto");
        }
    });
});



    </script>