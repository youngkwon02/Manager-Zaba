<?php
    session_start();
    if($_SESSION['user_name'] == null){
        header('location: ./sign.php');
    }

    require './userDAO.php';
    require './relationDAO.php';
    $userDAO = new userDAO();
    $relationDAO = new relationDAO();
    $requester = $_GET['requesterEmail'];
    $responser = $_GET['responserEmail'];

    $relationDAO->rejectRequest($requester, $responser);
    $_SESSION['reject'] = $userDAO->get_userName($requester);
    header('location: ./waitingList.php');
?>