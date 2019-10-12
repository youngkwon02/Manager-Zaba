<?php
    session_start();
    if($_SESSION['user_name'] === null){
        header('location: sign.php');
    }else if($_SESSION['sendSuccess'] === null){
        header('location: message.php');
    }else{?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <script src="./assets/js/message.js"></script>    
            <link rel="stylesheet" href="./assets/css/sendSuccess.css">
            <title>편지 전송 성공</title>
        </head>
        <body>
            <div id="inner">
                <h1>편지 전송 성공!</h1><br><br>
                <p>
                    <?= $_SESSION['sendSuccess'] ?>님께 보내신 편지가 정상적으로 전송되었습니다.<br><br>
                    이동하실 탭을 선택해주세요.<br><br><br><br>
                    <input type="button" value="홈" onclick="navigateTo('home')">
                    <input type="button" value="편지함" onclick="navigateTo('mailBox')">
                    <input type="button" value="편지 쓰기" onclick="navigateTo('writeMessage')"><br><br><br>
                    <img src="./images/sendRequest.png">
                </p>
            </div>
        </body>
        </html>
<?php
    }
?>