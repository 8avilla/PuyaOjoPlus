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
        <title>Gráficas</title>
        <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="css/style-census-electoral.css" rel="stylesheet">
    </head>
    <body>
        <script src="http://code.jquery.com/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="http://code.highcharts.com/highcharts.js"></script>
        <script src="js/stadistics-chart.js"></script>
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
                    <div class="btn-group navbar-right" style="margin-top: 10px">
                        <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-pencil" ></span></button>
                        <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container" style=" margin-top: 10%;">
            <div class="row">
                <div class="col-md-6">
                    <div style="height:400px; overflow-y: scroll;">
                        <table class="table table-responsive table-hover" >
                            <thead>
                                <tr>
                                    <th>Departamento</th>
                                    <th>Municipio</th>
                                    
                                    <th>Numero de votantes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for ($index = 0; $index < 50; $index++) {
                                    ?>
                                    <tr>
                                        <td>Content 1</td>
                                        <td>Content 2</td>
                                        <td>Content 3</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-6"><div id="conta" style="width:100%; height:400px; padding-top: 10%"></div></div>
            </div>
        </div>
    </div>
</body>
</html>