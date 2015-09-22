<?php

$root = realpath($_SERVER["DOCUMENT_ROOT"]);
include_once $root . '/puyaOjo/inc/modelo_logico/PuestoVotacion.php';
include_once 'Conexion.php';

/**
 * @author Ivan Villamil
 * @version 1.0
 * @created 18-ago-2015 11:23:50 a.m.
 */
class DAOZonificacion {

    private $conexion;

    function __construct() {
        $this->conexion = new Conexion();
    }

    function mostrarPuesto($cc_votante) {
        $this->conexion = new Conexion();
        $id_puesto_votacion = 0;
        $departamento = "0";
        $municipio = "0";
        $puesto = "0";
        $dir_puesto = "0";
        $mesa = 0;
        $consulta = "SELECT `id_puesto` FROM `zonificacion` WHERE `cc_votante` = " . $cc_votante;
        $resultado = $this->conexion->consultar_servidor($consulta);

        $j = 0;
        $lista = "";
        $x = 0;
        $listavotantes = "";
        for ($x = 0; $x < 300; $x++) {
            $lista = mysqli_fetch_array($resultado);
            if ($lista == TRUE) {
                $puestos[$j] = $lista[0];
                $j++;
            }
        }

        $puestovotacion = new PuestoVotacion($id_puesto_votacion, $departamento, $municipio, $puesto, $dir_puesto, $mesa);
//            echo count($datos);
        $DAOpuesto = new DAOPuestoVotacion();


        for ($x = 0; $x < count($puestovotacion); $x++) {
            $puestovotacion = $DAOpuesto->muestraPuestoVotacion($cc_votante);
            if ($puestovotacion->getId_puesto_votacion() != 0) {
                $listavotantes[$x][0] = $puestovotacion->getDir_puesto();
                $listavotantes[$x][1] = $puestovotacion->getDepartamento();
                $listavotantes[$x][2] = $puestovotacion->getMunicipio();
                $listavotantes[$x][3] = $puestovotacion->getPuesto();
                $listavotantes[$x][4] = $puestovotacion->getDir_puesto();
                $listavotantes[$x][5] = $puestovotacion->getMesa();

            }
        }
        return $listavotantes;
    }

    function agregarZonificacion($id_votante, $id_puesto) {
        $insert = "INSERT INTO  `censo_votacion`.`zonificacion` (
                    `id_zonificacion` ,
                    `id_votante` ,
                    `id_puesto`
                    )
                    VALUES (
                    NULL ,  '" . $id_votante . "',  '" . $id_puesto . "'
                    );";
        return $this->conexion->consultar_servidor($insert);
    }


    function modificarZonificacion($cc_votante, $id_puesto_antes, $id_puesto_actual) {
        
    }


    function eliminarZonificacion($id_puesto, $cc_votante) {
        
    }
    

}

?>