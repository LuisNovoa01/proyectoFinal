<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControladorUsuario
 *
 * @author DAW2
 */
class UsersController {

    public function registrar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //Comprobamos el token
            if ($_POST['token'] != $_SESSION['token']) {
                header('Location: #');
                MensajesFlash::add_message("Token incorrecto");
                die();
            }

            $usuario = new Usuario();
            $error = false;
            if (empty($_POST['name'])) {
                MensajesFlash::add_message("El nombre es obligatorio.");
                $error = true;
            }

            if (empty($_POST['email'])) {
                MensajesFlash::add_message("El email es obligatorio.");
                $error = true;
            }

            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                MensajesFlash::add_message("El email no es correcto.");
                $error = true;
            }

 
          //Check the email is not registrer yet  
           $usuarioDAO = new UsuarioDAO(ConexionBD::conectar());
          $usuarioEmail = $usuarioDAO->findByEmail($_POST['email']);

          if ($usuarioEmail != null) {
              MensajesFlash::add_message("El email ya está registrado.");
              $error = true;
          }
            

            if (empty($_POST['password'])) {
                MensajesFlash::add_message("El password es obligatorio.");
                $error = true;
            }

            if (empty($_POST['password2'])) {
                MensajesFlash::add_message("No es escrito la comprobación de la contraseña");
                $error = true;
            }

            if ($_POST['password'] != $_POST['password2']) {
                MensajesFlash::add_message("Las contraseñas no coinciden");
                $error = true;
            }

            //Validación photo
            if ($_FILES['photo']['type'] != 'image/png' &&
                    $_FILES['photo']['type'] != 'image/gif' &&
                    $_FILES['photo']['type'] != 'image/jpeg') {
                MensajesFlash::add_message("El archivo seleccionado no es una foto.");
                $error = true;
            }

            if ($_FILES['photo']['size'] > 1000000) {
                MensajesFlash::add_message("El archivo seleccionado es demasiado grande. Debe tener un tamaño inferior a 1MB");
                $error = true;
            }

     /*       if(!($_POST['datesConsent'])){
                MensajesFlash::add_message("Es obligatorio marcar la casilla de las condiciones de uso para poder registrarse.");
                $tipoMensaje = "alert alert-error";
                $error = true;
            }
*/
            if (!$error) {
                //Copiar photo
                //Generamos un nombre para la photo
                $nombre_photo = md5(time() + rand(0, 999999));
                $extension_photo = substr($_FILES['photo']['name'], strrpos($_FILES['photo']['name'], '.') + 1);
                $extension_photo = filter_var($extension_photo, FILTER_SANITIZE_SPECIAL_CHARS);
                //Comprobamos que no exista ya una photo con el mismo nombre, si existe calculamos uno nuevo
                while (file_exists("images/users/$nombre_photo.$extension_photo")) {
                    $nombre_photo = md5(time() + rand(0, 999999));
                }
                //movemos la photo a la carpeta que queramos guardarla y con el nombre original
                move_uploaded_file($_FILES['photo']['tmp_name'], "images/users/$nombre_photo.$extension_photo");

                //Limpiamos los datos de entrada 
                $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                $name = filter_var($_POST['name'], FILTER_SANITIZE_SPECIAL_CHARS);
                $surname = filter_var($_POST['surname'], FILTER_SANITIZE_SPECIAL_CHARS);
                $dni = filter_var($_POST['dni'], FILTER_SANITIZE_SPECIAL_CHARS);
                $phone = filter_var($_POST['phone'], FILTER_SANITIZE_SPECIAL_CHARS);
                $postal_code = filter_var($_POST['postal_code'], FILTER_SANITIZE_SPECIAL_CHARS);
                //Insertamos el usuario en la BBDD
                $usuario->setEmail($email);
                $usuario->setNombre($name);
                $usuario->setSurname($surname);
                $usuario->setDni($dni);
                $usuario->setPhone($phone);
                $usuario->setPostalCode($postalCode);
                $usuario->setPassword(password_hash($_POST['password'], PASSWORD_DEFAULT));
                $usuario->setPhoto("$nombre_photo.$extension_photo");

                $usuDAO = new UsuarioDAO(ConexionBD::conectar());
                $usuDAO->insert($usuario);
                MensajesFlash::add_message("Usuario creado.");
                header('Location: inicio');
                die();
            }
        }

        //Calculamos un token
        $token = md5(time() + rand(0, 999));
        $_SESSION['token'] = $token;

        require '../app/views/users/userRegistrer.php';
    }

    public function subir_photo() {
        if (($_FILES['photo']['type'] != 'image/png' &&
                $_FILES['photo']['type'] != 'image/gif' &&
                $_FILES['photo']['type'] != 'image/jpeg')) {
            MensajesFlash::add_message('La imagen no tiene el formato adecuado');
            header('Location: inicio');
            die();
        }
        //Generamos un nombre para la photo
        $nombre_photo = md5(time() + rand(0, 999999));
        $extension_photo = substr($_FILES['photo']['name'], strrpos($_FILES['photo']['name'], '.') + 1);
        //Comprobamos que no exista ya una photo con el mismo nombre, si existe calculamos uno nuevo
        while (file_exists("imagenes/$nombre_photo.$extension_photo")) {
            $nombre_photo = md5(time() + rand(0, 999999));
        }
        //movemos la photo a la carpeta que queramos guardarla y con el nombre original
        move_uploaded_file($_FILES['photo']['tmp_name'], "imagenes/$nombre_photo.$extension_photo");
        //Actualizamos en la BD
        $conn = ConexionBD::conectar();
        $usuarioDAO = new UsuarioDAO($conn);
        $usuario = $usuarioDAO->find(Session::obtener()->getId());
        $usuario->setphoto("$nombre_photo.$extension_photo");
        $usuarioDAO->update($usuario);

        //Para que recarge en la sesión la nueva photo
        Session::iniciar($usuario);

        header("Location: " . RUTA);
    }

    public function login() {
        //Obtendo el usuario, si no existe vuelvo a index con un parámetro de error
        $usuDAO = new UsuarioDAO(ConexionBD::conectar());
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        if (!$usuario = $usuDAO->findByEmail($email)) {
            //Usuario no encontrado
            MensajesFlash::add_message("Usuario o password incorrectos.");
            header("Location: " . RUTA);
            die();
        }
        //Compruebo la contraseña, si no existe vuelvo a index con un parámetro de error
        if (!password_verify($_POST['password'], $usuario->getPassword())) {
            //password incorrecto
            MensajesFlash::add_message("Usuario o password incorrectos.");
            header("Location: " . RUTA);
            die();
        }
        //Usuario y password correctos, redirijo al listado de anuncios
        MensajesFlash::add_message("LOGIN CORRECTO");
        Session::iniciar($usuario);

        //Generamos un código aleatorio sha1 y lo guardamos en la BD
        $usuario->setCookie_id(sha1(time() + rand()));
        $usuDAO->update($usuario);
        //Creamos la cookie en el navegador del cliente con el mismo código generado
        setcookie('uid', $usuario->getCookie_id(), time() + 60 * 60 * 24 * 7);
        header("Location: " . RUTA);
        die();
    }

    public function usersList() {
        $conn = ConexionBD::conectar();
        $usuDAO = new UsuarioDAO(ConexionBD::conectar());
        $usersList = $usuDAO->findAll();

        require '../app/views/users/usersList.php';
    }

    public function findByUserId($userId) {
        $conn = ConexionBD::conectar();
        $usuDAO = new UsuarioDAO(ConexionBD::conectar());
        $user = $usuDAO->find($userId);
        echo $user;
        console.log($user);
    }

    public function findUserByIdJson($userId) {
        $conn = ConexionBD::conectar();
        $usuDAO = new UsuarioDAO(ConexionBD::conectar());
        $user = $usuDAO->find($userId);
        echo json_encode($user);
        return $user;
    }


    public function logout() {
        Session::cerrar();
        //Borramos la cookie diciendole al navegador que está caducada
        setcookie('uid', '', time() - 5);
        header("Location: " . RUTA);
    }

    public function deleteUser(){
        $conn = ConexionBD::conectar();
        $usuDAO = new UsuarioDAO(ConexionBD::conectar());
        $usuDAO->delete($_POST['id']);
        header("Location: " . RUTA);
    }

    public function index() {
        require '../app/views/users/index.php';
    }

}