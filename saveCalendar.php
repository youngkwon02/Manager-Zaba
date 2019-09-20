<?php
    session_start();
    if($_SESSION['user_name'] == null) {
        header('location: sign.php');
    }
    $_SESSION['isFirstLoad'] = null;
    require 'initCalendar.php';
?>
<!DOCTYPE html>
<html lang="en" class="no-drag">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="./assets/js/jquery-3.4.1.min.js"></script>
    <script src="./assets/js/home.js"></script>
    <link rel="stylesheet" href="./assets/css/saveCalendar.css">
    <title>Add your event!</title>
</head>
<body>
    <form id="saveCalendarForm" method="POST" action="./saveCalendarAction.php">
        <a href="./manageCalendar.php">Back to your Calendar</a>
        <h2><a href="./saveCalendar.php">일정 추가</a></h2>
        <?php
        if($_GET['FAIL'] === 'title'){
            echo('<h3 id="titleErr">일정은 공란일 수 없습니다.</h3>');
        }else if($_GET['FAIL'] === 'date'){
            echo('<h3 id="dateErr">종료날짜가 시작날짜보다<br>과거일 수 없습니다.</h3>');
        }
        // 이하 조건문 Can't catch the condition
            if($_SERVER['REQUEST METHOD'] === 'GET'){
                if($_GET['FAIL'] === 'title') {
                    echo('<h3 style="color:red; grid-column-start:6; grid-column-end: 10;">일정은 공란일 수 없습니다.</h3>');
                }
            }
        ?>
        <div id="title"><span class="text">일정 : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><input type="text" name="title"></div>
        <div id="start">
        <span class="text">시작 날짜 : &nbsp;&nbsp;&nbsp;</span>
        <select class="yearSelect" id="startYearSelect" name="startY">
            <?php
                for($i=2010; $i<2030; $i++) {
                    // BECAUSE $i IS SMALLER THAN REAL MONTH AS 1
                    if($i == $now_Y){
                        echo('<option selected="selected">'.$i.'년</option>');
                    }else {
                        echo('<option>'.$i.'년</option>');
                    }
                }
            ?>
        </select>&nbsp;&nbsp;
        <select class="monthSelect" id="startMonthSelect" name="startM">
            <?php
                for($i=1; $i<13; $i++) {
                    if($i == $now_M){
                        echo('<option selected="selected">'.$i.'월</option>');
                    }else {
                        echo('<option>'.$i.'월</option>');
                    }
                }
            ?>
        </select>&nbsp;&nbsp;
        <select class="daySelect" id="startDaySelect" name="startD">
            <?php
                for($i=1; $i<$numOfDay + 1; $i++) {
                    if($i == $now_D){
                        echo('<option selected="selected">'.$i.'일</option>');
                    }else {
                        echo('<option>'.$i.'일</option>');
                    }
                }
            ?>
        </select><br><br>
        </div>

        <div id="end">
        <span class="text">종료 날짜 : &nbsp;&nbsp;&nbsp;</span>
        <select class="yearSelect" id="endYearSelect" name="endY">
            <?php
                for($i=2010; $i<2030; $i++) {
                    // BECAUSE $i IS SMALLER THAN REAL MONTH AS 1
                    if($i == $now_Y){
                        echo('<option selected="selected">'.$i.'년</option>');
                    }else {
                        echo('<option>'.$i.'년</option>');
                    }
                }
            ?>
        </select>&nbsp;&nbsp;
        <select class="monthSelect" id="endMonthSelect" name="endM">
            <?php
                for($i=1; $i<13; $i++) {
                    if($i == $now_M){
                        echo('<option selected="selected">'.$i.'월</option>');
                    }else {
                        echo('<option>'.$i.'월</option>');
                    }
                }
            ?>
        </select>&nbsp;&nbsp;
        <select class="daySelect" id="endDaySelect" name="endD">
            <?php
                for($i=1; $i<$numOfDay+2; $i++) {
                    if($i == $now_D){
                        echo('<option selected="selected">'.$i.'일</option>');
                    }else {
                        echo('<option>'.$i.'일</option>');
                    }
                }
            ?>
        </select>
        </div><br>
        <div id="share">
            <span class="text">혼자 보기 : &nbsp;&nbsp;&nbsp;</span><input type="radio" name="shareYN" value="N">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span class="text">친구와 함께 보기 : &nbsp;&nbsp;&nbsp;</span><input type="radio" name="shareYN" value="Y" checked="checked">
        </div>
        <div id="color">
            <span class="text">Color : &nbsp;&nbsp;&nbsp;</span><input id="colorPicker" name="color" type="color" value="#ed6fbf">
        </div>
        <input id="submit" type="submit" value="Save">
    </form>
</body>
</html>
