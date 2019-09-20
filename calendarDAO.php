<?php
    class calendarDAO {
        private static $db_host = "localhost";
        private static $db_user = "PUadmin";
        private static $db_passwd = "rladudrnjs1102";
        private static $db_name = "Project_Unknown";

        function __construct() {
            session_start();
        }

        function add_date($title, $user_email, $start_date, $end_date, $share_YN, $color){
            $db_connect = mysqli_connect(self::$db_host, self::$db_user, self::$db_passwd, self::$db_name);
            $now = date('Y-m-d', time());
            $query = "INSERT INTO CALENDAR(title, owner, start_date, end_date, record_date, share_YN, color) values('".$title."', '".$user_email."', '".$start_date."', '".$end_date."', '".$now."', '".$share_YN."', '".$color."')";
            mysqli_query($db_connect, $query);
        }

        function drop_date($CAL_seq){
            $db_connect = mysqli_connect(self::$db_host, self::$db_user, self::$db_passwd, self::$db_name);
            $query = "DELETE FROM CALENDAR WHERE CAL_seq = '".$CAL_seq."'";
            mysqli_query($db_connect, $query);
        }

        function get_date($user_email, $now_Y, $now_M) {
            $db_connect = mysqli_connect(self::$db_host, self::$db_user, self::$db_passwd, self::$db_name);
            $search_start = $now_Y.'-'.($now_M-1).'-01';
            $search_end = $now_Y.'-'.($now_M+1).'-31';
            $query = "SELECT CAL_seq, title, start_date, end_date, color FROM CALENDAR WHERE owner='".$user_email."' AND ( '".$search_end."' > start_date OR '".$search_start."' < end_date ) ORDER BY start_date and end_date and record_date";
            $result = mysqli_query($db_connect, $query);
            $returnArr;
            $index = 0;
            while($row = mysqli_fetch_assoc($result)){
                $returnArr[$index]['CAL_seq'] = $row['CAL_seq'];
                $returnArr[$index]['title'] = $row['title'];
                $returnArr[$index]['start_date'] = $row['start_date'];
                $returnArr[$index]['end_date'] = $row['end_date'];
                $returnArr[$index]['color'] = $row['color'];
                $index ++;
            }
            return $returnArr;
        }
    }
?>