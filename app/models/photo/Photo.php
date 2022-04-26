<?php
/**
 * Description of Photo
 *
 *  @author Juan Miguel Hurtado Montejano -> jmhurtadomontejano@gmail.com
 */
class Photo {
    private $id;
    private $nombre_archivo;
    private $id_articulo;
    
    //Va a almacenar los datos del artículo relacionado con esta photo
    private $articulo;
    
    function getId() {
        return $this->id;
    }

    function getNombre_archivo() {
        return $this->nombre_archivo;
    }

    function getId_articulo() {
        return $this->id_articulo;
    }

    function getArticulo() {
        return $this->articulo;
    }

    function setId($id): void {
        $this->id = $id;
    }

    function setNombre_archivo($nombre_archivo): void {
        $this->nombre_archivo = $nombre_archivo;
    }

    function setId_articulo($id_articulo): void {
        $this->id_articulo = $id_articulo;
    }

    function setArticulo($articulo): void {
        $this->articulo = $articulo;
    }


    
}
