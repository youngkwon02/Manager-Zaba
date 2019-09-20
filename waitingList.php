<?php
    session_start();
    if($_SESSION['user_name'] == null) {
        header('location: sign.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="./assets/js/jquery-3.4.1.min.js"></script>
    <script src="./assets/js/waitingList.js"></script>
    <link rel="stylesheet" href="./assets/css/friendManage.css">
    <title>대기중인 목록</title>
</head>
<?php
    if($_SESSION['accept'] != null){
        $message = $_SESSION['accept']."님의 친구요청을 수락하셨습니다.";
        echo('<script>window.onload = function(){
            setTimeout(function(){
                alert("'.$message.'");
            }, 200);
        }</script>');
        $_SESSION['accept'] = null;
    }
    if($_SESSION['reject'] != null){
        $message = $_SESSION['reject']."님의 친구요청을 거절하셨습니다.";
        echo('<script>window.onload = function(){
            setTimeout(function(){
                alert("'.$message.'");
            }, 200);
        }</script>');
        $_SESSION['reject'] = null;
    }
?>
<body>
    <div id="listBoard">
        <h1 id="receiveTitle">받은 친구요청</h1>
        <h1 id="sendTitle">대기중인 친구요청</h1>
        <div id="receiveList">
            <ol>
                <?php
                    require './userDAO.php';
                    require './relationDAO.php';
                    $userDAO = new userDAO();
                    $relationDAO = new relationDAO();
                    $owner_email = $userDAO->get_userEmail($_SESSION['user_name']);
                    
                    $result = $relationDAO->getListOfReceiveRequest($owner_email);
                    $receiveNum = 0;
                    while($row = mysqli_fetch_array($result)){
                        $receiveNum++;
                        $requester_email = $row[0];
                        $requester_name = $userDAO->get_userName($requester_email);
                        echo('<li>이름 : '.$requester_name.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;( <span style="cursor: pointer;" onclick="acceptRequest(\''.$requester_email.'\', \''.$owner_email.'\')">수락</span> / <span style="cursor: pointer;" onclick="rejectRequest(\''.$requester_email.'\', \''.$owner_email.'\')">거절</span> )<br>계정 : '.$requester_email.'</li>');
                    }
                    if($receiveNum > 9){
                        echo("<script>makeListScroll('receiveList')</script>");
                    }
                ?>
            </ol>
        </div>
        <div id="sendList">
            <ol>
                <?php                    
                    $result = $relationDAO->getListOfSendRequest($owner_email);
                    $sendNum = 0;
                    while($row = mysqli_fetch_array($result)){
                        $sendNum++;
                        $responser_email = $row[0];
                        $responser_name = $userDAO->get_userName($responser_email);
                        echo('<li>이름 : '.$responser_name.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(<span style="cursor: pointer;" onclick="cancelRequest(\''.$owner_email.'\',\''.$responser_email.'\')">친구요청 취소</span>)<br>계정 : '.$responser_email.'</li>');
                    }
                    if($sendNum > 9){
                        echo("<script>makeListScroll('sendList')</script>");
                    }
                ?>
            </ol>
        </div>
    </div>
</body>
</html>