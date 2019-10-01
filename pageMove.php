<?php
    session_start();
    if($_SESSION['user_name'] === null){
        header('location: sign.php');
    }

    $page = $_GET['Page'];
    if($page === 'before'){
        $_SESSION['page']--;
        if($_SESSION['page'] < 1){
            $_SESSION['page'] = 1;
        }
    }else if($page === 'after'){
        $_SESSION['page']++;
        if($_SESSION['page'] > $_SESSION['indexCounter'] - 1){
            $_SESSION['page'] = $_SESSION['indexCounter'] - 1;
        }
    }else{
        $_SESSION['page'] = $page;
    }
    header('location: message.php');
?>