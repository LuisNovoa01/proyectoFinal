<?php

/**
 * Description of Articulo
 *
 *  @author Juan Miguel Hurtado Montejano -> jmhurtadomontejano@gmail.com
 */
class Articulo {

    private $id;
    private $titulo;
    private $descripcion;
    private $precio;
    private $fecha;
    private $id_usuario;
    //Propiedad para acceder a los datos del usuario al que pertenece el artículo
    private $usuario;
    //Propiedad para acceder a las photos del artículo
    private $photos;

    function getFecha() {
        return $this->fecha;
    }

    function setFecha($fecha): void {
        $this->fecha = $fecha;
    }
    
    function getPhotos() {
        if (!isset($this->photos)) {
            $photoDAO = new PhotoDAO(ConexionBD::conectar());
            $this->photos = $photoDAO->findByIdArticulo($this->getId());
        }
        return $this->photos;
    }

    function getId() {
        return $this->id;
    }

    function getTitulo() {
        return $this->titulo;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getPrecio() {
        return $this->precio;
    }

    function getId_usuario() {
        return $this->id_usuario;
    }

    function getUsuario() {
        if (!isset($this->usuario)) {
            $usuarioDAO = new UsuarioDAO(ConexionBD::conectar());
            $this->usuario = $usuarioDAO->findUserById($this->getId_usuario());
        }
        return $this->usuario;
    }

    function setId($id): void {
        $this->id = $id;
    }

    function setTitulo($titulo): void {
        $this->titulo = $titulo;
    }

    function setDescripcion($descripcion): void {
        $this->descripcion = $descripcion;
    }

    function setPrecio($precio): void {
        $this->precio = $precio;
    }

    function setId_usuario($id_usuario): void {
        $this->id_usuario = $id_usuario;
    }

    function setPhoto($photo): void {
        $this->photo = $photo;
    }
}
