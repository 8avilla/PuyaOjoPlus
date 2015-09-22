<?php

session_start();

include_once 'modelo_logico/PuestoVotacion.php';
include_once 'DAO/DAOListaCandidato_Lider.php';
include_once 'DAO/DAOPuestoVotacion.php';
include_once 'DAO/DAOZonificacion.php';
include_once 'modelo_logico/Persona.php';
include_once 'DAO/DAOPersona.php';
if (isset($_GET["op"])) {
    $op = $_GET["op"];
    switch ($op) {
        case 1:
            add_lider($_POST["cc"], $_POST["nombre"], $_POST["apellido"], $_POST["tel"], $_POST["cel"], "NULL", "NULL", $_POST["departamento"], $_POST["municipio"], $_POST["puesto"], $_POST["dir_puesto"], $_POST["mesa"]);
            header('Location: http://localhost/puyaOjo/pages/leaders.php');
            break;
        case 2:
            add_lider($_POST["cc"]);
            break;
    }
}

function add_lider($cedula, $nombre, $apellido, $telefono, $celular, $direccion, $email, $departamento, $municipio, $puesto, $dirPuesto, $mesa) {
    $daoPersona = new DAOPersona();
    $daoLCandidatoL = new DAOListaCandidato_Lider();
    $id = $daoPersona->agregar($cedula, $nombre, $apellido, $telefono, $celular, $direccion, $email);
    if (zonificar($id, $departamento, $municipio, $puesto, $dirPuesto, $mesa)) {
        return $daoLCandidatoL->agregarCandidato_Lider($_SESSION["user"], $id);
    }
    return FALSE;
}

function zonificar($id, $departamento, $municipio, $puesto, $dirPuesto, $mesa) {
    $daoPV = new DAOPuestoVotacion();
    $daoZ = new DAOZonificacion();
    $idPuesto = $daoPV->consultarPuestoVotacionBD($departamento, $municipio, $puesto, $dirPuesto, $mesa);
    if ($idPuesto != NULL) {
        return $daoZ->agregarZonificacion($id, $idPuesto);
    } else {
        return false;
    }
}
