<?php
    session_start();
    if($_SESSION['user_name'] == null){
        header('location: sign.php');
    }
    require 'userDAO.php';
    require 'relationDAO.php';
    $userDAO = new userDAO();
    $relationDAO = new relationDAO();

    $ownerEmail = $userDAO->get_userEmail($_SESSION['user_name']);
    $deleteEmail = $_GET['deleteEmail'];
    $direction = $_GET['direction'];
    $link = 'location: ./'.$direction;

    $relationDAO->deleteFriend($ownerEmail, $deleteEmail);
    $_SESSION['deleteFriend'] = $userDAO->get_userName($deleteEmail);
    header($link);
?>