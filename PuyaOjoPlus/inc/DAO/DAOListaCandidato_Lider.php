<?php

$root = realpath($_SERVER["DOCUMENT_ROOT"]);
include_once 'Conexion.php';

class DAOListaCandidato_Lider {

    private $conexion;

    function __construct() {
        $this->conexion = new Conexion();
    }

    function agregarCandidato_Lider($id_candidato, $id_lider) {
        $consulta = "INSERT INTO  `censo_votacion`.`lista_candidato_lider` (
                        `id` ,
                        `id_candidato` ,
                        `id_lider`
                        )
                        VALUES (
                         '', '" . $id_candidato . "',  '" . $id_lider . "');";
        echo $consulta;
        $result = $this->conexion->consultar_servidor($consulta);
        $this->conexion->cerrar_conexion();
        return $result;
    }

    function mostrarLideres($id_candidato) {

        $consulta = "SELECT persona.cedula, persona.nombre, persona.apellido, persona.telefono, persona.celular, persona.direccion, persona.id FROM `lista_candidato_lider`, `persona` WHERE lista_candidato_lider.id_lider=persona.id AND lista_candidato_lider.id_candidato=" . $id_candidato;
        $resultado = $this->conexion->consultar_servidor($consulta);
        $listaaux = array();
        $size = 0;
        while ($lista = mysql_fetch_array($resultado)) {
//        var_dump($lista);
            $consulta2 = "SELECT COUNT(*) FROM `lista_votante_lider` WHERE lista_votante_lider.id_lider=" . $lista[6];
            $resultado2 = $this->conexion->consultar_servidor($consulta2);
            $lista3 = mysql_fetch_array($resultado2);
            $listaaux[$size][0] = $lista[0];
            $listaaux[$size][1] = $lista[1];
            $listaaux[$size][2] = $lista[2];
            $listaaux[$size][3] = $lista[3];
            $listaaux[$size][4] = $lista[4];
            $listaaux[$size][5] = $lista[5];
            $listaaux[$size][6] = $lista[6];
            $listaaux[$size][7] = $lista3[0];
            $size++;
        }
        if (empty($listaaux)) {
            return null;
        }
        for ($x = 0; $x < count($listaaux); $x++) {
            for ($j = $x+1; $j < count($listaaux); $j++) {
                if ($listaaux[$x][7] < $listaaux[$j][7]) {
                    $aux = "";
                    $aux = $listaaux[$x][7];
                    $listaaux[$x][7] = $listaaux[$j][7];
                    $listaaux[$j][7] = $aux;
                    
                    $aux = "";
                    $aux = $listaaux[$x][6];
                    $listaaux[$x][6] = $listaaux[$j][6];
                    $listaaux[$j][6] = $aux;

                    $aux = "";
                    $aux = $listaaux[$x][5];
                    $listaaux[$x][5] = $listaaux[$j][5];
                    $listaaux[$j][5] = $aux;

                    $aux = "";
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

    public function mostrarCandidatoID($id_lider) {


        $this->consulta = "SELECT `id_candidato` FROM `lista_candidato_lider` WHERE `id_lider`=" . $id_lider;
        $resultado = $this->conexion->consultar_servidor($consulta);
        $lista = mysql_fetch_array($resultado);
        $this->conexion->cerrar_conexion();
        return $lista[0];
    }

}

?>