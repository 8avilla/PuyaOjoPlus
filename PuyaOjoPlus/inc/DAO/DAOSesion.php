<?php

if(!isset($_SESSION)){
  session_start();  
}

include_once 'Conexion.php';
include_once 'InscripcionCandidato.php';
include_once 'DAOPersona.php';

class DAOSesion {

    private $conexion;

    function __construct() {
        $this->conexion = new Conexion();
    }

    function iniciarSesion($user, $pass) {
        
        try {
            $consulta = "SELECT * FROM `login` WHERE `cc_usuario` = " . $user . " and `contrasena` = " . $pass;
            $result = $this->conexion->consultar_servidor($consulta);
            if ($result != NULL) {
                if (mysql_num_rows($result) > 0) {
                    while ($row = mysql_fetch_array($result)) {
                        $_SESSION['user'] = $row['id_persona'];
                        $_SESSION['tipo'] = $row['tipo'];

                        $lista = $this->validaTipo($row['id_persona'], $row['tipo']);
                        $_SESSION['name'] = $lista[0];
                        $_SESSION['lastname'] = $lista[1];
                        $_SESSION['aspiracion'] = $lista[2];
                        return true;
                    }
                } else {
                    mysql_free_result($result);
                    return "No found";
                }
                mysql_free_result($result);
            }
        } catch (Exception $e) {
            return null;
        }
    }

    function validaTipo($id_persona, $tipo_usuario) {

        if ($tipo_usuario == 1) {
            $daoinscripcion = new InscripcionCandidato();
            $lista = $daoinscripcion->mostrarCandidato($id_persona);
            $listaaux[0] = $lista[1];
            $listaaux[1] = $lista[2];
            $listaaux[2] = $lista[9];
        }
        if ($tipo_usuario == 2) {
            $daopersona = new DAOPersona();
            $persona = $daopersona->consultar($id_persona);
            $listaaux[0] = $persona->getNombre();
            $listaaux[1] = $persona->getApellido();
            $listaaux[2] = "LIDER";
        }
        return $listaaux;
    }

}
