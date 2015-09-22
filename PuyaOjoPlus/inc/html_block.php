<?php

$root = realpath($_SERVER["DOCUMENT_ROOT"]);
include_once $root . '/puyaOjo/string/idiom_spn.php';
include_once 'DAO/Servicios.php';
include_once 'DAO/DAOListaCandidato_Lider.php';
include_once 'DAO/DAOCandidato.php';
include_once 'DAO/DAOLider.php';
include_once 'DAO/DAOListaLider_Votante.php';
include_once 'DAO/Conexion.php';
include_once 'DAO/InscripcionCandidato.php';
include_once 'DAO/DAOVotaciones.php';
include_once 'DAO/DAOAlianza.php';


//$user = $_SESSION['user'];



if (isset($_GET["op"]) && !empty($_GET["op"])) {
    $op = $_GET["op"];
    switch ($op) {
        case 1:
            $element = new ElementHTML();
            $element->load_modal_add_voter();
            break;
    }
}

class ElementHTML {

    private $idiom;
    private $host;

    function __construct() {
        $this->idiom = new Idiom();
        $this->host = "http://localhost/electoral/";
    }

    function load_navbar() {
        $tipo = $_SESSION['tipo'];
        $name = $_SESSION['name'];
        $user = $_SESSION['user'];
        $lastname = $_SESSION['lastname'];
        $inscripcion = new InscripcionCandidato();
        $servicio = new Servicios();
        echo '<aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src= '.$servicio->mostrarFoto($_SESSION['user']).' class="img-circle" alt="User Image">
                        </div>
                        <div class="pull-left info">
                            <p class="test">'.$name.' '.$lastname.'</p>
                            
                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                    <form action="result_service.php" method="post" class="sidebar-form">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="' . $this->idiom->getLabel_query_place() . '">
                            <span class="input-group-btn">
                                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">';
        if ($tipo == 1) {
                        echo '<li class="treeview">
                            <a href="votacion.php">
                                <i class="fa fa-get-pocket"></i>
                                <span>Escrutinio</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            
                        </li>';
            echo '<li class="treeview">
                            <a href="#">
                                <i class="fa fa-users"></i>
                                <span>' . $this->idiom->getLabel_leaders() . '</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="leaders.php"><i class="fa fa-map-o"></i>' . $this->idiom->getView_leaders() . '</a></li>
                                <li><a href="add_leader.php"><i class="fa fa-user-plus"></i> Agregar Lider</a></li>
                            </ul>
                        </li>';
        } echo '<li class="treeview">
                            <a href="#">
                                <i class="fa fa-user"></i>
                                <span>' . $this->idiom->getLabel_voter() . '</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="voters.php"><i class="fa fa-map-o"></i>' . $this->idiom->getView_voters() . '</a></li>
                                <li><a href="addVoter.php"><i class="fa fa-user-plus"></i> Agregar Votante</a></li>
                            </ul>
                        </li>';
        if ($tipo == 1) {
            $inscripcion=$inscripcion->mostrarCandidato($user);
            if ($inscripcion[9]!="JAL" && $inscripcion[9]!= "CONCEJO"){
            echo '<li class="treeview">
                            <a href="#">
                                <i class="fa fa-get-pocket"></i>
                                <span>Candidatos</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="candidate.php"><i class="fa fa-map-o"></i> Mostrar Candidatos</a></li>
                                <li><a href="pages/UI/general.html"><i class="fa fa-user-plus"></i> Agregar Candidato</a></li>
                            </ul>
                        </li>';
            
            
            }
            echo '<li class="treeview">
                            <a href="#">
                                <i class="fa fa-get-pocket"></i>
                                <span>Puya Ojo</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            
                        </li>';
        }
        echo '</ul>
                </section>
                <!-- /.sidebar -->
            </aside>
';
    }

    function load_table_votacion($puesto,$user) {
         if($_SESSION['tipo']==1){
            $daoVotaciones = new DAOVotaciones();
            $user = $_SESSION['user'];
            $daoinscripcion = new InscripcionCandidato();
            $inscripcion=$daoinscripcion->mostrarCandidato($user);
            if($inscripcion[9]=="JAL" || $inscripcion[9]== "CONCEJO" || $inscripcion[9]=="ALCALDE"){
                if($puesto==NULL){
                $votacion = $daoVotaciones->conteo_Candidato_puesto($inscripcion[6], $inscripcion[7], $user);
                echo '<thead><tr>
                <th class="text-center"><strong>Accion</strong></th>
                <th class="text-center"><strong>Puesto de Votación</strong></th>
                <th class="text-center"><strong>Votos</strong></th>
                </tr>
                </thead>
                <tbody>';
                    for ($x=1; $x<count($votacion); $x++) {
                        echo '<tr>
                        <td><a href=votacion.php?puesto='.str_replace(" ", "_", $votacion[$x][0]).' title="Ver"><span  class="glyphicon glyphicon-eye-open"></span></a></td>
                        <td>' . $votacion[$x][0] . '</td>
                        <td>' . $votacion[$x][1] . '</td>
                        </tr>';
                    }
                echo '</tbody>';
            }
            }  
            if($puesto!=NULL) {
                $puesto= str_replace("_", " ", $puesto);
                $votacion = $daoVotaciones->conteo_Candidato_Mesa($inscripcion[6], $inscripcion[7],$puesto, $user);
                echo '<thead><tr>

                <th class="text-center"><strong>No Mesa</strong></th>
                <th class="text-center"><strong>Votos</strong></th>
                </tr>
                </thead>
                <tbody>';
                    for ($x=1; $x<count($votacion); $x++) {
                        echo '<tr>
                        <td>' . $votacion[$x][0] . '</td>
                        <td>' . $votacion[$x][1] . '</td>
                        </tr>';
                    }
                echo '</tbody>';
            }
        }
    }
    
    function load_tabla_voters($user) {
       if($_SESSION['tipo']==1){
        $daoCandidato = new DAOCandidato();
        
        echo '<thead><tr>
                    <th class="text-center"><strong>Acción</strong></th>
                    <td class="text-center"><strong>Cédula de ciudadanía</strong></td>
                    <td class="text-center"><strong>Nombre</strong></td>
                    <td class="text-center"><strong>Apellidos</strong></td>
                    <td class="text-center"><strong>Departamento</strong></td>
                    <td class="text-center"><strong>Municipio</strong></td>
                    <td class="text-center"><strong>Puesto</strong></td>
                    <td class="text-center"><strong>Mesa</strong></td>
                </tr></thead>';

        $lista = $daoCandidato->mostrarVotantes($user);
        for ($x = 0; $x < count($lista); $x++) {
            echo '
                    <tr>
                        <td><label onclick="alerta();"><span  class="glyphicon glyphicon-eye-open"></span></label></td>
                        <td>' . $lista[$x][0] . '</td>
                        <td>' . $lista[$x][1] . '</td>
                        <td>' . $lista[$x][2] . '</td>
                        <td>' . $lista[$x][3] . '</td>
                        <td>' . $lista[$x][4] . '</td>
                        <td>' . $lista[$x][5] . '</td>
                        <td>' . $lista[$x][6] . '</td>
                    </tr>';
        }
        echo '</tbody>';
        }
        
        if($_SESSION['tipo']==2){
        $daoL_V = new DAOListaLider_Votante();
        echo '<thead><tr>
                    <th class="text-center"><strong></strong></th>
                    <th class="text-center"><strong>Acción</strong></th>
                    <td class="text-center"><strong>Cédula de ciudadanía</strong></td>
                    <td class="text-center"><strong>Nombre</strong></td>
                    <td class="text-center"><strong>Apellidos</strong></td>
                    <td class="text-center"><strong>Departamento</strong></td>
                    <td class="text-center"><strong>Municipio</strong></td>
                    <td class="text-center"><strong>Puesto</strong></td>
                    <td class="text-center"><strong>Mesa</strong></td>
                </tr></thead>';

        $lista = $daoL_V->mostrarVotantesLider($user);
        for ($x = 0; $x < count($lista); $x++) {
            echo '
                    <tr>
                        <td><div class="checkbox" style="margin: 0px;">
                        <label>
                            <input type="checkbox" name="del" data-col="' . $lista[$x][0] . '">
                        </label>
                        </div>
                        </td>
                        <td><label onclick="alerta();"><span  class="glyphicon glyphicon-eye-open"></span></label></td>
                        <td>' . $lista[$x][0] . '</td>
                        <td>' . $lista[$x][1] . '</td>
                        <td>' . $lista[$x][2] . '</td>
                        <td>' . $lista[$x][3] . '</td>
                        <td>' . $lista[$x][4] . '</td>
                        <td>' . $lista[$x][5] . '</td>
                        <td>' . $lista[$x][6] . '</td>
                    </tr>';
        }
        echo '</tbody>';
        }
        
    }
    function load_tabla_candidates($id_candidato) {
        echo '<thead><tr>
                    <th class="text-center"><strong>Acción</strong></th>
                    <th class="text-center"><strong>Cédula de ciudadanía</strong></th>
                    <th class="text-center"><strong>Nombres</strong></th>
                    <th class="text-center"><strong>Apellidos</strong></th>
                    <th class="text-center"><strong>Partido</strong></th>
                    <th class="text-center"><strong>Votación Total</strong></th>
                    
                </tr>
            </thead><tbody>';

        $dao = new DAOAlianza();
        $lista = $dao->mostrarcandidatos($id_candidato);
        for ($x = 0; $x < count($lista); $x++) {
            
            echo '
                    <tr>
                        <td><a href="/puyaOjo/pages/profile.php?id='.$lista[$x][0].'" title="Ver"><span  class="glyphicon glyphicon-eye-open"></span></a></td>
                        <td>' . $lista[$x][0] . '</td>
                        <td>' . $lista[$x][1] . '</td>
                        <td>' . $lista[$x][2] . '</td>
                        <td>' . $lista[$x][3] . '</td>
                        <td>' . $lista[$x][4] . '</td>
                        
                    </tr>';
        }
        echo '</tbody>';
    }
    
    function load_tabla_leaders($id_candidato) {
        echo '<thead><tr>
                    <th class="text-center"><strong>Acción</strong></th>
                    <th class="text-center"><strong>Cédula de ciudadanía</strong></th>
                    <th class="text-center"><strong>Nombres</strong></th>
                    <th class="text-center"><strong>Apellidos</strong></th>
                    <th class="text-center"><strong>Total Votacion</strong></th>
                </tr>
            </thead><tbody>';

        $dao = new DAOListaCandidato_Lider();
        $lista = $dao->mostrarLideres($id_candidato);
        for ($x = 0; $x < count($lista); $x++) {
            
            echo '
                    <tr>
                       
                        <td><a href="/puyaOjo/pages/profile.php?id='.$lista[$x][6].'" title="Ver"><span  class="glyphicon glyphicon-eye-open"></span></a></td>
                        <td>' . $lista[$x][0] . '</td>
                        <td>' . $lista[$x][1] . '</td>
                        <td>' . $lista[$x][2] . '</td>
                        <td>' . $lista[$x][7] . '</td>
                    </tr>';
        }
        echo '</tbody>';
    }

    function add_leader($documento) {
        if ($documento != "") {
            $service = new Servicios();
            $persona = $service->consultar($documento);
            if ($persona->getPuesto()->getMunicipio() == null) {
                echo '
<style>
#myBtn {
    width: 300px;
    padding: 10px;
    font-size:20px;
    position: absolute;
    margin: 0 auto;
    right: 0;
    left: 0;
    bottom: 50px;
    z-index: 9999;
}
</style>             
<div class="container">
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h2 class="modal-title">Error</h2>
        </div>
        <div class="modal-body">
          <p>' . $persona->getPuesto()->getDepartamento() . '</p>
 <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
        </div>
      </div>
      
    </div>
  </div>
</div>
 
<script>
$(document).ready(function(){
    // Show the Modal on load
    $("#myModal").modal("show");
    
    // Hide the Modal
    $("#myBtn").click(function(){
        $("#myModal").modal("hide");
    });
});
</script>';
                echo '<div class="modal-header">
                                <h4 class="modal-title">' . $this->idiom->getAdd_leader() . '</h4>
                            </div>
                            <div class="modal-body">
                                <form role="form" id="log_in" action="../inc/control_add.php?op=1" method="post">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="modal_cc">' . $this->idiom->getModal_label_cc() . '</label>
                                            <div class="input-group">
                                                <input type="text" name="cc" value="' . $documento . '" class="form-control" id="s_cc" onkeypress="return justNumbers(event);">
                                                <a class="input-group-addon" id="btn-q-l" href="#"><span class="glyphicon glyphicon-search"></span></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="modal_name">' . $this->idiom->getModal_label_name() . '</label>
                                            <input type="text" name="nombre" class="form-control" id="modal_name">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="modal_lastname">' . $this->idiom->getModal_label_lastname() . '</label>
                                            <input type="text" name="apellido" class="form-control" id="modal_lastname">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="modal_tel">' . $this->idiom->getModal_label_tel() . '</label>
                                            <input type="tel" name="tel" class="form-control" id="modal_tel" onkeypress="return justNumbers(event);">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="modal_tel">' . $this->idiom->getModal_label_cel() . '</label>
                                            <input type="tel" name="cel" class="form-control" id="modal_tel" onkeypress="return justNumbers(event);">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="modal_departament">' . $this->idiom->getModal_label_departament() . '</label>
                                            <input type="text" name="departamento" class="form-control" id="modal_departament" text="si escribe">
                                        </div>     
                                        <div class="col-md-6">
                                            <label for="modal_town">' . $this->idiom->getModal_label_town() . '</label>
                                            <input type="text" name="municipio" class="form-control" id="modal_town">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="modal_place">' . $this->idiom->getModal_label_place() . '</label>
                                            <input type="text" name="puesto" class="form-control" id="modal_place">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="modal_dir_place">' . $this->idiom->getModal_label_dir_place() . '</label>
                                            <input type="text" name="dir_puesto" class="form-control" id="modal_dir_place">
                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom: 10px;">
                                        <div class="col-md-6">
                                            <label for="modal_table">' . $this->idiom->getModal_label_table() . '</label>
                                            <input type="text" name="mesa" class="form-control" id="modal_table" onkeypress="return justNumbers(event);">
                                        </div>
                                    </div>';
            }
            if ($persona->getPuesto()->getMunicipio() != null) {
                echo '<div class="modal-header">
                                <h4 class="modal-title">' . $this->idiom->getAdd_leader() . '</h4>
                            </div>
                            <div class="modal-body">
                                <form role="form" id="log_in" action="../inc/control_add.php?op=1" method="post">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="modal_cc">' . $this->idiom->getModal_label_cc() . '</label>
                                            <div class="input-group">
                                                <input type="text" name="cc" value="' . $documento . '" class="form-control" id="s_cc" onkeypress="return justNumbers(event);">
                                                <a class="input-group-addon" id="btn-q-l" href="#"><span class="glyphicon glyphicon-search"></span></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="modal_name">' . $this->idiom->getModal_label_name() . '</label>
                                            <input type="text" name="nombre" value="' . $persona->getNombre() . '" class="form-control" id="modal_name">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="modal_lastname">' . $this->idiom->getModal_label_lastname() . '</label>
                                            <input type="text" name="apellido" value="' . $persona->getApellido() . '" class="form-control" id="modal_lastname">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="modal_tel">' . $this->idiom->getModal_label_tel() . '</label>
                                            <input type="tel" name="tel" value="' . $persona->getTelefono() . '" class="form-control" id="modal_tel" onkeypress="return justNumbers(event);">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="modal_tel">' . $this->idiom->getModal_label_cel() . '</label>
                                            <input type="tel" name="cel" value="' . $persona->getCelular() . '" class="form-control" id="modal_tel" onkeypress="return justNumbers(event);">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="modal_departament">' . $this->idiom->getModal_label_departament() . '</label>
                                            <input type="text" name="departamento" value="' . $persona->getPuesto()->getDepartamento() . '" class="form-control" id="modal_departament" text="si escribe">
                                        </div>     
                                        <div class="col-md-6">
                                            <label for="modal_town">' . $this->idiom->getModal_label_town() . '</label>
                                            <input type="text" name="municipio" value="' . $persona->getPuesto()->getMunicipio() . '" class="form-control" id="modal_town">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="modal_place">' . $this->idiom->getModal_label_place() . '</label>
                                            <input type="text" name="puesto" value="' . $persona->getPuesto()->getPuesto() . '" class="form-control" id="modal_place">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="modal_dir_place">' . $this->idiom->getModal_label_dir_place() . '</label>
                                            <input type="text" name="dir_puesto" value="' . $persona->getPuesto()->getDir_puesto() . '" class="form-control" id="modal_dir_place">
                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom: 10px;">
                                        <div class="col-md-6">
                                            <label for="modal_table">' . $this->idiom->getModal_label_table() . '</label>
                                            <input type="text" name="mesa" value="' . $persona->getPuesto()->getMesa() . '" class="form-control" id="modal_table" onkeypress="return justNumbers(event);">
                                        </div>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" >' . $this->idiom->getBtn_save() . '</button>
                            </div>';
            }
        } else {
            echo '<div class="modal-header">
                                <h4 class="modal-title">' . $this->idiom->getAdd_leader() . '</h4>
                            </div>
                            <div class="modal-body">
                                <form role="form" id="log_in" action="#" method="post">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="modal_cc">' . $this->idiom->getModal_label_cc() . '</label>
                                            <div class="input-group">
                                                <input type="text" name="cc" class="form-control" id="s_cc" onkeypress="return justNumbers(event);">
                                                <a class="input-group-addon" id="btn-q-l" href="#"><span class="glyphicon glyphicon-search"></span></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="modal_name">' . $this->idiom->getModal_label_name() . '</label>
                                            <input type="text" name="nombre" class="form-control" id="modal_name">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="modal_lastname">' . $this->idiom->getModal_label_lastname() . '</label>
                                            <input type="text" name="apellido" class="form-control" id="modal_lastname">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="modal_tel">' . $this->idiom->getModal_label_tel() . '</label>
                                            <input type="tel" name="tel" class="form-control" id="modal_tel" onkeypress="return justNumbers(event);">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="modal_tel">' . $this->idiom->getModal_label_cel() . '</label>
                                            <input type="tel" name="cel" class="form-control" id="modal_tel" onkeypress="return justNumbers(event);">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="modal_departament">' . $this->idiom->getModal_label_departament() . '</label>
                                            <input type="text" name="departamento"class="form-control" id="modal_departament" text="si escribe">
                                        </div>     
                                        <div class="col-md-6">
                                            <label for="modal_town">' . $this->idiom->getModal_label_town() . '</label>
                                            <input type="text" name="municipio" class="form-control" id="modal_town">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="modal_place">' . $this->idiom->getModal_label_place() . '</label>
                                            <input type="text" name="puesto" class="form-control" id="modal_place">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="modal_dir_place">' . $this->idiom->getModal_label_dir_place() . '</label>
                                            <input type="text" name="dir_puesto" class="form-control" id="modal_dir_place">
                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom: 10px;">
                                        <div class="col-md-6">
                                            <label for="modal_table">' . $this->idiom->getModal_label_table() . '</label>
                                            <input type="text" class="form-control" id="modal_table" onkeypress="return justNumbers(event);">
                                        </div>
                                    </div>';
        }
    }

    function add_voter() {
        echo '<div class="modal-header">
                                <h4 class="modal-title">' . $this->idiom->getAdd_voter() . '</h4>
                            </div>
                            <div class="modal-body">
                                <form role="form" id="log_in" action="#" method="get">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="modal_cc">' . $this->idiom->getModal_label_cc() . '</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" onkeypress="return justNumbers(event);">
                                                <a class="input-group-addon" id="btn-a" href="#"><span class="glyphicon glyphicon-search"></span></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="modal_name">' . $this->idiom->getModal_label_name() . '</label>
                                            <input type="text" class="form-control" id="modal_name">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="modal_lastname">' . $this->idiom->getModal_label_lastname() . '</label>
                                            <input type="text" class="form-control" id="modal_lastname">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="modal_tel">' . $this->idiom->getModal_label_tel() . '</label>
                                            <input type="tel" class="form-control" id="modal_tel" onkeypress="return justNumbers(event);">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="modal_tel">' . $this->idiom->getLabel_email() . '</label>
                                            <input type="tel" class="form-control" id="modal_tel" onkeypress="return justNumbers(event);">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="modal_departament">' . $this->idiom->getModal_label_departament() . '</label>
                                            <input type="text" class="form-control" id="modal_departament" text="si escribe">
                                        </div>     
                                        <div class="col-md-6">
                                            <label for="modal_town">' . $this->idiom->getModal_label_town() . '</label>
                                            <input type="text" class="form-control" id="modal_town">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="modal_place">' . $this->idiom->getModal_label_place() . '</label>
                                            <input type="text" class="form-control" id="modal_place">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="modal_dir_place">' . $this->idiom->getModal_label_dir_place() . '</label>
                                            <input type="text" class="form-control" id="modal_dir_place">
                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom: 10px;">
                                        <div class="col-md-6">
                                            <label for="modal_table">' . $this->idiom->getModal_label_table() . '</label>
                                            <input type="text" class="form-control" id="modal_table" onkeypress="return justNumbers(event);">
                                        </div>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" >' . $this->idiom->getBtn_save() . '</button>
                            </div>';
    }

    function load_modal_add_voter() {
        echo '<div class="modal-header">
                        <h4 class="modal-title">' . $this->idiom->getModal_add_voter() . '</h4>
                    </div>
                    <div class="modal-body">
                        <form role="form" id="log_in" action="voters.php" method="get">
                            <label for="modal_cc">' . $this->idiom->getModal_label_cc() . '</label>
                            <div class="input-group">
                                <input type="text" class="form-control" onkeypress="return justNumbers(event);">
                                <a class="input-group-addon" id="btn-a" href="#"><span class="glyphicon glyphicon-search"></span></a>
                            </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="modal_name">' . $this->idiom->getModal_label_name() . '</label>
                                        <input type="text" class="form-control" id="modal_name" value="Nombre de la registraduria">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="modal_lastname">' . $this->idiom->getModal_label_lastname() . '</label>
                                        <input type="text" class="form-control" id="modal_lastname">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="modal_tel">' . $this->idiom->getModal_label_tel() . '</label>
                                        <input type="tel" class="form-control" id="modal_tel" onkeypress="return justNumbers(event);">
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="modal_departament">' . $this->idiom->getModal_label_departament() . '</label>
                                        <input type="text" class="form-control" id="modal_departament" text="si escribe">
                                    </div>     
                                    <div class="col-md-6">
                                        <label for="modal_town">' . $this->idiom->getModal_label_town() . '</label>
                                        <input type="text" class="form-control" id="modal_town">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="modal_place">' . $this->idiom->getModal_label_place() . '</label>
                                        <input type="text" class="form-control" id="modal_place">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="modal_dir_place">' . $this->idiom->getModal_label_dir_place() . '</label>
                                        <input type="text" class="form-control" id="modal_dir_place">
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom: 10px;">
                                    <div class="col-md-6">
                                        <label for="modal_table">' . $this->idiom->getModal_label_table() . '</label>
                                        <input type="text" class="form-control" id="modal_table" onkeypress="return justNumbers(event);">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" >' . $this->idiom->getBtn_save() . '</button>
                            </div>
                        </form>';
    }

    function barraEstadistica($user){
        $daocandidado = new DAOCandidato();
                                    $daoC_L = new DAOListaCandidato_Lider();
                                        $lideres = $daoC_L->mostrarLideres($user);
                                        if(count($lideres)<5){
                                        for ($x = 0; $x < count($lideres); $x++) {
                                            $porcentaje=($lideres[$x][7]*100)/$lideres[0][7];
                                            echo '<div class="progress-group">'
                                        . '<span class="progress-text">'.$lideres[$x][1].' '.$lideres[$x][2].'</span>
                                        <span class="progress-number"><b>'.$lideres[$x][7].'</b>/'.$daocandidado->TotalVotos($user).'</span>
                                        <div class="progress sm">
                                            <div class="'.  $this->colorBarras($x).'" style="width: '.$porcentaje.'%"></div>
                                        </div>
                                    </div><!-- /.progress-group -->';
                                        }
    }
                                        
        
    }
    private function colorBarras($x){
                                            if($x==0){
                                                return "progress-bar progress-bar-aqua";
                                            }
                                             if($x==1){
                                                return "progress-bar progress-bar-red";
                                            }
                                            if($x==2){
                                                return "progress-bar progress-bar-green";
                                            }
                                            if($x==3){
                                                return "progress-bar progress-bar-yellow";
                                            }
                                            if($x==4){
                                                return "progress-bar progress-bar-light-blue";
                                            }
    }
    
    function perfil ($id_lider ){
//        $id_lider=4;
        $servicio = new Servicios();
        if($servicio->validador($id_lider)!=0){
            
        $persona = new DAOPersona();
        $daolider = new DAOLider();
        $daopuesto = new DAOPuestoVotacion();
        $puesto = $daopuesto->muestraPuestoVotacion($id_lider );
        
        $user = $_SESSION['user'];
        $persona = $persona->consultar($id_lider);
        
        $tipo= $_SESSION['tipo'];
        if($tipo==1){
            $votos=$daolider->TotalVotos($user , $id_lider);
        }
         if($tipo==2){
             $daocandidato = new DAOCandidato();
             $id_candidato= $daocandidato->consultarIdCandidato($user);
            $votos=$daolider->TotalVotos($id_candidato[0], $user);
        }
        
        echo '<div class="content-wrapper">
                <!-- Content Header (Page header) -->
                
              
      <!-- Content Wrapper. Contains page content -->
             <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Perfil
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            
            <li class="active">Perfil</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">

          <div class="row">
            <div class="col-md-3">

              <!-- Profile Image -->
              <div class="box box-primary">
                <div class="box-body box-profile">
                  <img class="profile-user-img img-responsive img-circle" src= '.$servicio->mostrarFoto($_SESSION['user']).' alt="User profile picture">
                  <h3 class="profile-username text-center">'.$persona->getNombre().' '.$persona->getApellido().'</h3>
                  
                   <p class="text-muted text-center">LIDER</p>

                  <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                      <b>Votación Total </b> <a class="pull-right">'.$votos.'</a>
                    </li>
                    <li class="list-group-item">
                      <b>Departamento</b> <a class="pull-right">'.$puesto->getMunicipio().'</a>
                    </li>
                    <li class="list-group-item">
                      <b>Municipio</b> <a class="pull-right">'.$puesto->getPuesto().'</a>
                    </li>
                  </ul>

                  <a href="#" class="btn btn-primary btn-block"><b>Votantes</b></a>
                </div><!-- /.box-body -->
              </div><!-- /.box -->


            </div><!-- /.col -->
            <div class="col-md-9">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#settings" data-toggle="tab">Datos del Perfil</a></li>
                </ul>
                <div class="tab-content">


                  <div class="active tab-pane" id="settings">
                    <form class="form-horizontal">
                      <div class="form-group">
                        <label for="inputName" class="col-sm-2 control-label">Cedula</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" id="cedula" placeholder="'.$persona->getCedula().'">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputEmail" class="col-sm-2 control-label">Nombre</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" id="mbreno" placeholder="'.$persona->getNombre().'">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputName" class="col-sm-2 control-label">Apellido</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="apellido" placeholder="'.$persona->getApellido().'">
                        </div>
                      </div>
                        <div class="form-group">
                        <label for="inputName" class="col-sm-2 control-label">Telefono</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="telefono" placeholder="'.$persona->getTelefono().'">
                        </div>
                      </div>
                        <div class="form-group">
                        <label for="inputName" class="col-sm-2 control-label">Celular</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="celular" placeholder="'.$persona->getCelular().'">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputExperience" class="col-sm-2 control-label">Direción</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="direccion" placeholder="'.$persona->getDireccion().'">
                        </div>
                      </div>
                     <div>
                        <a href="/puyaOjo/pages/profile.php?cedula=4"> Modificar </a>
                        </div>
                      <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                          <button type="submit"  class="btn btn-danger">Guardar Datos</button>
                        </div>
                      </div>
                    </form>
                  </div><!-- /.tab-pane -->
                </div><!-- /.tab-content -->
              </div><!-- /.nav-tabs-custom -->
            </div><!-- /.col -->
          </div><!-- /.row -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->';
        }else{
           
        }
    }
    function logoPartido($user){
        $tipo= $_SESSION['tipo'];
        $servicio = new Servicios();
        if($tipo==1){
            $daoinscripcion = new InscripcionCandidato();
        $inscripcion = $daoinscripcion->mostrarCandidato($user);
        echo ' <div class="box box-danger">
                                <div class="box-header "></div>
                                <div class="text-center">
                                    <img src='.$servicio->mostrarLogoPartido($_SESSION['user']).' class="user-image" alt="User Image">
                                    <div class="box-header with-border">
                                        
                                    </div>
                                </div>
               </div>';
        }
        
    }
    
    function VotacionTotal($user){
        $tipo= $_SESSION['tipo'];
        if($tipo==1){
            $daocandidato = new DAOCandidato();
            
            echo '<div class="box box-danger">
                                
                                <div class="text-center">
                                    <div class="box-header with-border">
                                        <p class="text-center"><h1> <strong>Votación Total</strong></h1></p>
                                        <p class="text-center"><h1> <strong>'.$daocandidato->TotalVotos($user).'</strong></h1></p>
                                    </div>
                  </div>';
        }
        
    }
            
    function getHost() {
        return $this->host;
    }
    
}

?>