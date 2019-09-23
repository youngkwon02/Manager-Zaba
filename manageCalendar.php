<?php
    session_start();
    if($_SESSION['user_name'] == null) {
        header('location: ./sign.php');
    }
?>
<!DOCTYPE html>
<html lang="en" class="no-drag">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="./assets/js/jquery-3.4.1.min.js"></script>
    <script src="./assets/js/home.js"></script>
    <link rel="stylesheet" href="./assets/css/calendar.css">
    <title>Calendar Management</title>
</head>
<body>
    <?php require 'initCalendar.php'; ?>
    <div class="inner">
        <div class="MY_cover"><span id="back"><a href="./calendarAction.php?action=reset"><img src="./images/back.png" style="width: 60px; height: 60px;"></a></span><span id="prev_M">◀</span><h1 id="month"><?= $monthArr[$_SESSION['month']] ?></h1><span id="next_M">▶</span><span id="add"><a href="./saveCalendar.php"><img src="./images/add.png" style="width: 60px; height: 60px;"></a></span><span id="drop" ondrop="drop(event)" ondragover="allowDrop(event)"><img src="./images/drop.png" style="width: 60px; height: 60px;"></span><span id="help"><img src="./images/help.png" style="width: 60px; height: 60px;"><span id="manual">Add : Click '+' button on the left<br>Drop : Drag the event you want to delete to the 'x' button on the left</span></span></div>
        <div class="MY_cover"><span id="prev_Y">◁</span><h5 id="year"><?= $yearArr[$_SESSION['year']] ?></h5><span id="next_Y">▷</span></div>
        <div class="no-drag" id="TODAY"><span id="todayInner">Today</span><div id="calendarFilter">내 일정 보기 : <input type="radio" name="calendarFilters" value="my" id="calFilter1" <?php if($_SESSION['filter'] === 'my'){ echo('checked="checked"'); } ?> > &nbsp;&nbsp;모든 일정 보기: <input type="radio" name="calendarFilters" value="all" id="calFilter2" <?php if($_SESSION['filter'] != 'my'){ echo('checked="checked"'); } ?>></div></div><br>
        <div class="calendarBody">            
            <?php
                for($i=0; $i<7; $i++) {
                    if($i == 5){
                        echo('<div id="Saturday" class="calendarDay">'.$dayArr[$i].'</div>');
                    }else if($i == 6){
                        echo('<div id="Sunday" class="calendarDay">'.$dayArr[$i].'</div>');
                    }else{
                        echo('<div class="calendarDay">'.$dayArr[$i].'</div>');
                    }
                }
            ?>

            <?php
                // Bring date of calendar from Database
                require 'userDAO.php';
                require 'calendarDAO.php';
                require 'relationDAO.php';

                $userDAO = new userDAO();
                $calendarDAO = new calendarDAO();
                $relationDAO = new relationDAO();
                $user_email = $userDAO->get_userEmail($_SESSION['user_name']);
                $allFriendsList = $relationDAO->getAllFriendsList($user_email);
                // date_arr is 2 dimensional array
                // arr[rowNum][colName] format
                if($_SESSION['filter'] === 'my'){
                    $date_arr = $calendarDAO->get_myDate($user_email, $now_Y, $now_M);
                }else{
                    // filter = all or null
                    $date_arr = $calendarDAO->get_allDate($user_email, $allFriendsList, $now_Y, $now_M);
                }
                
            ?>

            <?php 
                $year = $now_Y;
                $M = $now_M-1; //$M is for express the prev and next month's days
                if($M == 0){
                    $M = 12;
                }
                $month = $now_M-1; //$month is for compare with dateForArray value 
                if($month == 0){
                    $month = 12;
                    $year --;
                }
                if(strlen($month) == 1){
                    $month = '0'.$month;
                }
                $day = $prevNumOfDay + 1 - $startDayNum;
                
                $index = count($date_arr);

                $element = 'prev';                
                for($i = 0; $i < 42; $i++) {
                    if($i == $startDayNum) {
                        $day = 1;
                        $element = 'this';
                        $M = $now_M;
                        $month++;
                        if(strlen($month) == 1){
                            $month = '0'.$month;
                        }
                        if($month == 13){
                            $month = 1;
                            $year ++;
                        }
                    }
                    if($day == $numOfDay + 1 && $M == $now_M){
                        // day가 32일과 같이 numOfDay +1의 값을 가질 때 1로 Reset
                        $day = 1;
                        $element = 'next';
                        $month++;
                        if($month == 13){
                            $month = 1;
                            $year ++;
                        }
                        if(strlen($month) == 1){
                            $month = '0'.$month;
                        }
                    }

                    $dayForArray = $day; //$dayForArray is for compare with dateForArray value 
                    if(strlen($dayForArray) == 1){
                        $dayForArray = '0'.$dayForArray;
                    }

                    // $indexSet을 초기화를 안해서 1번 2번 3번 ... n번씩 출력되었었음.
                    $indexSet = null; //아래의 for문을 통해 기간에 포함된 경우의 index를 추출해서 array로 만듬

                    for($k=0; $k<$index; $k++){
                       $cond_1 = $date_arr[$k]['start_date'] <= ($year.'-'.$month.'-'.$dayForArray);
                       $cond_2 = ($year.'-'.$month.'-'.$dayForArray)<= $date_arr[$k]['end_date'];
                       if($cond_1 && $cond_2){
                           $indexSet[] = $k;
                       }
                    }

                    if($element === 'prev') {
                        if($indexSet != null){
                            if(count($indexSet)>3){
                                echo('<div class="calendarPrevElement"><div class="ele_num">('.count($indexSet).')&nbsp;&nbsp;&nbsp;&nbsp;'.$day.'</div>');
                            }else{
                                echo('<div class="calendarPrevElement"><div class="ele_num">'.$day.'</div>');
                            }
                            for($v=0; $v<count($indexSet); $v++){
                                if($v > 2){
                                    break;
                                }
                                $title = $date_arr[$indexSet[$v]]['title'];
                                $owner = $date_arr[$indexSet[$v]]['owner'];
                                $owner = $userDAO->get_userName($owner);
                                if(strlen($title) > 15){                                    
                                    if($owner != $_SESSION['user_name']){
                                        $title = substr($title, 0, 15);
                                        $title = $title.' ..';
                                        $title = $owner.' : '.$title;
                                    }else{
                                        $title = substr($title, 0, 15);
                                        $title = $title.' ..';    
                                    }
                                }else{
                                    if($owner != $_SESSION['user_name']){
                                        $title = $owner.' : '.$title;
                                    }
                                }
                                if($owner != $_SESSION['user_name']){
                                    echo('<div class="ele_date" id="'.$date_arr[$indexSet[$v]]['CAL_seq'].'" draggable="true" ondragstart="drag(event)" style="background-color: '.$date_arr[$indexSet[$v]]['color'].';"><span class="offMouse">'.$title.'</span><span class="onMouse">'.$owner.' : '.$date_arr[$indexSet[$v]]['title'].'</span></div>');
                                }else{
                                    echo('<div class="ele_date" id="'.$date_arr[$indexSet[$v]]['CAL_seq'].'" draggable="true" ondragstart="drag(event)" style="background-color: '.$date_arr[$indexSet[$v]]['color'].';"><span class="offMouse">'.$title.'</span><span class="onMouse">'.$date_arr[$indexSet[$v]]['title'].'</span></div>');
                                }
                            }
                            echo('</div>');
                        }else{
                            echo('<div class="calendarPrevElement"><div class="ele_num">'.$day.'</div></div>');
                        }
                    }else if($element === 'this') {
                        if($indexSet != null){
                            if(count($indexSet)>3){
                                echo('<div class="calendarThisElement"><div class="ele_num">('.count($indexSet).')&nbsp;&nbsp;&nbsp;&nbsp;'.$day.'</div>');
                            }else{
                                echo('<div class="calendarThisElement"><div class="ele_num">'.$day.'</div>');
                            }
                            for($v=0; $v<count($indexSet); $v++){
                                if($v > 2){
                                    break;
                                }
                                $title = $date_arr[$indexSet[$v]]['title'];
                                $owner = $date_arr[$indexSet[$v]]['owner'];
                                $owner = $userDAO->get_userName($owner);
                                if(strlen($title) > 15){                                    
                                    if($owner != $_SESSION['user_name']){
                                        $title = substr($title, 0, 15);
                                        $title = $title.' ..';
                                        $title = $owner.' : '.$title;
                                    }else{
                                        $title = substr($title, 0, 15);
                                        $title = $title.' ..';    
                                    }
                                }else{
                                    if($owner != $_SESSION['user_name']){
                                        $title = $owner.' : '.$title;
                                    }
                                }
                                if($owner != $_SESSION['user_name']){
                                    echo('<div class="ele_date" id="'.$date_arr[$indexSet[$v]]['CAL_seq'].'" style="background-color: '.$date_arr[$indexSet[$v]]['color'].';"><span class="offMouse">'.$title.'</span><span class="onMouse">'.$owner.' : '.$date_arr[$indexSet[$v]]['title'].'</span></div>');
                                }else{
                                    echo('<div class="ele_date" id="'.$date_arr[$indexSet[$v]]['CAL_seq'].'" draggable="true" ondragstart="drag(event)" style="background-color: '.$date_arr[$indexSet[$v]]['color'].';"><span class="offMouse">'.$title.'</span><span class="onMouse">'.$date_arr[$indexSet[$v]]['title'].'</span></div>');
                                }
                            }
                            echo('</div>');
                        }else{
                            echo('<div class="calendarThisElement"><div class="ele_num">'.$day.'</div></div>');
                        }
                    }else if($element === 'next') {
                        if($indexSet != null){           
                            if(count($indexSet)>3){
                                echo('<div class="calendarNextElement"><div class="ele_num">('.count($indexSet).')&nbsp;&nbsp;&nbsp;&nbsp;'.$day.'</div>');
                            }else{
                                echo('<div class="calendarNextElement"><div class="ele_num">'.$day.'</div>');
                            }
                            for($v=0; $v<count($indexSet); $v++){
                                if($v > 2){
                                    break;
                                }
                                $title = $date_arr[$indexSet[$v]]['title'];
                                $owner = $date_arr[$indexSet[$v]]['owner'];
                                $owner = $userDAO->get_userName($owner);
                                if(strlen($title) > 15){                                    
                                    if($owner != $_SESSION['user_name']){
                                        $title = substr($title, 0, 15);
                                        $title = $title.' ..';
                                        $title = $owner.' : '.$title;
                                    }else{
                                        $title = substr($title, 0, 15);
                                        $title = $title.' ..';    
                                    }
                                }else{
                                    if($owner != $_SESSION['user_name']){
                                        $title = $owner.' : '.$title;
                                    }
                                }
                                if($owner != $_SESSION['user_name']){
                                    echo('<div class="ele_date" id="'.$date_arr[$indexSet[$v]]['CAL_seq'].'" style="background-color: '.$date_arr[$indexSet[$v]]['color'].';"><span class="offMouse">'.$title.'</span><span class="onMouse">'.$owner.' : '.$date_arr[$indexSet[$v]]['title'].'</span></div>');
                                }else{
                                    echo('<div class="ele_date" id="'.$date_arr[$indexSet[$v]]['CAL_seq'].'" draggable="true" ondragstart="drag(event)" style="background-color: '.$date_arr[$indexSet[$v]]['color'].';"><span class="offMouse">'.$title.'</span><span class="onMouse">'.$date_arr[$indexSet[$v]]['title'].'</span></div>');
                                }
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
    </div>
</body>
</html>