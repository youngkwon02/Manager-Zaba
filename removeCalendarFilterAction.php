<?php
    session_start();
    if($_SESSION['user_name'] === null){
        header('location: sign.php');
    }

    require 'userDAO.php';
    require 'relationDAO.php';
    $userDAO = new userDAO();
    $relationDAO = new relationDAO();

    $user_email = $userDAO->get_userEmail($_SESSION['user_name']);
    $target_email = $_GET['targetEmail'];
    $target_name = $_GET['targetName'];
    
    $relationDAO->removeCalendarFilter($user_email, $target_email);
    $_SESSION['calendarFilter'] = 'REMOVE';
    $_SESSION['filterTarget'] = $target_name;
    header('location: friendList.php');
?>