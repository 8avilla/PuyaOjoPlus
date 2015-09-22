<?php

include_once 'DAO/DAOSesion.php';
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
if (isset($_POST['loginUsername']) && isset($_POST["loginPassword"])) {
    $sesion = new DAOSesion();
    $sesion->iniciarSesion($_POST['loginUsername'], $_POST["loginPassword"]);
//    header('Location: ' . $root . '\puyaOjo\pages\home.php');
    header('Location: http://localhost/puyaOjo/pages/home.php');
} else {
    header('Location: http://localhost/puyaOjo/login.php');
}