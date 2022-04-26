<?php

/**
 * Description of Usuario
 *
 * @author DAW2
 */
class Usuario {

    private $id;
    private $nombre;
    private $apellidos;
    private $telefono;
    private $email;
    private $password;
    private $foto;
    private $cookie_id;
    private $privilegios;
    //Array que va a contener los artículos de este usuario
    private $reservas;
    private $uid;

    function constructorVacio() {
        
    }

    function constructor($id, $nombre, $apellidos, $telefono, $email, $password, $foto, $cookie_id, $privilegios, $reservas, $uid) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->telefono = $telefono;
        $this->email = $email;
        $this->password = $password;
        $this->foto = $foto;
        $this->cookie_id = $cookie_id;
        $this->privilegios = $privilegios;
        $this->reservas = $reservas;
        $this->uid = $uid;
    }

    function getUid() {
        return $this->uid;
    }

    function setUid($uid): void {
        $this->uid = $uid;
    }

    function getId() {
        return $this->id;
    }

    function getPrivilegios() {
        return $this->privilegios;
    }

    function setPrivilegios($privilegios): void {
        $this->privilegios = $privilegios;
    }

    function getTelefono() {
        return $this->telefono;
    }

    function getReservas() {
        return $this->reservas;
    }

    function setTelefono($telefono): void {
        $this->telefono = $telefono;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getApellidos() {
        return $this->apellidos;
    }

    function getEmail() {
        return $this->email;
    }

    function getPassword() {
        return $this->password;
    }

    function getFoto() {
        return $this->foto;
    }

    function getArticulos() {
        return $this->articulos;
    }

    function setId($id): void {
        $this->id = $id;
    }

    function getCookie_id() {
        return $this->cookie_id;
    }

    function setCookie_id($cookie_id): void {
        $this->cookie_id = $cookie_id;
    }

    function setNombre($nombre): void {
        $this->nombre = $nombre;
    }

    function setEmail($email): void {
        $this->email = $email;
    }

    function setPassword($password): void {
        $this->password = $password;
    }

    function setFoto($foto): void {
        $this->foto = $foto;
    }

    function setArticulos($articulos): void {
        $this->articulos = $articulos;
    }

    function setApellidos($apellidos): void {
        $this->apellidos = $apellidos;
    }

    function setReservas($reservas): void {
        $this->reservas = $reservas;
    }

}
