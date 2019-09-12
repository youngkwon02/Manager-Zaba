<!-- Session Data를 사용하려면 session_start() 필수 -->
<?php session_start(); ?>
<?php require 'userDAO.php'; ?>
<?php require 'todoDAO.php'; ?>

<?php

    $userDAO = new userDAO();
    $todoDAO = new todoDAO();
    
    $email = $userDAO->get_userEmail($_SESSION['user_name']);
    $name = $_SESSION['user_name'];
    $date = $_POST['date'];
    $content = $_POST['content'];
    if(strlen($content) > 150){
        header('location: ./manageTODO.php?error=TOOLONG');
    }else {
        $todoDAO->set_TODO($email, $name, $date, $content);
        header('location: ./manageTODO.php?success=SAVE');
    }

?>