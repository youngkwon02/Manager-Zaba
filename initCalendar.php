<?php
    session_start();
    $dayArr = ['MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT', 'SUN'];
    $monthArr = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    $yearArr = [];
    $present_Y = date('Y', time());
    for($i = 1960; $i < $present_Y + 10; $i++) {
        $yearArr[] = $i;
    }

    if($_SESSION['isFirstLoad'] == null){
        $now_M = date('m', time());
        $now_Y = date('Y', time());
        $numOfDay = cal_days_in_month(CAL_GREGORIAN, $now_M, $now_Y); //이번달의 일 수
        $flag = 'none';
        $now_M --;
        if($now_M == 0){
            $now_M = 12;
            $now_Y --;
            $flag = 'prev';
        }
        $prevNumOfDay = cal_days_in_month(CAL_GREGORIAN, $now_M, $now_Y); //지난달의 일 수
        if($flag == 'prev'){
            $now_M = 1;
            $now_Y++;
        }else {
            $now_M++;
        }

        $now_M ++;
        if($now_M == 13){
            $now_M = 1;
            $now_Y ++;
            $flag = 'next';
        }
        $prevNumOfDay = cal_days_in_month(CAL_GREGORIAN, $now_M, $now_Y); //다음달의 일 수
        if($flag == 'next'){
            $now_M = 12;
            $now_Y--;
        }else {
            $now_M--;
        }
    
        // $startDayNum = 6; //이번달의 시작 요일 0 to 6
        $startDayNum = date('w', mktime(12, 0, 0, $now_M, 1, $now_Y)) - 1;
        if($startDayNum == -1) {
            $startDayNum = 6;
        }
        $todayNum = date('w', time()) - 1; //NOW $startDayNum is num in 0 to 6, 오늘의 요일
        if($todayNum == -1) {
            $todayNum = 6;
        }
        $today = $dayArr[$startDayNum]; //NOW $startDay is string in $dayArr
        
        // Only Here
        $_SESSION['month'] = $now_M - 1; $_SESSION['year'] = $now_Y - 1960;
    }else {
        $now_M = $_SESSION['month'] + 1;
        $now_Y = $_SESSION['year'] + 1960;
        if($_SESSION['year'] > ($present_Y + 9 - 1960)){ $_SESSION['year'] = $present_Y + 9 - 1960; }
        $numOfDay = cal_days_in_month(CAL_GREGORIAN, $now_M, $now_Y); //이번달의 일 수
        
        $flag = 'none';
        $now_M --;
        if($now_M == 0){
            $now_M = 12;
            $now_Y --;
            $flag = 'prev';
        }
        $prevNumOfDay = cal_days_in_month(CAL_GREGORIAN, $now_M, $now_Y); //지난달의 일 수
        if($flag == 'prev'){
            $now_M = 1;
            $now_Y++;
        }else {
            $now_M++;
        }

        $now_M ++;
        if($now_M == 13){
            $now_M = 1;
            $now_Y ++;
            $flag = 'next';
        }
        $prevNumOfDay = cal_days_in_month(CAL_GREGORIAN, $now_M, $now_Y); //다음달의 일 수
        if($flag == 'next'){
            $now_M = 12;
            $now_Y--;
        }else {
            $now_M--;
        }

         // $startDayNum = 6; //이번달의 시작 요일 0 to 6
         $startDayNum = date('w', mktime(12, 0, 0, $now_M, 1, $now_Y)) - 1;
         if($startDayNum == -1) {
             $startDayNum = 6;
         }
         $todayNum = date('w', time()) - 1; //NOW $startDayNum is num in 0 to 6, 오늘의 요일
         if($todayNum == -1) {
             $todayNum = 6;
         }
         $today = $dayArr[$startDayNum]; //NOW $startDay is string in $dayArr
    }
?>