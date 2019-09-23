<?php
    session_start();
    if($_SESSION['user_name'] === null){
        header('location: sign.php');
    }

    require 'userDAO.php';
    require 'relationDAO.php';
    $userDAO = new userDAO();
    $relationDAO = new relationDAO();

    $owner_email = $userDAO->get_userEmail($_SESSION['user_name']);
    $text = $_POST['text'];
    $filter = $_POST['filter'];

    $friendArr = array(array());
    $friendNum = 0;

    if($filter === 'all'){
        $result = $relationDAO->getListOfAllFriends($owner_email);
            while($row = mysqli_fetch_array($result)){
                $row[0] = $row[0];
                $name = $userDAO->get_userName($row[0]);
                $name = $name;
                if(strpos($row[0], $text, 0)!==false || strpos($name, $text, 0)!==false){
                    $friendArr[$friendNum]['email'] = $row[0];
                    $friendArr[$friendNum]['name'] = $name;
                    $friendNum++;
                }
            }
        $friendArr = $relationDAO->friendListSort($friendArr);    
    }else{
        $result = $relationDAO->getListOfRecentFriends($owner_email);
            while($row = mysqli_fetch_array($result)){
                $name = $userDAO->get_userName($row[0]);
                if(strpos($row[0], $text, 0)!==false || strpos($name, $text, 0)!==false){
                    $friendArr[$friendNum]['email'] = $row[0];
                    $friendArr[$friendNum]['name'] = $name;
                    $friendNum++;
                }
            }
        $friendArr = $relationDAO->friendListSort($friendArr);
    }
?>

[
    <?php
        if($friendNum > 0){
            echo('["'.$friendArr[0]['email'].'", "'.$friendArr[0]['name'].'"]');
            if($friendNum > 1){
                for($i=1; $i<$friendNum; $i++){
                    echo(', ["'.$friendArr[$i]['email'].'", "'.$friendArr[$i]['name'].'"]');
                }
            }
        }
    ?>    
]