<?php
    session_start();
    if($_SESSION['user_name'] === null){
        header('location: sign.php');
    }
    $method = $_GET['method'];
    $section = $_GET['section'];
    $maxPage = $_SESSION[$section.'MaxPage'];

    if($method === 'back'){
        $_SESSION['manualPage'] --;
        if($_SESSION['manualPage'] < 1){
            $_SESSION['manualPage'] = $maxPage;
        }
        header('location: manual.php');
    }else if($method === 'next'){
        $_SESSION['manualPage'] ++;
        if($_SESSION['manualPage']>$maxPage){
            $_SESSION['manualPage'] = 1;
        }
        header('location: manual.php');
    }else{
        header('location: sign.php');
    }
?>