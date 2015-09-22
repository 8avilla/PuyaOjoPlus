<?php

$root = realpath($_SERVER["DOCUMENT_ROOT"]);
include_once $root . '/puyaOjo/inc/DAO/DAOPuestoVotacion.php';
include_once $root . '/puyaOjo/inc/DAO/DAOCiudadano.php';
include_once $root . '/puyaOjo/inc/DAO/DAOSesion.php';
include_once $root . '/puyaOjo/inc/modelo_logico/Persona.php';
include_once $root . '/puyaOjo/inc/modelo_logico/PuestoVotacion.php';

class Servicios {

    private $conexion;

    function __construct() {
        $this->conexion = new Conexion();
    }
    function mostrarLogoPartido ($user){
        $consulta = "SELECT partido.logo FROM `partido`, `inscripcion_candidato` "
                . "WHERE inscripcion_candidato.partido=partido.partido AND "
                . "inscripcion_candidato.id=".$user;
            $result = $this->conexion->consultar_servidor($consulta);
            $this->conexion->cerrar_conexion();
            $row = mysql_fetch_array($result);
                
            if ($row[0] != NULL) {
                return $row[0];
            }else{
                return "../dist/img/avatar5.png";
            }
        
    }
            function mostrarFoto ($user){
            $consulta = "SELECT `foto` FROM `login` WHERE `id_persona` =".$user;
            $result = $this->conexion->consultar_servidor($consulta);
            $this->conexion->cerrar_conexion();
            $row = mysql_fetch_array($result);
                
            if ($row[0] != NULL) {
                return $row[0];
            }else{
                return "../dist/img/user2-160x160.jpg";
            }
    }
            
function apariencia($user){
            $consulta = "SELECT partido.apariencia FROM `partido`, `inscripcion_candidato` "
                . "WHERE inscripcion_candidato.partido=partido.partido AND "
                . "inscripcion_candidato.id=".$user;
            $result = $this->conexion->consultar_servidor($consulta);
            $this->conexion->cerrar_conexion();
            $row = mysql_fetch_array($result);
                
            if ($row[0] != NULL) {
                return $row[0];
            }else{
                return "skin-blue-light";
            }
       }
    
    function validador($persona){
       
        $aux=0;
        if($_SESSION['tipo']==1){
            $consulta = "SELECT COUNT(*) FROM `lista_candidato_lider`,  `lista_votante_lider` WHERE lista_candidato_lider.id_candidato='".$_SESSION['user']."' AND lista_candidato_lider.id_lider= lista_votante_lider.id_lider AND lista_votante_lider.id_votante=".$persona;
            $resultado = $this->conexion->consultar_servidor($consulta);
            $lista = mysql_fetch_array($resultado);
            $aux=$aux+$lista[0]; 
            
            $consulta = "SELECT COUNT(*) FROM `lista_candidato_lider` WHERE lista_candidato_lider.id_candidato='".$_SESSION['user']."' AND lista_candidato_lider.id_lider= ".$persona;
            $resultado = $this->conexion->consultar_servidor($consulta);
            $lista = mysql_fetch_array($resultado);
            $aux=$aux+$lista[0];
            
            if($_SESSION['user']== $persona){
                 $aux=$aux+1;
            }   
        }
        
        if($_SESSION['tipo']==2){
            $consulta = "SELECT COUNT(*) FROM `lista_votante_lider` WHERE lista_votante_lider.id_lider='".$_SESSION['user']."' AND lista_votante_lider.id_votante=".$persona;
            $resultado = $this->conexion->consultar_servidor($consulta);
            $lista = mysql_fetch_array($resultado);
            $aux=$aux+$lista[0];
            
            if($_SESSION['user']== $persona){
                 $aux=$aux+1;
            } 
            
        }
        $this->conexion->cerrar_conexion();
        return $aux;
        
    }


    
    public function consultar($cedula) {
//        $persona = new Votante();
        if ($cedula != "") {
            $listaPersona = $this->buscarNombre($cedula);
            $puesto = $this->buscarPuestoVotacion($cedula);
            //$persona = new Votante($cedula, "", "", "", "", "", "", $puesto);
            $persona = new Persona($cedula, $listaPersona[0], $listaPersona[1], "", "", "", "", $puesto);
            return $persona;
        } else {
            return null;
        }
    }

////////////////////////////////////////////////////////////////// FUNCIONES ////////////////////////////////////// FUNCIONES ////////////////////////////////////// FUNCIONES ////////////////////////////////////// FUNCIONES
    public function buscarPuestoVotacion($cedula) {

        $lista = $this->puestoVotacion($cedula);
        $daopuesto = new DAOPuestoVotacion();
        $puesto1 = new PuestoVotacion(NULL, NULL, NULL, NULL, NULL, NULL);
        if ($lista['ERROR'] == NULL) {

            $puestoreg = $daopuesto->agregarPuestoVotacion($lista['DEPARTAMENTO'], $lista['MUNICIPIO'], $lista['PUESTO'], $lista['DIRECCION'], $lista['MESA']);
            return $puestoreg;
        } else {
            
            $puesto1->SetDepartamento($lista['ERROR']);
            return $puesto1;
        }
    }

////////////////////////////////////////////////////////////////// FUNCIONES ////////////////////////////////////// FUNCIONES ////////////////////////////////////// FUNCIONES ////////////////////////////////////// FUNCIONES
    function buscarNombre($cc_votante) {
        // return new Votante(1, "ivan", "villamil", 321, 312, "klasj","email");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://wssisbenconsulta.sisben.gov.co/DNP_SisbenConsulta/DNP_SISBEN_Consulta.aspx");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "__EVENTTARGET=&__EVENTARGUMENT=&__VIEWSTATE=X3cFBBdHAULQAa6MyEFrfzXbPgq2Aq9lm4jLXshg0ovIaTX%2BbKTgJolrr8PUp4r9csNLGp6K4xkLzeiIXdDkelm%2BTei6l9NJKZ%2Bv9J38kjfY304mBckjh2Iv87yuD1O83JxbdjkCSl3bl9Iqb%2F5qV%2B5f70LaxXMDgu5xj0Axb7mqATrzzZezk676SNVUV%2BpXooMHSSwnpozqZXSDF%2BImQvqbpN31DVyniJ6Gv0R%2F3LCOD4nc3dpI1SbYIa3PEyKd1B0r5lG4cVOEidqHtS1xN9FvsYHmcahZpFKFhokb%2BiS6iTgx4tkcZ8ivIQ03m4%2FCC0H5rAELM%2BDiKTw5lQcZ2Vz%2BWafINolM5dXIJy5cCSviaOi2wBI6jvcEhfoYKXioG0lOu8OdPJ9yz1jWsWDRhXYR3DFkjIp9W75mFidSBPDJr4wkyNTh0TjuAlhLpFX4b1aWDcN796IETn74zxOGMs4QcbWBAsbEIw3lxtXTprkvedleirXOG23UDDfeVs3I2NFhq0C%2BdDqpi5mZ%2BEy%2F%2F3pvms69Qt3Lmh1bZOiwZch0OHZBAAPX6z%2FRrrxrKQ0xMrr3hb2qF3TLXtHqjWDHswf4rAU%2FGCYIwFGahrXDnE5DRkQJDFleBCWeLZSSr07rhyBKmUghjjP2svves3Q5exb7yUcvJLd3vJLExk8Iz1uU3JuxMoDhjYnqhuJ0OmBPmSfBHTY%2BYrbHA%2BTFflC3HrZyXjvr%2BqWikWowYd5cPdTUCwFAyhMn1z4xw3B6NWHeqG7IcaJnzLf%2FoIQy6MMfbui8p7T8Kl6zHMCpwN%2BVUN%2FkPL8F5Q7ALOFo9UcfdqtDn2hqcejS46VOgEKc9Llmg3Vm0EYDoXEvgiAdy6hUR5WHx7voy9FzFNwwNG71dCTLwqNMA57tlrU%2FwjJw3WJCB374OADXspP9v%2Ba66M476H8gk4m8ESLGggyUtqw2T%2Fukd5wXilDJFyMBVJjVLFqp%2Frm0GPNljiCvmsYXY5zIF1%2FJcjJoZvquOp8nLAvNKSe5bFO5qL%2F0C7qkpzMB9kyKnmIHlaSpea%2B2tM7iuN6BBF9JVv93iF4qvkjq8u1u2iyPkhvmgiLNGBb1roCACoYJeLGeeuyZlvtDl8NXlTLCStwr87j5WjOxXSBkBZXnrW58PHQ4kFZTf38aQdVQMKXdMyhZWh8Op55%2FTsJIlRyhIiUGAkSo%2BsJdg%2BgL01MtqGNadWrifq%2Bmy77xE1fNplYtpGVNHCKRb5uLjmY%2FncoxcF8Q3FWFuEylzyF676K5olEPsds5SMdtn4ioY%2FTQCvaHzOZihr7Wz1SKvXMbJAbKM8LPuBRQPAJTrHlJg1PGgNQlhf%2BRn6X7h8JftMgK2ohYxbsWxeLcl9fq1gM7sPP88p%2Bq18O01apf7yMuv3CxqkpYkIsN7p6Tcyh0Q41yZMI4Eh7nzRwcSdKM2NEyb7tVbiUvWLbMpHbEsPu4LBWXRSvLlMWf%2FFjZR4tqMhhlpFGfwjJIGg8bvvyBzUR10bqZvj8f99Fw2WE4SQ9s0HXlOcBrT8VhkS5zchcbMdm9hGtBRDrl98DZOvNgfPRlThDJfnw%3D&__VIEWSTATEGENERATOR=2AB62757&__VIEWSTATEENCRYPTED=&__EVENTVALIDATION=MB5KwTsCcGKOIwpFBmKvKojfLJsCQft9o0iu00mhwaAlY0mDbP1hbxZLsZ%2BIBiXkGwzbEYFaUUXAXfvTdWfkYnGTc%2BgF4FwbRlgxMPQyq9UnE1eKDugTuNuBHB9zk7TWxcE0zVovWWxDPoJda2tjAcF%2FPHBAZ5OCNIIIXTIbfUofpi12a%2F%2Fe9Yg5vJg8J557ROZ2dQEeahxwBQq42u%2FAcyjS%2BNjRmt0u1qIe%2FRMZrzzyzhXsGsWGv6o7v1hXNTcF4D08SQIiTNpMGNpPOvMST%2FfdTG4tq1MP80lfjj3YEFI%3D&ddlTipoDocumento=1&tboxNumeroDocumento=" . $cc_votante . "&btnConsultar=Consultar
");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $es = curl_exec($ch);
        curl_close($ch);
        $es = strip_tags($es);

        $es = $this->LimpiaTexto_mejorado($es);
        $es = $this->Depurador_mejorado($es);
        if ($es == "@") {

            return NULL;
        }
        if ($es == "error pagina") {

            return 1;
        }
        $lista = $this->Pasarvariables_mejorado($es);
        $lista = $this->espacioscoienzoyfinal_mejorado($lista);
        
        
        if (empty($lista)) {
            return NULL;
        } else {
            $daociudadano = new DAOCiudadano();
            $daociudadano->agregarPersona($cc_votante, $lista[0], $lista[1]);
            return $lista;
        }
    }

////////////////////////////////////////////////////////////////// FUNCIONES ////////////////////////////////////// FUNCIONES ////////////////////////////////////// FUNCIONES ////////////////////////////////////// FUNCIONES
//////////////////////////////////////// FUNCIONES ////////////////////////////////////// FUNCIONES ////////////////////////////////////// FUNCIONES ////////////////////////////////////// FUNCIONES
////////////////////////////////////////////////////////////////// FUNCIONES ////////////////////////////////////// FUNCIONES ////////////////////////////////////// FUNCIONES ////////////////////////////////////// FUNCIONES
////////////////////////////////////// FUNCIONES ////////////////////////////////////// FUNCIONES ////////////////////////////////////// FUNCIONES ////////////////////////////////////// FUNCIONES
    private function puestoVotacion($cedula) {
        try {
            $opciones = array(
                'http' => array(
                    'method' => "GET",
                    'header' => "Accept-language: en\r\n" .
                    "Cookie: foo=bar\r\n"
                )
            );
            $contexto = stream_context_create($opciones);
            $contenido = file_get_contents("http://www3.registraduria.gov.co/censo/_censoresultado.php?nCedula=" . $cedula, false, $contexto);
            $contenido = trim(strip_tags($contenido));
            $buscar = array(chr(13) . chr(10), "\r\n", "\n", "\r",);
            $reemplazar = array("", "", "", "");
            $contenido = str_ireplace($buscar, $reemplazar, $contenido);
            $contenido = str_replace("\r", ". ", $contenido);
            $contenido = str_replace("\n", " ", $contenido);

            $posicion_coincidencia = strpos($contenido, 'Departamento');

            //se puede hacer la comparacion con 'false' o 'true' y los comparadores '===' o '!=='
            if ($posicion_coincidencia === false) {
                //echo "NO se ha encontrado la palabra deseada!!!!";
                $puesto_votacion = array(
                    'DEPARTAMENTO' => '',
                    'MUNICIPIO' => '',
                    'PUESTO' => '',
                    'DIRECCION' => '',
                    'MESA' => '',
                    'FECHA_INSCRIP' => '',
                    'ERROR' => NULL
                );
                $posicion_coincidencia2 = strpos($contenido, 'Cancelada por Muerte');
                if ($posicion_coincidencia2 === false) {
                    $posicion_coincidencia3 = strpos($contenido, 'Debe inscribirse');
                    if ($posicion_coincidencia3 === false) {
                        $posicion_coincidencia4 = strpos($contenido, 'Pendiente por Solicitud en proceso');
                        if ($posicion_coincidencia4 === false) {
                            $posicion_coincidencia5 = strpos($contenido, 'Baja por Perdida o Suspension');
                            if ($posicion_coincidencia5 === false) {
                                $posicion_coincidencia6 = strpos($contenido, 'Por favor intente');
                                if ($posicion_coincidencia6 === false) {
                                    $puesto_votacion = array(
                                        'ERROR' => '<h4>Esta Cédula no se encuentra en la base de datos. Intente nuevamente.</h4>'
                                    );
                                    return $puesto_votacion;
                                } else {
                                    $puesto_votacion = array(
                                        'ERROR' => utf8_decode('La información se encuentra en actualización. Por favor intente más tarde.')
                                    );
                                    return $puesto_votacion;
                                }
                            } else {
                                $puesto_votacion = array(
                                    'ERROR' => 'Cédula dada de baja por Pérdida o Suspensión de Derechos Políticos.'
                                );
                                return $puesto_votacion;
                            }
                        } else {
                            $puesto_votacion = array(
                                'ERROR' => 'Cédula Pendiente por Solicitud en proceso.'
                            );
                            return $puesto_votacion;
                        }
                    } else {
                        $puesto_votacion = array(
                            'ERROR' => 'Cedula No inscrita.'
                        );
                        return $puesto_votacion;
                    }
                } else {
                    $puesto_votacion = array(
                        'ERROR' => 'Cedula Cancelada por Muerte.'
                    );
                    return $puesto_votacion;
                }
                return $puesto_votacion;
            } else {

                $resultado = substr($contenido, 1159, 1702);

                $puesto = explode(':', $resultado);

                //Departamento
                $puesto2 = $this->limpiar_metas($puesto[1], null);
                $puesto2 = explode('Municipio', $puesto2);

                //Municipio
                $puesto3 = $this->limpiar_metas($puesto[2], null);
                $puesto3 = explode('Puesto', $puesto3);

                //Puesto
                $puesto4 = $this->limpiar_metas($puesto[3], null);
                $puesto4 = explode('Direcci', $puesto4);

                //Direccion del Puesto
                $puesto5 = $this->limpiar_metas($puesto[4], null);
                $puesto5 = explode('Fecha', $puesto5);

                //Mesa de Votacion
                $puesto6 = $this->limpiar_metas($puesto[6], null);
                $puesto6 = explode('Censo', $puesto6);
                $puesto6 = $this->limpiar_metas($puesto6[0], null);
                $puesto6 = explode('Mesa', $puesto6);

                //Fecha de inscripcion 
                $puesto7 = $this->limpiar_metas($puesto[5], null);

                $puesto_votacion = array(
                    'DEPARTAMENTO' => trim($puesto2[0]),
                    'MUNICIPIO' => trim($puesto3[0]),
                    'PUESTO' => trim($puesto4[0]),
                    'DIRECCION' => trim($puesto5[0]),
                    'MESA' => trim($puesto6[1]),
                    'FECHA' => trim($puesto7),
                    'ERROR' => NULL
                );
                return $puesto_votacion;
            }
        } catch (Exception $e) {
            $observacion2 = $e->getMessage();
            throw new Exception($observacion2);
        }
    }

    private function limpiar_metas($string, $corte = null) {
        $caracters_no_permitidos = array('"', "'");
        # paso los caracteres entities tipo &aacute; $gt;etc a sus respectivos html
        $s = html_entity_decode($string, ENT_COMPAT, 'UTF-8');
        # quito todas las etiquetas html y php
        $s = strip_tags($s);
        # elimino todos los retorno de carro
        // $s = str_replace("r", '', $s);
        # en todos los espacios en blanco le añado un <br /> para después eliminarlo
        $s = preg_replace('/(?<!>)n/', "<br />n", $s);
        # elimino la inserción de nuevas lineas
        //$s = str_replace("n", '', $s);
        # elimino tabulaciones y el resto de la cadena
        //$s = str_replace("t", '', $s);
        # elimino caracteres en blanco
        $s = preg_replace('/[ ]+/', ' ', $s);
        $s = preg_replace('/<!--[^-]*-->/', '', $s);
        # vuelvo a hacer el strip para quitar el <br /> que he añadido antes para eliminar las saltos de carro y nuevas lineas
        $s = strip_tags($s);
        # elimino los caracters como comillas dobles y simples
        $s = str_replace($caracters_no_permitidos, "", $s);

        if (isset($corte) && (is_numeric($corte))) {
            $s = mb_substr($s, 0, $corte, 'UTF-8');
        }

        return $s;
    }

    private function myErrorHandler($errno, $errstr, $errfile, $errline) {
        if (!(error_reporting() & $errno)) {
            // This error code is not included in error_reporting
            return;
        }

        switch ($errno) {
            case E_USER_ERROR:
                echo "<b>My ERROR</b> [$errno] $errstr<br />\n";
                echo "  Fatal error on line $errline in file $errfile";
                echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
                echo "Aborting...<br />\n";
                exit(1);
                break;

            case E_USER_WARNING:
                echo "<b>My WARNING</b> [$errno] $errstr<br />\n";
                break;

            case E_USER_NOTICE:
                echo "<b>My NOTICE</b> [$errno] $errstr<br />\n";
                break;

            default:
                $puesto = explode(':', $errstr);
                if (!empty($puesto[2]) && !empty($puesto[3]) && trim($puesto[2]) == 'failed to open stream') {
                    echo $puesto[3] . '<br/>http://www3.registraduria.gov.co';
                } else {
                    echo "Unknown error type: [$errno] $errstr<br />\n";
                }
                break;
        }

        /* Don't execute PHP internal error handler */
        return true;
    }

// function to test the error handling
    private function scale_by_log($vect, $scale) {
        if (!is_numeric($scale) || $scale <= 0) {
            trigger_error("log(x) for x <= 0 is undefined, you used: scale = $scale", E_USER_ERROR);
        }

        if (!is_array($vect)) {
            trigger_error("Incorrect input vector, array of values expected", E_USER_WARNING);
            return null;
        }

        $temp = array();
        foreach ($vect as $pos => $value) {
            if (!is_numeric($value)) {
                trigger_error("Value at position $pos is not a number, using 0 (zero)", E_USER_NOTICE);
                $value = 0;
            }
            $temp[$pos] = log($scale) * $value;
        }

        return $temp;
    }

////////////////////////////////////////////////////////////////// FUNCIONES ////////////////////////////////////// FUNCIONES ////////////////////////////////////// FUNCIONES ////////////////////////////////////// FUNCIONES
    private function LimpiaTexto_mejorado($es) {
        $es = str_replace("Nombre:", "*", $es);
        $es = str_replace("Apellidos", "*", $es);
        $es = str_replace("Tipo", "*", $es);
        $es = str_replace("no se encuentra registrada", "@", $es);

        return $es;
    }

////////////////////////////////////////////////////////////////// FUNCIONES ////////////////////////////////////// FUNCIONES ////////////////////////////////////// FUNCIONES ////////////////////////////////////// FUNCIONES
    private function Pasarvariables_mejorado($string) {
        $j = 0;
        $ojo = 0;
        $aux;
        $listaux;
        $listanew;
        $aux = "";
        $lista = str_split($string);
        $listaux = str_split($string);
        for ($x = 0; $x < count($lista); $x++) {
            if ($lista[$x] == '*') {
                $listaux[$j] = $x;
                $ojo++;
                $j = $j + 1;
            }
        }
        if ($ojo == 3) {
            $x = $listaux[0] + 1;
            $j = $listaux[1];
            for ($x; $x < $j; $x++) {
                $aux = $aux . $lista[$x];
            }
            $listanew[0] = $aux;
            $aux = "";
            $x = $listaux[1] + 1;
            $j = $listaux[2];
            for ($x; $x < $j; $x++) {
                $aux = $aux . $lista[$x];
            }
            $listanew[1] = $aux;
        } else {
            $listanew[0] = "NOMBRE NO SE ENCUENTRA EN LA BASE DE DATOS";
            $listanew[1] = "APELLIDOS NO SE ENCUENTRA EN LA BASE DE DATOS";
        }
        return $listanew;
    }

////////////////////////////////////////////////////////////////// FUNCIONES ////////////////////////////////////// FUNCIONES ////////////////////////////////////// FUNCIONES ////////////////////////////////////// FUNCIONES
    private function espacioscoienzoyfinal_mejorado($listanew) {
        $resultado = "";
        for ($x = 0; $x < count($listanew); $x++) {
            $resultado = $listanew[$x];
            $listanew[$x] = trim($resultado);
        }
        return $listanew;
    }

////////////////////////////////////////////////////////////////// FUNCIONES ////////////////////////////////////// FUNCIONES ////////////////////////////////////// FUNCIONES ////////////////////////////////////// FUNCIONES
    private function Depurador_mejorado($es) {
        $lista = str_split($es);
        $j = count($lista);

        for ($x = 0; $x < count($lista); $x++) {
            if ($lista[$x] == "@") {


                return "@";
            }
        }
        if(count($x)<2500){
            return "error pagina";
        }
        for ($x = 0; $x < 2500; $x++) {
            $lista[$x] = '+';
        }
        $x = $j - 2000;
        for ($x; $x < $j; $x++) {
            $lista[$x] = '+';
        }
        $resultado = "";
        $regex = '#^[+]*[A-Z]*[ ]*[*]*$#i';
        $j = 0;
        for ($x = 0; $x < count($lista); $x++) {
            $j++;
            if ((preg_match($regex, $lista[$x])) == 1) {
                $resultado = $resultado . $lista[$x];
            }
        }
        $lista = str_split($resultado);
        $resultado = "";
        $regex = '#^[+]*$#i';
        $j = 0;
        for ($x = 0; $x < count($lista); $x++) {
            $j++;
            if ((preg_match($regex, $lista[$x])) == 1) {
                
            } else {
                $resultado = $resultado . $lista[$x];
            }
        }
        return $resultado;
    }

    private function LimpiaTexto_muerte($es) {
        $es = str_replace("Cancelada por Muerte", "@", $es);


        return $es;
    }

    private function Depurador_muerte($es) {
        $lista = str_split($es);
        $j = count($lista);

        for ($x = 0; $x < count($lista); $x++) {
            if ($lista[$x] == "@") {


                return "m";
            }
        }
    }

}

?>