<?php

/**
 * Description of ReservaDAO
 *
 * @author DAW2
 */
class ReservaDAO {

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function insert($reserva) {
        //Comprobamos que el parámetro sea de la clase Usuario
        if (!$reserva instanceof Reserva) {
            return false;
        }
        //$id_usuario = filter_var($reserva->getId_usuario().FILTER_SANITIZE_NUMBER_INT); NO ME FUNCIONA SANITIZAR CON INT FUNCIONA CON CHARS, PORQUE?
        $id_usuario = filter_var($reserva->getId_usuario(), FILTER_SANITIZE_SPECIAL_CHARS);
        $id_instalacion = filter_var($reserva->getId_instalacion(), FILTER_SANITIZE_SPECIAL_CHARS);
        $fecha_reserva = filter_var($reserva->getFecha_reserva(), FILTER_SANITIZE_SPECIAL_CHARS);
        $hora_inicio = filter_var($reserva->getHora_inicio(), FILTER_SANITIZE_SPECIAL_CHARS);
        $hora_fin = $reserva->getHora_fin();
       
        
        $sql = "INSERT INTO reservas (id_usuario, id_instalacion, fecha_reserva, hora_inicio, hora_fin) VALUES "
                . "(?,?,?,?,?)";
        if (!$stmt = $this->conn->prepare($sql)) {
            die("Error al preparar la consulta: " . $this->conn->error);
            MensajesFlash::anadir_mensaje("Error al añadir la reserva");
        }

        $stmt->bind_param('issss', $id_usuario, $id_instalacion, $fecha_reserva, $hora_inicio, $hora_fin);
        $stmt->execute();
        $result = $stmt->get_result();


        return true;
    }

    /**
     * Borra un registro de la tabla Usuarios
     * @param type $usuario Objeto de la clase usuario
     * @return bool Devuelve true si se ha borrado un usuario y false en caso contrario
     */
    public function delete($reserva) {
        //Comprobamos que el parámetro no es nulo y es de la clase Usuario
        if ($reserva == null || get_class($reserva) != 'Reserva') {
            return false;
        }
        $sql = "DELETE FROM reservas WHERE id_reserva = " . $reserva->getId_reserva();
        if (!$this->conn->query($sql)) {
            die("Error en la SQL: " . $this->conn->error);
        }
        if ($this->conn->affected_rows == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function findByUser($id_usuario) {
        $sql = "SELECT * FROM reservas WHERE id_usuario=$id_usuario order by fecha_reserva DESC, hora_inicio";
        if (!$result = $this->conn->query($sql)) {
            die("Error en la SQL: " . $this->conn->error);
        }
        $array_horarios_reservados_por_usuario = array();
        while ($reserva = $result->fetch_object('Reserva')) {
            $array_horarios_reservados_por_usuario[] = $reserva;
        }
        return $array_horarios_reservados_por_usuario;
    }

    public function findallReservasByFecha($fecha_seleccionada) {
        $sql = "SELECT * FROM reservas WHERE fecha_reserva='$fecha_seleccionada'";
        if (!$result = $this->conn->query($sql)) {
            die("Error en la SQL: " . $this->conn->error);
        }
        $array_horarios_reservados = array();
        while ($reserva = $result->fetch_object('Reserva')) {
            $array_horarios_reservados[] = $reserva;
        }
        return $array_horarios_reservados;
    }
    
        public function findallReservasByFechaEInstalacion($fecha_seleccionada, $id_instalacion) {
        $sql = "SELECT * FROM reservas WHERE fecha_reserva='$fecha_seleccionada' and id_instalacion='$id_instalacion'";
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

        public function findallReservasToFecha($fecha_seleccionada) {
        $sql = "SELECT * FROM reservas WHERE fecha_reserva>'$fecha_seleccionada'";
        if (!$result = $this->conn->query($sql)) {
            die("Error en la SQL: " . $this->conn->error);
        }
        $array_horarios_reservados = array();
        while ($reserva = $result->fetch_object('Reserva')) {
            $array_horarios_reservados[] = $reserva;
        }
        return $array_horarios_reservados;
    }
}
