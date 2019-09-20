<?php
    session_start();
    require 'relationDAO.php';
    if(isset($_POST['done'])){
        $text = $_POST['text'];
        $relationDAO = new relationDAO();
        
        $result = $relationDAO->getSearchResult($text);
        $returnArr = array(array());
        $resultNum = 0;
        while($row = mysqli_fetch_assoc($result)){
            $returnArr[$resultNum]['user_email'] = $row['user_email'];
            $returnArr[$resultNum]['user_name'] = $row['user_name'];
            $returnArr[$resultNum]['user_birth'] = $row['user_birth'];
            $returnArr[$resultNum]['user_nick'] = $row['user_nick'];
            $resultNum++;
        }
    }
?>
{
    <?php
    // 해당하는 result를 각각 1d array로 JSON datalizing
        for($i=0; $i<$resultNum; $i++){
            echo('"result'.$i.'": ["'.$returnArr[$i]['user_email'].'", "'.$returnArr[$i]['user_name'].'", "'.$returnArr[$i]['user_birth'].'", "'.$returnArr[$i]['user_nick'].'"],');
        }
    ?> 
    "index": <?= $resultNum ?>,
    "isSuccess": 1
}