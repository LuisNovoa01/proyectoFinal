<?php

/**
 * Description of ArticuloDAO
 *
 *  @author Juan Miguel Hurtado Montejano -> jmhurtadomontejano@gmail.com
 */
class ArticuloDAO {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function insert($articulo) {
        //Comprobamos que el parámetro sea de la clase Usuario
        if (!$articulo instanceof Articulo) {
            return false;
        }
        $titulo = $articulo->getTitulo();
        $descripcion = $articulo->getDescripcion();
        $precio = $articulo->getPrecio();
        $id_usuario = $articulo->getId_usuario();
        $sql = "INSERT INTO articulos (titulo, descripcion, precio, id_usuario) VALUES "
                . "(?,?,?,?)";
        if(!$stmt = $this->conn->prepare($sql)){
            die("Error al preparar la consulta: " . $this->conn->error);
        }
        
        $stmt->bind_param('ssdi',$titulo, $descripcion, $precio, $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        
        //Guardo el id que le ha asignado la base de datos en la propiedad id del objeto
        $articulo->setId($this->conn->insert_id);
        return true;
    }

    public function update($articulo) {
        //Comprobamos que el parámetro es de la clase Usuario
        if (!$usuario instanceof Articulo) {
            return false;
        }
        $titulo = $articulo->getTitulo();
        $descripcion = $articulo->getDescripcion();
        $precio = $articulo->getPrecio();
        $id = $articulo->getId();
        $sql = "UPDATE articulos SET"
                . " titulo=?, descripcion=?,precio=? "
                . "WHERE id = ?";
        if(!$stmt = $this->conn->prepare($sql))
        {
            die("Error al preparar la consulta: ". $this->conn->error);
        }
        $stmt->bind_param("ssdi",$titulo, $descripcion, $precio, $id);
        $stmt->execute();
        $result = $stmt->get_result();
                
        if ($stmt->affected_rows == 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Borra un registro de la tabla Usuarios
     * @param type $usuario Objeto de la clase usuario
     * @return bool Devuelve true si se ha borrado un usuario y false en caso contrario
     */
    public function delete($articulo) {
        //Comprobamos que el parámetro no es nulo y es de la clase Usuario
        if ($articulo == null || get_class($articulo) != 'Articulo') {
            return false;
        }
        $sql = "DELETE FROM articulos WHERE id = " . $articulo->getId();
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
     * Devuelve el articulo de la BD 
     * @param  $id id del usuario
     * @return \ Articulo de la BD o null si no existe
     */
    public function find($id) { //: Usuario especifica el tipo de datos que va a devolver pero no es obligatorio ponerlo
        $sql = "SELECT * FROM articulos WHERE id=$id";
        if (!$result = $this->conn->query($sql)) {
            die("Error en la SQL: " . $this->conn->error);
        }
        return $result->fetch_object('Articulo');
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
        $sql = "SELECT *,date_format(fecha,'%e/%c/%Y') as fecha FROM articulos ORDER BY $campo $orden";
        if (!$result = $this->conn->query($sql)) {
            die("Error en la SQL: " . $this->conn->error);
        }
        $array_obj_articulos = array();
        while ($articulo = $result->fetch_object('Articulo')) {
            $array_obj_articulos[] = $articulo;
        }
        return $array_obj_articulos;
    }
    
    public function findByUser($id_usuario) {
        $sql = "SELECT *,date_format(fecha,'%e/%c/%Y') as fecha FROM articulos WHERE id_usuario=? ORDER BY id DESC";
        if(!$stmt = $this->conn->prepare($sql)){
            die("Error en la consulta $sql:" . $this->conn->error);
        }
        
        $stmt instanceof mysqli_stmt;
        
        $stmt->bind_param('i', $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        
        
        $array_obj_articulos = array();
        while ($articulo = $result->fetch_object('Articulo')) {
            $array_obj_articulos[] = $articulo;
        }
        return $array_obj_articulos;
    }

}
