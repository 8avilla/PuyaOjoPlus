<?php
session_start();
if (empty($_SESSION['user'])) {
    header('Location: index.php');
}
include_once getcwd() . '\html_block.php';
include_once getcwd() . '\string\idiom_spn.php';
include_once getcwd() . '\html_block.php';
include_once getcwd() . '\inc\DAO\Conexion.php';
include_once getcwd() . '\inc\DAO\BuscarServicios.php';
include_once getcwd() . '\inc\DAO\DAOCandidato.php';
include_once getcwd() . '\inc\DAO\DAOLider.php';
include_once getcwd() . '\inc\DAO\DAOListaCandidato_Votante.php';
include_once getcwd() . '\inc\DAO\DAOVotante.php';
include_once getcwd() . '\inc\DAO\DAOPuestoVotacion.php';
include_once getcwd() . '\inc\DAO\DAOListas.php';
include_once getcwd() . '\inc\DAO\Zonificacion.php';
include_once getcwd() . '\inc\modelo_logico\PuestoVotacion.php';
include_once getcwd() . '\inc\modelo_logico\Votante.php';
include_once getcwd() . '\inc\modelo_logico\Lider.php';
include_once getcwd() . '\inc\modelo_logico\Candidato.php';
$elements = new ElementHTML();
$idiom = new Idiom();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $idiom->getLabel_voter(); ?></title>
        <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="css/style-census-electoral.css" rel="stylesheet">
    </head>
    <body>
        <script src="http://code.jquery.com/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/census-voter.js"></script>
        <div class="navbar navbar-default navbar-fixed-top" style="padding-left: 20px; padding-right: 20px; margin-bottom: 10px">
            <?php $elements->load_navbar(); ?>
            <div class="navbar navbar-default border-none">
                <div class="container">   
                    <form class="navbar-form navbar-left" role="search" style="margin-top: 10px">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Cédula de ciudadanía">
                        </div>
                        <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
                    </form>
                    <div  class="navbar-right" style="margin-top: 10px">
                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal_add_voter" style="margin-right: 10px"><span class="glyphicon glyphicon-plus" ></span></button>
                        <div class="btn-group" >
                            <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-pencil" ></span></button>
                            <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-trash"></span></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--**************************************************-->
        <div class="container" style="padding-top: 10%">
            <table class="table table-condensed table-hover table-responsive">
                <tr>
                    <td><strong></strong></td>
                    <td><strong><?php echo $idiom->getModal_label_cc(); ?></strong></td>
                    <td><strong><?php echo $idiom->getModal_label_name(); ?></strong></td>
                    <td><strong><?php echo $idiom->getModal_label_lastname(); ?></strong></td>
                    <td><strong><?php echo $idiom->getModal_label_departament(); ?></strong></td>
                    <td><strong><?php echo $idiom->getModal_label_town(); ?></strong></td>
                    <td><strong><?php echo $idiom->getModal_label_place(); ?></strong></td>
                    <td><strong><?php echo $idiom->getModal_label_table(); ?></strong></td>
                </tr>
                <?php
                $cc_lider = 1049453283;

                $dao = new DAOVotante();
                $lista = $dao->mostrarListaVotantes_Lider($cc_lider);

                for ($x = 0; $x < count($lista); $x++) {
                    ?>
                    <td><div class="checkbox" style="margin: 0px;"><label><input type="checkbox" value=""></label></div></td>
                    <td><?php echo $lista[$x][0]; ?></td>
                    <td><?php echo $lista[$x][1]; ?></td>
                    <td><?php echo $lista[$x][2]; ?></td>
                    <td><?php echo $lista[$x][3]; ?></td>
                    <td><?php echo $lista[$x][4]; ?></td>
                    <td><?php echo $lista[$x][5]; ?></td>
                    <td><?php echo $lista[$x][6]; ?></td>

                    </tr>
                <?php } ?>
            </table>
        </div>
        <!-- modal_add_voter -->
        <div class="modal fade" id="modal_add_voter">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div id="load_voter">
                        <?php echo $elements->load_modal_add_voter(); ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>