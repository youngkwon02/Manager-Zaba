<!-- Session Data를 사용하려면 session_start() 필수 -->
<?php session_start(); ?>
<?php require 'userDAO.php'; ?>
<?php require 'todoDAO.php'; ?>
<!-- @TODO:이후에 이 부분에 session이 없으면 접근 차단하는 코드 작성 필요 -->
<?php
    if($_SESSION['user_name'] == null){
        header('location: sign.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="./assets/js/home.js"></script>
    <link rel="stylesheet" href="./assets/css/TODO.css">
    <title>TODO_Management</title>
</head>
<body>
    <h1>
    <a id="back" href="./home.php" style="text-decoration:none; color: rgba(255, 255, 255, .9);"><
    </a>        
    <a href="./manageTODO.php" style="text-decoration:none; color: yellow;">
        <?php
            $userDAO = new userDAO();
            $user_nick = $userDAO->get_userNick($userDAO->get_userEmail($_SESSION['user_name']));
            echo($user_nick."'s TODO");
        ?>
    </a></h1>
    <div id="inner">
        <div id="addTab">
            <form id="addForm" method="POST" action="./saveTodoAction.php">
                Date :&nbsp;&nbsp;&nbsp;<input id="date"" type="date" name="date" value="<?= date("Y-m-d", time()) ?>"><br>
                <br><div style="text-align: left; margin-left:20px;">Content<?php if($_GET['error'] === 'TOOLONG'){ echo('<span style="color: red; font-size:15px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Content is too long!</span>'); }else if($_GET['success']==='SAVE'){ echo('<span style="color: blue; font-size:15px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Save complete!</span>'); }?></div>
                <input id="text" type="text" name="content" value="Enter your TODO thing!" onfocus="this.value=''">
                <input id="submit" type="submit" value="Save">
            </form>
        </div>
        <div id="listTab">
            <h2>TODO NOTE</h2>
            <p>
                <ul style="padding-left: 70px;">
                <?php
                    $userDAO = new userDAO();
                    $todoDAO = new todoDAO();
                    $name = $_SESSION['user_name'];
                    $email = $userDAO->get_userEmail($name);
                    $line = $todoDAO->printTODO($email, $name);
                    if($line > 15){
                        echo('<script>resize_todoNote('.$line.');</script>');
                    }
                ?>
                </ul>
            </p>
        </div>
    </div>
</body>
</html>