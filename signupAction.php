<?php
    require 'userDAO.php';
    $userDAO = new userDAO();
    list($input, $errors) = $userDAO->validate_signForm($_POST['signup_email'], $_POST['signup_password'], $_POST['signup_password_check'], $_POST['signup_name'], $_POST['signup_birth']);
    if($errors == null) {
        // Success Flag;
        $is_success = 1;
        // Data to Database;
        $userDAO->add_user($input['email'], $input['passwd'], $input['name'], $input['birth']);
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