<?php
    require 'userDAO.php';
    $userDAO = new userDAO();
    list($input, $errors) = $userDAO->validate_signForm($_POST['signup_email'], $_POST['signup_password'], $_POST['signup_password_check'], $_POST['signup_name'], $_POST['signup_birth']);
    $is_success = -1;
    if($errors == null) {
        // Success Flag;
        $is_success = 1;
        // Data to Database;
        $userDAO->add_user($input['email'], $input['passwd'], $input['name'], $input['birth']);
    }else {
        $is_success = -1;
    }
?>
{
    "isSuccess": <?= $is_success ?>    
}