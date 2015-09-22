<?php

/**
 * @author Romero Rossi
 * @version 1.0
 * @created 15-ago-2015 04:57:53 p.m.
 */
class Persona {

    private $cedula;
    private $nombre;
    private $apellido;
    private $telefono;
    private $celular;
    private $direccion;
    private $puesto;
    private $email;
    private $id;

    function __construct($cedula, $nombre, $apellido, $telefono, $celular, $direccion, $email, $puesto) {
        $this->cedula = $cedula;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->telefono = $telefono;
        $this->celular = $celular;
        $this->direccion = $direccion;
        $this->email = $email;
        $this->puesto = $puesto;
        $this->id = "";
    }

    function getArray() {

        $result = array(
            "id" => $this->id,
            "cc" => $this->cedula,
            "nombre" => "$this->nombre",
            "apellido" => "$this->apellido",
            "tel" => "$this->telefono",
            "cel" => "$this->celular",
            "dir" => "$this->direccion",
            "email" => "$this->email",
            "departamento" => $this->puesto->getDepartamento(),
            "municipio" => $this->puesto->getMunicipio(),
            "puesto" => $this->puesto->getPuesto(),
            "dir_puesto" => $this->puesto->getDir_puesto(),
            "mesa" => $this->puesto->getMesa(),
        );
        return $result;
    }

    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }

    function getCedula() {
        return $this->cedula;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getApellido() {
        return $this->apellido;
    }

    function getTelefono() {
        return $this->telefono;
    }

    function getCelular() {
        return $this->celular;
    }

    function getDireccion() {
        return $this->direccion;
    }

    function getPuesto() {
        return $this->puesto;
    }

    function getEmail() {
        return $this->email;
    }

    function setCedula($cedula) {
        $this->cedula = $cedula;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setApellido($apellido) {
        $this->apellido = $apellido;
    }

    function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    function setCelular($celular) {
        $this->celular = $celular;
    }

    function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    function setPuesto($puesto) {
        $this->puesto = $puesto;
    }

    function setEmail($email) {
        $this->email = $email;
    }

}

?>