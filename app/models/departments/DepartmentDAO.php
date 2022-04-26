<?php

/**
 * Description of DepartmentDAO
 *
 *  @author Juan Miguel Hurtado Montejano -> jmhurtadomontejano@gmail.com
 */
class DepartmentDAO {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function insert($department) {
        //Comprobamos que el parámetro sea de la clase Usuario
        if (!$department instanceof department) {
            return false;
        }
        $departmentName = $department->getName();
        $departmentDescription = $department->getDescription();
        //SQL to insert department on the database
        $sql = "INSERT INTO departments (name, description) VALUES (?,?)";
        if(!$stmt = $this->conn->prepare($sql)){
            die("Error al preparar la consulta: " . $this->conn->error);
        }
        $stmt->bind_param('ss',$departmentName, $departmentDescription);
        $stmt->execute();
        $result = $stmt->get_result();

        return true;
    }

    /**
     * Borra un registro de la tabla Usuarios
     * @param type $usuario Objeto de la clase usuario
     * @return bool Devuelve true si se ha borrado un usuario y false en caso contrario
     */
    public function delete($department) {
        //Comprobamos que el parámetro no es nulo y es de la clase Usuario
        if ($department == null || get_class($department) != 'department') {
            return false;
        }
        $sql = "DELETE FROM departments WHERE idDepartment = " . $department->getIdDepartament();
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
        $sql = "SELECT * FROM departments WHERE idDepartment=$id";
        if (!$result = $this->conn->query($sql)) {
            die("Error en la SQL: " . $this->conn->error);
        }
        return $result->fetch_object('department');   //Para poder hacer esto 
    }

    /**
     * Devuelve todos los usuarios de la BD
     * @param type $orden Tipo de orden (ASC o DESC)
     * @param type $campo Campo de la BD por el que se van a ordenar
     * @return array Array de objetos de la clase Usuario
     */
    public function findByIdDepartment($id_department) {
        $sql = "SELECT * FROM departments WHERE idDepartment=$id_department";
        if (!$result = $this->conn->query($sql)) {
            die("Error en la SQL: " . $this->conn->error);
        }
        $array_obj_departments = array();
        while ($department = $result->fetch_object('department')) {
            $array_obj_departments[] = $department;
        }
        return $array_obj_departments;
    }

    public function findAll() {
        $sql = "SELECT * FROM departments order by idDepartment ASC";
        if (!$result = $this->conn->query($sql)) {
            die("Error en la SQL: " . $this->conn->error);
        }
        $array_obj_departments = array();
        while ($department = $result->fetch_object('department')) {
            $array_obj_departments[] = $department;
        }
        return $array_obj_departments;
    }

}
