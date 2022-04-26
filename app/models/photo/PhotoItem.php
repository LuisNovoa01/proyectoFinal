<?php
/**
 * Description of Photo
 *
 *  @author Juan Miguel Hurtado Montejano -> jmhurtadomontejano@gmail.com
 */
class PhotoItem {
    private $id;
    private $file_name;
    private $id_item;
    
    //Va a almacenar los datos del artículo relacionado con esta photo
    private $item;
    
    function getId() {
        return $this->id;
    }

    function getFile_name() {
        return $this->file_name;
    }

    function getId_item() {
        return $this->id_item;
    }

    function getItem() {
        return $this->item;
    }

    function setId($id): void {
        $this->id = $id;
    }

    function setFile_name($file_name): void {
        $this->file_name = $file_name;
    }

    function setId_item($id_item): void {
        $this->id_item = $id_item;
    }

    function setItem($item): void {
        $this->item = $item;
    }


    
}
