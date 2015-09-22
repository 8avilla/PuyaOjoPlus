<?php

include_once 'Conexion.php';

class InscripcionCandidato {

    private $conexion;

    function __construct() {
        $this->conexion = new Conexion();
    }
    
    function mostrarCandidato($id_candidato) {
        $consulta = "SELECT persona.cedula, persona.nombre, persona.apellido, inscripcion_candidato.partido, "
                . "inscripcion_candidato.reglon, inscripcion_candidato.tipo_voto, inscripcion_candidato.departamento,"
                . "inscripcion_candidato.municipio, inscripcion_candidato.localidad, inscripcion_candidato.aspiracion "
                . "FROM `inscripcion_candidato`, `persona` WHERE inscripcion_candidato.id=persona.id AND "
                . "persona.id=" . $id_candidato;
        $resultado = $this->conexion->consultar_servidor($consulta);
        $fila = mysql_fetch_array($resultado);
        $this->conexion->cerrar_conexion();
        if (empty($fila)) {
            return NULL;
        } else {
            return $fila;
        }
    }

}

?>