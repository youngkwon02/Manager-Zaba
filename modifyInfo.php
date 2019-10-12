<!-- Session Data를 사용하려면 session_start() 필수 -->
<?php session_start(); ?>
<?php require 'userDAO.php'; ?>
<!-- 이 부분에 session이 없으면 접근 차단하는 코드 작성 필요 -->
<?php
    if($_SESSION['user_name'] == null){
        header('location: sign.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./assets/css/modifyInfo.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>정보 수정</title>
</head>
<body>
    <div id="form">
        <div id="back"><a href="./home.php"><<</a></div>
        <h1 style="font-style : normal;">정보 수정</h1><br>
        <form id="modify_form" method="POST" action="./modifyAction.php">
            <h3>이름 : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php $userDAO = new userDAO(); echo($userDAO->get_userName($userDAO->get_userEmail($_SESSION['user_name']))) ?></h3>
            <h3>E-mail : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php $userDAO = new userDAO(); echo($userDAO->get_userEmail($_SESSION['user_name'])) ?></h3>
            <h3>Nickname : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class="input" type="text" value="<?php $userDAO = new userDAO(); echo($userDAO->get_userNick($userDAO->get_userEmail($_SESSION['user_name']))) ?>" name="nick"></h3>
            <h3>친구 추가를 위한 검색 허용 : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;허용
                <?php
                    if($userDAO->get_searchYN($_SESSION['user_name']) === 'N'){
                        echo('<input type="radio" name="search_YN" value="Y">&nbsp;거부 <input type="radio" name="search_YN" value="N" checked="checked">');
                    }else{
                        echo('<input type="radio" name="search_YN" value="Y" checked="checked">&nbsp;거부 <input type="radio" name="search_YN" value="N">');
                    }
                ?>            
            </h3>
            <h3>Password : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class="input" type="password" name="pass"></h3>
            <h3>Password Check : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class="input" type="password" name="passck"></h3>
            <h5>비밀번호 변경을 원하지 않으시면 Password, Password Check는 빈칸으로 두시면 됩니다.</h5>
            <?php 
                if($_GET['error'] == 1) {
                    echo '<h4>Your nickname is too long!</h4>'; echo '<h4>English is up to 20 characters, Korean is up to 6 characters.</h4>';
                }else if($_GET['error'] == 2) {
                    echo '<h4>Password is incorrect.</h4>';
                }else if($_GET['success'] == 1) {
                    echo '<h2>Data was updated successfully!</h2>';
                }
            ?>
            <input class="apply" type="submit" value="Apply">
        </form>
    </div>
</body>
</html>