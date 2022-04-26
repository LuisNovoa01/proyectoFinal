<?php

/**
 * Description of ArticuloDAO
 *
 * @author DAW2
 */
class InstalacionDAO {

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function insert($instalacion) {
        //Comprobamos que el parámetro sea de la clase Usuario
        if (!$instalacion instanceof Instalacion) {
            return false;
        }
        $nombre_instalacion = filter_var($instalacion->getNombre_instalacion(), FILTER_SANITIZE_SPECIAL_CHARS);
        $descripcion_instalacion = filter_var($instalacion->getDescripcion_instalacion(), FILTER_SANITIZE_SPECIAL_CHARS);
        $precio_hora = filter_var($instalacion->getPrecio_hora_instalacion(), FILTER_SANITIZE_NUMBER_INT);
        $foto_instalacion = filter_var($instalacion->getFoto_instalacion(), FILTER_SANITIZE_SPECIAL_CHARS);
        $sql = "INSERT INTO instalaciones (nombre_instalacion, descripcion_instalacion, precio_hora_instalacion, foto_instalacion) VALUES "
                . "(?,?,?,?)";
        if (!$stmt = $this->conn->prepare($sql)) {
            die("Error al preparar la consulta: " . $this->conn->error);
        }

        $stmt->bind_param('ssis', $nombre_instalacion, $descripcion_instalacion, $precio_hora, $foto_instalacion);
        $stmt->execute();
        $result = $stmt->get_result();


        return true;
    }

    /**
     * Borra un registro de la tabla Instalaciones
     * @param type $usuario Objeto de la clase Instalaciones
     * @return bool Devuelve true si se ha borrado una instalacion y false en caso contrario
     */
    public function delete($instalacion) {
        //Comprobamos que el parámetro no es nulo y es de la clase Instalacion
        if ($instalacion == null || get_class($instalacion) != 'Instalacion') {
            return false;
        }
        $sql = "DELETE FROM instalaciones WHERE id_instalacion=" . $instalacion->getId_instalacion();
        if (!$this->conn->query($sql)) {
            die("Error en la SQL: " . $this->conn->error);
        }
        if ($this->conn->affected_rows == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function findByInstalacion($id_instalacion) {
        $sql = "SELECT * FROM instalaciones WHERE id_instalacion='$id_instalacion'";
        if (!$result = $this->conn->query($sql)) {
            die("Error en la SQL: " . $this->conn->error);
        }
        //return $result->fetch_object('Instalacion');
        //return $result;
        return $result->fetch_object('Instalacion');
    }

    public function findByNombreInstalacion($nombreInstalacion) {
        $sql = "SELECT * FROM instalaciones WHERE nombre_instalacion='$nombreInstalacion'";
        if (!$result = $this->conn->query($sql)) {
            die("Error en la SQL: " . $this->conn->error);
        }
        //return $result->fetch_object('Instalacion');
        //return $result;
        return $result->fetch_object('Instalacion');
    }

    public function findallInstalaciones() {
        $sql = "SELECT * FROM instalaciones";
        if (!$result = $this->conn->query($sql)) {
            die("Error en la SQL: " . $this->conn->error);
        }
        $array_instalaciones = Array();
        while ($instalacion = $result->fetch_object('Instalacion')) {
            $array_instalaciones[] = $instalacion;
        }
        return $array_instalaciones;
    }

    public function findallReservasByInstalacionFecha($idInstalacion, $fecha_seleccionada) {
        $sql = "SELECT * FROM reservas WHERE id_instalacion='$id_instalacion'&fecha_reserva='$fecha_seleccionada'";
        if (!$result = $this->conn->query($sql)) {
            die("Error en la SQL: " . $this->conn->error);
        }
        $array_horarios_reservados = array();
        while ($reserva = $result->fetch_object('Reserva')) {
            $array_horarios_reservados[] = $reserva;
        }
        return $array_horarios_reservados;
    }

    public function findByIdReserva($id_reservaPaEliminar) {
        $sql = "SELECT * FROM reservas WHERE id_reserva='$id_reservaPaEliminar'";
        if (!$result = $this->conn->query($sql)) {
            die("Error en la SQL: " . $this->conn->error);
            MensajesFlash::anadir_mensaje("No se ha podido eliminar la reserva");
        }

        return $result->fetch_object('Reserva');
    }

}
