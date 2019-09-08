<!-- Session Data를 사용하려면 session_start() 필수 -->
<?php session_start(); ?>
<?php require 'userDAO.php'; ?>
<!-- @TODO:이후에 이 부분에 session이 없으면 접근 차단하는 코드 작성 필요 -->
<?php
    if($_SESSION['user_name'] == null){
        header('location: sign.php');
    }
?>

<?php
    $nick = $_POST['nick'];
    $pass = $_POST['pass'];
    $passck = $_POST['passck'];

    // GET 방식으로 ERROR CODE 를 넘기거나, SUCCESSFUL APPLING
    // ERROR = 1 -> NICK IS TOO LONG
    // ERROR = 2 -> PASSWORD IS INCORRECT
    if(strlen($nick) > 20) {
        header('location: modifyInfo.php?error=1');
    }else if($pass != $passck) {
        header('location: modifyInfo.php?error=2');
    }else{
        $userDAO = new userDAO();
        $email = $userDAO->get_userEmail($_SESSION['user_name']);
        $userDAO->set_userNick($email, $nick);
        $userDAO->reset_passwd($email, $_SESSION['user_name'], $pass);
        header('location: modifyInfo.php?success=1');
    }
?>