<?php
    session_start();
    if($_SESSION['user_name'] === null){
        header('location: sign.php');
    }

    $_SESSION['selected'] = 'writeMessage';
    header('location: message.php');
?>