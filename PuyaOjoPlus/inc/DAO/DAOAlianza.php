<?php

include_once 'Conexion.php';
include_once 'DAOCandidato.php';

class DAOAlianza{

    private $conexion;

    function __construct() {
        $this->conexion = new Conexion();
    }
    
    function mostrarcandidatos($id_1ercandidato) {
        $daocandidato = new DAOCandidato();
        $consulta = "SELECT persona.cedula, persona.nombre, persona.apellido, inscripcion_candidato.partido "
                . "FROM `alianza`, `inscripcion_candidato`, `persona` WHERE inscripcion_candidato.id=persona.id "
                . "AND persona.id=alianza.cc_candidato2do AND alianza.cc_candidato1er=" . $id_1ercandidato;
        $resultado = $this->conexion->consultar_servidor($consulta);
        
        $listaaux = array();
        $size = 0;
        while ($lista = mysql_fetch_array($resultado)) {
//        var_dump($lista);
            
            $votosconcejal = $daocandidato->TotalVotos($lista[0]);
            $listaaux[$size][0] = $lista[0];
            $listaaux[$size][1] = $lista[1];
            $listaaux[$size][2] = $lista[2];
            $listaaux[$size][3] = $lista[3];
            $listaaux[$size][4] = $votosconcejal;
            $size++;
        }
        if (empty($listaaux)) {
            return null;
        }
        for ($x = 0; $x < count($listaaux); $x++) {
            for ($j = $x+1; $j < count($listaaux); $j++) {
                if ($listaaux[$x][4] < $listaaux[$j][4]) {
                    
                    $aux = $listaaux[$x][4];
                    $listaaux[$x][4] = $listaaux[$j][4];
                    $listaaux[$j][4] = $aux;

                    $aux = "";
                    $aux = $listaaux[$x][3];
                    $listaaux[$x][3] = $listaaux[$j][3];
                    $listaaux[$j][3] = $aux;

                    $aux = "";
                    $aux = $listaaux[$x][2];
                    $listaaux[$x][2] = $listaaux[$j][2];
                    $listaaux[$j][2] = $aux;

                    $aux = $listaaux[$x][1];
                    $listaaux[$x][1] = $listaaux[$j][1];
                    $listaaux[$j][1] = $aux;

                    $aux = "";
                    $aux = $listaaux[$x][0];
                    $listaaux[$x][0] = $listaaux[$j][0];
                    $listaaux[$j][0] = $aux;
                }
            }
        }
        $this->conexion->cerrar_conexion();
        return $listaaux;
    }

}

?>