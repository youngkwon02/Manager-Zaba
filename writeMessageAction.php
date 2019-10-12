<?php
    session_start();
    if($_SESSION['user_name'] === null){
        header('location: sign.php');
    }
    $_SESSION['messageException'] = null;
    $_SESSION['sendSuccess'] = false;

    require 'userDAO.php';
    require 'messageDAO.php';
    require 'relationDAO.php';
    $userDAO = new userDAO();
    $relationDAO = new relationDAO();
    $messageDAO = new messageDAO();

    $receiver = $_POST['receiver'];
    $receiver_name = $userDAO->get_userName($receiver);
    $writer = $_POST['writer'];
    $writer_name = $userDAO->get_userName($writer);
    $title = $_POST['title'];
    $text = $_POST['text'];

    $user_email = $userDAO->get_userEmail($_SESSION['user_name']);

    // Firstly validate writer is login user
    if($writer != $user_email){
        $_SESSION['messageException'] = 'writer';
    }else{
        $validate = $messageDAO->validate_form($receiver, $writer, $title, $text);
    }
    
    if($validate && $_SESSION['messageException'] === null){
        $messageDAO->send_Message($receiver, $receiver_name, $writer, $writer_name, $title, $text);
        $_SESSION['sendSuccess'] = $receiver_name;
        header('location: sendMessageSuccess.php');
    }else{
        header('location: message.php');
    }
?>