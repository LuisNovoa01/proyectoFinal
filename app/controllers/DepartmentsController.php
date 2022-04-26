<?php

class DepartmentsController {
    function insert(){
        if (Session::existe() == false) {
            header("Location: " . RUTA);
            MensajesFlash::add_message("No puedes añadir items si no inicias sesión");
            die();
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            /*             * ***************************************** */
            /*             * *** GUARDAMOS EL DEPARTAMENTO EN LA BBDD  */
            /*             * ***************************************** */
            $conn = ConexionBD::conectar();
            //Insertamos el departmento en la BBDD
            $departmentDAO = new DepartmentDAO($conn);
            $department = new Department();

            //Filtramos datos de entrada
            $name = filter_var($_POST['inputName'], FILTER_SANITIZE_SPECIAL_CHARS);
            $description = filter_var($_POST['inputDescription'], FILTER_SANITIZE_SPECIAL_CHARS);

            $department->setName($name);
            $department->setDescription($description);

            $departmentDAO->insert($department);

            MensajesFlash::add_message("Departamento añadido correctamente");
            header("Location: " . RUTA);
            die();
    }
    require '../app/views/departments/insert_department.php';
    }

    function departments_list(){
        if (Session::existe() == false) {
            header("Location: " . RUTA);
            MensajesFlash::add_message("No puedes añadir items si no inicias sesión");
            die();
        }
        $conn = ConexionBD::conectar();
        $departmentDAO = new DepartmentDAO($conn);
        $departments = $departmentDAO->findAll();
        require '../app/views/departments/departments_list.php';
    }
}