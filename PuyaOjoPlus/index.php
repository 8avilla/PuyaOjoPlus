<?php
session_start();
if (isset($_SESSION['user'])) {
    header('Location: http://localhost/puyaOjo/pages/home.php');
}
header('Location: http://localhost/puyaOjo/login.php');
?>