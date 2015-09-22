<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
include_once $root . '/puyaOjo/inc/DAO/Servicios.php';
include_once $root . '/puyaOjo/inc/modelo_logico/PuestoVotacion.php';
/**
 * @author Romero Rossi
 * @version 1.0
 * @created 15-ago-2015 05:42:01 p.m.
 */
class DAOPuestoVotacion {

    function agregarPuestoVotacion($departamento, $municipio, $puesto, $dir_puesto, $mesa) {
        
        //$puestoV = new PuestoVotacion(NULL, NULL,NULL,NULL,NULL);
        $dao = new DAOPuestoVotacion();
        $consultaBD = $dao->consultarPuestoVotacionBD($departamento, $municipio, $puesto, $dir_puesto, $mesa);
       
        
        if ($consultaBD == NULL) {
            $conexion = new Conexion();
            $consulta = "INSERT INTO `censo_votacion`.`puesto_votacion` (`departamento`, `municipio`, `puesto`, `direccion`, `mesa`) VALUES ('" . $departamento . "', '" . $municipio . "', '" . $puesto . "', '" . $dir_puesto . "', '" . $mesa . "')";
            $conexion->consultar_servidor($consulta);
            $conexion->cerrar_conexion();
        }
        $puestoV = new PuestoVotacion($departamento, $municipio, $puesto, $dir_puesto, $mesa);
        return $puestoV;
    }

    function modificarPuestoVotacion($id_puesto_votacion, $departamento, $municipio, $puesto, $dir_puesto, $mesa) {
        $conexion = new Conexion();
        $consulta = "UPDATE `censo_votacion`.`puesto_votacion` SET `departamento` = '" . $departamento . "', `municipio` = '" . $municipio . "', `puesto` = '" . $puesto . "', `direccion` = '" . $dir_puesto . "', `mesa` = '" . $mesa . "' WHERE `puesto_votacion`.`id_puesto_votacion` = " . $id_puesto_votacion;
        $conexion->consultar_servidor($consulta);
        $conexion->cerrar_conexion();
    }

    function consultarPuestoVotacionBD($departamento, $municipio, $puesto, $dir_puesto, $mesa) {
        $conexion = new Conexion();
        $consulta = "SELECT `id_puesto_votacion` FROM `puesto_votacion` WHERE `departamento` LIKE '" . $departamento . "' AND `municipio` LIKE '" . $municipio . "' AND `puesto` LIKE '" . $puesto . "' AND `mesa` LIKE '" . $mesa . "'";
        $resultado = $conexion->consultar_servidor($consulta);
        $fila = mysql_fetch_array($resultado);
        $conexion->cerrar_conexion();
        if(empty($fila)){
            return NULL;
        }  else {
            return $fila[0]; 
        }
    }

    function eliminarPuestoVotacion($id_puesto_votacion) {
        $conexion = new Conexion();
        $consulta = "DELETE FROM `censo_votacion`.`puesto_votacion` WHERE `puesto_votacion`.`id_puesto_votacion` = " . $id_puesto_votacion;
        $conexion->consultar_servidor($consulta);
        $conexion->cerrar_conexion();
    }

    function muestraPuestoVotacion($id_persona) {
        $conexion = new Conexion();
        $consulta = "SELECT `id_puesto` FROM `zonificacion` WHERE `id_votante` = " . $id_persona;
        $resultado = $conexion->consultar_servidor($consulta);
        $fila = mysql_fetch_array($resultado);
        $consulta = "SELECT * FROM `puesto_votacion` WHERE `id_puesto_votacion` = " . $fila[0];
        $resultado = $conexion->consultar_servidor($consulta);
        $fila = mysql_fetch_array($resultado);
        $dao = new PuestoVotacion($fila[0], $fila[1], $fila[2], $fila[3], $fila[4], $fila[5]);
        //echo $fila[0];
        //echo $fila[1];
        $conexion->cerrar_conexion();
        return $dao;
    }

}

?>
