<?php
class memoDAO {
    private static $db_host = "localhost";
    private static $db_user = "PUadmin";
    private static $db_passwd = "1234";
    private static $db_name = "Project_Unknown";
   
    function __construct() {
        session_start();
    }

    // MEMO Table에 Insert
    function add_memo($user_email, $user_name, $title, $text) {
        $date = date("Y-m-d", time());
        $db_connect = mysqli_connect(self::$db_host, self::$db_user, self::$db_passwd, self::$db_name);
        $query = "INSERT INTO MEMO (user_email, user_name, title, text, Last_Modified) VALUES ('".$user_email."', '".$user_name."', '".$title."', '".$text."', '".$date."')";
        mysqli_query($db_connect, $query);
    }

    // 초기 회원가입할 때 ADD_MEMO를 통해 INSERT해놓은 데이터를 이후에 수정
    function set_memo($user_email, $user_name, $title, $text) {
        $date = date("Y-m-d", time());
        $db_connect = mysqli_connect(self::$db_host, self::$db_user, self::$db_passwd, self::$db_name);
        $query = "UPDATE MEMO SET title = '".$title."', text = '".$text."', Last_Modified = '".$date."' WHERE user_email = '".$user_email."' and user_name = '".$user_name."'";
        mysqli_query($db_connect, $query);
    }

    function get_memo($user_email, $user_name) {
        $db_connect = mysqli_connect(self::$db_host, self::$db_user, self::$db_passwd, self::$db_name);
        $query = "SELECT text FROM MEMO WHERE user_email = '".$user_email."' AND user_name = '".$user_name."' ORDER BY Last_Modified DESC";
        $result = mysqli_query($db_connect, $query);
        $row = mysqli_fetch_array($result);
        $row[0] = str_replace("//", "\r\n", $row[0]);
        return $row[0];
    }

    function get_memoTitle($user_email, $user_name){
        $db_connect = mysqli_connect(self::$db_host, self::$db_user, self::$db_passwd, self::$db_name);
        $query = "SELECT title FROM MEMO WHERE user_email = '".$user_email."' AND user_name = '".$user_name."' ORDER BY Last_Modified DESC";
        $result = mysqli_query($db_connect, $query);
        $row = mysqli_fetch_array($result);
        return $row[0];
    }
}   
?>