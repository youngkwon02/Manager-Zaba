<?php
    class todoDAO{
        private static $db_host = "localhost";
        private static $db_user = "PUadmin";
        private static $db_passwd = "1234";
        private static $db_name = "Project_Unknown";
    
        function __construct() {
            session_start();
        }
        
        function get_TODO($user_email, $user_name, $date) {
            $db_connect = mysqli_connect(self::$db_host, self::$db_user, self::$db_passwd, self::$db_name);
            // 아래 쿼리에 AND 조건으로 user_name까지 걸어줄 것.
            // Terminal에서 DB 한글입력 불가로 임시적으로 삭제.
            $query = "SELECT TODO_content FROM TODO WHERE user_email = '".$user_email."' AND user_name = '".$user_name."' AND date = '".$date."' ORDER BY record_date DESC";
            $result = mysqli_query($db_connect, $query);
            $num = 1;
            $line = 0;
            for(; $row = mysqli_fetch_array($result); $num++){
                if(strlen($row[0])<40){
                    // 1 Line = 39 character, X 1
                    $line += 1;
                }else{
                    if(strlen($row[0])>79){
                        if(strlen($row[0])>118){
                            // 1 Line = 39 character, X 4
                            $row[0] = substr_replace($row[0], '<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 39, 0);
                            $row[0] = substr_replace($row[0], '<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 131, 0);
                            $row[0] = substr_replace($row[0], '<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 223, 0);
                            $line += 4;
                        }else{
                            // 1 Line = 39 character, X 3
                            $row[0] = substr_replace($row[0], '<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 39, 0);
                            $row[0] = substr_replace($row[0], '<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 131, 0);
                            $line += 3;
                        }
                    }else {
                            // 1 Line = 39 character, X 2                        
                        $row[0] = substr_replace($row[0], '<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 39, 0);
                        $line += 2;
                    }
                }
                echo($num.'. &nbsp;&nbsp;&nbsp;'.$row[0].'<br>');
            }
            // Return $line for div size
            return $line;
        }

        function set_TODO($user_email, $user_name, $date, $content) {
            $db_connect = mysqli_connect(self::$db_host, self::$db_user, self::$db_passwd, self::$db_name);
            $query = "INSERT INTO TODO (user_email, user_name, TODO_content, date, record_date) VALUES ('".$user_email."', '".$user_name."', '".$content."', '".$date."', NOW())";
            mysqli_query($db_connect, $query);
        }

        function remove_TODO($user_email, $user_name, $removeNum) {
            $db_connect = mysqli_connect(self::$db_host, self::$db_user, self::$db_passwd, self::$db_name);
            $query = "SELECT TODO_seq FROM TODO WHERE user_email = '".$user_email."' AND user_name = '".$user_name."' ORDER BY record_date";
            $result = mysqli_query($db_connect, $query);
            for($i=0; $i<$removeNum; $i++) {
                $row = mysqli_fetch_array($result);
            }
            $removeSeq = $row[0];
            $query = "DELETE FROM TODO where TODO_seq = '".$removeSeq."'";
            mysqli_query($db_connect, $query);
        }

        function printTODO($user_email, $user_name) {
            $db_connect = mysqli_connect(self::$db_host, self::$db_user, self::$db_passwd, self::$db_name);
            $query = "SELECT date, TODO_content FROM TODO WHERE user_email = '".$user_email."' AND user_name = '".$user_name."' ORDER BY date, record_date asc";
            $result = mysqli_query($db_connect, $query);
            $num = 1;
            $line = 0;
            while($row = mysqli_fetch_array($result)) {
                if(strlen($row[1])<41){
                    // 1 ~ 40글자
                    $line += 1;
                }else{
                    if(strlen($row[1])>81){
                        if(strlen($row[1])>121){
                            // 121 ~ 150글자
                            $row[1] = substr_replace($row[1], '<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 39, 0);
                            $row[1] = substr_replace($row[1], '<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 239, 0);
                            $row[1] = substr_replace($row[1], '<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 439, 0);
                            $line += 4;
                        }else{
                            // 81~100글자
                            $row[1] = substr_replace($row[1], '<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 39, 0);
                            $row[1] = substr_replace($row[1], '<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 239, 0);
                            $line += 3;
                        }
                    }else {
                        // 41 ~ 80글자
                        $row[1] = substr_replace($row[1], '<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', 39, 0);
                        $line += 2;
                    }
                }
                echo('<li>'.$row[0].' : '.$row[1].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span><a style="color:red; text-decoration:none;" href="./removeTODO.php?num='.$num.'">X</a></span></li>');
                $num++;
            }
            return $line;
        }
    }
?>