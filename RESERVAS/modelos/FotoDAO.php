<?php

/**
 * Description of ArticuloDAO
 *
 * @author DAW2
 */
class FotoDAO {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function insert($foto) {
        //Comprobamos que el parámetro sea de la clase Usuario
        if (!$foto instanceof Articulo) {
            return false;
        }
        $nombre_archivo = $foto->getNombre_archivo();
        $id_articulo = $articulo->getId_articulo();
        
        $sql = "INSERT INTO fotos (nombre_archivo, id_articulo) VALUES "
                . "('$nombre_archivo', $id_articulo)";
        if (!$result = $this->conn->query($sql)) {
            die("Error en la SQL: " . $this->conn->error);
        }
        //Guardo el id que le ha asignado la base de datos en la propiedad id del objeto
        $foto->setId($this->conn->insert_id);
        return true;
    }

    /**
     * Borra un registro de la tabla Usuarios
     * @param type $usuario Objeto de la clase usuario
     * @return bool Devuelve true si se ha borrado un usuario y false en caso contrario
     */
    public function delete($foto) {
        //Comprobamos que el parámetro no es nulo y es de la clase Usuario
        if ($foto == null || get_class($foto) != 'Foto') {
            return false;
        }
        $sql = "DELETE FROM fotos WHERE id = " . $foto->getId();
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
        return $result->fetch_object('Foto');   //Para poder hacer esto 
    }

    /**
     * Devuelve todos los usuarios de la BD
     * @param type $orden Tipo de orden (ASC o DESC)
     * @param type $campo Campo de la BD por el que se van a ordenar
     * @return array Array de objetos de la clase Usuario
     */
    public function findByIdArticulo($id_articulo) {
        $sql = "SELECT * FROM fotos WHERE id_articulo=$id_articulo";
        if (!$result = $this->conn->query($sql)) {
            die("Error en la SQL: " . $this->conn->error);
        }
        $array_obj_fotos = array();
        while ($foto = $result->fetch_object('Foto')) {
            $array_obj_fotos[] = $foto;
        }
        return $array_obj_fotos;
    }

}
