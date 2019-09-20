<?php
    session_start();
    if($_SESSION['user_name'] == null) {
        header('location: sign.php');
    }
    require 'userDAO.php';
    require 'calendarDAO.php';

    $userDAO = new userDAO();
    $calendarDAO = new calendarDAO();

    $dropSeq = $_GET['CAL_seq'];
    $calendarDAO->drop_date($dropSeq);
    header('location: ./manageCalendar.php')
?>