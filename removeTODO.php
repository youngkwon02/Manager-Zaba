<?php
    session_start();
    require 'userDAO.php';
    require 'todoDAO.php';

    $userDAO = new userDAO();
    $todoDAO = new todoDAO();
    $name = $_SESSION['user_name'];
    $email = $userDAO->get_userEmail($name);
    $removeNum = $_GET['num'];
    
    $todoDAO->remove_TODO($email, $name, $removeNum);
    header('location: manageTODO.php');
?>