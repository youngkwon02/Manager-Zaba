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
    <script src="./assets/js/manual.js"></script>
    <link rel="stylesheet" href="./assets/css/manual.css">
    <title>Manual</title>
</head>
<body>
<header>
    <div id="back"><a href="./home.php">←</a></div>
    <h1>Project_Unknown Manual</h1>
</header>
    <div id="nav">
        <ul>
        <?php
            if($_SESSION['manualPage'] === null){
                $_SESSION['manualPage'] = 1;
            }

            if($_SESSION['manualSection'] === 'HELLO' || $_SESSION['manualSection'] === null){
                $_SESSION['manualSection'] = 'HELLO';
                echo('<li class="navListSelected" onclick="navMove(\'HELLO\')">HELLO</li>');
                echo('<li class="navList" onclick="navMove(\'TODO\')">TODO</li>');
                echo('<li class="navList" onclick="navMove(\'MEMO\')">MEMO</li>');
                echo('<li class="navList" onclick="navMove(\'CALENDAR\')">CALENDAR</li>');
                echo('<li class="navList" onclick="navMove(\'FRIENDLIST\')">FRIENDLIST</li>');
                echo('<li class="navList" onclick="navMove(\'FRIENDSEARCH\')">FRIENDSEARCH</li>');
                echo('<li class="navList" onclick="navMove(\'MESSAGE\')">MESSAGE</li>');
            }else if($_SESSION['manualSection'] === 'TODO'){
                echo('<li class="navList" onclick="navMove(\'HELLO\')">HELLO</li>');
                echo('<li class="navListSelected" onclick="navMove(\'TODO\')">TODO</li>');
                echo('<li class="navList" onclick="navMove(\'MEMO\')">MEMO</li>');
                echo('<li class="navList" onclick="navMove(\'CALENDAR\')">CALENDAR</li>');
                echo('<li class="navList" onclick="navMove(\'FRIENDLIST\')">FRIENDLIST</li>');
                echo('<li class="navList" onclick="navMove(\'FRIENDSEARCH\')">FRIENDSEARCH</li>');
                echo('<li class="navList" onclick="navMove(\'MESSAGE\')">MESSAGE</li>');
            }else if($_SESSION['manualSection'] === 'MEMO'){
                echo('<li class="navList" onclick="navMove(\'HELLO\')">HELLO</li>');
                echo('<li class="navList" onclick="navMove(\'TODO\')">TODO</li>');
                echo('<li class="navListSelected" onclick="navMove(\'MEMO\')">MEMO</li>');
                echo('<li class="navList" onclick="navMove(\'CALENDAR\')">CALENDAR</li>');
                echo('<li class="navList" onclick="navMove(\'FRIENDLIST\')">FRIENDLIST</li>');
                echo('<li class="navList" onclick="navMove(\'FRIENDSEARCH\')">FRIENDSEARCH</li>');
                echo('<li class="navList" onclick="navMove(\'MESSAGE\')">MESSAGE</li>');
            }else if($_SESSION['manualSection'] === 'CALENDAR'){
                echo('<li class="navList" onclick="navMove(\'HELLO\')">HELLO</li>');
                echo('<li class="navList" onclick="navMove(\'TODO\')">TODO</li>');
                echo('<li class="navList" onclick="navMove(\'MEMO\')">MEMO</li>');
                echo('<li class="navListSelected" onclick="navMove(\'CALENDAR\')">CALENDAR</li>');
                echo('<li class="navList" onclick="navMove(\'FRIENDLIST\')">FRIENDLIST</li>');
                echo('<li class="navList" onclick="navMove(\'FRIENDSEARCH\')">FRIENDSEARCH</li>');
                echo('<li class="navList" onclick="navMove(\'MESSAGE\')">MESSAGE</li>');
            }else if($_SESSION['manualSection'] === 'FRIENDLIST'){
                echo('<li class="navList" onclick="navMove(\'HELLO\')">HELLO</li>');
                echo('<li class="navList" onclick="navMove(\'TODO\')">TODO</li>');
                echo('<li class="navList" onclick="navMove(\'MEMO\')">MEMO</li>');
                echo('<li class="navList" onclick="navMove(\'CALENDAR\')">CALENDAR</li>');
                echo('<li class="navListSelected" onclick="navMove(\'FRIENDLIST\')">FRIENDLIST</li>');
                echo('<li class="navList" onclick="navMove(\'FRIENDSEARCH\')">FRIENDSEARCH</li>');
                echo('<li class="navList" onclick="navMove(\'MESSAGE\')">MESSAGE</li>');
            }else if($_SESSION['manualSection'] === 'FRIENDSEARCH'){
                echo('<li class="navList" onclick="navMove(\'HELLO\')">HELLO</li>');
                echo('<li class="navList" onclick="navMove(\'TODO\')">TODO</li>');
                echo('<li class="navList" onclick="navMove(\'MEMO\')">MEMO</li>');
                echo('<li class="navList" onclick="navMove(\'CALENDAR\')">CALENDAR</li>');
                echo('<li class="navList" onclick="navMove(\'FRIENDLIST\')">FRIENDLIST</li>');
                echo('<li class="navListSelected" onclick="navMove(\'FRIENDSEARCH\')">FRIENDSEARCH</li>');
                echo('<li class="navList" onclick="navMove(\'MESSAGE\')">MESSAGE</li>');
            }else if($_SESSION['manualSection'] === 'MESSAGE'){
                echo('<li class="navList" onclick="navMove(\'HELLO\')">HELLO</li>');
                echo('<li class="navList" onclick="navMove(\'TODO\')">TODO</li>');
                echo('<li class="navList" onclick="navMove(\'MEMO\')">MEMO</li>');
                echo('<li class="navList" onclick="navMove(\'CALENDAR\')">CALENDAR</li>');
                echo('<li class="navList" onclick="navMove(\'FRIENDLIST\')">FRIENDLIST</li>');
                echo('<li class="navList" onclick="navMove(\'FRIENDSEARCH\')">FRIENDSEARCH</li>');
                echo('<li class="navListSelected" onclick="navMove(\'MESSAGE\')">MESSAGE</li>');
            }


            $_SESSION['HELLOMaxPage'] = 3;
            $_SESSION['TODOMaxPage'] = 4;
            $_SESSION['MEMOMaxPage'] = 1;
            $_SESSION['CALENDARMaxPage'] = 3;
            $_SESSION['FRIENDLISTMaxPage'] = 3;
            $_SESSION['FRIENDSEARCHMaxPage'] = 5;
            $_SESSION['MESSAGEMaxPage'] = 3;

        ?>
        </ul>
    </div>
    <div id="inner">
            <?php
                if($_SESSION['manualSection'] === 'HELLO'){
                    echo('<div class="pageMove" onclick="backPage(\'HELLO\')"><div class="pageMoveButton">◀</div></div>');
                    echo('<div id="content">');
                    if($_SESSION['manualPage'] == 1){
                        echo('<div id="contentImg"><img src="./images/manual/hello.png" style="width: 700px; height: 526.8px;"></div>');
                        $text = "로그인하면 나타나는 Welcome 메시지!! <br><br> Welcome뒤에 나타날 nickname을 설정해서 더욱 센스있는 Welcome 메시지를<br>만들어 볼까요?!<br><br>";
                        $text = $text."우측 상단에 위치한 메뉴 버튼을 클릭해서 \"Modify Info\"로 이동해 봅시다! gogo~";
                        echo('<div id="contentText"><h3>HELLO Page</h3><p>'.$text.'</p></div>');
                    }else if($_SESSION['manualPage'] == 2){
                        echo('<div id="contentImg"><img src="./images/manual/modifyInfo.png" style="width: 700px; height: 526.8px;"></div>');
                        $text = "정보수정에서는 비밀번호 변경 및 닉네임 설정이 가능하며,<br>";
                        $text = $text."Friend Search 기능에서 다른 친구들로부터 자신이 검색 되는것을 허용할지 선택 할 수 있습니다.<br><br>";
                        $text = $text."바로 이곳에서 닉네임을 설정하므로써<br> Welcome 문구에 원하는 닉네임이 나타나게 할 수 있어요~<br>";
                        $text = $text."설정한 닉네임을 다음 페이지에서 확인해볼까요?!";
                        echo('<div id="contentText"><h3>Modify Info</h3><p>'.$text.'</p></div>');
                    }else if($_SESSION['manualPage'] == 3){
                        echo('<div id="contentImg"><img src="./images/manual/helloWithNickname.png" style="width: 700px; height: 526.8px;"></div>');
                        $text = "설정하신 닉네임이 마음에 드시나요??<br>";
                        $text = $text."다른 닉네임으로 변경을 원하신다면 얼마든지 Modify Info에 들어가서<br>닉네임을 변경할 수 있어요.<br>";
                        $text = $text."나만의 독특한 닉네임을 설정해서 사용해보아요~~<br>";
                        echo('<div id="contentText"><h3>짜잔~~</h3><p>'.$text.'</p></div>');
                    }
                    echo('</div>');
                    echo('<div class="pageMove" onclick="nextPage(\'HELLO\')"><div class="pageMoveButton">▶</div></div>');
                }else if($_SESSION['manualSection'] === 'TODO'){
                    echo('<div class="pageMove" onclick="backPage(\'TODO\')"><div class="pageMoveButton">◀</div></div>');
                    echo('<div id="content">');
                    if($_SESSION['manualPage'] == 1){
                        echo('<div id="contentImg"><img src="./images/manual/todo.png" style="width: 700px; height: 526.8px;"></div>');
                        $text = "TODO 위젯은 여러분이 해야할 일을 미리미리 기록해 두면,<br>해당 날짜에 해야할 일을 표시해주는 위젯입니다.<br>";
                        $text = $text."새로운 TODO를 추가하기 위해 + 버튼을 눌러봅시다~";
                        echo('<div id="contentText"><h3>TODO</h3><p>'.$text.'</p></div>');
                    }else if($_SESSION['manualPage'] == 2){
                        echo('<div id="contentImg"><img src="./images/manual/todoAdd.png" style="width: 700px; height: 526.8px;"></div>');
                        $text = "좌측의 양식에 알림을 받을 날짜와 알림 내용을 각각 입력한 후 Save 버튼을 누르면<br>";
                        $text = $text."우측의 TODO NOTE에 저장한 일정들이 쭉~ 나타납니다.<br><br>";
                        $text = $text."또한 TODO NOTE에 표시된 각 일정의 빨간색 X버튼을 누르면 해당 일정을 삭제할 수 있습니다.<br>";
                        $text = $text."첫 페이지를 보면 오늘은 10월 2일인데 이미 지난 일정들밖에 없으니 새로운 일정을 추가해볼까요?<br><br>";
                        $text = $text."일정을 추가 했습니다.<br>추가하는 방법은 어렵지 않으니 따로 설명하지 않고 결과를 확인해보겠습니다.";
                        echo('<div id="contentText"><h3>TODO Management</h3><p>'.$text.'</p></div>');
                    }else if($_SESSION['manualPage'] == 3){
                        echo('<div id="contentImg"><img src="./images/manual/todoSave.png" style="width: 700px; height: 526.8px;"></div>');
                        $text = "짠!<br>저장을 하니 Save Complete! 메시지와 함께 TODO NOTE에 새로운 일정이 추가되었습니다.<br><br>";
                        $text = $text."이번에는 Home에서도 확인해 볼까요?<br>";
                        echo('<div id="contentText"><h3>저장 완료!</h3><p>'.$text.'</p></div>');
                    }else if($_SESSION['manualPage'] == 4){
                        echo('<div id="contentImg"><img src="./images/manual/todoComplete.png" style="width: 700px; height: 526.8px;"></div>');
                        $text = "10월 2일 날짜에 '오늘은 메뉴얼 만들기~'라는 내용으로 TODO를 추가했고,<br>";
                        $text = $text."오늘이 10월 2일이므로 화면과 같이 저장한 TODO일정을 알려주는 것을 확인할 수 있습니다.<br><br>";
                        $text = $text."해야할 일을 TODO 위젯에 미리미리 기록해 두고<br>알림을 통해 까먹지 않는것은 어떨까요?^^<br>";
                        echo('<div id="contentText"><h3>Home에서도 확인 완료!</h3><p>'.$text.'</p></div>');
                    }
                    echo('</div>');
                    echo('<div class="pageMove" onclick="nextPage(\'TODO\')"><div class="pageMoveButton">▶</div></div>');
                }else if($_SESSION['manualSection'] === 'MEMO'){
                    echo('<div class="pageMove" onclick="backPage(\'MEMO\')"><div class="pageMoveButton">◀</div></div>');
                    echo('<div id="content">');
                    if($_SESSION['manualPage'] == 1){
                        echo('<div id="contentImg"><img src="./images/manual/memo.png" style="width: 700px; height: 526.8px;"></div>');
                        $text = "MEMO 위젯은 정말 단순한 Note 위젯이랍니다.<br>";
                        $text = $text."( 그래요... 저는 아직도 병장이 되고싶은 일병이에요.... 전역까지는 바라지도 않는다는ㅠ )<br><br>";
                        $text = $text."저는 MEMO 위젯에 이렇게 휴가 일정을 적어놓고 지낸답니다~<br>";
                        $text = $text."아직도 휴가가 멀었지만 볼때마다 웃음이 나온다구요ㅎㅎ<br>";
                        $text = $text."여러분들도 상상만 해도 기분이 좋아지는 계획을 적어놓으시면 어떨까요??<br><br>";
                        $text = $text."MEMO 내용을 수정하고 싶다면 원하는 내용으로 바꾼다음 Save버튼을 누르면 끝!!<br>";
                        $text = $text."참 쉽죠~?!?";
                        echo('<div id="contentText"><h3>MEMO</h3><p>'.$text.'</p></div>');
                    }
                    echo('</div>');
                    echo('<div class="pageMove" onclick="nextPage(\'MEMO\')"><div class="pageMoveButton">▶</div></div>');
                }else if($_SESSION['manualSection'] === 'CALENDAR'){
                    echo('<div class="pageMove" onclick="backPage(\'CALENDAR\')"><div class="pageMoveButton">◀</div></div>');
                    echo('<div id="content">');
                    if($_SESSION['manualPage'] == 1){
                        echo('<div id="contentImg"><img src="./images/manual/calendar.png" style="width: 700px; height: 526.8px;"></div>');
                        $text = "CALENDAR 위젯은 일정 관리 위젯입니다.<br>";
                        $text = $text."다른 달력 위젯들과 비슷하게 사용가능하답니다.<br>";
                        $text = $text."하지만 이 Calendar 위젯의 숨겨진 기능은 다음페이지에서 확인 가능합니다!<br>";
                        $text = $text."우측 하단의 +버튼을 눌러서 확인해볼까요~?<br>";
                        echo('<div id="contentText"><h3>CALENDAR</h3><p>'.$text.'</p></div>');
                    }else if($_SESSION['manualPage'] == 2){
                        echo('<div id="contentImg"><img src="./images/manual/calendarManage.png" style="width: 700px; height: 526.8px;"></div>');
                        $text = "+버튼을 눌러서 일정관리 페이지로 이동했습니다.<br><br>";
                        $text = $text."이곳에서는 우측 상단의 초록색 일정추가 버튼을 눌러서 일정을 추가할 수 있고,<br>";
                        $text = $text."추가한 일정을 우측 상단의 빨간색 일정삭제 버튼에 Drag & Drop해서 삭제가능합니다.<br>";
                        $text = $text."또한 버튼 아래의 '내 일정 보기'와 '모든 일정 보기'를 선택해서 원하는 일정들만 볼 수 있습니다.<br><br>";
                        $text = $text."초록색 버튼을 눌러서 새로운 일정을 추가해볼까요?<br>";
                        echo('<div id="contentText"><h3>Calendar Management</h3><p>'.$text.'</p></div>');
                    }else if($_SESSION['manualPage'] == 3){
                        echo('<div id="contentImg"><img src="./images/manual/calendarAdd.png" style="width: 700px; height: 526.8px;"></div>');
                        $text = "이곳에서 새로운 일정을 추가할 수 있습니다.<br><br>";
                        $text = $text."일정을 입력한 후, 일정의 시작 날짜와 종료 날짜를 설정합니다.<br>";
                        $text = $text."다음으로 지금 추가하는 일정을 친구와 함께 볼 수 있도록 설정할지 여부를 결정할 수 있습니다.<br>";
                        $text = $text."생일, 휴가, 시험 등의 일정을 친구와 하나의 달력에서 공유할 수 있도록<br>";
                        $text = $text."친구와 함께 보기 기능을 이용하는 것은 어떨까요?<br><br>";
                        $text = $text."마지막으로 달력에 표시할 색상을 선택 한 후 Save 버튼을 누르면 새로운 일정이 추가됩니다.<br>";
                        echo('<div id="contentText"><h3>새로운 일정 추가하기</h3><p>'.$text.'</p></div>');
                    }
                    echo('</div>');
                    echo('<div class="pageMove" onclick="nextPage(\'CALENDAR\')"><div class="pageMoveButton">▶</div></div>');
                }else if($_SESSION['manualSection'] === 'FRIENDLIST'){
                    echo('<div class="pageMove" onclick="backPage(\'FRIENDLIST\')"><div class="pageMoveButton">◀</div></div>');
                    echo('<div id="content">');
                    if($_SESSION['manualPage'] == 1){
                        echo('<div id="contentImg"><img src="./images/manual/helloWithNickname.png" style="width: 700px; height: 526.8px;"></div>');
                        $text = "Home에서 우측상단의 메뉴버튼을 누르면 메뉴 탭이 나타납니다.<br>";
                        $text = $text."우측에 나타나는 메뉴탭에서 Frined List버튼을 눌러서 친구목록을 확인가능합니다.<br>";                        
                        echo('<div id="contentText"><h3>Home</h3><p>'.$text.'</p></div>');
                    }else if($_SESSION['manualPage'] == 2){
                        echo('<div id="contentImg"><img src="./images/manual/friendList.png" style="width: 700px; height: 526.8px;"></div>');
                        $text = "Friend List를 누르면 화면과 같이 친구 목록을 확인 가능합니다.<br><br>";
                        $text = $text."친구 리스트에서 친구 이름 및 이메일 주소를 검색해서 친구를 관리할 수 있으며,<br>";
                        $text = $text."원하는 친구의 오른쪽에 위치한 etc버튼(...)을 클릭하면 친구관리를 할 수 있습니다.<br><br>";
                        $text = $text."etc 버튼을 눌러볼까요~?<br>";
                        echo('<div id="contentText"><h3>친구 목록</h3><p>'.$text.'</p></div>');
                    }else if($_SESSION['manualPage'] == 3){
                        echo('<div id="contentImg"><img src="./images/manual/friendListFunc.png" style="width: 700px; height: 526.8px;"></div>');
                        $text = "etc버튼을 클릭하면 화면과 같이 세개의 버튼이 나타납니다.<br><br>";
                        $text = $text."첫번째로 쪽지 보내기 버튼을 통해 해당 친구에게 message를 보낼 수 있습니다.<br>"; 
                        $text = $text."다음으로 일정 표시 안함 버튼을 누르면, Calendar위젯에서 해당 친구의 일정을<br>표시하지 않습니다.<br>";
                        $text = $text."만약 친구의 일정을 다시 표시하고 싶다면, 해당 친구의 etc버튼을 눌러서 일정 표시 함<br>버튼을 누르면 됩니다.<br>";
                        $text = $text."마지막으로 친구 삭제 버튼을 통해서 친구와의 관계를 끊을 수 있습니다.<br>";
                        $text = $text."친구를 삭제하면 더이상 친구에게 메시지를 보낼 수 없고, 친구와 일정을 공유할 수 없으므로<br>";
                        $text = $text."신중히 결정해주세요~<br>";
                        $text = $text."친구 삭제 후 다시 친구를 맺기 원한다면 다음에서 설명 할 Friend Search에서 가능하답니다. ";
                        echo('<div id="contentText"><h3>친구 목록 기능</h3><p>'.$text.'</p></div>');
                    }
                    echo('</div>');
                    echo('<div class="pageMove" onclick="nextPage(\'FRIENDLIST\')"><div class="pageMoveButton">▶</div></div>');
                }else if($_SESSION['manualSection'] === 'FRIENDSEARCH'){
                    echo('<div class="pageMove" onclick="backPage(\'FRIENDSEARCH\')"><div class="pageMoveButton">◀</div></div>');
                    echo('<div id="content">');
                    if($_SESSION['manualPage'] == 1){
                        echo('<div id="contentImg"><img src="./images/manual/helloWithNickname.png" style="width: 700px; height: 526.8px;"></div>');
                        $text = "Home에서 우측상단의 메뉴버튼을 누르면 메뉴 탭이 나타납니다.<br>";
                        $text = $text."우측에 나타나는 메뉴탭에서 Frined Search버튼을 눌러서 친구를 검색할 수 있습니다.<br>";                        
                        echo('<div id="contentText"><h3>Home</h3><p>'.$text.'</p></div>');
                    }else if($_SESSION['manualPage'] == 2){
                        echo('<div id="contentImg"><img src="./images/manual/friendSearch.png" style="width: 700px; height: 526.8px;"></div>');
                        $text = "Friend Search를 누르면 화면과 같이 친구를 찾아 볼 수 있습니다.<br><br>";
                        $text = $text."검색창에 친구의 이름 또는 이메일을 검색해서 친구를 찾아 볼 수 있으며,<br>";
                        $text = $text."이름 또는 이메일의 특정 부분만 검색해도 결과에 나타날 것 입니다.<br>";
                        $text = $text."친구의 이름 또는 이메일을 검색해볼까요~?<br>";
                        echo('<div id="contentText"><h3>친구 찾기</h3><p>'.$text.'</p></div>');
                    }else if($_SESSION['manualPage'] == 3){
                        echo('<div id="contentImg"><img src="./images/manual/friendSearching.png" style="width: 700px; height: 526.8px;"></div>');
                        $text = "검색창에 '김핑크'라는 친구를 검색해보았습니다.<br>";
                        $text = $text."검색창에 입력한 값에 따라 결과가 나타나는데, 친구의 정보를 확인해서 "; 
                        $text = $text."친구가 맞다면<br>결과의 우측 하단에 있는 친구신청 버튼을 눌러서 친구요청을 보낼 수 있습니다.<br>";
                        $text = $text."이미 친구인 사람을 검색하면 친구신청 버튼 대신 친구 끊기 버튼이 나타나며, 버튼을 누르시면<br>";
                        $text = $text."친구를 끊을 수 있습니다.<br><br>";
                        $text = $text."친구 요청을 보낸 후, 친구가 요청을 승인한다면 친구에게 쪽지 전송 및<br>일정공유가 가능합니다.<br>";
                        $text = $text."대기중인 친구 요청이 있거나, 보낸 친구요청이 존재할 경우 우측 상단에 나타나는데<br>다음 페이지에서 확인해 볼까요?";
                        echo('<div id="contentText"><h3>친구 검색</h3><p>'.$text.'</p></div>');
                    }else if($_SESSION['manualPage'] == 4){
                        echo('<div id="contentImg"><img src="./images/manual/existRequest.png" style="width: 700px; height: 526.8px;"></div>');
                        $text = "만약 여러분에게 전송된 친구 요청이 있다면 화면과 같이 우측 상단에 알림이 나타납니다.<br>";
                        $text = $text."해당 알림을 클릭하면 다음 페이지와 같이 친구요청을 관리할 수 있습니다."; 
                        echo('<div id="contentText"><h3>친구 검색</h3><p>'.$text.'</p></div>');
                    }else if($_SESSION['manualPage'] == 5){
                        echo('<div id="contentImg"><img src="./images/manual/requestList.png" style="width: 700px; height: 526.8px;"></div>');
                        $text = "요청 알림을 클릭하면 화면과 같이 친구요청 관리페이지로 이동합니다.<br>";
                        $text = $text."이 페이지에서 친구요청 수락 및 거절을 할 수 있으며, 보낸 친구요청을 취소할 수 있습니다."; 
                        echo('<div id="contentText"><h3>친구 검색</h3><p>'.$text.'</p></div>');
                    }
                    echo('</div>');
                    echo('<div class="pageMove" onclick="nextPage(\'FRIENDSEARCH\')"><div class="pageMoveButton">▶</div></div>');
                }else if($_SESSION['manualSection'] === 'MESSAGE'){
                    echo('<div class="pageMove" onclick="backPage(\'MESSAGE\')"><div class="pageMoveButton">◀</div></div>');
                    echo('<div id="content">');
                    if($_SESSION['manualPage'] == 1){
                        echo('<div id="contentImg"><img src="./images/manual/helloWithNickname.png" style="width: 700px; height: 526.8px;"></div>');
                        $text = "Home에서 우측상단의 메뉴버튼을 누르면 메뉴 탭이 나타납니다.<br>";
                        $text = $text."우측에 나타나는 메뉴탭에서 Message버튼을 눌러서 친구에게 편지를 보낼 수 있습니다.<br>";                        
                        echo('<div id="contentText"><h3>Home</h3><p>'.$text.'</p></div>');
                    }else if($_SESSION['manualPage'] == 2){
                        echo('<div id="contentImg"><img src="./images/manual/messageMain.png" style="width: 700px; height: 526.8px;"></div>');
                        $text = "Message 버튼을 누르면 화면과 같이 Message box에 들어올 수 있습니다.<br>";
                        $text = $text."왼쪽 탭에서 원하는 기능을 수행할 수 있습니다.<br>";                        
                        echo('<div id="contentText"><h3>Home</h3><p>'.$text.'</p></div>');
                    }else if($_SESSION['manualPage'] == 3){
                        echo('<div id="contentImg"><img src="./images/manual/messageExample.png" style="width: 700px; height: 526.8px;"></div>');
                        $text = "친구와 Message를 주고 받으면 화면과 같이 편지함에 편지가 나타납니다.<br>";
                        $text = $text."별을 눌러서 중요한 편지를 따로 표시할 수 있으며, 편지 읽음 여부 역시 확인할 수 있습니다.<br>";                        
                        echo('<div id="contentText"><h3>Home</h3><p>'.$text.'</p></div>');
                    }
                    echo('</div>');
                    echo('<div class="pageMove" onclick="nextPage(\'MESSAGE\')"><div class="pageMoveButton">▶</div></div>');
                }
            ?>
    </div>
</body>
</html>