<?php
// Just set session value by GET FILTER Value from friendList.js
// By using the value setted on here, friendList.php shows list to client

    session_start();
    if($_SESSION['user_name'] === null){
        header('location: sign.php');
    }

    $val = $_GET['FILTER'];
    if($val === 'all'){
        $_SESSION['listFilter'] = 'all';
    }else if($val === 'recent'){
        $_SESSION['listFilter'] = 'recent';
    }
    header('location: friendList.php');
?>