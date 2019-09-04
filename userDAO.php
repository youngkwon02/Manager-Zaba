<?php
class userDAO {
    private static $db_host = "localhost";
    private static $db_user = "PUadmin";
    private static $db_passwd = "rladudrnjs1102";
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
        $query = "INSERT INTO user_info (user_email, user_passwd, user_name, user_birth) values ('".$user_email."', '".$user_passwd."', '".$user_name."', '".$user_birth."')";
        mysqli_query($db_connect, $query);        
    }

    function check_email_existing($user_email) {

    }

    function login_action($user_email, $user_passwd) {

    }

    function resave_passwd($user_email, $user_name, $user_birth) {

    }
}

?>