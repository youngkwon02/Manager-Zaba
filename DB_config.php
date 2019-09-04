<?php
    $db_host = "localhost";
    $db_user = "PUadmin";
    $db_passwd = "rladudrnjs1102";
    $db_name = "Project_Unknown";
    $db_connect = mysqli_connect($db_host, $db_user, $db_passwd, $db_name);

    // Check connection
    if($db_connect === false) {     
?>
    <script>console.log("DB connection ERROR!")</script>
        
<?php
    die("ERROR: Could not connect to DB. " . mysqli_connect_error());
} ?>