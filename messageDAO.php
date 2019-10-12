<?php
    class messageDAO {
        private static $db_host = "localhost";
        private static $db_user = "PUadmin";
        private static $db_passwd = "1234";
        private static $db_name = "Project_Unknown";
    
        function __construct() {
            session_start();
        }

        function validate_form($receiver, $writer, $title, $text){
            $result = true;
            // Secondly validate receiver is exist on friendList
            $db_connect = mysqli_connect(self::$db_host, self::$db_user, self::$db_passwd, self::$db_name);
            $query = "SELECT relation_seq FROM relation WHERE (first_user_email = '".$writer."' AND second_user_email = '".$receiver."') OR (first_user_email = '".$receiver."' AND second_user_email = '".$writer."')";
            $result = mysqli_query($db_connect, $query);
            $row = mysqli_fetch_array($result);
            if(!$row[0]){
                $_SESSION['messageException'] = 'receiver';
                $result = false;
            }

            // Thirdly validate title and text
            if(strlen($title)>51){
                $_SESSION['messageException'] = 'title';
                $result = false;
            }else if(strlen($text)>210){
                $_SESSION['messageException'] = 'text';
                $result = false;
            }else if(strpos($title, "'") !== false){
                $_SESSION['messageException'] = 'titleUnexpected';
                $result = false;
            }else if(strpos($text, "'") !== false){
                $_SESSION['messageException'] = 'textUnexpected';
                $result = false;
            }else if(strpos($title, '"') !== false){
                $_SESSION['messageException'] = 'titleUnexpected';
                $result = false;
            }else if(strpos($text, '"') !== false){
                $_SESSION['messageException'] = 'textUnexpected';
                $result = false;
            }


            return $result;
        }

        function send_Message($receiver, $receiver_name, $writer, $writer_name, $title, $text){
            // 줄바꿈 처리!!!
            $send_date = date('Y-m-d H:i:s', time());
            $db_connect = mysqli_connect(self::$db_host, self::$db_user, self::$db_passwd, self::$db_name);
            $query = "INSERT INTO MESSAGE(title, text, receiver_email, receiver_name, writer_email, writer_name, send_date, read_YN, receiver_Delete_YN, writer_Delete_YN, receiver_Important_YN, writer_Important_YN) VALUES('".$title."', '".$text."', '".$receiver."', '".$receiver_name."', '".$writer."', '".$writer_name."', '".$send_date."', 'N', 'N', 'N', 'N', 'N')";
            mysqli_query($db_connect, $query);
        }

        function messageAccessCheck($message_seq, $user_email, $user_name){
            $db_connect = mysqli_connect(self::$db_host, self::$db_user, self::$db_passwd, self::$db_name);
            $query = "SELECT message_seq FROM MESSAGE WHERE message_seq = '".$message_seq."' AND ((receiver_email='".$user_email."' AND receiver_name='".$user_name."') OR (writer_email='".$user_email."' AND writer_name='".$user_name."'))";
            $result = mysqli_query($db_connect, $query);
            $row = mysqli_fetch_array($result);
            if($row[0] != null){
                return true;
            }else{
                return false;
            }
        }

        function read_Message($message_seq){
            $db_connect = mysqli_connect(self::$db_host, self::$db_user, self::$db_passwd, self::$db_name);
            // Update read_YN column value

            $modifyReadYN = "UPDATE MESSAGE SET read_YN = 'Y' WHERE message_seq = '".$message_seq."' AND receiver_name = '".$_SESSION['user_name']."'";
            mysqli_query($db_connect, $modifyReadYN);

            // Update read_date column value
            $read_date = date('Y-m-d H:i:s', time());
            $modifyReadDate = "UPDATE MESSAGE SET read_date = '".$read_date."' WHERE (message_seq = '".$message_seq."' AND read_date IS NULL AND receiver_name = '".$_SESSION['user_name']."')";
            mysqli_query($db_connect, $modifyReadDate);

            // Take message data
            $getMessage = "SELECT * FROM MESSAGE WHERE message_seq = '".$message_seq."'";
            $result = mysqli_query($db_connect, $getMessage);
            return $result;
        }

        function get_allMessage($owner_email){
            $db_connect = mysqli_connect(self::$db_host, self::$db_user, self::$db_passwd, self::$db_name);
            $query = "SELECT * FROM MESSAGE WHERE (receiver_email = '".$owner_email."' AND receiver_Delete_YN = 'N') OR (writer_email = '".$owner_email."' AND writer_Delete_YN = 'N')ORDER BY send_date DESC";
            $result = mysqli_query($db_connect, $query);
            return $result;
        }

        function get_receiveMessage($owner_email){
            $db_connect = mysqli_connect(self::$db_host, self::$db_user, self::$db_passwd, self::$db_name);
            $query = "SELECT * FROM MESSAGE WHERE (receiver_email = '".$owner_email."' AND receiver_Delete_YN = 'N') ORDER BY send_date DESC";
            $result = mysqli_query($db_connect, $query);
            return $result;
        }

        function get_sendMessage($owner_email){
            $db_connect = mysqli_connect(self::$db_host, self::$db_user, self::$db_passwd, self::$db_name);
            $query = "SELECT * FROM MESSAGE WHERE (writer_email = '".$owner_email."' AND writer_Delete_YN = 'N') ORDER BY send_date DESC";
            $result = mysqli_query($db_connect, $query);
            return $result;
        }

        function get_importantMessage($owner_email){
            $db_connect = mysqli_connect(self::$db_host, self::$db_user, self::$db_passwd, self::$db_name);
            $query = "SELECT * FROM MESSAGE WHERE (writer_email = '".$owner_email."' AND writer_Delete_YN = 'N' AND writer_Important_YN = 'Y') OR (receiver_email = '".$owner_email."' AND receiver_Delete_YN = 'N' AND receiver_Important_YN = 'Y') ORDER BY send_date DESC";
            $result = mysqli_query($db_connect, $query);
            return $result;
        }

        function get_deleteMessage($owner_email){
            $db_connect = mysqli_connect(self::$db_host, self::$db_user, self::$db_passwd, self::$db_name);
            $query="SELECT * FROM MESSAGE WHERE (writer_email = '".$owner_email."' AND writer_Delete_YN = 'Y') OR (receiver_email = '".$owner_email."' AND receiver_Delete_YN = 'Y') ORDER BY send_date DESC";
            $result = mysqli_query($db_connect, $query);
            return $result;
        }


        function select_delete($owner_email, $targetArr, $selected){
            $db_connect = mysqli_connect(self::$db_host, self::$db_user, self::$db_passwd, self::$db_name);
            if($selected === 'allMessage'){
                $selQuery = "SELECT message_seq FROM MESSAGE WHERE (receiver_email = '".$owner_email."' AND receiver_Delete_YN = 'N') OR (writer_email = '".$owner_email."' AND writer_Delete_YN = 'N')ORDER BY send_date DESC";
                $selResult = mysqli_query($db_connect, $selQuery);
                $index = 0;
                while($row = mysqli_fetch_array($selResult)){
                    $index++;
                    for($i=0; $i<count($targetArr); $i++){
                        if($index == $targetArr[$i]){
                            $delQuery = "UPDATE MESSAGE SET receiver_Delete_YN = IF(receiver_email = '".$owner_email."', 'Y', receiver_Delete_YN), writer_Delete_YN = IF(writer_email = '".$owner_email."', 'Y', writer_Delete_YN) WHERE message_seq = '".$row[0]."'";
                            mysqli_query($db_connect, $delQuery);
                            break;
                        }
                    }
                }
            }else if($selected === 'receiveMessage'){
                $selQuery = "SELECT message_seq FROM MESSAGE WHERE (receiver_email = '".$owner_email."' AND receiver_Delete_YN = 'N') ORDER BY send_date DESC";
                $selResult = mysqli_query($db_connect, $selQuery);
                $index = 0;
                while($row = mysqli_fetch_array($selResult)){
                    $index++;
                    for($i=0; $i<count($targetArr); $i++){
                        if($index == $targetArr[$i]){
                            $delQuery = "UPDATE MESSAGE SET receiver_Delete_YN = 'Y' WHERE message_seq = '".$row[0]."'";
                            mysqli_query($db_connect, $delQuery);
                            break;
                        }
                    }
                }
            }else if($selected === 'sendMessage'){
                $selQuery = "SELECT message_seq FROM MESSAGE WHERE (writer_email = '".$owner_email."' AND writer_Delete_YN = 'N') ORDER BY send_date DESC";
                $selResult = mysqli_query($db_connect, $selQuery);
                $index = 0;
                while($row = mysqli_fetch_array($selResult)){
                    $index++;
                    for($i=0; $i<count($targetArr); $i++){
                        if($index == $targetArr[$i]){
                            $delQuery = "UPDATE MESSAGE SET writer_Delete_YN = 'Y' WHERE message_seq = '".$row[0]."'";
                            mysqli_query($db_connect, $delQuery);
                            break;
                        }
                    }
                }
            }else if($selected === 'importantMessage'){
                $selQuery = "SELECT message_seq FROM MESSAGE WHERE (writer_email = '".$owner_email."' AND writer_Delete_YN = 'N' AND writer_Important_YN = 'Y') OR (receiver_email = '".$owner_email."' AND receiver_Delete_YN = 'N' AND receiver_Important_YN = 'Y') ORDER BY send_date DESC";
                $selResult = mysqli_query($db_connect, $selQuery);
                $index = 0;
                while($row = mysqli_fetch_array($selResult)){
                    $index++;
                    for($i=0; $i<count($targetArr); $i++){
                        if($index == $targetArr[$i]){
                            $delQuery = "UPDATE MESSAGE SET receiver_Delete_YN = IF(receiver_email = '".$owner_email."', 'Y', receiver_Delete_YN), writer_Delete_YN = IF(writer_email = '".$owner_email."', 'Y', writer_Delete_YN) WHERE message_seq = '".$row[0]."'";
                            mysqli_query($db_connect, $delQuery);
                            break;
                        }
                    }
                }
            }
        }

        function select_important($owner_email, $targetArr, $selected){
            $db_connect = mysqli_connect(self::$db_host, self::$db_user, self::$db_passwd, self::$db_name);
            if($selected === 'allMessage'){
                $selQuery = "SELECT message_seq FROM MESSAGE WHERE (receiver_email = '".$owner_email."' AND receiver_Delete_YN = 'N') OR (writer_email = '".$owner_email."' AND writer_Delete_YN = 'N')ORDER BY send_date DESC";
                $selResult = mysqli_query($db_connect, $selQuery);
                $index = 0;
                while($row = mysqli_fetch_array($selResult)){
                    $index++;
                    for($i=0; $i<count($targetArr); $i++){
                        if($index == $targetArr[$i]){
                            $setQuery = "UPDATE MESSAGE SET receiver_Important_YN = IF(receiver_email = '".$owner_email."', 'Y', receiver_Important_YN), writer_Important_YN = IF(writer_email = '".$owner_email."', 'Y', writer_Important_YN) WHERE message_seq = '".$row[0]."'";
                            mysqli_query($db_connect, $setQuery);
                            break;
                        }
                    }
                }
            }else if($selected === 'receiveMessage'){
                $selQuery = "SELECT message_seq FROM MESSAGE WHERE (receiver_email = '".$owner_email."' AND receiver_Delete_YN = 'N') ORDER BY send_date DESC";
                $selResult = mysqli_query($db_connect, $selQuery);
                $index = 0;
                while($row = mysqli_fetch_array($selResult)){
                    $index++;
                    for($i=0; $i<count($targetArr); $i++){
                        if($index == $targetArr[$i]){
                            $setQuery = "UPDATE MESSAGE SET receiver_Important_YN = 'Y' WHERE message_seq = '".$row[0]."'";
                            mysqli_query($db_connect, $setQuery);
                            break;
                        }
                    }
                }
            }else if($selected === 'sendMessage'){
                $selQuery = "SELECT message_seq FROM MESSAGE WHERE (writer_email = '".$owner_email."' AND writer_Delete_YN = 'N') ORDER BY send_date DESC";
                $selResult = mysqli_query($db_connect, $selQuery);
                $index = 0;
                while($row = mysqli_fetch_array($selResult)){
                    $index++;
                    for($i=0; $i<count($targetArr); $i++){
                        if($index == $targetArr[$i]){
                            $setQuery = "UPDATE MESSAGE SET writer_Important_YN = 'Y' WHERE message_seq = '".$row[0]."'";
                            mysqli_query($db_connect, $setQuery);
                            break;
                        }
                    }
                }
            }
        }

        function select_remove($owner_email, $targetArr, $selected){
            $db_connect = mysqli_connect(self::$db_host, self::$db_user, self::$db_passwd, self::$db_name);
            if($selected === 'deleteMessage'){
                $selQuery = "SELECT message_seq FROM MESSAGE WHERE (receiver_email = '".$owner_email."' AND receiver_Delete_YN = 'Y') OR (writer_email = '".$owner_email."' AND writer_Delete_YN = 'Y')ORDER BY send_date DESC";
                $selResult = mysqli_query($db_connect, $selQuery);
                $index = 0;
                while($row = mysqli_fetch_array($selResult)){
                    $index++;
                    for($i=0; $i<count($targetArr); $i++){
                        if($index == $targetArr[$i]){
                            $delQuery = "UPDATE MESSAGE SET receiver_Delete_YN = IF(receiver_email = '".$owner_email."', 'R', receiver_Delete_YN), writer_Delete_YN = IF(writer_email = '".$owner_email."', 'R', writer_Delete_YN) WHERE message_seq = '".$row[0]."'";
                            mysqli_query($db_connect, $delQuery);
                            break;
                        }
                    }
                }
            }
        }

        function select_recover($owner_email, $targetArr, $selected){
            $db_connect = mysqli_connect(self::$db_host, self::$db_user, self::$db_passwd, self::$db_name);
            if($selected === 'deleteMessage'){
                $selQuery = "SELECT message_seq FROM MESSAGE WHERE (receiver_email = '".$owner_email."' AND receiver_Delete_YN = 'Y') OR (writer_email = '".$owner_email."' AND writer_Delete_YN = 'Y')ORDER BY send_date DESC";
                $selResult = mysqli_query($db_connect, $selQuery);
                $index = 0;
                while($row = mysqli_fetch_array($selResult)){
                    $index++;
                    for($i=0; $i<count($targetArr); $i++){
                        if($index == $targetArr[$i]){
                            $delQuery = "UPDATE MESSAGE SET receiver_Delete_YN = IF(receiver_email = '".$owner_email."', 'N', receiver_Delete_YN), writer_Delete_YN = IF(writer_email = '".$owner_email."', 'N', writer_Delete_YN) WHERE message_seq = '".$row[0]."'";
                            mysqli_query($db_connect, $delQuery);
                            break;
                        }
                    }
                }
            }
        }

        function all_delete($owner_email){
            $db_connect = mysqli_connect(self::$db_host, self::$db_user, self::$db_passwd, self::$db_name);
            $selectSection = $_SESSION['selected'];
            if($selectSection === 'allMessage'){
                $query = "UPDATE MESSAGE SET receiver_Delete_YN = IF(receiver_email = '".$owner_email."', 'Y', receiver_Delete_YN), writer_Delete_YN = IF(writer_email = '".$owner_email."', 'Y', writer_Delete_YN)
                WHERE (receiver_email = '".$owner_email."' and receiver_Delete_YN = 'N') OR (writer_email = '".$owner_email."' and writer_Delete_YN = 'N')";
            }else if($selectSection === 'receiveMessage'){
                $query = "UPDATE MESSAGE SET receiver_Delete_YN = 'Y' WHERE (receiver_email = '".$owner_email."' and receiver_Delete_YN = 'N')";
            }else if($selectSection === 'sendMessage'){
                $query = "UPDATE MESSAGE SET writer_Delete_YN = 'Y' WHERE (writer_email = '".$owner_email."' and writer_Delete_YN = 'N')";
            }
            mysqli_query($db_connect, $query);
        }

        function all_remove($owner_email){
            $db_connect = mysqli_connect(self::$db_host, self::$db_user, self::$db_passwd, self::$db_name);
            $selectSection = $_SESSION['selected'];
            if($selectSection === 'deleteMessage'){
                $query = "UPDATE MESSAGE SET receiver_Delete_YN = IF(receiver_email = '".$owner_email."', 'R', receiver_Delete_YN), writer_Delete_YN = IF(writer_email = '".$owner_email."', 'R', writer_Delete_YN)
                WHERE (receiver_email = '".$owner_email."' and receiver_Delete_YN = 'Y') OR (writer_email = '".$owner_email."' and writer_Delete_YN = 'Y')";
                mysqli_query($db_connect, $query);
            }
        }

        function toggleImportant($owner_email, $target, $selected){
            $db_connect = mysqli_connect(self::$db_host, self::$db_user, self::$db_passwd, self::$db_name);
            if($selected === 'allMessage'){
                $selQuery = "SELECT message_seq FROM MESSAGE WHERE (receiver_email = '".$owner_email."' AND receiver_Delete_YN = 'N') OR (writer_email = '".$owner_email."' AND writer_Delete_YN = 'N')ORDER BY send_date DESC";
                $selResult = mysqli_query($db_connect, $selQuery);
                $index = 0;
                while($row = mysqli_fetch_array($selResult)){
                    $index++;
                    if($index == $target){
                        $toggleQuery = "UPDATE MESSAGE SET receiver_Important_YN = IF(receiver_email = '".$owner_email."' AND receiver_Important_YN='N', 'Y', IF(receiver_email = '".$owner_email."' AND receiver_Important_YN='Y', 'N', receiver_Important_YN)), writer_Important_YN = IF(writer_email = '".$owner_email."' and writer_Important_YN='N', 'Y', IF(writer_email = '".$owner_email."' and writer_Important_YN='Y', 'N' ,writer_Important_YN)) WHERE message_seq = '".$row[0]."'";
                        mysqli_query($db_connect, $toggleQuery);
                        break;
                    }
                }
            }else if($selected === 'receiveMessage'){
                $selQuery = "SELECT message_seq FROM MESSAGE WHERE (receiver_email = '".$owner_email."' AND receiver_Delete_YN = 'N') ORDER BY send_date DESC";
                $selResult = mysqli_query($db_connect, $selQuery);
                $index = 0;
                while($row = mysqli_fetch_array($selResult)){
                    $index++;
                    if($index == $target){
                        $toggleQuery = "UPDATE MESSAGE SET receiver_Important_YN = IF(receiver_Important_YN='N', 'Y', 'N') WHERE message_seq = '".$row[0]."'";
                        mysqli_query($db_connect, $toggleQuery);
                        break;
                    }
                }
            }else if($selected === 'sendMessage'){
                $selQuery = "SELECT message_seq FROM MESSAGE WHERE (writer_email = '".$owner_email."' AND writer_Delete_YN = 'N') ORDER BY send_date DESC";
                $selResult = mysqli_query($db_connect, $selQuery);
                $index = 0;
                while($row = mysqli_fetch_array($selResult)){
                    $index++;
                    if($index == $target){
                        $toggleQuery = "UPDATE MESSAGE SET writer_Important_YN = IF(writer_Important_YN='N', 'Y', 'N') WHERE message_seq = '".$row[0]."'";
                        mysqli_query($db_connect, $toggleQuery);
                        break;
                    }
                }
            }else if($selected === 'importantMessage'){
                $selQuery = "SELECT message_seq FROM MESSAGE WHERE (writer_email = '".$owner_email."' AND writer_Delete_YN = 'N' AND writer_Important_YN = 'Y') OR (receiver_email = '".$owner_email."' AND receiver_Delete_YN = 'N' AND receiver_Important_YN = 'Y') ORDER BY send_date DESC";
                $selResult = mysqli_query($db_connect, $selQuery);
                $index = 0;
                while($row = mysqli_fetch_array($selResult)){
                    $index++;
                    if($index == $target){
                        $toggleQuery = "UPDATE MESSAGE SET receiver_Important_YN = IF(receiver_email = '".$owner_email."', 'N', receiver_Delete_YN), writer_Important_YN = IF(writer_email = '".$owner_email."', 'N', writer_Delete_YN) WHERE message_seq = '".$row[0]."'";
                        mysqli_query($db_connect, $toggleQuery);
                        break;
                    }
                }
            }
        }

        function existNewMessage($user_email, $user_name){
            $db_connect = mysqli_connect(self::$db_host, self::$db_user, self::$db_passwd, self::$db_name);
            $query = "SELECT message_seq FROM MESSAGE WHERE receiver_email = '".$user_email."' AND receiver_name = '".$user_name."' AND read_YN = 'N' AND receiver_Delete_YN = 'N'";
            $result = mysqli_query($db_connect, $query);
            $row = mysqli_fetch_array($result);
            if($row != null){
                return true;
            }else{
                return false;
            }
        }
    }   
?>