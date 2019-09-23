<?php
    session_start();
    
    require 'userDAO.php';
    $in_em = $_POST['user_email'];
    $in_pw = $_POST['user_passwd'];
    $userDAO = new userDAO();
    $result = $userDAO->login_action($in_em, $in_pw);
    if($result === 'SUCCESS') {
        $_SESSION['user_name'] = $userDAO->get_userName($in_em);
        header('location: home.php');
    }else if($result === 'EMPTY'){
        $_SESSION['loginERR'] = 'emptyID';
        header('location: index.php');
    }else if($result === 'NOID'){
        $_SESSION['loginERR'] = 'ID';
        header('location: index.php');
    }else if($result === 'INCORRECTPW'){
        $_SESSION['loginERR'] = 'PW';
        header('location: index.php');
    }
?>