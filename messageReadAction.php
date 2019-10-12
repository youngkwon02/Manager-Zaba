<?php
    session_start();
    if($_SESSION['user_name'] === null){
        header('location: sign.php');
    }

    require 'userDAO.php';
    require 'messageDAO.php';

    $userDAO = new userDAO();
    $messageDAO = new messageDAO();

    $message_seq = $_GET['messageSeq'];
    $user_name = $_SESSION['user_name'];
    $user_email = $userDAO->get_userEmail($user_name);

    $qualification = $messageDAO->messageAccessCheck($message_seq, $user_email, $user_name);
    if($qualification){
        $result = $messageDAO->read_Message($message_seq);
        $row = mysqli_fetch_assoc($result);
        $_SESSION['readingTarget'] = $row;
        header('location: messageRead.php');
    }else{
        $_SESSION['messageAccessWrong'] = 'NO_QUALIFICATION';
        header('location: sign.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Message Box</title>
</head>
<body>
    <?php echo($row['title']); ?>
</body>
</html>