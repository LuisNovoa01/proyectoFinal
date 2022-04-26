<?php

/**
 * Description of ArticuloDAO
 *
 *  @author Juan Miguel Hurtado Montejano -> jmhurtadomontejano@gmail.com
 */
class photoItemDAO {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function insert($photoItem) {
        //Comprobamos que el parámetro sea de la clase Usuario
        if (!$photoItem instanceof photoItem) {
            return false;
        }
        $file_name = $photoItem->getFile_name();
        $id_item = $photoItem->getid_item();
        
        $sql = "INSERT INTO photositems (file_name, id_item) VALUES "
                . "('$file_name', $id_item)";
        if (!$result = $this->conn->query($sql)) {
            die("Error en la SQL: " . $this->conn->error);
        }
        //Guardo el id que le ha asignado la base de datos en la propiedad id del objeto
        $photoItem->setId($this->conn->insert_id);
        return true;
    }

    /**
     * Borra un registro de la tabla Usuarios
     * @param type $usuario Objeto de la clase usuario
     * @return bool Devuelve true si se ha borrado un usuario y false en caso contrario
     */
    public function delete($photoItem) {
        //Comprobamos que el parámetro no es nulo y es de la clase Usuario
        if ($photoItem == null || get_class($photoItem) != 'photo') {
            return false;
        }
        $sql = "DELETE FROM photositems WHERE id = " . $photoItem->getId();
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
        $sql = "SELECT * FROM photositems WHERE id=$id";
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
    public function findByIdItem($id_item) {
        $sql = "SELECT * FROM photositems WHERE id_item=$id_item";
        if (!$result = $this->conn->query($sql)) {
            die("Error en la SQL: " . $this->conn->error);
        }
        $array_obj_photos = array();
        while ($photoItem = $result->fetch_object('PhotoItem')) {
            $array_obj_photos[] = $photoItem;
        }
        return $array_obj_photos;
    }

}
