<?php

/**
 * @author Ivan Villamil Ochoa
 * @version 1.0
 * @created 15-ago-2015 05:39:44 p.m.
 */
class PuestoVotacion {

    private $departamento;
    private $municipio;
    private $puesto;
    private $mesa;
    private $dir_puesto;

    function __construct($departamento, $municipio, $puesto, $dir_puesto, $mesa) {
        $this->departamento = $departamento;
        $this->municipio = $municipio;
        $this->puesto = $puesto;
        $this->dir_puesto = $dir_puesto;
        $this->mesa = $mesa;
    }

    function getDepartamento() {
        return $this->departamento;
    }

    function getMunicipio() {
        return $this->municipio;
    }

    function getPuesto() {
        return $this->puesto;
    }

    function getMesa() {
        return $this->mesa;
    }

    function getDir_puesto() {
        return $this->dir_puesto;
    }

    function setDepartamento($departamento) {
        $this->departamento = $departamento;
    }

    function setMunicipio($municipio) {
        $this->municipio = $municipio;
    }

    function setPuesto($puesto) {
        $this->puesto = $puesto;
    }

    function setMesa($mesa) {
        $this->mesa = $mesa;
    }

    function setDir_puesto($dir_puesto) {
        $this->dir_puesto = $dir_puesto;
    }

}

?>