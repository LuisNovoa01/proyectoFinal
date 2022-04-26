<?php
/**
 * Description of Departament
 *
 *  @author Juan Miguel Hurtado Montejano -> jmhurtadomontejano@gmail.com
 */
class Department {
    private $idDepartment;
    private $name;
    private $description;
    
    //Va a almacenar los datos del artículo relacionado con este Departamento
    private $articulo;
    
    function getIdDepartment() {
        return $this->idDepartment;
    }

    function getName() {
        return $this->name;
    }

    function getDescription() {
        return $this->description;
    }


    function setIdDepartment($id): void {
        $this->id = $idDepartment;
    }

    function setName($name): void {
        $this->name = $name;
    }

    function setDescription($description): void {
        $this->description = $description;
    }

    
}
