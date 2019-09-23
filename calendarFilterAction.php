<?php
    session_start();
    if($_SESSION['user_name'] === null){
        header('location: sign.php');
    }

    $filter = $_GET['filter'];
    $_SESSION['filter'] = $filter;
    header('location: manageCalendar.php');
?>