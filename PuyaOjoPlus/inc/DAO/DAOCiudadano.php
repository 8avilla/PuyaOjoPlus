<?php
include_once 'Conexion.php';
class DAOCiudadano{

    function agregarPersona($cedula, $nombre, $apellido) {

        $consultaBD = $this->consultarPersona($cedula);
        if ($consultaBD == FALSE) {
            $conexion = new Conexion();
            $consulta = "INSERT INTO `censo_votacion`.`ciudadano` (`cedula`, `nombre`, `apellido`) VALUES ('".$cedula."', '".$nombre."', '".$apellido."');";
            $conexion->consultar_servidor($consulta);
            $conexion->cerrar_conexion();
            return TRUE;
        }
    }
    
        private function consultarPersona($cedula) {
        $conexion = new Conexion();
        $consulta = "SELECT * FROM `ciudadano` WHERE `cedula` =" . $cedula;
        $resultado = $conexion->consultar_servidor($consulta);
        $conexion->cerrar_conexion();
        if($resultado==TRUE){
            return FALSE;
        }else {
          return TRUE;  
        }
       
    }
}
?>
