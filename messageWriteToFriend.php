<?php
    session_start();
    if($_SESSION['user_name'] === null){
        header('location: sign.php');
    }
    $_SESSION['selected'] = 'writeMessage';
    $_SESSION['receiver_email'] = $_GET['targetEmail'];
    header('location: message.php');
?>