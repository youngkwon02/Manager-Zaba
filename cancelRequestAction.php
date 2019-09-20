<?php
    session_start();
    if($_SESSION['user_name'] == null){
        header('location: sign.php');
    }

    $requester = $_GET['requesterEmail'];
    $responser = $_GET['responserEmail'];

    require 'relationDAO.php';
    $relationDAO = new relationDAO();
    $relationDAO->cancelSendRequest($requester, $responser);
    header('location: ./waitingList.php');
?>