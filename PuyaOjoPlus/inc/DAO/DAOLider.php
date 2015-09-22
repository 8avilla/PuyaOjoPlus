<?php
include_once 'Conexion.php';
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
//include_once $root.'/puyaOjo/inc/modelo_logico/Candidato.php';
class DAOLider
{
    private $conexion;

    function __construct() {
        $this->conexion = new Conexion();
    }
    function TotalVotos($id_candidato, $id_lider)
    {
            $conexion = new Conexion();
            $consulta = "SELECT COUNT(*) FROM `puesto_votacion`, `zonificacion`, `persona`, `lista_votante_lider`,`lista_candidato_lider` WHERE zonificacion.id_votante = persona.id AND zonificacion.id_puesto = puesto_votacion.id_puesto_votacion AND lista_votante_lider.id_votante = persona.id AND lista_candidato_lider.id_lider = lista_votante_lider.id_lider AND lista_candidato_lider.id_candidato='".$id_candidato."' AND lista_votante_lider.id_lider=".$id_lider; 
            $resultado=$conexion->consultar_servidor($consulta);
            $lista = mysql_fetch_array($resultado);
            $votacion = $lista[0];
            $conexion->cerrar_conexion();
            return $votacion;
    }   
    
        function consultarIdLider($cedula, $id_candidato) {
        $consulta = "SELECT persona.id FROM `lista_candidato_lider`, `persona` WHERE lista_candidato_lider.id_candidato='".$id_candidato."' AND lista_candidato_lider.id_lider=persona.id AND persona.cedula=" . $cedula;
        $resultado = $this->conexion->consultar_servidor($consulta);
        if ($resultado == false) {
            return FALSE;
        } else {
            $lista = mysql_fetch_array($resultado);
            return $lista["id"];
        }
    }
    
    
    
}