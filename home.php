<!-- Session Data를 사용하려면 session_start() 필수 -->
<?php session_start(); ?>
<?php require 'userDAO.php'; ?>
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
    <link rel="stylesheet" href="./assets/css/home.css">
    <title>Home</title>
</head>
<body>
    <section id="slidebar">
        <div class="inner">
            <nav>
                <ul>
                    <li>TODO</li>
                    <li>MEMO</li>
                    <li>CALENDAR</li>
                    <li onclick="click_menu(this)"><div class="bar1"></div><div class="bar2"></div><div class="bar3"></div></li>
                </ul>
            </nav>
        </div>
    </section>
    <div id="menuTab">
        <ul>
            <li><a href="./modifyInfo.php">Modify Info</a></li>
            <li><a href="./signoutAction.php">Sign Out</a></li>
        </ul>
    </div>
    <header id = "header">
        <div class="inner">
            <h1>Welcome, <?php $userDAO = new userDAO(); echo($userDAO->get_userNick($userDAO->get_userEmail($_SESSION['user_name']))); ?></h1>
            <p>
                Are you having a good day today?<br>
                Or do you have plan that makes you feel better just by imagining?<br>
                I'll help you get your plan done perfectly!
            </p>
        </div>
    </header>

</body>
</html>