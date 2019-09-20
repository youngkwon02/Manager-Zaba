<?php
    session_start();
    $_SESSION['isFirstLoad'] = 'FALSE';
    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        $action = $_GET['action'];
        if($action == 'prevM'){
            $_SESSION['month'] --;
            if($_SESSION['month'] == -1){
                $_SESSION['month'] = 11;
                $_SESSION['year'] -- ;
            }else if($_SESSION['month'] == 12){
                $_SESSION['month'] = 0;
                $_SESSION['year'] ++;
            }
            if($_GET['onPage'] == null){
                header('location: ./home.php#calendar');
            }else{
                header('location: ./manageCalendar.php');
            }
        }else if($action == 'nextM'){
            $_SESSION['month'] ++;
            if($_SESSION['month'] == -1){
                $_SESSION['month'] = 11;
                $_SESSION['year'] -- ;
            }else if($_SESSION['month'] == 12){
                $_SESSION['month'] = 0;
                $_SESSION['year'] ++;
            }
            if($_GET['onPage'] == null){
                header('location: ./home.php#calendar');
            }else{
                header('location: ./manageCalendar.php');
            }
        }else if($action == 'prevY'){
            $_SESSION['year'] --;
            if($_SESSION['year'] == -1){
                $_SESSION['year'] = 0;
            }
            if($_GET['onPage'] == null){
                header('location: ./home.php#calendar');
            }else{
                header('location: ./manageCalendar.php');
            }
        }else if($action == 'nextY'){
            $_SESSION['year'] ++;
            // nextY result $_SESSION[year] is controlled home beacause of $nowY
            if($_GET['onPage'] == null){
                header('location: ./home.php#calendar');
            }else{
                header('location: ./manageCalendar.php');
            }
        }else if($action == 'reset'){
            $_SESSION['isFirstLoad'] = null;
            if($_GET['onPage'] == null){
                header('location: ./home.php#calendar');
            }else{
                header('location: ./manageCalendar.php');
            }
        }
    }else{
        header('location: sign.php');
    }
?>