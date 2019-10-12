<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="styleSheet" href="./assets/css/main.css">
    <script src="./assets/js/jquery-3.4.1.min.js"></script>
    <title>Welcome !</title>
</head>
<script type = "text/javascript" src = "./assets/js/sign_up.js"></script>
<body>
    <div id = "sign_board">
        <div id = "Welcome_Message">
            <h2>Project_Unknown</h2>
            <h5>Welcome to Project_Unknown!</h5>
        </div>
        <div id = "div_signin_form">
            <form method = "POST" action = "./signinAction.php">
                <input class = "signin_form" type = "text" onfocus = "this.value = ''" value = 'E-mail' name = "user_email"><br>
                <input class = "signin_form" type = "password" onfocus = "this.value = ''" value = 'Password' name = "user_passwd">
                <input id = "signin_submit" type = "submit" value = "Sign In">
            </form>
        </div>
    </div>
    <?php
        session_start();
        if($_SESSION['loginERR'] === 'ID'){
            $message = "존재하지 않는 계정입니다.";
            echo('<script>window.onload = function(){
                setTimeout(function(){
                    alert("'.$message.'");
                }, 200);
            }</script>');
            $_SESSION['loginERR'] = null;
        }else if($_SESSION['loginERR'] === 'emptyID'){
            $message = "E-mail을 입력하세요.";
            echo('<script>window.onload = function(){
                setTimeout(function(){
                    alert("'.$message.'");
                }, 200);
            }</script>');
            $_SESSION['loginERR'] = null;
        }else if($_SESSION['loginERR'] === 'PW'){
            $message = "비밀번호가 올바르지 않습니다.";
            echo('<script>window.onload = function(){
                setTimeout(function(){
                    alert("'.$message.'");
                }, 200);
            }</script>');
            $_SESSION['loginERR'] = null;
        }

        if($_SESSION['messageAccessWrong'] != null){
            $message = "잘못된 접근입니다.";
            echo('<script>window.onload = function(){
                setTimeout(function(){
                    alert("'.$message.'");
                }, 200);
            }</script>');
            $_SESSION['messageAccessWrong'] = null;
        }
    ?>
    <div id = "div_signup_form">
        <h2>Sign up</h2><br>  
            <div id = "signup_form">
                Name&nbsp;&nbsp;&nbsp;<span class="div_error" style = "color:red; font-size:12px;"></span><br>
                <input class = "signup_input" id = "signup_name" type = "text" name = "signup_name" ><br>
                Birth&nbsp;&nbsp;&nbsp;<span class="div_error" style = "color:red; font-size:12px;"></span><br>
                <input type="date" id = "signup_birth" name = "signup_birth" value = "<?php $date = date("Y-m-d", time()); $str_date = strtotime($date. '-22 years'); echo date("Y-m-d", $str_date);?>"><br>
                E-mail&nbsp;&nbsp;&nbsp;<span class="div_error" style = "color:red; font-size:12px;"></span><br>
                <input class = "signup_input" id = "signup_email" type = "text" name = "signup_email" ><br>
                Password&nbsp;&nbsp;&nbsp;<span class="div_error" style = "color:red; font-size:12px;"></span><br>
                <input class = "signup_input" id = "signup_password" type = "password" name = "signup_password" ><br>
                Password check&nbsp;&nbsp;&nbsp;<span class="div_error" style = "color:red; font-size:12px;"></span><br>
                <input class = "signup_input" id = "signup_password_check" type = "password" name = "signup_password_check" ><br><br>
                <input type = "button" id = "signup_submit" value = "Sign up" onclick="send_form()"><br><br>
                <input type = "button" id = "signup_cancel" value = "Cancel" onclick="sign_up()"><br>
            </div>
    </div>
    <div id = "sign_up" onclick = "sign_up()">Click me to sign up</div>
</body>
</html>