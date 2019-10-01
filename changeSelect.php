<?php
    session_start();
    if($_SESSION['user_name'] === null){
        header('location: sign.php');
    }

    $select = $_GET['func'];
    $_SESSION['selected'] = $select.'Message';
    $_SESSION['page'] = null;
    header('location: message.php');
?>