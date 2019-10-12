<?php
    session_start();
    if($_SESSION['user_name'] === null){
        header('location: sign.php');
    }

    $_SESSION['manualSection'] = $_GET['section'];
    $_SESSION['manualPage'] = 1;
    header('location: manual.php');

?>