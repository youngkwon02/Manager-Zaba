<?php
    session_start();
    require 'userDAO.php';
    require 'relationDAO.php';

    $userDAO = new userDAO();
    $relationDAO = new relationDAO();

    $requesterEmail = $userDAO->get_userEmail($_SESSION['user_name']);
    $responserEmail = $_GET['responserEmail'];

    // exist is pending_seq if Request existing
    $exist = $relationDAO->checkRequestExisting($requesterEmail, $responserEmail);
    if($exist === null){
        $relationDAO->sendFriendRequest($requesterEmail, $responserEmail);
        $_SESSION['send_Request'] = 'success';
    }else {
        $_SESSION['send_Request'] = 'already';
    }
    header('location: ./friendManagement.php');

?>