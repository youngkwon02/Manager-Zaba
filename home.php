<!-- Session Data를 사용하려면 session_start() 필수 -->
<?php session_start(); ?>
<?php require 'userDAO.php'; ?>
<?php require 'todoDAO.php'; ?>
<?php require 'memoDAO.php'; ?>
<?php require 'relationDAO.php'; ?>
<?php require 'messageDAO.php'; ?>
<?php
    if($_SESSION['user_name'] === null){
        header('location: sign.php');
    }
    $_SESSION['manualSection'] === 'HELLO';
    $_SESSION['manualPage'] = 1;

?>
<!DOCTYPE html>
<html id="html" lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="./assets/js/jquery-3.4.1.min.js"></script>
    <script src="./assets/js/home.js"></script>
    <link rel="stylesheet" href="./assets/css/home.css">
    <title>Home</title>
</head>
<body class="no-drag">
    <section id="slidebar">
        <div class="inner">
            <nav>
                <ul>
                    <li class="navli" onclick="navMove('header')">HELLO</li>
                    <li class="navli" onclick="navMove('todo')">TODO</li>
                    <li class="navli" onclick="navMove('memo')">MEMO</li>
                    <li class="navli" onclick="navMove('calendar')">CALENDAR</li>
                    <li onclick="click_menu(this)"><div class="bar1"></div><div class="bar2"></div><div class="bar3"></div></li>
                </ul>
            </nav>
        </div>
    </section>
    <div id="menuTab">
        <?php
            $userDAO = new userDAO();
            $relationDAO = new relationDAO();
            $messageDAO = new messageDAO();

            $user_email = $userDAO->get_userEmail($_SESSION['user_name']);
            $receiveNum = $relationDAO->getNumOfReceiveRequest($user_email);

            $isThereNewMessage = $messageDAO->existNewMessage($user_email, $_SESSION['user_name']);
        ?>
        <ul>
            <li><a href="./friendList.php">Friend List</a></li>
            <li><a href="./friendManagement.php">Friend Search</a><?php if($receiveNum != 0){echo('<span style="font-weight: bold; color: red; font-size: 20px;">&nbsp;&nbsp;!</span>');} ?></li>
            <li><a href="./message.php">Message</a><?php if($isThereNewMessage != false){echo('<span style="font-weight: bold; color: red; font-size: 20px;">&nbsp;&nbsp;!</span>');} ?></li>
            <li><a href="./modifyInfo.php">Modify Info</a></li>
            <li><a href="./manual.php">Help</a></li>
            <li><a href="./signoutAction.php">Sign out</a></li>
        </ul>
    </div>
    <header id = "header">
        <div class="inner">
            <h1>Welcome, <?php echo($userDAO->get_userNick($user_email)); ?></h1>
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
                        $name = $_SESSION['user_name'];
                        $date = date("Y-m-d", time());
                        $todoDAO = new todoDAO();
                        $line = $todoDAO->get_TODO($user_email, $name, $date);
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
                    This is so simple MEMO widget.<br>
                    Just leave something you must not forget!<br><br>
                    For example, you can write some phrases<br>
                    that will make you feel better.<br>
                    Or you can write a plan to be happy<br>just by thinking!
                </p>
            </div>
            
            <!-- MEMO save Exception catching -->
            <?php
                if($_GET['memo_Ex'] == 1) {
                    echo('<h4 style="text-align:center; color:red; margin:0; grid-row:1; grid-column-start:16; grid-column-end:28;">MEMO Title is too long (UP TO 27 characters)</h4>');
                }else if($_GET['memo_Ex'] == 2) {
                    echo('<h4 style="text-align:center; color:red; margin:0; grid-row:1; grid-column-start:16; grid-column-end:28;">MEMO Text is too long (UP TO 300 characters)</h4>');
                }else if($_GET['memo_Ex'] == 3) {
                    echo('<h4 style="text-align:center; color:red; margin:0; grid-row:1; grid-column-start:16; grid-column-end:28;">MEMO Title contains unexpected character!</h4>');
                }else if($_GET['memo_Ex'] == 4) {
                    echo('<h4 style="text-align:center; color:red; margin:0; grid-row:1; grid-column-start:16; grid-column-end:28;">MEMO Text contains unexpected character!</h4>');
                }
            ?>

            <div id="memoBox">
                <?php $memoDAO = new memoDAO(); ?>
                <form id="memoForm" method="POST" action="./saveMemoAction.php"><br><br>
                    <input id="memoTitle" type="text" name="title" value="<?php echo($memoDAO->get_memoTitle($user_email, $name));?>"><br><br>
                    <textarea id="memoText" name="text"><?= $memoDAO->get_memo($user_email, $name) ?></textarea><br>
                    <button id="memoSubmit" onclick="save_memo()">Save</button>
                </form>
            </div>
        </div>
    </section>

    <section id="calendar">
        <div class="inner">
            <div class="contentBox">
                <h1>CALENDAR</h1>
                <p>
                    Make your own calendar with this widget!<br>
                    You can remind your plan by writing<br>on this calendar.<br><br>
                    In addition, you can choose and share<br>your calendar with your friends.
                </p>
            </div>
            <div id="calendarBox">
                <!-- php code for calendar -->
                <?php require_once './initCalendar.php'; ?>

                <div class="no-drag" id="monthSelect"><span id="prev_m">◀</span><div id="monthValue"><?= $monthArr[$_SESSION['month']] ?></div><span id="next_m">▶</span></div>
                <div class="no-drag" id="yearSelect"><span id="prev_y">◁</span><div id="yearValue"><?= $yearArr[$_SESSION['year']] ?></div><span id="next_y">▷</span></div>
                <div class="no-drag" id="today">Today</div><br>
                <div id="calendarBody">
                    <!-- 요일 출력 MON ~ SUN -->
                    <?php
                        for($i=0; $i<7; $i++) {
                            if($i == 6){
                                echo('<div id="Saturday" class="calendarDay">'.$dayArr[$i].'</div>');
                            }else if($i == 0){
                                echo('<div id="Sunday" class="calendarDay">'.$dayArr[$i].'</div>');
                            }else{
                                echo('<div class="calendarDay">'.$dayArr[$i].'</div>');
                            }
                        }
                    ?>

                    <?php
                        require './initCalendar.php';
                        require './calendarDAO.php';
                        $calendarDAO = new calendarDAO();
                        $allFriendsList = $relationDAO->getAllFriendsList($user_email);
                        $date_arr = $calendarDAO->get_allDate($user_email, $allFriendsList, $now_Y, $now_M);
                        $index = count($date_arr);

                    //  일자 출력 .. 1 ~ 31 ..
                        $day = $prevNumOfDay + 1 - $startDayNum;
                        $year = $now_Y;
                        $month = $now_M -1;

                        $element = 'prev';
                        for($i = 0; $i < 42; $i++){
                            if($i == $startDayNum) {
                                $day = 1;
                                $element = 'this';
                                $month++;
                                if($month == 13){
                                    $month = 1;
                                    $year ++;
                                }
                            }
                            if($day == $numOfDay + 1 && $month == $now_M){
                                // day가 32일과 같이 numOfDay +1의 값을 가질 때 1로 Reset
                                $day = 1;
                                $element = 'next';
                                $month++;
                                if($month == 13){
                                    $month = 1;
                                    $year ++;
                                }
                            }

                            $dayForArr = $day;
                            if(strlen($dayForArr) == 1){
                                $dayForArr = '0'.$dayForArr;
                            }
                            $monthForArr = $month;
                            if($monthForArr == 0){
                                $monthForArr = 12;
                                $year --;
                            }
                            if(strlen($monthForArr) == 1){
                                $monthForArr = '0'.$monthForArr;
                            }
                            $yearForArr = $now_Y;
    
                            $indexSet = null;

                            for($k = 0; $k < $index; $k++){
                                $cond_1 = $date_arr[$k]['start_date'] <= ($yearForArr.'-'.$monthForArr.'-'.$dayForArr);
                                $cond_2 = ($yearForArr.'-'.$monthForArr.'-'.$dayForArr)<= $date_arr[$k]['end_date'];
                                if($cond_1 && $cond_2){
                                    $indexSet[] = $k;
                                }
                            }
                            $indexSetLen = count($indexSet);

                            if($element === 'prev') {
                                if($indexSet != null){
                                    if($indexSetLen>3){
                                        echo('<div class="calendarPrevElement"><div class="ele_num">('.$indexSetLen.')&nbsp;&nbsp;&nbsp;&nbsp;'.$day.'</div>');
                                    }else{
                                        echo('<div class="calendarPrevElement"><div class="ele_num">'.$day.'</div>');
                                    }
                                    for($v=0; $v<$indexSetLen; $v++){
                                        if($v > 2){
                                            break;
                                        }                     
                                        echo('<div class="ele_date" style="background-color: '.$date_arr[$indexSet[$v]]['color'].';">&nbsp;</div>');
                                    }
                                    echo('</div>');
                                }else{
                                    echo('<div class="calendarPrevElement"><div class="ele_num">'.$day.'</div></div>');
                                }
                            } else if($element === 'this') {
                                if($indexSet != null){
                                    if($indexSetLen>3){
                                        if($day == $now_D){
                                            echo('<div class="calendarThisElement" id="todayBox"><div class="ele_num">('.$indexSetLen.')&nbsp;&nbsp;&nbsp;&nbsp;'.$day.'</div>');
                                        }else{
                                            echo('<div class="calendarThisElement"><div class="ele_num">('.$indexSetLen.')&nbsp;&nbsp;&nbsp;&nbsp;'.$day.'</div>');
                                        }
                                    }else{
                                        if($day == $now_D){
                                            echo('<div class="calendarThisElement" id="todayBox"><div class="ele_num">'.$day.'</div>');
                                        }else{
                                            echo('<div class="calendarThisElement"><div class="ele_num">'.$day.'</div>');
                                        }
                                    }
                                    for($v=0; $v<$indexSetLen; $v++){
                                        if($v > 2){
                                            break;
                                        }
                                        echo('<div class="ele_date" style="background-color: '.$date_arr[$indexSet[$v]]['color'].';">&nbsp;</div>');
                                    }
                                    echo('</div>');
                                }else{
                                    if($day == $now_D){
                                        echo('<div class="calendarThisElement" id="todayBox"><div class="ele_num">'.$day.'</div></div>');
                                    }else {
                                        echo('<div class="calendarThisElement"><div class="ele_num">'.$day.'</div></div>');
                                    }
                                }
                            } else if($element === 'next') {
                                if($indexSet != null){           
                                    if($indexSetLen>3){
                                        echo('<div class="calendarNextElement"><div class="ele_num">('.$indexSetLen.')&nbsp;&nbsp;&nbsp;&nbsp;'.$day.'</div>');
                                    }else{
                                        echo('<div class="calendarNextElement"><div class="ele_num">'.$day.'</div>');
                                    }
                                    for($v=0; $v<$indexSetLen; $v++){
                                        if($v > 2){
                                            break;
                                        }
                                        echo('<div class="ele_date" style="background-color: '.$date_arr[$indexSet[$v]]['color'].';">&nbsp;</div>');
                                    }
                                    echo('</div>');
                                }else{
                                    echo('<div class="calendarNextElement"><div class="ele_num">'.$day.'</div></div>');
                                }
                            }                            
                            $day ++;
                        }
                    ?>
                </div>
                <h1 id="calendarAdd"><a href="./calendarAction.php?action=reset&onPage=TRUE">+</a></h1>
            </div>
        </div>
    </section>
</body>
</html>
