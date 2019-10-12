<?php
    session_start();
    if($_SESSION['user_name'] === null){
        header('location: sign.php');
    }

    require 'userDAO.php';
    require 'messageDAO.php';
    $userDAO = new userDAO();
    $messageDAO = new messageDAO();

    $user_email = $userDAO->get_userEmail($_SESSION['user_name']);

    $method = $_GET['method'];
    $target = $_GET['target'];
    $selected = $_SESSION['selected'];

    if($method === 'allDelete'){
        $messageDAO->all_delete($user_email);
        $_SESSION['page'] = 1;
    }else if($method === 'selectDelete'){
        $targetList = explode(',', $target);
        $messageDAO->select_delete($user_email, $targetList, $selected);
        $_SESSION['page'] = 1;
    }else if($method === "selectImportant"){
        $targetList = explode(',', $target);
        $messageDAO->select_important($user_email, $targetList, $selected);
    }else if($method === "allRemove"){
        $targetList = explode(',', $target);
        $messageDAO->all_remove($user_email);
        $_SESSION['page'] = 1;
    }else if($method === "selectRecover"){
        $targetList = explode(',', $target);
        $messageDAO->select_recover($user_email, $targetList, $selected);
        $_SESSION['page'] = 1;
    }else if($method === "selectRemove"){
        $targetList = explode(',', $target);
        $messageDAO->select_remove($user_email, $targetList, $selected);
        $_SESSION['page'] = 1;
    }else if($method === "toggleImportant"){
        // By click star
        $messageDAO->toggleImportant($user_email, $target, $selected);
    }
    header('location: message.php');
?>