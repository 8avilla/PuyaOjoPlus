<?php

session_start();
include_once './DAO/DAOVotante.php';

if (isset($_POST['cc']) && isset($_SESSION["user"])) {
    $dao = new DAOVotante();
    $dao->eliminarListaVotante_Lider($_SESSION["user"], $_POST["cc"]);
//    echo 'elimo';
} else {
    if (isset($_SESSION["user"])) {
        echo 'No a seleccionado votante';
    } else {
        echo 'Inicie sesion';
    }
}
