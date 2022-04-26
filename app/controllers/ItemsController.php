<?php

class ItemsController {
    

    public function toList() {
        $conn = ConexionBD::conectar();
        $itemDAO = new ItemDAO($conn);
        $items = $itemDAO->findAll('DESC', 'date');

        //Generamos Token para seguridad del borrado
        $_SESSION['token'] = md5(time() + rand(0, 999));
        $token = $_SESSION['token'];

        require '../app/views/items/items_list.php';
    }

     function pb() {

        $conn = ConexionBD::conectar();
        //$itemDAO = new ItemDAO($conn);
        $id = $_POST['id'];

        $array_busqueda = array();

       /*Se realizara la consulta de todos los datos
            Es importante que se nombren todos los datos en la consulta
       */
        $busqueda = mysqli_prepare($conn,"SELECT id, name, description, location, id_department, id_service, id_attendUser, id_clientUser, id_user, state, date, hour, duration, registrationDate FROM items WHERE id = $id");
            mysqli_stmt_execute($busqueda);
            mysqli_stmt_store_result($busqueda);
            mysqli_stmt_bind_result($busqueda, $id, $name, $description, $location, $id_department, $id_service, $id_attendUser, $id_clientUser, $id_user, $state, $date, $hour, $duration, $registrationDate);  


            /*Usando la erramienta de while recorreremos todos los datos que nos trajo la consulta */
        while ($row = mysqli_stmt_fetch($busqueda)) {
               $array_busqueda[] = array(
                  'id' => $id,
                  'name'=> $name,
                  'description'=> $description,
                  'location'=> $location,
                  'id_department'=> $id_department,
                  'id_service'=> $id_service,
                  'id_attendUser'=> $id_attendUser,
                  'setId_clientUser'=> $setId_clientUser,
                  'id_user'=> $id_user,
                  'state'=> $state,
                  'date'=> $date,
                  'hour'=> $hour,
                  'duration'=> $duration,
               );

               }
        /*El array lo convertiremos en formato JSON para que este sea leido por javascrip*/
    $vari = json_encode($array_busqueda);
        echo $vari;
    }
    

    function borrar() {
        //Comprobamos que el token recibido es igual al que tenemos en la variable de sesión para evitar ataques CSRF
        if ($_GET['t'] != $_SESSION['token']) {
            header("Location: " . RUTA);
            MensajesFlash::add_message("El token no es correcto");
            die();
        }

        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        $itemDAO = new ItemDAO(ConexionBD::conectar());
        $item = $itemDAO->find($id);
        //Comprobamos el el usuario es propietario del item
        if ($item->getId_usuario() == Session::obtener()->getId()) {
            if ($itemDAO->delete($item)) {
                MensajesFlash::add_message("Item borrado");
            } else {
                MensajesFlash::add_message("Item no encontrado");
            }
        } else {
            MensajesFlash::add_message("¡El item no es tuyo!");
        }
        header("Location: " . RUTA);
    }

    function insert() {
        if (Session::existe() == false) {
            header("Location: " . RUTA);
            MensajesFlash::add_message("No puedes añadir items si no inicias sesión");
            die();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            /*             * ***************************************** */
            /*             * *** GUARDAMOS EL ITEM EN LA BBDD **** */
            /*             * ***************************************** */
            $conn = ConexionBD::conectar();
            $itemDAO = new ItemDAO($conn);
            $item = new Item();

            //Filtramos datos de entrada
            $name = filter_var($_POST['inputName'], FILTER_SANITIZE_SPECIAL_CHARS);
            $description = filter_var($_POST['inputDescription'], FILTER_SANITIZE_SPECIAL_CHARS);
            $location = filter_var($_POST['inputLocation'], FILTER_SANITIZE_SPECIAL_CHARS);
            $id_department = filter_var($_POST['inputDepartment'], FILTER_SANITIZE_NUMBER_INT);
            $id_service = filter_var($_POST['inputService'], FILTER_SANITIZE_NUMBER_INT);
            $id_attendUser = filter_var($_POST['inputAttendUser'], FILTER_SANITIZE_NUMBER_INT);
            $id_clientUser = filter_var($_POST['inputClientUser'], FILTER_SANITIZE_NUMBER_INT);
            $state = filter_var($_POST['inputState'], FILTER_SANITIZE_SPECIAL_CHARS);
            $date = filter_var($_POST['inputDate'], FILTER_SANITIZE_SPECIAL_CHARS);
            $hour = filter_var($_POST['inputHour'], FILTER_SANITIZE_SPECIAL_CHARS);
            $duration = filter_var($_POST['inputDuration'], FILTER_SANITIZE_SPECIAL_CHARS);

            $item->setName($name);
            $item->setDescription($description);
            $item->setLocation($location);
            $item->setId_department($id_department);
            $item->setId_service($id_service);
            $item->setId_attendUser($id_attendUser);
            $item->setId_clientUser($id_clientUser);
            $item->setState($state);
            $item->setDate($date);
            $item->setHour($hour);
            $item->setDuration($duration);
   
            $item->setId_user(Session::obtener()->getId());

            $itemDAO->insert($item);

            for ($i = 0; $i < count($_FILES['inputPhotoItem']['name']); $i++) {
                $error = false;
                echo($_FILES['inputPhotoItem']['name'][$i]);
                /*                 * ****************************************** */
                /*                 * ************ VALIDAMOS LA photo *********** */
                /*                 * ****************************************** */

                if ($_FILES['inputPhotoItem']['type'][$i] != 'image/png' &&
                        $_FILES['inputPhotoItem']['type'][$i] != 'image/gif' &&
                        $_FILES['inputPhotoItem']['type'][$i] != 'image/jpeg') {
                    MensajesFlash::add_message("El archivo seleccionado no es una foto.");
                    $error = true;
                }
                if ($_FILES['inputPhotoItem']['size'][$i] > 1000000) {
                    MensajesFlash::add_message("El archivo seleccionado es demasiado grande. Debe tener un tamaño inferior a 1MB");
                    $error = true;
                }

                if (!$error) {


                    /*                     * ****************************************** */
                    /*                     * ********** COPIAR LA FOTO A DISCO ******** */
                    /*                     * ****************************************** */
                    $nombre_photo = md5(time() + rand(0, 999999));
                    $extension_photo = substr($_FILES['inputPhotoItem']['name'][$i], strrpos($_FILES['inputPhotoItem']['name'][$i], '.') + 1);
                    //Limpiamos la extensión de la photo
                    $extension_photo = filter_var($extension_photo, FILTER_SANITIZE_SPECIAL_CHARS);
                    //Comprobamos que no exista ya una photo con el mismo nombre, si existe calculamos uno nuevo
                    while (file_exists("images/items/$nombre_photo.$extension_photo")) {
                        $nombre_photo = md5(time() + rand(0, 999999));
                    }
                    //movemos la photo a la carpeta que queramos guardarla y con el nuevo nombre
                    if (!move_uploaded_file($_FILES['inputPhotoItem']['tmp_name'][$i], "images/items/$nombre_photo.$extension_photo")) {
                        MensajesFlash::add_message("No se ha podido copiar la photo");
                        header("Location: inicio");
                        die();
                    }

                    /*                     * ****************************************** */
                    /*                     * ******* GUARDAMOS LA FOTO EN LA BBDD ***** */
                    /*                     * ****************************************** */
                    $id_item = $item->getId();
                    $nombre_archivo = "$nombre_photo.$extension_photo";
                    $photoDAO = new PhotoItemDAO($conn);
                    $photo = new PhotoItem();
                    $photo->setId_item($id_item);
                    $photo->setFile_name($nombre_archivo);
                    if (!$photoDAO->insert($photo)) {
                        die("Error al insertar la photo del Item en la BD");
                    }
                }//if(!$error)
            } //for

            MensajesFlash::add_message("Se ha insertado el Item correctamente");
            header("Location: " . RUTA);
            die();
        }

        require '../app/views/items/insert_item.php';
    }

    public function ver() {
        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        $conn = ConexionBD::conectar();
        //Insertamos el item en la BBDD
        $itemDAO = new ItemDAO($conn);
        $item = $itemDAO->find($id);

        require '../app/vistas/view_item.php';
    }

    public function mis_items() {
        $conn = ConexionBD::conectar();
        $itemDAO = new ItemDAO($conn);
        $mis_items = $itemDAO->findByUser(Session::obtener()->getId());

        //Generamos Token para seguridad del borrado
        $_SESSION['token'] = md5(time() + rand(0, 999));
        $token = $_SESSION['token'];

        require '../app/views/items/own_items.php';
    }

    public function update_item() {
        $conn = ConexionBD::conectar();
        $itemDAO = new ItemDAO($conn);
        $item = $itemDAO->find($_GET['id']);

        $departmentDAO = new DepartmentDAO($conn);
        $departments = $departmentDAO->findAll();

        $serviceDAO = new ServiceDAO($conn);
        $services = $serviceDAO->findAll();

        $attendUserDAO = new AttendUserDAO($conn);
        $attendUsers = $attendUserDAO->findAll();

        $clientUserDAO = new ClientUserDAO($conn);
        $clientUsers = $clientUserDAO->findAll();

        $photoDAO = new PhotoItemDAO($conn);
        $photos = $photoDAO->findAll($_GET['id']);

        $token = md5(time() + rand(0, 999));
        $_SESSION['token'] = $token;

        require '../app/views/items/update_item.php';
    }

    /*public function findByIdItem($id) { //: Usuario especifica el tipo de datos que va a devolver pero no es obligatorio ponerlo
        $sql = "SELECT * FROM items WHERE id=$id";
        if (!$result = $this->conn->query($sql)) {
            die("Error en la SQL: " . $this->conn->error);
        }
        return $result->fetch_object('item');
     
    }*/

    public function download_csv_files() {
        $sql = "SELECT *,date_format(date,'%e/%c/%Y') as date FROM items ORDER BY id DESC";
        if (!$result = $this->conn->query($sql)) {
            die("Error en la SQL: " . $this->conn->error);
        }
        $array_obj_items = array();
        while ($item = $result->fetch_object('item')) {
            $array_obj_items[] = $item;
        }
        /*$array_obj_items[] to csv */
        $filename = "items.csv";
        $fp = fopen('php://output', 'w');
        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        foreach ($array_obj_items as $item) {
            fputcsv($fp, $item);
        }
        fclose($fp);
        
    }

}