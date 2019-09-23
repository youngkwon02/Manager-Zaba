<?php
    session_start();
    if($_SESSION['user_name'] === null){
        header('location: ./sign.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="./assets/js/jquery-3.4.1.min.js"></script>
    <script src="./assets/js/friendList.js"></script>
    <link rel="stylesheet" href="./assets/css/friendList.css">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>친구 목록</title>
</head>
<body>
    <h2><a href="./home.php">←</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$_SESSION['user_name']?></h2>
    <div id="category"><span id="all" onclick="filter('all')">모두</span><span id="recent" onclick="filter('recent')">최근 추가한 친구</span></div>
    <?php
        if($_SESSION['listFilter'] === null){
            $_SESSION['listFilter'] = 'all';
        }
        
        if($_SESSION['deleteFriend'] != null){
            $message = $_SESSION['deleteFriend']."님과의 친구관계를 삭제했습니다.";

            echo('<script>window.onload = function(){
                setTimeout(function(){
                    alert("'.$message.'");
                }, 200);
            }</script>');
            $_SESSION['deleteFriend'] = null;
        }
        
        if($_SESSION['calendarFilter'] === 'REMOVE'){
            $message = $_SESSION['filterTarget']."님의 일정을 표시합니다.";

            echo('<script>window.onload = function(){
                setTimeout(function(){
                    alert("'.$message.'");
                }, 200);
            }</script>');
            $_SESSION['calendarFilter'] = null;
            $_SESSION['filterTarget'] = null;
        }else if($_SESSION['calendarFilter'] === 'SET'){
            $message = $_SESSION['filterTarget']."님의 일정을 표시하지 않습니다.";

            echo('<script>window.onload = function(){
                setTimeout(function(){
                    alert("'.$message.'");
                }, 200);
            }</script>');
            $_SESSION['calendarFilter'] = null;
            $_SESSION['filterTarget'] = null;
        }
    ?> 

    <div id="searchDiv">
        <div id="searchIcon"><img src="./images/search.png"></div>
        <input id="searchBar" type="text" value="친구 리스트 검색">
        <div id="clear" onclick="clear()"></div>
    </div>
    <div id="list">

        <div id="listInner">
        <?php
            require 'userDAO.php';
            require 'relationDAO.php';
            $userDAO = new userDAO();
            $owner_email = $userDAO->get_userEmail($_SESSION['user_name']);
            $relationDAO = new relationDAO();
            
            $filter = $_SESSION['listFilter'];
            echo("<script>filterColor('".$filter."')</script>");
            $friendArr = array(array());
            $friendNum = 0;

            if($filter === 'all'){
                // show all friends
                $result = $relationDAO->getListOfAllFriends($owner_email);
                while($row = mysqli_fetch_array($result)){
                    $friendArr[$friendNum]['email'] = $row[0];
                    $friendArr[$friendNum]['name'] = $userDAO->get_userName($row[0]);
                    $friendNum++;
                }
                $friendArr = $relationDAO->friendListSort($friendArr);

                for($i=0; $i<$friendNum; $i++){
                    $firstName = substr($friendArr[$i]['name'], 0, 3);
                    echo('<div class="no-drag listEle">');
                    echo('<div class="eleImg">'.$firstName.'</div>');
                    echo('<div class="eleName">'.$friendArr[$i]['name'].'</div>');
                    echo('<div class="eleMail">'.$friendArr[$i]['email'].'</div>');
                    if($relationDAO->getCalendarFilter($owner_email, $friendArr[$i]['email'])){
                        echo('<div class="eleFunc"><div class="sendMessage" onclick="sendMessage('.$i.')">쪽지 보내기</div><div class="noExpress" onclick="removeCalendarFilter('.$i.')">일정 표시하기</div><div class="deleteFriend" onclick="deleteFriend('.$i.')">친구 삭제</div></div>');
                    }else{
                        echo('<div class="eleFunc"><div class="sendMessage" onclick="sendMessage('.$i.')">쪽지 보내기</div><div class="noExpress" onclick="setCalendarFilter('.$i.')">일정 표시 안함</div><div class="deleteFriend" onclick="deleteFriend('.$i.')">친구 삭제</div></div>');
                    }
                    echo('<div class="eleEtc" onclick="etcFunc('.$i.')">'.'···'.'</div>');
                    echo('</div>');
                }
                
                if($friendNum>5) {
                    echo('<script>listScroll()</script>');
                }
                
                
            }else if($filter === 'recent'){
                // show recent friends
                $result = $relationDAO->getListOfRecentFriends($owner_email);
                while($row = mysqli_fetch_array($result)){
                    $friendArr[$friendNum]['email'] = $row[0];
                    $friendArr[$friendNum]['name'] = $userDAO->get_userName($row[0]);
                    $friendNum++;
                }
                $friendArr = $relationDAO->friendListSort($friendArr);

                for($i=0; $i<$friendNum; $i++){
                    $firstName = substr($friendArr[$i]['name'], 0, 3);
                    echo('<div class="no-drag listEle">');
                    echo('<div class="eleImg">'.$firstName.'</div>');
                    echo('<div class="eleName">'.$friendArr[$i]['name'].'</div>');
                    echo('<div class="eleMail">'.$friendArr[$i]['email'].'</div>');
                    if($relationDAO->getCalendarFilter($owner_email, $friendArr[$i]['email'])){
                        echo('<div class="eleFunc"><div class="sendMessage" onclick="sendMessage('.$i.')">쪽지 보내기</div><div class="noExpress" onclick="removeCalendarFilter('.$i.')">일정 표시하기</div><div class="deleteFriend" onclick="deleteFriend('.$i.')">친구 삭제</div></div>');
                    }else{
                        echo('<div class="eleFunc"><div class="sendMessage" onclick="sendMessage('.$i.')">쪽지 보내기</div><div class="noExpress" onclick="setCalendarFilter('.$i.')">일정 표시 안함</div><div class="deleteFriend" onclick="deleteFriend('.$i.')">친구 삭제</div></div>');
                    }
                    echo('<div class="eleEtc" onclick="etcFunc('.$i.')">'.'···'.'</div>');
                    echo('</div>');
                }
                
                if($friendNum>5) {
                    echo('<script>listScroll()</script>');
                }
                
            }
        ?>        
        </div>

    </div>
</body>
</html>