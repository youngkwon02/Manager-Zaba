<?php
    session_start();
    if($_SESSION['user_name'] === null){
        header('location: sign.php');
    }else{
        $_SESSION['selected'] = 'allMessage';
        $_SESSION['page'] = '1';
        header('location: message.php');
    }
?>