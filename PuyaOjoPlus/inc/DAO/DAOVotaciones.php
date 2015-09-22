<?php
include_once 'Conexion.php';
class DAOVotaciones{
 private $conexion;

    function __construct() {
        $this->conexion = new Conexion();
    }
    
    function conteo_Candidato_Municipio($departamento, $id_candidato){

        $consulta = "SELECT puesto_votacion.municipio FROM `puesto_votacion`, `zonificacion`, `persona`, "
                . "`lista_votante_lider`,`lista_candidato_lider` WHERE zonificacion.id_votante = persona.id AND "
                . "zonificacion.id_puesto = puesto_votacion.id_puesto_votacion AND lista_votante_lider.id_votante = persona.id "
                . "AND lista_candidato_lider.id_lider = lista_votante_lider.id_lider AND "
                . "lista_candidato_lider.id_candidato=".$id_candidato;
        $resultado=$this->conexion->consultar_servidor($consulta);
        $x=0;
        while ($lista2 = mysql_fetch_row($resultado)) {
            $lista[$x][0]=$lista2[0];
            $x++;
        }
        $listaux[0][0]="General";
        $listaux[0][1]=0;
        
        for($x=0;$x<count($lista);$x++){
            
            $aux=0;
            for($j=0;$j<count($listaux);$j++){
                if($listaux[$j][0] == $lista[$x][0]){
                $aux=1;
                }
                
            }
            if($aux==0){
                $listaux[count($listaux)][0]=$lista[$x][0];
            }    
        }
        
    $aux=0;
    //echo count($lista);
    for($x=0;$x<count($lista);$x++){
        for($j=0;$j<count($listaux);$j++){
            if($listaux[$j][0] == $lista[$x][0]){
            $aux=$aux+1;
            $listaux[$j][1]=$aux;
            }
        }
    }
    for ($x = 1; $x < count($listaux) - 1; $x++) {
            for ($j = $x + 1; $j < count($listaux); $j++) {
                if ($listaux[$x][1] < $listaux[$j][1]) {
                    

                    $aux = $listaux[$x][1];
                    $listaux[$x][1] = $listaux[$j][1];
                    $listaux[$j][1] = $aux;

                    $aux = $listaux[$x][0];
                    $listaux[$x][0] = $listaux[$j][0];
                    $listaux[$j][0] = $aux;
                }
            }
        }
    $this->conexion->cerrar_conexion();
    return $listaux;
    
     
    
    
    }
    
        function conteo_Candidato_puesto($departamento, $municipio, $id_candidato){
        $consulta = "SELECT puesto_votacion.puesto FROM `puesto_votacion`, `zonificacion`, `persona`, `lista_votante_lider`, `lista_candidato_lider` WHERE zonificacion.id_votante = persona.id AND zonificacion.id_puesto = puesto_votacion.id_puesto_votacion AND lista_votante_lider.id_votante = persona.id AND lista_candidato_lider.id_lider = lista_votante_lider.id_lider AND lista_candidato_lider.id_candidato='".$id_candidato."' AND puesto_votacion.municipio = '".$municipio."' AND puesto_votacion.departamento='".$departamento."'";

        $resultado=$this->conexion->consultar_servidor($consulta);
        $x=0;
        while ($lista2 = mysql_fetch_row($resultado)) {
            $lista[$x][0]=$lista2[0];
            $x++;
        }
        $listaux[0][0]="General";
        $listaux[0][1]=0;
        
        for($x=0;$x<count($lista);$x++){
            
            $aux=0;
            for($j=0;$j<count($listaux);$j++){
                if($listaux[$j][0] == $lista[$x][0]){
                $aux=1;
                }
                
            }
            if($aux==0){
                $listaux[count($listaux)][0]=$lista[$x][0];
            }    
        }
    for($j=0;$j<count($listaux);$j++){
            $listaux[$j][1]=0;
            }
    $aux=0;
    //echo count($lista);
    for($x=0;$x<count($lista);$x++){
        //$aux=0;
        for($j=0;$j<count($listaux);$j++){
            if($lista[$x][0]==$listaux[$j][0]){
            $aux=$listaux[$j][1];
            $listaux[$j][1]=$aux+1;
            }
        }
    }
    for ($x = 1; $x < count($listaux) - 1; $x++) {
            for ($j = $x + 1; $j < count($listaux); $j++) {
                if ($listaux[$x][1] < $listaux[$j][1]) {
                    

                    $aux = $listaux[$x][1];
                    $listaux[$x][1] = $listaux[$j][1];
                    $listaux[$j][1] = $aux;

                    $aux = $listaux[$x][0];
                    $listaux[$x][0] = $listaux[$j][0];
                    $listaux[$j][0] = $aux;
                }
            }
        }
    $this->conexion->cerrar_conexion();
    return $listaux;
    }
    
    
    function conteo_Candidato_Mesa($departamento, $municipio, $puesto, $id_candidato){
        $consulta = "SELECT puesto_votacion.mesa FROM `puesto_votacion`, `zonificacion`, `persona`, `lista_votante_lider`, `lista_candidato_lider` WHERE zonificacion.id_votante = persona.id AND zonificacion.id_puesto = puesto_votacion.id_puesto_votacion AND lista_votante_lider.id_votante = persona.id AND lista_candidato_lider.id_lider = lista_votante_lider.id_lider AND lista_candidato_lider.id_candidato='".$id_candidato."' AND puesto_votacion.municipio = '".$municipio."' AND puesto_votacion.departamento='".$departamento."' AND puesto_votacion.puesto='".$puesto."'";

        $resultado=$this->conexion->consultar_servidor($consulta);
        $x=0;
        while ($lista2 = mysql_fetch_row($resultado)) {
            $lista[$x][0]=$lista2[0];
            $x++;
        }
        $listaux[0][0]=0;
        $listaux[0][1]=0;
        
        for($x=0;$x<count($lista);$x++){
            
            $aux=0;
            for($j=0;$j<count($listaux);$j++){
                if($listaux[$j][0] == $lista[$x][0]){
                $aux=1;
                }
                
            }
            if($aux==0){
                $listaux[count($listaux)][0]=$lista[$x][0];
            }    
        }
    for($j=0;$j<count($listaux);$j++){
            $listaux[$j][1]=0;
            }
    $aux=0;
    //echo count($lista);
    for($x=0;$x<count($lista);$x++){
        //$aux=0;
        for($j=0;$j<count($listaux);$j++){
            if($lista[$x][0]==$listaux[$j][0]){
            $aux=$listaux[$j][1];
            $listaux[$j][1]=$aux+1;
            }
        }
    }
    for ($x = 1; $x < count($listaux); $x++) {
            for ($j = $x; $j < count($listaux); $j++) {
                if ($listaux[$x][0] < $listaux[$j][0]) {
                    
                    $aux = $listaux[$x][1];
                    $listaux[$x][1] = $listaux[$j][1];
                    $listaux[$j][1] = $aux;

                    $aux = $listaux[$x][0];
                    $listaux[$x][0] = $listaux[$j][0];
                    $listaux[$j][0] = $aux;
                }
            }
    }
    $this->conexion->cerrar_conexion();
    return $listaux;
    }
}
?>