<?php

class Instalacion{
private $id_instalacion;
private $nombre_instalacion;
private $descripcion_instalacion;
private $precio_hora_instalacion;
private $foto_instalacion;
private $fecha_registro;

function __constructVacio() {
    
}
function constructorInstalacion($id_instalacion, $nombre_instalacion, $descripcion_instalacion, $precio_hora_instalacion, $foto_instalacion, $fecha_registro) {
    $this->id_instalacion = $id_instalacion;
    $this->nombre_instalacion = $nombre_instalacion;
    $this->descripcion_instalacion = $descripcion_instalacion;
    $this->precio_hora_instalacion = $precio_hora_instalacion;
    $this->foto_instalacion = $foto_instalacion;
    $this->fecha_registro = $fecha_registro;
}


function getId_instalacion() {
    return $this->id_instalacion;
}

function getNombre_instalacion() {
    return $this->nombre_instalacion;
}
function getPrecio_hora_instalacion() {
    return $this->precio_hora_instalacion;
}

function setPrecio_hora_instalacion($precio_hora_instalacion): void {
    $this->precio_hora_instalacion = $precio_hora_instalacion;
}

function getDescripcion_instalacion() {
    return $this->descripcion_instalacion;
}

function getFoto_instalacion() {
    return $this->foto_instalacion;
}

function setId_instalacion($id_instalacion): void {
    $this->id_instalacion = $id_instalacion;
}

function setNombre_instalacion($nombre_instalacion): void {
    $this->nombre_instalacion = $nombre_instalacion;
}

function setDescripcion_instalacion($descripcion_instalacion): void {
    $this->descripcion_instalacion = $descripcion_instalacion;
}

function setFoto_instalacion($foto_instalacion): void {
    $this->foto_instalacion = $foto_instalacion;
}
function getFecha_registro() {
    return $this->fecha_registro;
}

function setFecha_registro($fecha_registro): void {
    $this->fecha_registro = $fecha_registro;
}




}