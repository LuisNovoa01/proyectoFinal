<?php

/**
 * Description of Reserva
 *
 * @author DAW2
 */
class Reserva {

    private $id_reserva;
    private $id_usuario;
    private $id_instalacion;
    private $fecha_reserva;
    private $hora_inicio;
    private $hora_fin;
    private $hora_registro;

    function constructorReserva($id_reserva, $id_usuario, $id_instalacion, $fecha_reserva, $hora_inicio, $hora_fin, $hora_registro) {
        $this->id_reserva = $id_reserva;
        $this->id_usuario = $id_usuario;
        $this->id_instalacion = $id_instalacion;
        $this->fecha_reserva = $fecha_reserva;
        $this->hora_inicio = $hora_inicio;
        $this->hora_fin = $hora_fin;
        $this->hora_registro = $hora_registro;
    }

    /*ESTE ERA EL CONSTRUCTOR SIN LA PISTA/* function constructorReserva( $id_usuario, $fecha, $hora_inicio, $hora_fin, $hora_registro) {
      $this->id_usuario = $id_usuario;
      $this->fecha_reserva = $fecha;
      $this->hora_inicio = $hora_inicio;
      $this->hora_fin = $hora_fin;
      $this->hora_registro = $hora_registro;
      } */

    function constructorReservaVacio() {
        
    }

    function getId_instalacion() {
        return $this->id_instalacion;
    }

    function setId_instalacion($id_instalacion): void {
        $this->id_instalacion = $id_instalacion;
    }

    function getId_reserva() {
        return $this->id_reserva;
    }

    function getId_usuario() {
        return $this->id_usuario;
    }

    function getFecha_reserva() {
        return $this->fecha_reserva;
    }

    function getHora_inicio() {
        return $this->hora_inicio;
    }

    function getHora_fin() {
        return $this->hora_fin;
    }

    function getHora_registro() {
        return $this->hora_registro;
    }

    function setId_reserva($id_reserva): void {
        $this->id_reserva = $id_reserva;
    }

    function setId_usuario($id_usuario): void {
        $this->id_usuario = $id_usuario;
    }

    function setFecha_reserva($fecha): void {
        $this->fecha_reserva = $fecha;
    }

    function setHora_inicio($hora_inicio): void {
        $this->hora_inicio = $hora_inicio;
    }

    function setHora_fin($hora_fin): void {
        $this->hora_fin = $hora_fin;
    }

    function setHora_registro($hora_registro): void {
        $this->hora_registro = $hora_registro;
    }

}
