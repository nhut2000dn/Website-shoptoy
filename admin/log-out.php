<?php 
    session_start();
    if (isset($_SESSION['emailUser'])) {
        unset($_SESSION["emailUser"]);
        unset($_SESSION["passwordUser"]);
    }
    header ("location:../index.php");
?>