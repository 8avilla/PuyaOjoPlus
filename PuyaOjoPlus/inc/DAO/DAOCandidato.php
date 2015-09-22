<?php
include_once 'Conexion.php';
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
//include_once $root.'/puyaOjo/inc/modelo_logico/Candidato.php';
class DAOCandidato
{
    private $conexion;

    function __construct() {
        $this->conexion = new Conexion();
    }


    
    function TotalVotos($id_candidato)
    {
            $this->conexion = new Conexion();
            $consulta = "SELECT COUNT(*) FROM `puesto_votacion`, `zonificacion`, `persona`, `lista_votante_lider`,`lista_candidato_lider` WHERE zonificacion.id_votante = persona.id AND zonificacion.id_puesto = puesto_votacion.id_puesto_votacion AND lista_votante_lider.id_votante = persona.id AND lista_candidato_lider.id_lider = lista_votante_lider.id_lider AND lista_candidato_lider.id_candidato=".$id_candidato; 
            $resultado=  $this->conexion->consultar_servidor($consulta);
            $lista = mysql_fetch_array($resultado);
            $votacion = $lista[0];
            
            
            $x=0;
            $consulta = "SELECT COUNT(*) FROM `puesto_votacion`, `zonificacion`, `persona`, `lista_votante_lider`,`lista_candidato_lider`, `alianza` WHERE zonificacion.id_votante = persona.id AND zonificacion.id_puesto = puesto_votacion.id_puesto_votacion AND lista_votante_lider.id_votante = persona.id AND lista_candidato_lider.id_lider = lista_votante_lider.id_lider AND lista_candidato_lider.id_candidato= alianza.cc_candidato2do AND alianza.cc_candidato1er=".$id_candidato; 
            $resultado=  $this->conexion->consultar_servidor($consulta);
            while ($lista = mysql_fetch_array($resultado)) {
                $votacion =$votacion + $lista[0];
            $x++;
            }
            $this->conexion->cerrar_conexion();
            
            return $votacion;
    }   
    
    function mostrarVotantes($id_candidato)
    {
            $conexion = new Conexion();
            $consulta = "SELECT persona.cedula, persona.nombre, persona.apellido, puesto_votacion.departamento, puesto_votacion.municipio, puesto_votacion.puesto, puesto_votacion.mesa FROM `puesto_votacion`, `zonificacion`, `persona`, `lista_votante_lider`,`lista_candidato_lider` WHERE zonificacion.id_votante = persona.id AND zonificacion.id_puesto = puesto_votacion.id_puesto_votacion AND lista_votante_lider.id_votante = persona.id AND lista_candidato_lider.id_lider = lista_votante_lider.id_lider AND lista_candidato_lider.id_candidato=".$id_candidato; 
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
        
        function consultarIdCandidato($id_lider) {
        $consulta = "SELECT lista_candidato_lider.id_candidato FROM `lista_candidato_lider` WHERE lista_candidato_lider.id_lider=" . $id_lider;
        $resultado = $this->conexion->consultar_servidor($consulta);
        if ($resultado == false) {
            return FALSE;
        } else {
            $lista = mysql_fetch_array($resultado);
            return $lista;
        }
        }
        function muestraPuestos($id_candidato){
        $daoinscripcion = new InscripcionCandidato();
        $inscripcion = $daoinscripcion->mostrarCandidato($id_candidato);
        $consulta = "SELECT puesto_votacion.puesto FROM `puesto_votacion`, `zonificacion`, `persona`, "
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
        $listaux[0][0]="j";
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
        
        
    
}
?>