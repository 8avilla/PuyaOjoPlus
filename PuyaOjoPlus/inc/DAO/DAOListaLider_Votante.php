<?php 

$root = realpath($_SERVER["DOCUMENT_ROOT"]);

include_once 'DAOPersona.php';

/**
 * @author Romero Rossi
 * @version 1.0
 * @created 15-ago-2015 03:55:22 p.m.
 */

//$p = new DAOLider();
//$p->agregarLider("3832011", "3832011");

class DAOListaLider_Votante {

    private $conexion;

    function __construct() {
        $this->conexion = new Conexion();
    }

    function agregarLider($cc_candidato, $cc_lider) {
        $daoP = new DAOPersona();
        $persona = $daoP->consultar($cc_lider);
        if ($persona != false) {
            $insert = "INSERT INTO  `censo_votacion`.`lista_candidato_lider` (
                            `cc_candidato` ,`cc_lider`)
                        VALUES (
                            '" . $cc_candidato . "',  '" . $cc_lider . "');";
            $resultado = $this->conexion->consultar_servidor($insert);
            $this->conexion->cerrar_conexion();
//            $this->agregarLider_Candidato($cc, $cc_lider);
            if ($resultado == TRUE) {
                //El Lider se agrego a la Base de Datos
                return 2;
            }
            if ($resultado == FALSE) {
                //Error al momento de agregar el Lider a la Base de Datos
                return 3;
            }
        } else {
            echo 'El lider se encuentra registrado';
            $this->conexion->cerrar_conexion();
            return 1;
        }
    }

        function mostrarVotantesLider($id_lider)
	{
            $conexion = new Conexion();
            $consulta = "SELECT persona.cedula, persona.nombre, persona.apellido, puesto_votacion.departamento, puesto_votacion.municipio, puesto_votacion.puesto, puesto_votacion.mesa FROM `puesto_votacion`, `zonificacion`, `persona`, `lista_votante_lider` WHERE zonificacion.id_votante = persona.id AND zonificacion.id_puesto = puesto_votacion.id_puesto_votacion AND lista_votante_lider.id_votante = persona.id AND lista_votante_lider.id_lider=".$id_lider; 
            $resultado=$conexion->consultar_servidor($consulta);
            $x=0;
            while ($lista = mysql_fetch_array($resultado)) {
                $lista2[$x][0] = $lista[0];
                $lista2[$x][1] = $lista[1];
                $lista2[$x][2] = $lista[2];
                $lista2[$x][3] = $lista[3];
                $lista2[$x][4] = $lista[4];
                $lista2[$x][5] = $lista[5];
                $lista2[$x][6] = $lista[6];
            $x++;
            }
            $conexion->cerrar_conexion();
            if (empty($lista2)) {
                return NULL;
            }
            return $lista2;
           
            
	}
        
       

}

?>