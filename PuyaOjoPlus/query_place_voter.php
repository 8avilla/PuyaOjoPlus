<?php
session_start();
if (empty($_SESSION['user'])) {
    header('Location: index.php');
}
include_once getcwd() . '\html_block.php';
$elements = new ElementHTML();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Home</title>
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
                    <div  class="navbar-right" style="margin-top: 10px">
                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal_add_voter" style="margin-right: 10px"><span class="glyphicon glyphicon-plus" ></span></button>
                    </div>
                </div>
            </div>
        </div>
        <!--**************************************************-->
        <div class="container">
            <div class="row" style="margin-top: 20%">
                <div class="col-md-3">
                    <div class="modal-content " style="padding: 10px">
                        <div style="margin: 10px">
                            <label>Digite número de cédula</label>
                            <input type="text" id="doc" name="doc" class=" form-control center-block" placeholder="Digite su cédula">
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="submit_pet" class=" btn btn-default center-block">Buscar</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div id="result_serv"></div>
                </div>
            </div>
        </div>
    </body>
</html>