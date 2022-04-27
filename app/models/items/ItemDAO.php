<?php

//echo $_POST['id'];

/*
 * Description of ItemDAO
 *
 *  @author Juan Miguel Hurtado Montejano -> jmhurtadomontejano@gmail.com
 */
class ItemDAO {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }


    public function insert($item) {
        //Comprobamos que el parámetro sea de la clase Usuario
        if (!$item instanceof item) {
            return false;
        }
        $name = $item->getname();
        $description = $item->getDescription();
        $location = $item->getLocation();
        $id_department = $item->getId_department();
        $id_service = $item->getId_service();
        $id_attendUser = $item->getId_attendUser();
        $id_clientUser = $item->getId_clientUser();
        $id_user = $item->getId_user();
        $state = $item->getState();
        $date = $item->getDate();
        $hour = $item->getHour();
        $duration = $item->getDuration();
        $sql = "INSERT INTO items (name, description, location, id_department, id_service, id_attendUser, id_clientUser, id_user, state, date, hour, duration) VALUES "
                . "(?,?,?,?,?,?,?,?,?,?,?,?)";
        if(!$stmt = $this->conn->prepare($sql)){
            die("Error al preparar la consulta: " . $this->conn->error);
        }
        
        $stmt->bind_param('sssdiiiissss',$name, $description, $location, $id_department, $id_service, $id_attendUser, $id_clientUser, $id_user, $state, $date, $hour, $duration);
        $stmt->execute();
        $result = $stmt->get_result();
        
        //Guardo el id que le ha asignado la base de datos en la propiedad id del objeto
        $item->setId($this->conn->insert_id);
        return true;
    }

    public function update($item) {
        //Comprobamos que el parámetro es de la clase Usuario
        if (!$usuario instanceof item) {
            return false;
        }
        $name = $item->getname();
        $description = $item->getDescription();
        $location = $item->getlocation();
        $id_department = $item->getId_department();
        $id_service = $item->getId_service();
        $id_attendUser = $item->getId_attendUser();
        $id_clientUser = $item->getId_clientUser();
        $id = $item->getId();
        $state = $item->getState();
        $date = $item->getDate();
        $hour = $item->getHour();
        $duration = $item->getDuration();
        $sql = "UPDATE items SET"
                . " name=?, description=?,location=?, id_department=?, id_service=?, id_attendUser=?, id_clientUser=?, state=?, date=?, hour=?, duration=?"
                . "WHERE id = ?";
        if(!$stmt = $this->conn->prepare($sql))
        {
            die("Error al preparar la consulta: ". $this->conn->error);
        }
        $stmt->bind_param("sssdiiiissss",$name, $description, $location, $id_department, $id_service, $id_attendUser, $id_clientUser, $state, $id, $state, $date, $hour, $duration);
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
    public function delete($item) {
        //Comprobamos que el parámetro no es nulo y es de la clase Usuario
        if ($item == null || get_class($item) != 'item') {
            return false;
        }
        $sql = "DELETE FROM items WHERE id = " . $item->getId();
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
     * Devuelve el item de la BD 
     * @param  $id id del usuario
     * @return \ item de la BD o null si no existe
     */
    public function find($id) { //: Usuario especifica el tipo de datos que va a devolver pero no es obligatorio ponerlo
        $sql = "SELECT * FROM items WHERE id=$id";
        if (!$result = $this->conn->query($sql)) {
            die("Error en la SQL: " . $this->conn->error);
        }
        return $result->fetch_object('item');
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

    
    public function findByIdItem($id) { //: Usuario especifica el tipo de datos que va a devolver pero no es obligatorio ponerlo
        $sql = "SELECT * FROM items WHERE id=$id";
        if (!$result = $this->conn->query($sql)) {
            die("Error en la SQL: " . $this->conn->error);
        }
        return $result->fetch_object('item');
     
    }

    public function listar_departamentos() { //: Usuario especifica el tipo de datos que va a devolver pero no es obligatorio ponerlo
        $sql = "SELECT *  FROM departments";
        if (!$result = $this->conn->query($sql)) {
            die("Error en la SQL: " . $this->conn->error);
        }
        $array_obj_departament = array();
        while ($department = $result->fetch_object()) {
            $array_obj_departament[] = $department;
        }
       // $var1 = json_encode($array_obj_departament);
        return $array_obj_departament;
     
    }

    

    /**
     * Devuelve todos los usuarios de la BD
     * @param type $orden Tipo de orden (ASC o DESC)
     * @param type $campo Campo de la BD por el que se van a ordenar
     * @return array Array de objetos de la clase Usuario
     */
    public function findAll($orden = 'ASC', $campo = 'id') {
        $sql = "SELECT *,date_format(date,'%e/%c/%Y') as date FROM items ORDER BY $campo $orden";
        if (!$result = $this->conn->query($sql)) {
            die("Error en la SQL: " . $this->conn->error);
        }
        $array_obj_items = array();
        while ($item = $result->fetch_object('item')) {
            $array_obj_items[] = $item;
        }
        return $array_obj_items;
    }
    
    public function findItemsByUser($id_user) {
        $sql = "SELECT *,date_format(date,'%e/%c/%Y') as date FROM items WHERE id_user=? ORDER BY id DESC";
        if(!$stmt = $this->conn->prepare($sql)){
            die("Error en la consulta $sql:" . $this->conn->error);
        }
        
        $stmt instanceof mysqli_stmt;
        
        $stmt->bind_param('i', $id_user);
        $stmt->execute();
        $result = $stmt->get_result();
        
        
        $array_obj_items = array();
        while ($item = $result->fetch_object('item')) {
            $array_obj_items[] = $item;
        }
        return $array_obj_items;
    }
    
    /*public function download_csv_file($items) to export all items to CSV*/
  
}