<?php
    session_start();
    if($_SESSION['user_name'] === null || $_SESSION['readingTarget'] === null){
        header('location: sign.php');
    }else{
        $title = $_SESSION['readingTarget']['title'] ? $_SESSION['readingTarget']['title'] : '제목 없음';
        $text = $_SESSION['readingTarget']['text'] ? $_SESSION['readingTarget']['text'] : '내용 없음';
        $receiver_email = $_SESSION['readingTarget']['receiver_email'];
        $receiver_name = $_SESSION['readingTarget']['receiver_name'];
        $writer_email = $_SESSION['readingTarget']['writer_email'];
        $writer_name = $_SESSION['readingTarget']['writer_name'];
        $send_date = $_SESSION['readingTarget']['send_date'];
        if($send_date != null){
            $send_date = substr($send_date, 0, 16);
        }
        $read_date = $_SESSION['readingTarget']['read_date'];
        if($read_date != null){
            $read_date = substr($read_date, 0, 16);
        }

        if($receiver_name === $_SESSION['user_name']){
            $message_type = '받은 편지';
        }else{
            $message_type = '보낸 편지';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./assets/css/messageRead.css">
    <title>Message Box</title>
</head>
<body>
    <div id="inner">
        <div id="firstRow"><header><?= $title ?></header><div id="back"><a href="./message.php">X</a></div></div>
        <div id="thirdRow">
            <div id="messageType"><?= $message_type ?></div>
            <?php
                if($message_type === '받은 편지'){
                    echo('<div class="targetInfo" id="writerName">'.'&lt;'.$writer_name.'&gt; : '.$writer_email.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;⇒&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;'.$receiver_name.'&gt; : '.$receiver_email.'</div>');
                }else{
                    echo('<div class="targetInfo" id="writerName">'.'&lt;'.$writer_name.'&gt; : '.$writer_email.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;⇒&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&lt;'.$receiver_name.'&gt; : '.$receiver_email.'</div>');                
                }
            ?>
            <div id="date">
                <?php
                    if($message_type === '받은 편지'){
                        echo('<div>받은 날짜 : '.$send_date.'</div>');
                        echo('<div>읽은 날짜 : '.$read_date.'</div>');
                    }else{
                        echo('<div>보낸 날짜 : '.$send_date.'</div>');
                        if($read_date === null){
                            echo('<div>읽음 여부 : 읽지 않음</div>');
                        }else{
                            echo('<div>읽은 날짜 : '.$read_date.'</div>');
                        }
                    }
                ?>
            </div>
        </div>
        <textarea id="messageText" uneditable="true"><?= $text ?></textarea>
    </div>
</body>
</html>