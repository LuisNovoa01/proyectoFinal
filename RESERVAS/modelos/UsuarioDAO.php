<?php

/**
 * Description of UsuarioDAO
 *
 * @author DAW2
 */
class UsuarioDAO {

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    /**
     * //TODO Método que inserta un usuario en la BD
     * @param Usuario $usuario
     * @return boolean
     */
    public function insert($usuario) {
        //Comprobamos que el parámetro sea de la clase Usuario
        if (!$usuario instanceof Usuario) {
            return false;
        }
        $nombre = filter_var($usuario->getNombre(), FILTER_SANITIZE_SPECIAL_CHARS);
        $apellidos = filter_var($usuario->getApellidos(), FILTER_SANITIZE_SPECIAL_CHARS);
        $telefono = filter_var($usuario->getTelefono(), FILTER_SANITIZE_NUMBER_INT);
        $email = filter_var($usuario->getEmail(), FILTER_SANITIZE_EMAIL);
        $password = $usuario->getPassword();
        $foto = $usuario->getFoto();
        $cookie_id = sha1(time() + rand()); //con sha1 genero un has a partir de la hora y un numero aleatorio
        /*    //Validación foto
          if ($_FILES['foto']['type'] != 'image/png' &&
          $_FILES['foto']['type'] != 'image/gif' &&
          $_FILES['foto']['type'] != 'image/jpeg') {
          MensajesFlash::anadir_mensaje("El archivo seleccionado no es una foto.");
          $error = true;
          }
          if ($_FILES['foto']['size'] > 1000000) {
          MensajesFlash::anadir_mensaje("El archivo seleccionado es demasiado grande. Debe tener un tamaño inferior a 1MB");
          $error = true;
          }

          if (!$error) {
          //Copiar foto
          //Generamos un nombre para la foto
          $nombre_foto = md5(time() + rand(0, 999999));
          $extension_foto = substr($_FILES['foto']['name'], strrpos($_FILES['foto']['name'], '.') + 1);
          $extension_foto = filter_var($extension_foto, FILTER_SANITIZE_SPECIAL_CHARS);
          //Comprobamos que no exista ya una foto con el mismo nombre, si existe calculamos uno nuevo
          while (file_exists("imagenes/fotosUsuarios/$nombre_foto.$extension_foto")) {
          $nombre_foto = md5(time() + rand(0, 999999));
          }
          //movemos la foto a la carpeta que queramos guardarla y con el nombre original
          move_uploaded_file($_FILES['foto']['tmp_name'], "imagenes/fotosUsuarios/$nombre_foto.$extension_foto");
         */

        /* $sql = "INSERT INTO usuarios (nombre, apellidos, telefono, email, password, foto, cookie_id) VALUES "
          . "('$nombre','$apellidos','$telefono','$email','$password','$foto','$cookie_id')"; */
        /* la de arriba es la consulta antigua, la de abajo es la nueva */
        $sql = "INSERT INTO usuarios (nombre, apellidos, telefono, email, password, foto, cookie_id) VALUES "
                . "(?,?,?,?,?,?,?)";
        if (!$stmt = $this->conn->prepare($sql)) {
            die("Error al preparar la consulta SQL: " . $this->conn->error);
        }

        $stmt->bind_param('ssissss', $nombre, $apellidos, $telefono, $email, $password, $foto, $cookie_id);
        $stmt->execute();
        $result = $stmt->get_result();

        //Guardo el id que le ha asignado la base de datos en la propiedad id del objeto
        $usuario->setId($this->conn->insert_id);
        return true;
        if (!$result = $this->conn->query($sql)) {
            die("Error en la SQL: " . $this->conn->error);
        }
    }

    /* } */

    public function update($usuarios) {
        //Comprobamos que el parámetro no es nulo y es de la clase Usuario
        if (!$usuarios instanceof Usuario) {
            return false;
        }
        $nombre = $usuarios->getNombre();
        $email = $usuarios->getEmail();
        $password = $usuarios->getPassword();
        $foto = $usuarios->getFoto();
        $cookie_id = $usuarios->getCookie_id();
        $sql = "UPDATE usuarios SET"
                . " nombre='$nombre', email='$email',password='$password', foto='$foto', cookie_id='$cookie_id' "
                . "WHERE id = " . $usuarios->getId();
        if (!$result = $this->conn->query($sql)) {
            die("Error en la SQL: " . $this->conn->error);
        }
        if ($this->conn->affected_rows == 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Borra un registro de la tabla
     * @param type $usuarios //Objeto de la clase Usuario
     * @return type
     */
    public function delete($usuarios) {
        if ($usuarios == null || get_class($usuarios) != 'Usuario') {
            return false;
        }
        $sql = "DELETE FROM usuarios WHERE id = " . $usuarios->getId();
        if (!$result = $this->conn->query($sql)) {
            die("Error en la SQL: " . $this->conn->error);
        }
        if ($this->conn->affected_rows == 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Devuelve el usuario de la BD 
     * @param type $id id del usuario
     * @return \Usuario Usuario de la BD o null si no existe
     */
    public function find($id) { //: Usuario especifica el tipo de datos que va a devolver pero no es obligatorio ponerlo
        $sql = "SELECT * FROM usuarios WHERE id=$id";
        if (!$result = $this->conn->query($sql)) {
            die("Error en la SQL: " . $this->conn->error);
        }
        return $result->fetch_object('Usuario');
        /* También se podría sustituir el fetch_object por lo siguiente:
         * 
         * if ($fila = $result->fetch_assoc()) {
          $usuario = new Usuario();
          $usuario->setEmail($fila['email']);
          $usuario->setPassword($fila['password']);
          $usuario->setId($fila['id']);
          $usuario->setFoto($fila['foto']);
          $usuario->setNombre($fila['nombre']);

          return $usuario;
          } else {
          return null;
          } */
    }

    /**
     * Devuelve todos los usuarios de la BD
     * @param type $orden Tipo de orden (ASC o DESC)
     * @param type $campo Campo de la BD por el que se van a ordenar
     * @return array Array de objetos de la clase Usuario
     */
    public function findAll($orden = 'ASC', $campo = 'id') {
        $sql = "SELECT * FROM usuarios ORDER BY $campo $orden";
        if (!$result = $this->conn->query($sql)) {
            die("Error en la SQL: " . $this->conn->error);
        }
        $array_obj_usuarios = array();
        while ($usuario = $result->fetch_object('Usuario')) {
            $array_obj_usuarios[] = $usuario;
        }
        return $array_obj_usuarios;
    }

    public function findByEmail($email) {
        $sql = "SELECT * FROM usuarios WHERE email='$email'";
        if (!$result = $this->conn->query($sql)) {
            die("Error en la SQL: " . $this->conn->error);
        }
        return $result->fetch_object('Usuario');
    }

    public function findByCookie($cookie_id) {
        $sql = "SELECT *  FROM usuarios WHERE cookie_id='$cookie_id'";
        if (!$result = $this->conn->query($sql)) {
            die("Error en la SQL: " . $this->conn->error);
        }
        return $result->fetch_object('Usuario');
    }

}
