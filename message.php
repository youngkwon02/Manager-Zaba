<?php
    session_start();
    if($_SESSION['user_name'] === null){
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
    <script src="./assets/js/message.js"></script>
    <link rel="stylesheet" href="./assets/css/message.css">
    <title>Message Box</title>
</head>
<body>
    <div id="inner">
        <section id="header">
            <div id="back"><a href="./home.php">←</a></div>
            <div id="messageIcon"><a href="messageRedirect.php"><img src="./images/mail.png"></a></div>
            <div id="headerTitle">Zaba Message Box</div>
            
        </section>
        <section id="tabBar">
            <input id="writeButton" type="button" value="+ 편지쓰기" onclick="writeMessage()">
            <div id="indexAll" onclick="changeSelect('all')">Ａ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;전체 편지함</div>
            <div id="indexReceive" onclick="changeSelect('receive')">Ｒ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;받은 편지함</div>
            <div id="indexSend" onclick="changeSelect('send')">Ｓ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;보낸 편지함</div>
            <div id="indexImportant" onclick="changeSelect('important')">★&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;중요 편지함</div>
            <div id="indexDelete" onclick="changeSelect('delete')">Ｄ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;삭제 편지함</div>
        </section>
        <section id="content">
            <?php
                $_SESSION['sendSuccess'] = null;

                if($_SESSION['page'] === null){
                    $_SESSION['page'] = 1;
                }

                $page = $_SESSION['page'];

                require 'userDAO.php';
                require 'messageDAO.php';
                $userDAO = new userDAO();
                $messageDAO = new messageDAO();

                $user_email = $userDAO->get_userEmail($_SESSION['user_name']);
                
                if($_SESSION['messageException'] != null){
                    $_SESSION['selected'] = 'writeMessage';
                }
                if($_SESSION['selected'] === null){
                    $_SESSION['selected'] = 'allMessage';
                    $selected = 'allMessage';
                }else{
                    $selected = $_SESSION['selected'];
                }
                
                if($selected === 'writeMessage'){
            ?>
                <form id="writeForm" method="POST" action="writeMessageAction.php">
                    <?php
                        if($_SESSION['receiver_email'] != null){
                            echo('<div id="writeForm_receiver">받는 사람 : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="receiver" value="'.$_SESSION['receiver_email'].'"><input id="addReceiverButton" type="button" name="addReceiver" onclick="friendSearch()" value="친구 검색"></div>');
                            $_SESSION['receiver_email'] = null;
                        }else{
                    ?>

                    <div id="writeForm_receiver">받는 사람 : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="receiver"><input id="addReceiverButton" type="button" name="addReceiver" onclick="friendSearch()" value="친구 검색"><?php if($_SESSION['messageException']==='receiver'){ echo('<div id="errMessage">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;받는 사람과 친구가 아닙니다.</div>'); } ?></div>
                        <?php } ?>
                    <div id="writeForm_writer">보내는 사람 : &nbsp;&nbsp;&nbsp;&nbsp;<?php echo('<input type="text" name="writer" value="'.$user_email.'" readonly>'); if($_SESSION['messageException']==='writer'){ echo('<div id="errMessage">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;보내는 사람이 정확하지 않습니다.</div>'); } ?></div>
                    <div id="writeForm_title">제목 : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="title"><?php if($_SESSION['messageException']==='title'){ echo('<div id="errMessage">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;제목은 영문 51자, 한글 17자까지 입력 가능합니다.</div>'); }else if($_SESSION['messageException'] === 'titleUnexpected'){ echo('<div id="errMessage">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;제목에 포함될 수 없는 특수문자가 포함되어있습니다.</div>'); } ?></div>
                    <div id="writeForm_context">
                        <div>내용&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="submit" value="보내기"><?php if($_SESSION['messageException']==='text'){ echo('<div id="errMessage">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;내용은 영문 210자, 한글 70자까지 입력 가능합니다.</div>'); }else if($_SESSION['messageException'] === 'textUnexpected'){ echo('<div id="errMessage">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;내용에 포함될 수 없는 특수문자가 포함되어있습니다.</div>');} ?>
                        </div>
                        <textarea name="text"></textarea>
                    </div>
                    <?php $_SESSION['messageException'] = null; ?>
                </form>
            <?php
                }else if($selected === 'allMessage'){
            ?>
                <div id="message">
                <div id="empty"></div>
                    <div id="topBar">
                        <input id = "allCheck" type="checkbox" name="allCheck">
                        <?php echo('<input id="selectDelete" type="button" name="selectDelete" value="선택 편지 삭제" onclick="selectDelete('.$page.')">'); ?>
                        <?php echo('<input id="selectImportant" type="button" name="selectImportant" value="선택 편지 중요" onclick="selectImportant('.$page.')">'); ?>
                        <input id = "allDelete" type="button" name="allDelete" value="전체 편지 삭제" onclick="allDelete()">
                    </div>

                    <div id="contentInner">
                        <?php
                            $result = $messageDAO->get_allMessage($user_email);
                            $index = 0;
                            while($row = mysqli_fetch_assoc($result)){
                                if(mb_strlen($row['title'], 'utf-8') > 15){
                                    $row['title'] = mb_substr($row['title'], 0, 15, 'utf-8');
                                    $row['title'] = $row['title'].'..';
                                }else{
                                    $row['title'] = mb_substr($row['title'], 0, 15, 'utf-8');
                                }

                                if(mb_strlen($row['text'], 'utf-8') > 15){
                                    $row['text'] = mb_substr($row['text'], 0, 15, 'utf-8');
                                    $row['text'] = $row['text'].'..';
                                }else{
                                    $row['text'] = mb_substr($row['text'], 0, 15, 'utf-8');
                                }
                                $index++;
                                if($_SESSION['page']*20<$index || $index<=($_SESSION['page'] - 1)*20){
                                    continue;
                                }
                                if($row['writer_email'] === $user_email){
                                    echo('<div class="sendMessageEle">');
                                        echo('<input class="checkbox" type="checkbox" id="check'.$index.'">');

                                        if($row['writer_Important_YN'] === 'Y'){
                                            echo('<div class="star" id="star'.$index.'" style="color: deepskyblue;" onclick="toggleImportant('.$index.')">★</div>');
                                        }else{
                                            echo('<div class="star" id="star'.$index.'" onclick="toggleImportant('.$index.')">☆</div>');
                                        }
                                        
                                        echo('<div class="send_receive">보낸 편지</div>');

                                        if($row['read_YN'] === 'Y'){
                                            echo('<div class="readYN" style="color: rgba(0, 0, 0, .6);">Read</div>');
                                        }else{
                                            echo('<div class="readYN" style="color: rgba(0, 0, 0, 1);">Unread</div>');
                                        }

                                        if($row['receiver_email'] === $user_email){
                                            echo('<div class="target"><span class="targetText" onclick="sendMessage('.$index.')">'.$row['writer_email'].'</span></div>');
                                        }else{
                                            echo('<div class="target"><span class="targetText" onclick="sendMessage('.$index.')">'.$row['receiver_email'].'</span></div>');
                                        }

                                        echo('<div class="content" onclick="readMessage('.$row['message_seq'].')">제목 : '.$row['title'].'&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;내용 : '.$row['text'].'</div>');
                                        echo('<div class="timeStamp">'.$row['send_date'].'</div>');
                                    echo('</div>');
                                }else{
                                    echo('<div class="receiveMessageEle">');
                                        echo('<input class="checkbox" type="checkbox" id="check'.$index.'">');

                                        if($row['receiver_Important_YN'] === 'Y'){
                                            echo('<div class="star" id="star'.$index.'" style="color: deepskyblue;" onclick="toggleImportant('.$index.')">★</div>');
                                        }else{
                                            echo('<div class="star" id="star'.$index.'" onclick="toggleImportant('.$index.')">☆</div>');
                                        }
                                        
                                        echo('<div class="send_receive">받은 편지</div>');

                                        if($row['read_YN'] === 'Y'){
                                            echo('<div class="readYN" style="color: rgba(0, 0, 0, .6);">Read</div>');
                                        }else{
                                            echo('<div class="readYN" style="color: rgba(0, 0, 0, 1);">Unread</div>');
                                        }

                                        if($row['receiver_email'] === $user_email){
                                            echo('<div class="target"><span class="targetText" onclick="sendMessage('.$index.')">'.$row['writer_email'].'</span></div>');
                                        }else{
                                            echo('<div class="target"><span class="targetText" onclick="sendMessage('.$index.')">'.$row['receiver_email'].'</span></div>');
                                        }

                                        echo('<div class="content" onclick="readMessage('.$row['message_seq'].')">제목 : '.$row['title'].'&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;내용 : '.$row['text'].'</div>');
                                        echo('<div class="timeStamp">'.$row['send_date'].'</div>');
                                    echo('</div>');
                                }
                            }
                        echo('</div>');
                    $_SESSION['indexCounter'] = (($index-1) - (($index-1) % 20))/20 + 2;

                    echo('<div id="pageIndex"><a class="triangle" href="pageMove.php?Page=before">◀</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'); 
                        for($i = 1; $i < $_SESSION['indexCounter']; $i++){
                            if($i == $_SESSION['page']){
                                if($i === 1){
                                    echo('<a id="selectedIndex" href="pageMove.php?Page='.$i.'">'.$i.'</a>');
                                }else{
                                    echo('&nbsp;&nbsp;&nbsp;<a id="selectedIndex" href="pageMove.php?Page='.$i.'">'.$i.'</a>');
                                }
                            }else{
                                if($i === 1){
                                    echo('<a id="unselectedIndex" href="pageMove.php?Page='.$i.'">'.$i.'</a>');
                                }else{
                                    echo('&nbsp;&nbsp;&nbsp;<a id="unselectedIndex" href="pageMove.php?Page='.$i.'">'.$i.'</a>');
                                }
                            }
                        }
                    echo('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="triangle" href="pageMove.php?Page=after">▶</a></div>');
                ?>
                </div>
            <?php
                }else if($selected === 'receiveMessage'){
            ?>
                <div id="message">
                <div id="empty"></div>
                    <div id="topBar">
                        <input id = "allCheck" type="checkbox" name="allCheck">
                        <?php echo('<input id="selectDelete" type="button" name="selectDelete" value="선택 편지 삭제" onclick="selectDelete('.$page.')">'); ?>
                        <?php echo('<input id="selectImportant" type="button" name="selectImportant" value="선택 편지 중요" onclick="selectImportant('.$page.')">'); ?>
                        <input id = "allDelete" type="button" name="allDelete" value="전체 편지 삭제" onclick="allDelete()">
                    </div>
                    <div id="contentInner">
                        <?php
                            $result = $messageDAO->get_receiveMessage($user_email);
                            $index = 0;
                            while($row = mysqli_fetch_assoc($result)){
                                $index++;
                                if($_SESSION['page']*20<$index || $index<=($_SESSION['page'] - 1)*20){
                                    continue;
                                }
                                if($row['writer_email'] === $user_email){
                                    echo('<div class="sendMessageEle">');
                                        echo('<input class="checkbox" type="checkbox" id="check'.$index.'">');

                                        if($row['writer_Important_YN'] === 'Y'){
                                            echo('<div class="star" id="star'.$index.'" style="color: deepskyblue;" onclick="toggleImportant('.$index.')">★</div>');
                                        }else{
                                            echo('<div class="star" id="star'.$index.'" onclick="toggleImportant('.$index.')">☆</div>');
                                        }
                                        
                                        echo('<div class="send_receive">보낸 편지</div>');

                                        if($row['read_YN'] === 'Y'){
                                            echo('<div class="readYN" style="color: rgba(0, 0, 0, .6);">Read</div>');
                                        }else{
                                            echo('<div class="readYN" style="color: rgba(0, 0, 0, 1);">Unread</div>');
                                        }

                                        if($row['receiver_email'] === $user_email){
                                            echo('<div class="target"><span class="targetText" onclick="sendMessage('.$index.')">'.$row['writer_email'].'</span></div>');
                                        }else{
                                            echo('<div class="target"><span class="targetText" onclick="sendMessage('.$index.')">'.$row['receiver_email'].'</span></div>');
                                        }

                                        echo('<div class="content" onclick="readMessage('.$row['message_seq'].')">제목 : '.$row['title'].'&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;내용 : '.$row['text'].'</div>');
                                        echo('<div class="timeStamp">'.$row['send_date'].'</div>');
                                    echo('</div>');
                                }else{
                                    echo('<div class="receiveMessageEle">');
                                        echo('<input class="checkbox" type="checkbox" id="check'.$index.'">');

                                        if($row['receiver_Important_YN'] === 'Y'){
                                            echo('<div class="star" id="star'.$index.'" style="color: deepskyblue;" onclick="toggleImportant('.$index.')">★</div>');
                                        }else{
                                            echo('<div class="star" id="star'.$index.'" onclick="toggleImportant('.$index.')">☆</div>');
                                        }
                                        
                                        echo('<div class="send_receive">받은 편지</div>');

                                        if($row['read_YN'] === 'Y'){
                                            echo('<div class="readYN" style="color: rgba(0, 0, 0, .6);">Read</div>');
                                        }else{
                                            echo('<div class="readYN" style="color: rgba(0, 0, 0, 1);">Unread</div>');
                                        }

                                        if($row['receiver_email'] === $user_email){
                                            echo('<div class="target"><span class="targetText" onclick="sendMessage('.$index.')">'.$row['writer_email'].'</span></div>');
                                        }else{
                                            echo('<div class="target"><span class="targetText" onclick="sendMessage('.$index.')">'.$row['receiver_email'].'</span></div>');
                                        }

                                        echo('<div class="content" onclick="readMessage('.$row['message_seq'].')">제목 : '.$row['title'].'&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;내용 : '.$row['text'].'</div>');
                                        echo('<div class="timeStamp">'.$row['send_date'].'</div>');
                                    echo('</div>');
                                }
                            }
                        echo('</div>');
                    $_SESSION['indexCounter'] = (($index-1) - (($index-1) % 20))/20 + 2;

                    echo('<div id="pageIndex"><a class="triangle" href="pageMove.php?Page=before">◀</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'); 
                        for($i = 1; $i < $_SESSION['indexCounter']; $i++){
                            if($i == $_SESSION['page']){
                                if($i === 1){
                                    echo('<a id="selectedIndex" href="pageMove.php?Page='.$i.'">'.$i.'</a>');
                                }else{
                                    echo('&nbsp;&nbsp;&nbsp;<a id="selectedIndex" href="pageMove.php?Page='.$i.'">'.$i.'</a>');
                                }
                            }else{
                                if($i === 1){
                                    echo('<a id="unselectedIndex" href="pageMove.php?Page='.$i.'">'.$i.'</a>');
                                }else{
                                    echo('&nbsp;&nbsp;&nbsp;<a id="unselectedIndex" href="pageMove.php?Page='.$i.'">'.$i.'</a>');
                                }
                            }
                        }
                    echo('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="triangle" href="pageMove.php?Page=after">▶</a></div>');
                ?>
                </div>
            <?php
                }else if($selected === 'sendMessage'){
                    ?>
                        <div id="message">
                        <div id="empty"></div>
                        <div id="topBar">
                            <input id = "allCheck" type="checkbox" name="allCheck">
                            <?php echo('<input id="selectDelete" type="button" name="selectDelete" value="선택 편지 삭제" onclick="selectDelete('.$page.')">'); ?>
                            <?php echo('<input id="selectImportant" type="button" name="selectImportant" value="선택 편지 중요" onclick="selectImportant('.$page.')">'); ?>
                            <input id = "allDelete" type="button" name="allDelete" value="전체 편지 삭제" onclick="allDelete()">
                        </div>
                            <div id="contentInner">
                                <?php
                                    $result = $messageDAO->get_sendMessage($user_email);
                                    $index = 0;
                                    while($row = mysqli_fetch_assoc($result)){
                                        $index++;
                                        if($_SESSION['page']*20<$index || $index<=($_SESSION['page'] - 1)*20){
                                            continue;
                                        }
                                        if($row['writer_email'] === $user_email){
                                            echo('<div class="sendMessageEle">');
                                                echo('<input class="checkbox" type="checkbox" id="check'.$index.'">');
        
                                                if($row['writer_Important_YN'] === 'Y'){
                                                    echo('<div class="star" id="star'.$index.'" style="color: deepskyblue;" onclick="toggleImportant('.$index.')">★</div>');
                                                }else{
                                                    echo('<div class="star" id="star'.$index.'" onclick="toggleImportant('.$index.')">☆</div>');
                                                }
                                                
                                                echo('<div class="send_receive">보낸 편지</div>');
        
                                                if($row['read_YN'] === 'Y'){
                                                    echo('<div class="readYN" style="color: rgba(0, 0, 0, .6);">Read</div>');
                                                }else{
                                                    echo('<div class="readYN" style="color: rgba(0, 0, 0, 1);">Unread</div>');
                                                }
        
                                                if($row['receiver_email'] === $user_email){
                                                    echo('<div class="target"><span class="targetText" onclick="sendMessage('.$index.')">'.$row['writer_email'].'</span></div>');
                                                }else{
                                                    echo('<div class="target"><span class="targetText" onclick="sendMessage('.$index.')">'.$row['receiver_email'].'</span></div>');
                                                }
        
                                                echo('<div class="content" onclick="readMessage('.$row['message_seq'].')">제목 : '.$row['title'].'&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;내용 : '.$row['text'].'</div>');
                                                echo('<div class="timeStamp">'.$row['send_date'].'</div>');        
                                            echo('</div>');
                                        }else{
                                            echo('<div class="receiveMessageEle">');
                                                echo('<input class="checkbox" type="checkbox" id="check'.$index.'">');
        
                                                if($row['receiver_Important_YN'] === 'Y'){
                                                    echo('<div class="star" id="star'.$index.'" style="color: deepskyblue;" onclick="toggleImportant('.$index.')">★</div>');
                                                }else{
                                                    echo('<div class="star" id="star'.$index.'" onclick="toggleImportant('.$index.')">☆</div>');
                                                }
                                                
                                                echo('<div class="send_receive">받은 편지</div>');
        
                                                if($row['read_YN'] === 'Y'){
                                                    echo('<div class="readYN" style="color: rgba(0, 0, 0, .6);">Read</div>');
                                                }else{
                                                    echo('<div class="readYN" style="color: rgba(0, 0, 0, 1);">Unread</div>');
                                                }
        
                                                if($row['receiver_email'] === $user_email){
                                                    echo('<div class="target"><span class="targetText" onclick="sendMessage('.$index.')">'.$row['writer_email'].'</span></div>');
                                                }else{
                                                    echo('<div class="target"><span class="targetText" onclick="sendMessage('.$index.')">'.$row['receiver_email'].'</span></div>');
                                                }
        
                                                echo('<div class="content" onclick="readMessage('.$row['message_seq'].')">제목 : '.$row['title'].'&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;내용 : '.$row['text'].'</div>');
                                                echo('<div class="timeStamp">'.$row['send_date'].'</div>');        
                                            echo('</div>');
                                        }
                                    }
                                echo('</div>');
                            $_SESSION['indexCounter'] = (($index-1) - (($index-1) % 20))/20 + 2;
        
                            echo('<div id="pageIndex"><a class="triangle" href="pageMove.php?Page=before">◀</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'); 
                                for($i = 1; $i < $_SESSION['indexCounter']; $i++){
                                    if($i == $_SESSION['page']){
                                        if($i === 1){
                                            echo('<a id="selectedIndex" href="pageMove.php?Page='.$i.'">'.$i.'</a>');
                                        }else{
                                            echo('&nbsp;&nbsp;&nbsp;<a id="selectedIndex" href="pageMove.php?Page='.$i.'">'.$i.'</a>');
                                        }
                                    }else{
                                        if($i === 1){
                                            echo('<a id="unselectedIndex" href="pageMove.php?Page='.$i.'">'.$i.'</a>');
                                        }else{
                                            echo('&nbsp;&nbsp;&nbsp;<a id="unselectedIndex" href="pageMove.php?Page='.$i.'">'.$i.'</a>');
                                        }
                                    }
                                }
                            echo('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="triangle" href="pageMove.php?Page=after">▶</a></div>');
                        ?>
                        </div>
                    <?php
                        }else if($selected === 'importantMessage'){
                        ?>
                            <div id="message">
                            <div id="empty"></div>
                            <div id="topBar">
                                <input id = "allCheck" type="checkbox" name="allCheck">
                                <?php echo('<input id="selectDelete" type="button" name="selectDelete" value="선택 편지 삭제" onclick="selectDelete('.$page.')">'); ?>
                                <?php echo('<input id="selectImportant" type="button" name="selectImportant" value="선택 편지 중요" onclick="selectImportant('.$page.')">'); ?>
                                <input id = "allDelete" type="button" name="allDelete" value="전체 편지 삭제" onclick="allDelete()">
                            </div>
                            <div id="contentInner">
                                <?php
                                    $result = $messageDAO->get_importantMessage($user_email);
                                    $index = 0;
                                    while($row = mysqli_fetch_assoc($result)){
                                        $index++;
                                        if($_SESSION['page']*20<$index || $index<=($_SESSION['page'] - 1)*20){
                                            continue;
                                        }
                                        if($row['writer_email'] === $user_email){
                                            echo('<div class="sendMessageEle">');
                                                echo('<input class="checkbox" type="checkbox" id="check'.$index.'">');
        
                                                if($row['writer_Important_YN'] === 'Y'){
                                                    echo('<div class="star" id="star'.$index.'" style="color: deepskyblue;" onclick="toggleImportant('.$index.')">★</div>');
                                                }else{
                                                    echo('<div class="star" id="star'.$index.'" onclick="toggleImportant('.$index.')">☆</div>');
                                                }
                                                
                                                echo('<div class="send_receive">보낸 편지</div>');
        
                                                if($row['read_YN'] === 'Y'){
                                                    echo('<div class="readYN" style="color: rgba(0, 0, 0, .6);">Read</div>');
                                                }else{
                                                    echo('<div class="readYN" style="color: rgba(0, 0, 0, 1);">Unread</div>');
                                                }
        
                                                if($row['receiver_email'] === $user_email){
                                                    echo('<div class="target"><span class="targetText" onclick="sendMessage('.$index.')">'.$row['writer_email'].'</span></div>');
                                                }else{
                                                    echo('<div class="target"><span class="targetText" onclick="sendMessage('.$index.')">'.$row['receiver_email'].'</span></div>');
                                                }
        
                                                echo('<div class="content" onclick="readMessage('.$row['message_seq'].')">제목 : '.$row['title'].'&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;내용 : '.$row['text'].'</div>');
                                                echo('<div class="timeStamp">'.$row['send_date'].'</div>');        
                                            echo('</div>');
                                        }else{
                                            echo('<div class="receiveMessageEle">');
                                                echo('<input class="checkbox" type="checkbox" id="check'.$index.'">');
        
                                                if($row['receiver_Important_YN'] === 'Y'){
                                                    echo('<div class="star" id="star'.$index.'" style="color: deepskyblue;" onclick="toggleImportant('.$index.')">★</div>');
                                                }else{
                                                    echo('<div class="star" id="star'.$index.'" onclick="toggleImportant('.$index.')">☆</div>');
                                                }
                                                
                                                echo('<div class="send_receive">받은 편지</div>');
        
                                                if($row['read_YN'] === 'Y'){
                                                    echo('<div class="readYN" style="color: rgba(0, 0, 0, .6);">Read</div>');
                                                }else{
                                                    echo('<div class="readYN" style="color: rgba(0, 0, 0, 1);">Unread</div>');
                                                }
        
                                                if($row['receiver_email'] === $user_email){
                                                    echo('<div class="target"><span class="targetText" onclick="sendMessage('.$index.')">'.$row['writer_email'].'</span></div>');
                                                }else{
                                                    echo('<div class="target"><span class="targetText" onclick="sendMessage('.$index.')">'.$row['receiver_email'].'</span></div>');
                                                }
        
                                                echo('<div class="content" onclick="readMessage('.$row['message_seq'].')">제목 : '.$row['title'].'&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;내용 : '.$row['text'].'</div>');
                                                echo('<div class="timeStamp">'.$row['send_date'].'</div>');        
                                            echo('</div>');
                                        }
                                    }
                                echo('</div>');
                            $_SESSION['indexCounter'] = (($index-1) - (($index-1) % 20))/20 + 2;
        
                            echo('<div id="pageIndex"><a class="triangle" href="pageMove.php?Page=before">◀</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'); 
                                for($i = 1; $i < $_SESSION['indexCounter']; $i++){
                                    if($i == $_SESSION['page']){
                                        if($i === 1){
                                            echo('<a id="selectedIndex" href="pageMove.php?Page='.$i.'">'.$i.'</a>');
                                        }else{
                                            echo('&nbsp;&nbsp;&nbsp;<a id="selectedIndex" href="pageMove.php?Page='.$i.'">'.$i.'</a>');
                                        }
                                    }else{
                                        if($i === 1){
                                            echo('<a id="unselectedIndex" href="pageMove.php?Page='.$i.'">'.$i.'</a>');
                                        }else{
                                            echo('&nbsp;&nbsp;&nbsp;<a id="unselectedIndex" href="pageMove.php?Page='.$i.'">'.$i.'</a>');
                                        }
                                    }
                                }
                            echo('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="triangle" href="pageMove.php?Page=after">▶</a></div>');
                        ?>
                        </div>
                    <?php
                    }else if($selected === 'deleteMessage'){
                        ?>
                            <div id="message">
                            <div id="empty"></div>
                            <div id="topBar">
                                <input id = "allCheck" type="checkbox" name="allCheck">
                                <?php echo('<input id="selectRecover" type="button" name="selectRecover" value="선택 편지 복원" onclick="selectRecover('.$page.')">'); ?>
                                <?php echo('<input id="selectRemove" type="button" name="selectRemove" value="선택 편지 완전 삭제" onclick="selectRemove('.$page.')">'); ?>
                                <input id = "allRemove" type="button" name="allRemove" value="전체 편지 완전 삭제" onclick="allRemove()">
                            </div>
                            <div id="contentInner">
                                <?php
                                    $result = $messageDAO->get_deleteMessage($user_email);
                                    $index = 0;
                                    while($row = mysqli_fetch_assoc($result)){
                                        $index++;
                                        if($_SESSION['page']*20<$index || $index<=($_SESSION['page'] - 1)*20){
                                            continue;
                                        }
                                        if($row['writer_email'] === $user_email){
                                            echo('<div class="sendMessageEle">');
                                                echo('<input class="checkbox" type="checkbox" id="check'.$index.'">');
        
                                                if($row['writer_Important_YN'] === 'Y'){
                                                    echo('<div class="delstar" id="star'.$index.'" style="color: deepskyblue;">★</div>');
                                                }else{
                                                    echo('<div class="delstar" id="star'.$index.'">☆</div>');
                                                }
                                                
                                                echo('<div class="send_receive">보낸 편지</div>');
        
                                                if($row['read_YN'] === 'Y'){
                                                    echo('<div class="readYN" style="color: rgba(0, 0, 0, .6);">Read</div>');
                                                }else{
                                                    echo('<div class="readYN" style="color: rgba(0, 0, 0, 1);">Unread</div>');
                                                }
        
                                                if($row['receiver_email'] === $user_email){
                                                    echo('<div class="target"><span class="targetText" onclick="sendMessage('.$index.')">'.$row['writer_email'].'</span></div>');
                                                }else{
                                                    echo('<div class="target"><span class="targetText" onclick="sendMessage('.$index.')">'.$row['receiver_email'].'</span></div>');
                                                }
        
                                                echo('<div class="content" onclick="readMessage('.$row['message_seq'].')">제목 : '.$row['title'].'&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;내용 : '.$row['text'].'</div>');
                                                echo('<div class="timeStamp">'.$row['send_date'].'</div>');        
                                            echo('</div>');
                                        }else{
                                            echo('<div class="receiveMessageEle">');
                                                echo('<input class="checkbox" type="checkbox" id="check'.$index.'">');
        
                                                if($row['receiver_Important_YN'] === 'Y'){
                                                    echo('<div class="delstar" id="star'.$index.'" style="color: deepskyblue;">★</div>');
                                                }else{
                                                    echo('<div class="delstar" id="star'.$index.'">☆</div>');
                                                }
                                                
                                                echo('<div class="send_receive">받은 편지</div>');
        
                                                if($row['read_YN'] === 'Y'){
                                                    echo('<div class="readYN" style="color: rgba(0, 0, 0, .6);">Read</div>');
                                                }else{
                                                    echo('<div class="readYN" style="color: rgba(0, 0, 0, 1);">Unread</div>');
                                                }
        
                                                if($row['receiver_email'] === $user_email){
                                                    echo('<div class="target"><span class="targetText" onclick="sendMessage('.$index.')">'.$row['writer_email'].'</span></div>');
                                                }else{
                                                    echo('<div class="target"><span class="targetText" onclick="sendMessage('.$index.')">'.$row['receiver_email'].'</span></div>');
                                                }
        
                                                echo('<div class="content" onclick="readMessage('.$row['message_seq'].')">제목 : '.$row['title'].'&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;내용 : '.$row['text'].'</div>');
                                                echo('<div class="timeStamp">'.$row['send_date'].'</div>');        
                                            echo('</div>');
                                        }
                                    }
                                echo('</div>');
                            $_SESSION['indexCounter'] = (($index-1) - (($index-1) % 20))/20 + 2;
        
                            echo('<div id="pageIndex"><a class="triangle" href="pageMove.php?Page=before">◀</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'); 
                                for($i = 1; $i < $_SESSION['indexCounter']; $i++){
                                    if($i == $_SESSION['page']){
                                        if($i === 1){
                                            echo('<a id="selectedIndex" href="pageMove.php?Page='.$i.'">'.$i.'</a>');
                                        }else{
                                            echo('&nbsp;&nbsp;&nbsp;<a id="selectedIndex" href="pageMove.php?Page='.$i.'">'.$i.'</a>');
                                        }
                                    }else{
                                        if($i === 1){
                                            echo('<a id="unselectedIndex" href="pageMove.php?Page='.$i.'">'.$i.'</a>');
                                        }else{
                                            echo('&nbsp;&nbsp;&nbsp;<a id="unselectedIndex" href="pageMove.php?Page='.$i.'">'.$i.'</a>');
                                        }
                                    }
                                }
                            echo('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="triangle" href="pageMove.php?Page=after">▶</a></div>');
                        ?>
                        </div>
                    <?php
                        }
                    ?>
        </section>
    </div>
</body>
</div>