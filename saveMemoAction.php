<!-- Session Data를 사용하려면 session_start() 필수 -->
<?php session_start(); ?>
<?php require 'userDAO.php'; ?>
<?php require 'memoDAO.php'; ?>

<?php

    $userDAO = new userDAO();
    $memoDAO = new memoDAO();
    
    $name = $_SESSION['user_name'];
    $email = $userDAO->get_userEmail($name);
    $title = $_POST['title'];
    $text = $_POST['text'];
    $text = str_replace("\r\n", '//', $text);

    if(strpos($title, "'") !== false){
        header('location: home.php?memo_Ex=3#memo');
    }else if(strpos($text, "'") !== false){
        header('location: home.php?memo_Ex=4#memo');
    }
    else{
        if(strlen($title)>27) {
            header('location: home.php?memo_Ex=1#memo');    
        }else {
            if(strlen($text)>300) {
                header('location: home.php?memo_Ex=2#memo');
            }else {
                $memoDAO->set_memo($email, $name, $title, $text);
                header('location: home.php#memo');
            }
        }
    }
    

?>