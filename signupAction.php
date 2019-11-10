<?php
    require 'userDAO.php';
    require 'memoDAO.php';
    require 'messageDAO.php';

    $userDAO = new userDAO();
    $memoDAO = new memoDAO();
    $messageDAO = new messageDAO();
    list($input, $errors) = $userDAO->validate_signForm($_POST['signup_email'], $_POST['signup_password'], $_POST['signup_password_check'], $_POST['signup_name'], $_POST['signup_birth']);
    if($errors == null) {
        $autoMessageTitle = "Welcome to Manager Zaba!";
        $autoMessageText = "먼저 일정관리 매니저 Zaba에 가입하신것을 환영하며 감사드립니다.\n\n";
        $autoMessageText .= "Manage Zaba는 회원님의 계획이 완벽하게 실행되도록 함께 할 것입니다.\n"; 
        $autoMessageText .= "또한 회원님의 일정이 Zaba의 위젯에 등록되어, 잊지않고 수행되기를 바라겠습니다.\n\n"; 
        $autoMessageText .= "마지막으로 Manager Zaba를 이용함에 있어서 불편하신 사항은 Manager Zaba의 Message기능을 통하여\n"; 
        $autoMessageText .= "'administrator@naver.com'으로 연락주시면 감사하겠습니다.\n\n"; 
        $autoMessageText .= "회원님의 하루하루가 최고의 일들로 가득하시기를 바라겠습니다 :)\n"; 
        // Success Flag;
        $is_success = 1;
        // Data to Database;
        $userDAO->add_user($input['email'], $input['passwd'], $input['name'], $input['birth']);
        $memoDAO->add_memo($input['email'], $input['name'], 'MEMO TITLE', 'Enter your MEMO here :)');
        $messageDAO->send_Message($input['email'], $input['name'], "administrator@naver.com", "관리자",
            $autoMessageTitle, $autoMessageText);
    }else {
        $is_success = -1;
        $email = '';
        $passwd = '';
        $name = '';
        $birth = '';
        if(array_key_exists('email', $errors)) {
            $email = $errors['email'];
        }
        if(array_key_exists('passwd', $errors)) {
            $passwd = $errors['passwd'];
        }
        if(array_key_exists('passwdck', $errors)) {
            $passwdck = $errors['passwdck'];
        }
        if(array_key_exists('name', $errors)) {
            $name = $errors['name'];
        }
        if(array_key_exists('birth', $errors)) {
            $birth = $errors['birth'];
        }
        
    }
?>
{
    "isSuccess": <?= $is_success ?>,
    "email_error": <?= '"'.$email.'\n"' ?>,
    "passwd_error": <?= '"'.$passwd.'\n"' ?>,
    "passwdck_error": <?= '"'.$passwdck.'\n"' ?>,
    "name_error": <?= '"'.$name.'\n"' ?>,
    "birth_error": <?= '"'.$birth.'\n"' ?>
}