<!-- Session Data를 사용하려면 session_start() 필수 -->
<?php session_start(); ?>
<?php require 'userDAO.php'; ?>
<?php require 'todoDAO.php'; ?>
<?php require 'memoDAO.php'; ?>
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
                    <li class="navli">TODO</li>
                    <li class="navli">MEMO</li>
                    <li class="navli">CALENDAR</li>
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

    <section id="todo">
        <div class="inner">
            <div class="contentBox">
                <h1>TODO</h1>
                <p>
                    Record your TODO things on this widget!<br>
                    Everyday, this TODO widget will show you<br>
                    what to do.<br><br>
                    Don't forget what you planned through<br>TODO widget!
                </p>
            </div>
            <div id="todoBox">
                <h1 id="todoTitle">
                    <?php
                        $date = date("m월 d일", time());
                        $day = date("Y-m-d", time());
                        $weekString = array("일요일", "월요일", "화요일", "수요일", "목요일", "금요일", "토요일");
                        echo($date);
                        echo('&nbsp;&nbsp;&nbsp;'.$weekString[date('w',strtotime($day))]);
                    ?>
                </h1>
                <p id="todoP">
                    <?php
                        $userDAO = new userDAO();
                        $email = $userDAO->get_userEmail($_SESSION['user_name']);
                        $name = $_SESSION['user_name'];
                        $date = date("Y-m-d", time());
                        $todoDAO = new todoDAO();
                        $line = $todoDAO->get_TODO($email, $name, $date);
                        echo('<h1 id="addButton"><a href="./manageTODO.php" style="text-decoration: none; color: rgba(255, 255, 255, .85);">+</a></h1>');
                        echo('<script>resize_todoP('.$line.');</script>');
                        if($line>4) {
                            echo('<script>resize_todo('.$line.');</script>');
                        }
                    ?>
                </p>
            </div>            
        </div>
    </section>

    <section id="memo">
        <div class="inner">
            <div class="contentBox">
                <h1>MEMO</h1>
                <p>
                    This is a simple MEMO widget!<br>
                    It will notify you something every time you sign in.<br><br>
                    For example, you can write something<br>
                    that can be easily forgotten such as a plan<br>
                    to do something!
                </p>
            </div>
            
            <!-- MEMO save Exception catching -->
            <?php
                if($_GET['memo_Ex'] == 1) {
                    echo('<h4 style="text-align:center; color:red; margin:0; grid-row:1; grid-column-start:16; grid-column-end:28;">MEMO Title is too long (UP TO 27 characters)</h4>');
                }else if($_GET['memo_Ex'] == 2) {
                    echo('<h4 style="text-align:center; color:red; margin:0; grid-row:1; grid-column-start:16; grid-column-end:28;">MEMO Text is too long (UP TO 300 characters)</h4>');
                }
            ?>

            <div id="memoBox">
                <?php $memoDAO = new memoDAO(); ?>
                <form id="memoForm" method="POST" action="./saveMemoAction.php"><br><br>
                    <input id="memoTitle" type="text" name="title" value="<?php echo($memoDAO->get_memoTitle($email, $name));?>"><br><br>
                    <textarea id="memoText" name="text"><?= $memoDAO->get_memo($email, $name) ?></textarea><br>
                    <button id="memoSubmit" onclick="save_memo()">Save</button>
                </form>
            </div>
        </div>
    </section>

    <section id="calendar">
        <div class="inner">
        </div>
    </section>
</body>
</html>