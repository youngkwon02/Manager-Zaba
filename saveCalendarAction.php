<?php
    session_start();
    if($_SESSION['user_name'] == null) {
        header('location: sign.php');
    }
    require 'userDAO.php';
    require 'calendarDAO.php';

    $userDAO = new userDAO();
    $calendarDAO = new calendarDAO();

    $title = $_POST['title'];
    $success = true;
    if(trim($title) == '' || trim($title) == null) {
        $success = false;
        header('location: ./saveCalendar.php?FAIL=title');
    }

    if(strpos($title, "'") !== false){
        $success = false;
        header('location: ./saveCalendar.php?FAIL=titleException');
    }

    $user_email = $userDAO->get_userEmail($_SESSION['user_name']);

    $start_year = str_replace('년', '', $_POST['startY']);
    $start_month = str_replace('월', '', $_POST['startM']);
    if(strlen($start_month) == 1){
        $start_month = '0'.$start_month;
    }
    $start_day = str_replace('일', '', $_POST['startD']);
    if(strlen($start_day) == 1){
        $start_day = '0'.$start_day;
    }
    $start_date = $start_year.'-'.$start_month.'-'.$start_day;

    $end_year = str_replace('년', '', $_POST['endY']);
    $end_month = str_replace('월', '', $_POST['endM']);
    if(strlen($end_month) == 1){
        $end_month = '0'.$end_month;
    }
    $end_day = str_replace('일', '', $_POST['endD']);
    if(strlen($end_day) == 1){
        $end_day = '0'.$end_day;
    }
    $end_date = $end_year.'-'.$end_month.'-'.$end_day;

    if($end_date < $start_date) {
        $success = false;
        header('location: ./saveCalendar.php?FAIL=date');
    }

    $share_YN = $_POST['shareYN'];

    $color = $_POST['color'];


    if($success === true){
        $calendarDAO->add_date($title, $user_email, $start_date, $end_date, $share_YN, $color);
        header('location: ./saveCalendar.php');
    }
?>