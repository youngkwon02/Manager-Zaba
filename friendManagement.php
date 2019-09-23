<?php
    session_start();
    if($_SESSION['user_name'] == null){
        header('location: sign.php');
    }

    require 'userDAO.php';
    require 'relationDAO.php';
    $userDAO = new userDAO();
    $relationDAO = new relationDAO();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="./assets/js/jquery-3.4.1.min.js"></script>
    <script src="./assets/js/relation.js"></script>
    <link rel="stylesheet" href="./assets/css/friendManage.css">
    <title>친구 관리</title>
</head>
<body>
    <?php
        if($_SESSION['send_Request'] === 'success'){
            echo('<script>window.onload = function(){
                setTimeout(function(){
                    alert("Successfully sent friend request!");
                }, 200);
            }</script>');
            $_SESSION['send_Request'] = null;
        }else if($_SESSION['send_Request'] === 'already'){
            echo('<script>window.onload = function(){
                setTimeout(function(){
                    alert("Already waiting for friend\'s response.");
                }, 200);
            }</script>');
            $_SESSION['send_Request'] = null;
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
    ?>

    <?php
        $user_email = $userDAO->get_userEmail($_SESSION['user_name']);
        $receiveNum = $relationDAO->getNumOfReceiveRequest($user_email);
        $sendNum = $relationDAO->getNumOfSendRequest($user_email);
    ?>

    <div id="inner">
        <div id="waitingReceiveRequest"><a href="./waitingList.php">받은 요청 : <?= $receiveNum ?></a></div>
        <div id="waitingSendRequest"><a href="./waitingList.php">보낸 요청 : <?= $sendNum ?></a></div>
        <div id="back"><a href="./home.php"><img src="./images/back.png"></a></div>
        <input id="searchBar" type="text" name="searchBar" value="Enter your friend's name or email!">
        <div id="result">
            <div id="result_num"></div>
            <div id="result_name"></div>
            <div id="result_email"></div>
            <div id="result_birth"></div>
            <div id="result_nick"></div>
            <div id="sendRequest"></div>
            <div id="deleteFriend"></div>
        </div>
    </div>
</body>
</html>