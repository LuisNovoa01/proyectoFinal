<?php

/**
 * Description of ArticuloDAO
 *
 * @author DAW2
 */
class photoDAO {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function insert($photo) {
        //Comprobamos que el parámetro sea de la clase Usuario
        if (!$photo instanceof photo) {
            return false;
        }
        $nombre_archivo = $photo->getNombre_archivo();
        $id_articulo = $photo->getId_articulo();
        
        $sql = "INSERT INTO photos (nombre_archivo, id_articulo) VALUES "
                . "('$nombre_archivo', $id_articulo)";
        if (!$result = $this->conn->query($sql)) {
            die("Error en la SQL: " . $this->conn->error);
        }
        //Guardo el id que le ha asignado la base de datos en la propiedad id del objeto
        $photo->setId($this->conn->insert_id);
        return true;
    }

    /**
     * Borra un registro de la tabla Usuarios
     * @param type $usuario Objeto de la clase usuario
     * @return bool Devuelve true si se ha borrado un usuario y false en caso contrario
     */
    public function delete($photo) {
        //Comprobamos que el parámetro no es nulo y es de la clase Usuario
        if ($photo == null || get_class($photo) != 'photo') {
            return false;
        }
        $sql = "DELETE FROM photos WHERE id = " . $photo->getId();
        if (!$this->conn->query($sql)) {
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
        $sql = "SELECT * FROM fotos WHERE id=$id";
        if (!$result = $this->conn->query($sql)) {
            die("Error en la SQL: " . $this->conn->error);
        }
        return $result->fetch_object('photo');   //Para poder hacer esto 
    }

    /**
     * Devuelve todos los usuarios de la BD
     * @param type $orden Tipo de orden (ASC o DESC)
     * @param type $campo Campo de la BD por el que se van a ordenar
     * @return array Array de objetos de la clase Usuario
     */
    public function findByIdArticulo($id_articulo) {
        $sql = "SELECT * FROM photos WHERE id_articulo=$id_articulo";
        if (!$result = $this->conn->query($sql)) {
            die("Error en la SQL: " . $this->conn->error);
        }
        $array_obj_photos = array();
        while ($photo = $result->fetch_object('photo')) {
            $array_obj_photos[] = $photo;
        }
        return $array_obj_photos;
    }

}
