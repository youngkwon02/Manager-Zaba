<?php
    session_start();
    if($_SESSION['user_name'] === null){
        header('sign.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="./assets/js/jquery-3.4.1.min.js"></script>
    <script src="./assets/js/receiverSearch.js"></script>
    <link rel="stylesheet" href="./assets/css/friendList.css">

    <title>친구 검색</title>
</head>
<body>
<h2><a href="./message.php">←</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$_SESSION['user_name']?></h2>
    <div id="notice">※ 편지를 수신할 친구를 선택하세요.</div>
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
            
            $friendArr = array(array());
            $friendNum = 0;

            
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
                    echo('<div class="eleEtc" onclick="sendMessage('.$i.')">선택</div>');
                    echo('</div>');
                }
                
                if($friendNum>5) {
                    echo('<script>listScroll()</script>');
                }
        ?>        
        </div>

    </div>
</body>
</html>