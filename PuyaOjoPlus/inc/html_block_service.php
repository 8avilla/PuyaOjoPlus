<?php

include_once 'DAO/Servicios.php';
include_once '../string/idiom_spn.php';
include_once 'modelo_logico/Persona.php';

if (isset($_GET["doc"])) {
    cargar_resultado($_GET["doc"]);
}

function cargar_resultado($documento) {
    $service = new Servicios();
    $persona = $service->consultar($documento);
    $error = null;
    if ($documento == "") {
        $error = "Es necesario digitar una cédula";
        $persona = new Persona("No encontrado", "No encontrado", "No encontrado", "No encontrado", "No encontrado", "No encontrado", "No encontrado", new PuestoVotacion("No encontrado", "No encontrado", "No encontrado", "No encontrado", "No encontrado"));
    } else if ($persona->getPuesto()->getMunicipio() == null) {
        $error = $persona->getPuesto()->getDepartamento();
        $persona = new Persona("No encontrado", "No encontrado", "No encontrado", "No encontrado", "No encontrado", "No encontrado", "No encontrado", new PuestoVotacion("No encontrado", "No encontrado", "No encontrado", "No encontrado", "No encontrado"));
    }
    echo '
                    <table class="table table-bordered table-striped">
                        <tr>
                            <td><strong>Cédula de ciudadanía:</strong></td>
                            <td>' . $persona->getCedula() . '</td>
                        </tr>
                        <tr>
                            <td><strong>Nombre:</strong></td>
                            <td>' . $persona->getNombre() . '</td>
                        </tr>
                        <tr>
                            <td><strong>Apellidos:</strong></td>
                            <td>' . $persona->getApellido() . '</td>
                        </tr>
                        <tr>
                            <td><strong>Departamento:</strong></td>
                            <td>' . $persona->getPuesto()->getMunicipio() . '</td>
                        </tr>
                        <tr>
                            <td><strong>Municipio:</strong></td>
                            <td>' . $persona->getPuesto()->getPuesto() . '</td>
                        </tr>
                        <tr>
                            <td><strong>Puesto de votación:</strong></td>
                            <td>' . $persona->getPuesto()->getDir_puesto() . '</td>
                        </tr>
                        <tr>
                            <td><strong>Dirección del puesto:</strong></td>
                            <td>' . $persona->getPuesto()->getMesa() . '</td>
                        </tr>
                        <tr>
                            <td><strong>Mesa:</strong></td>
                            <td>' . $persona->getPuesto()->getDepartamento() . '</td>
                        </tr>
                    </table>';
    if ($error != null) {
        load_modal($error);
    } else {
        echo '<div>
                <div class="text-right">
                    <button type="button " class="btn btn-primary" data-toggle="modal" data-target="#myModal">agregar</button>
                </div>
              </div>';
        load_modal_add_leader($persona->getArray());
    }
}

function load_modal($error) {
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
          <p>' . $error . '</p>
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
}

function load_modal_add_leader($persona) {
    $persona = new Persona($persona["cc"], $persona["nombre"], $persona["apellido"], $persona["tel"], $persona["cel"], $persona["dir"], $persona["email"], new PuestoVotacion($persona["departamento"], $persona["municipio"], $persona["puesto"], $persona["dir_puesto"], $persona["mesa"]));
    $idiom = new Idiom();
    echo '<div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">' . $idiom->getModal_add_voter() . '</h4>
                    </div>
                    <div class="modal-body">
                        <form role="form" id="log_in" action="../inc/control_add.php?op=1" method="post">
                            <label for="modal_cc">' . $idiom->getModal_label_cc() . '</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="cc" onkeypress="return justNumbers(event);" value="' . $persona->getCedula() . '">
                                <a class="input-group-addon" id="btn-a" href="#"><span class="glyphicon glyphicon-search"></span></a>
                            </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="modal_name">' . $idiom->getModal_label_name() . '</label>
                                        <input type="text" class="form-control" name="nombre" value="' . $persona->getNombre() . '">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="modal_lastname">' . $idiom->getModal_label_lastname() . '</label>
                                        <input type="text" class="form-control" name="apellido" value="' . $persona->getApellido() . '">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="modal_tel">' . $idiom->getModal_label_tel() . '</label>
                                        <input type="tel" class="form-control" name="tel" onkeypress="return justNumbers(event);">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="modal_tel">' . $idiom->getModal_label_cel() . '</label>
                                        <input type="tel" class="form-control" name="cel" onkeypress="return justNumbers(event);">
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="modal_departament">' . $idiom->getModal_label_departament() . '</label>
                                        <input type="text" class="form-control" name="departamento" value = "' . $persona->getPuesto()->getDepartamento() . '">
                                    </div>     
                                    <div class="col-md-6">
                                        <label for="modal_town">' . $idiom->getModal_label_town() . '</label>
                                        <input type="text" class="form-control" name="municipio" value = "' . $persona->getPuesto()->getMunicipio() . '">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="modal_place">' . $idiom->getModal_label_place() . '</label>
                                        <input type="text" class="form-control" name="puesto" value = "' . $persona->getPuesto()->getPuesto() . '">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="modal_dir_place">' . $idiom->getModal_label_dir_place() . '</label>
                                        <input type="text" class="form-control" name="dir_puesto" value = "' . $persona->getPuesto()->getDir_puesto() . '">
                                    </div>
                                </div>
                                <div class="row" style="margin-bottom: 10px;">
                                    <div class="col-md-6">
                                        <label for="modal_table">' . $idiom->getModal_label_table() . '</label>
                                        <input type="text" class="form-control" name="mesa" onkeypress="return justNumbers(event);" value = "' . $persona->getPuesto()->getMesa() . '">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" >' . $idiom->getBtn_save() . '</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>';
}

function buscar_votante($documento) {
    $service = new Servicios();
    $result = $service->muestraVotante($documento);
    return $result;
}

?>