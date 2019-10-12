<?php
class userDAO {
    private static $db_host = "localhost";
    private static $db_user = "PUadmin";
    private static $db_passwd = "1234";
    private static $db_name = "Project_Unknown";
   
    function __construct() {
        session_start();
    }   

    function validate_signForm($user_email, $user_passwd, $user_passwd_check, $user_name, $user_birth) {
        $input = array();
        $errors = array();

        $input['email'] = filter_input(INPUT_POST, 'signup_email', FILTER_VALIDATE_EMAIL);
        if(is_null($input['email']) || ($input['email'] === false)){
            $errors['email'] = 'Email format must contain \'@\'.';
        } else {
            $existing = $this->check_email_existing($input['email']);
            if($existing === TRUE) {
                $errors['email'] = 'Sorry, Entered email existing already.';
            }
        }

        if($user_passwd === $user_passwd_check) {
            $input['passwd'] = $user_passwd;
            if($user_passwd == ''){ $errors['passwd'] = 'Enter the password you want.'; }
        } else { $errors['passwdck'] = 'Password is Invalid.'; }

        if(strlen(trim($user_name)) == 0) {
            $errors['name'] = 'Enter your name.';
        }else { $input['name'] = $user_name; }

        if($user_birth == null) {
            $errors['birth'] = 'Error on your birth.';
        }else { $input['birth'] = $user_birth; }

        return array($input, $errors);
    }

    function add_user($user_email, $user_passwd, $user_name, $user_birth) {
        $db_connect = mysqli_connect(self::$db_host, self::$db_user, self::$db_passwd, self::$db_name);
        $query = "INSERT INTO user_info (user_email, user_passwd, user_name, user_birth, search_YN, login_count) values ('".$user_email."', MD5('".$user_passwd."'), '".$user_name."', '".$user_birth."', 'Y', 0)";
        mysqli_query($db_connect, $query);
    }

    function check_email_existing($user_email) {
        $db_connect = mysqli_connect(self::$db_host, self::$db_user, self::$db_passwd, self::$db_name);
        // Email Existing을 Check 하는 Query에서 user_seq를 SELECT
        $query = "SELECT user_seq FROM user_info WHERE user_email = '".$user_email."'";
        $result = mysqli_query($db_connect, $query);
        $row = mysqli_fetch_row($result);
        if($row[0] === null) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function login_action($user_email, $user_passwd) {
        if($user_email === '' || $user_email ==='E-mail'){
            return 'EMPTY';
        }
        $db_connect = mysqli_connect(self::$db_host, self::$db_user, self::$db_passwd, self::$db_name);
        if(mysqli_connect_error() != null){
            $err_message = "Failed to connect to MySQL: ".mysqli_connect_error();
            return $err_message;
        }
        $query = "SELECT user_email, user_passwd FROM user_info WHERE user_email = '".$user_email."'";
        $result = mysqli_query($db_connect, $query);
        $row = mysqli_fetch_assoc($result);
        
        if($row == false){
            return 'NOID';
        }
        $query = "SELECT MD5('".$user_passwd."')";
        $result = mysqli_query($db_connect, $query);
        $inpw_md5 = mysqli_fetch_row($result);
        if($inpw_md5[0] === $row['user_passwd']){
            $counterUpdateQuery = "UPDATE user_info SET login_count = login_count+1 WHERE user_email = '".$user_email."'";
            return 'SUCCESS';
        } else {
            return 'INCORRECTPW';
        }
    }

    function get_userName($user_email) {
        // get_userName for Session
        // call on SigninAction     
        $db_connect = mysqli_connect(self::$db_host, self::$db_user, self::$db_passwd, self::$db_name);
        $query = "SELECT user_name FROM user_info WHERE user_email = '".$user_email."'";
        $result = mysqli_query($db_connect, $query);
        $row = mysqli_fetch_row($result);
        return $row[0];
    }

    function get_userEmail($user_name) {
        // get userEmail for set_nickname parameter
        // call on homepage, set_nickname method call
        // maybe $user_name parameter will be $_SESSION['user_name']
        $db_connect = mysqli_connect(self::$db_host, self::$db_user, self::$db_passwd, self::$db_name);
        $query = "SELECT user_email FROM user_info WHERE user_name = '".$user_name."'";
        $result = mysqli_query($db_connect, $query);
        $row = mysqli_fetch_row($result);
        return $row[0];
    }

    function reset_passwd($user_email, $user_name, $new_passwd) {
        // reset_passwd for 정보수정
        $db_connect = mysqli_connect(self::$db_host, self::$db_user, self::$db_passwd, self::$db_name);
        $query = "UPDATE user_info SET user_passwd = MD5('".$new_passwd."') WHERE user_email='".$user_email."' and user_name='".$user_name."'";
        $result = mysqli_query($db_connect, $query);
        mysqli_fetch_row($result);    
    }

    function set_userNick($user_email, $new_nick) {
        // null이 가능한 user_nick col에 추가
        $db_connect = mysqli_connect(self::$db_host, self::$db_user, self::$db_passwd, self::$db_name);
        $query = "UPDATE user_info SET user_nick = '".$new_nick."' WHERE user_email = '".$user_email."'";
        mysqli_query($db_connect, $query);
    }

    function set_searchYN($user_email, $search_YN){
        $db_connect = mysqli_connect(self::$db_host, self::$db_user, self::$db_passwd, self::$db_name);
        $query = "UPDATE user_info SET search_YN = '".$search_YN."' WHERE user_email = '".$user_email."'";
        mysqli_query($db_connect, $query);
    }

    function get_searchYN($user_name){
        $db_connect = mysqli_connect(self::$db_host, self::$db_user, self::$db_passwd, self::$db_name);
        $query = "SELECT search_YN FROM user_info WHERE user_name = '".$user_name."'";
        $result = mysqli_query($db_connect, $query);
        $row = mysqli_fetch_assoc($result);
        return $row['search_YN'];
    }

    function get_userNick($user_email) {
        $db_connect = mysqli_connect(self::$db_host, self::$db_user, self::$db_passwd, self::$db_name);
        $query = "SELECT user_nick FROM user_info WHERE user_email = '".$user_email."'";
        $result = mysqli_query($db_connect, $query);
        $row = mysqli_fetch_row($result);
        return $row[0];
    }
}

?>
