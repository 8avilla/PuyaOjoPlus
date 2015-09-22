<?php

include_once 'Conexion.php';
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
include_once $root . '/puyaOjo/inc/DAO/Servicios.php';
include_once $root . '/puyaOjo/inc/modelo_logico/Persona.php';

class DAOPersona {

    private $conexion;

    function __construct() {
        $this->conexion = new Conexion();
    }

    function agregar($cedula, $nombre, $apellido, $telefono, $celular, $direccion, $emai) {
        $id = $this->generarID();
        if ($this->consultarId($cedula) == false) {
            $insert = "INSERT INTO `censo_votacion`.`persona` (`id`, `cedula`, `nombre`, `apellido`, `telefono`, `celular`, `direccion`, `email`) VALUES (" . $id . ", '" . $cedula . "', '" . $nombre . "', '" . $apellido . "', '" . $telefono . "', '" . $celular . "', '" . $direccion . "', '" . $emai . "');";
            $resultado = $this->conexion->consultar_servidor($insert);
            $this->conexion->cerrar_conexion();
            if ($resultado == TRUE) {
                //El Lider se agrego a la Base de Datos
                return $id;
            }
            if ($resultado == FALSE) {
                //Error al momento de agregar el Lider a la Base de Datos
                return -2;
            }
        } else {
            //echo 'La persona se encuentra registrado';
            $this->conexion->cerrar_conexion();
            return -1;
        }
    }

    function generarID() {
        $consulta = "SELECT MAX(id) AS id FROM persona";
        $resultado = $this->conexion->consultar_servidor($consulta);
        $lista = mysql_fetch_array($resultado);
        return ($lista["id"] + 1);
    }

    function consultar($id) {
        $consulta = "SELECT * FROM `persona` WHERE `id` = " . $id;
        $resultado = $this->conexion->consultar_servidor($consulta);
        $daop = new DAOPuestoVotacion();
//        $p = new PuestoVotacion("", "", "", "", "");
        $puesto = $daop->muestraPuestoVotacion($id);
        if (!$resultado) {
            return FALSE;
        } else {
            while ($lista = mysql_fetch_array($resultado)) {
                $persona = new Persona($lista["cedula"], $lista["nombre"], $lista["apellido"], $lista["telefono"], $lista["celular"], $lista["direccion"], $lista["email"], $puesto);
                $persona->setId($lista["id"]);
                return $persona;
            }
        }
    }

    function consultarId($cedula) {
        $consulta = "SELECT * FROM `persona` WHERE `cedula` = " . $cedula;
        $resultado = $this->conexion->consultar_servidor($consulta);
        if ($resultado == false) {
            return FALSE;
        } else {
            $lista = mysql_fetch_array($resultado);
            return $lista["id"];
        }
    }
    

    
    
    private function eliminar($id) {

        
        
    }

}

function modificar ($id, $cedula, $nombre, $apellido, $telefono, $celular, $direccion, $emai){
        $consulta = "UPDATE `censo_votacion`.`persona` SET `cedula` = '".$cedula."', `nombre` = '".$nombre."', `apellido` = '".$apellido."', `telefono` = '".$telefono."', `celular` = '".$celular."', `direccion` = '".$direccion."', `email` = '".$emai."' WHERE `persona`.`id` =" . $id;
        $resultado = $this->conexion->consultar_servidor($consulta);
        $this->conexion->cerrar_conexion();
        if ($resultado == TRUE) {
          
            return TRUE; //TRUE, La Persona se elimino Exitosamente
        }
        if ($resultado == FALSE) {
            //echo 'Error al eliminar Candidato';
            return FALSE; //Error al eliminar Persona de la Base de Datos
        }
    
}

?>