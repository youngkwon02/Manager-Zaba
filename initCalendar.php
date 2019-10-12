<?php
    session_start();
    $dayArr = ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'];
    $monthArr = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    $yearArr = [];
    $present_Y = date('Y', time());
    for($i = 1960; $i < $present_Y + 10; $i++) {
        $yearArr[] = $i;
    }

    if($_SESSION['isFirstLoad'] == null){
        $now_Y = date('Y', time());
        $now_M = date('m', time());
        $now_D = date('d', time());

        $prev_Y = $now_Y;
        $next_Y = $now_Y;

        $prev_M = $now_M - 1;
        if($prev_M == 0){
            $prev_M = 12;
            $prev_Y--;
        }

        $next_M = $now_M + 1;
        if($next_M == 13){
            $next_M = 1;
            $next_Y++;
        }

        $numOfDay = cal_days_in_month(CAL_GREGORIAN, $now_M, $now_Y); //이번달의 일 수
        $prevNumOfDay = cal_days_in_month(CAL_GREGORIAN, $prev_M, $prev_Y); //지난달의 일 수
        $nextNumOfDay = cal_days_in_month(CAL_GREGORIAN, $next_M, $next_Y); //다음달의 일 수
        
    
        // $startDayNum = 6; //이번달의 시작 요일 0 to 6
        // $startDayNum = date('w', mktime(12, 0, 0, $now_M, 1, $now_Y))-1;
         $startDayNum = date('w', mktime(12, 0, 0, $now_M, 1, $now_Y));
        // if($startDayNum == -1) {
        //     $startDayNum = 6;
        // }
        //$todayNum = date('w', time()) - 1; //NOW $startDayNum is num in 0 to 6, 오늘의 요일
        $todayNum = date('w', time());
        // if($todayNum == -1) {
        //     $todayNum = 6;
        // }
        $today = $dayArr[$startDayNum]; //NOW $startDay is string in $dayArr
        
        // Only Here
        $_SESSION['month'] = $now_M - 1; $_SESSION['year'] = $now_Y - 1960;
    }else {
        $now_M = $_SESSION['month'] + 1;
        $now_Y = $_SESSION['year'] + 1960;
        if($_SESSION['year'] > ($present_Y + 9 - 1960)){ $_SESSION['year'] = $present_Y + 9 - 1960; }
        $numOfDay = cal_days_in_month(CAL_GREGORIAN, $now_M, $now_Y); //이번달의 일 수
        
        $prev_Y = $now_Y;
        $next_Y = $now_Y;

        $prev_M = $now_M - 1;
        if($prev_M == 0){
            $prev_M = 12;
            $prev_Y--;
        }

        $next_M = $now_M + 1;
        if($next_M == 13){
            $next_M = 1;
            $next_Y++;
        }

        $numOfDay = cal_days_in_month(CAL_GREGORIAN, $now_M, $now_Y); //이번달의 일 수
        $prevNumOfDay = cal_days_in_month(CAL_GREGORIAN, $prev_M, $prev_Y); //지난달의 일 수
        $nextNumOfDay = cal_days_in_month(CAL_GREGORIAN, $next_M, $next_Y); //다음달의 일 수
        

         // $startDayNum = 6; //이번달의 시작 요일 0 to 6
        //  $startDayNum = date('w', mktime(12, 0, 0, $now_M, 1, $now_Y)) - 1;
        $startDayNum = date('w', mktime(12, 0, 0, $now_M, 1, $now_Y));
        //  if($startDayNum == -1) {
        //      $startDayNum = 6;
        //  }
         //$todayNum = date('w', time()) - 1; //NOW $startDayNum is num in 0 to 6, 오늘의 요일
         $todayNum = date('w', time()); //NOW $startDayNum is num in 0 to 6, 오늘의 요일
        //  if($todayNum == -1) {
        //      $todayNum = 6;
        //  }
         $today = $dayArr[$startDayNum]; //NOW $startDay is string in $dayArr
    }
?>