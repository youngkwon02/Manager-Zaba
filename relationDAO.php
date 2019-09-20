<?php
    session_start();
    class relationDAO{
        private static $db_host = "localhost";
        private static $db_user = "PUadmin";
        private static $db_passwd = "rladudrnjs1102";
        private static $db_name = "Project_Unknown";
    
        function __construct() {
            session_start();
        }

        function getSearchResult($text){
            $db_connect = mysqli_connect(self::$db_host, self::$db_user, self::$db_passwd, self::$db_name);
            $query = "SELECT user_email, user_name, user_birth, user_nick FROM user_info WHERE search_YN = 'Y' AND (user_name like '%".$text."%' OR user_email like '%".$text."%') AND NOT user_name = '".$_SESSION['user_name']."' ORDER BY user_name";
            $result = mysqli_query($db_connect, $query);
            return $result;
        }

        function sendFriendRequest($requester_email, $responser_email){
            $now = date('Y-m-d', time());
            $db_connect = mysqli_connect(self::$db_host, self::$db_user, self::$db_passwd, self::$db_name);
            $query = "INSERT INTO pending_relation (requester_email, responser_email, request_date, accept_YN) VALUES('".$requester_email."', '".$responser_email."', '".$now."', 'N')";
            mysqli_query($db_connect, $query);
        }

        function checkRequestExisting($requester_email, $responser_email){
            $db_connect = mysqli_connect(self::$db_host, self::$db_user, self::$db_passwd, self::$db_name);
            $query = "SELECT * FROM pending_relation WHERE requester_email = '".$requester_email."' AND responser_email = '".$responser_email."' AND accept_YN = 'N'";
            $result = mysqli_query($db_connect, $query);
            $row = mysqli_fetch_array($result);
            return $row[0];
        }

        // 받은 요청, 즉 owner가 Responser
        function getNumOfReceiveRequest($owner_email){
            $db_connect = mysqli_connect(self::$db_host, self::$db_user, self::$db_passwd, self::$db_name);
            $query = "SELECT count(*) FROM pending_relation WHERE responser_email = '".$owner_email."' AND accept_YN = 'N'";
            $result = mysqli_query($db_connect, $query);
            $row = mysqli_fetch_array($result);
            return $row[0];
        }

        // 보낸 요청, 즉 owner가 Requester
        function getNumOfSendRequest($owner_email){
            $db_connect = mysqli_connect(self::$db_host, self::$db_user, self::$db_passwd, self::$db_name);
            $query = "SELECT count(*) FROM pending_relation WHERE requester_email = '".$owner_email."' AND accept_YN = 'N'";
            $result = mysqli_query($db_connect, $query);
            $row = mysqli_fetch_array($result);
            return $row[0];
        }

        function getListOfReceiveRequest($owner_email){
            $db_connect = mysqli_connect(self::$db_host, self::$db_user, self::$db_passwd, self::$db_name);
            $query = "SELECT requester_email FROM pending_relation WHERE responser_email = '".$owner_email."' AND accept_YN = 'N'";
            $result = mysqli_query($db_connect, $query);
            return $result;
        }

        function getListOfSendRequest($owner_email){
            $db_connect = mysqli_connect(self::$db_host, self::$db_user, self::$db_passwd, self::$db_name);
            $query = "SELECT responser_email FROM pending_relation WHERE requester_email = '".$owner_email."' AND accept_YN = 'N'";
            $result = mysqli_query($db_connect, $query);
            return $result;
        }

        function acceptRequest($requester, $responser){
            $db_connect = mysqli_connect(self::$db_host, self::$db_user, self::$db_passwd, self::$db_name);
            $query1 = "UPDATE pending_relation SET accept_YN = 'Y' WHERE requester_email = '".$requester."' AND responser_email = '".$responser."'";
            mysqli_query($db_connect, $query1);

            $now = date('Y-m-d', time());
            $query2 = "INSERT INTO relation(first_user_email, second_user_email, since) VALUES('".$requester."', '".$responser."', '".$now."')";
            mysqli_query($db_connect, $query2);
        }

        function rejectRequest($requester, $responser){
            $db_connect = mysqli_connect(self::$db_host, self::$db_user, self::$db_passwd, self::$db_name);
            $query = "UPDATE pending_relation SET accept_YN = 'R' WHERE requester_email = '".$requester."' AND responser_email = '".$responser."'";
            mysqli_query($db_connect, $query);
        }

        function cancelSendRequest($requester, $responser){
            $db_connect = mysqli_connect(self::$db_host, self::$db_user, self::$db_passwd, self::$db_name);
            $query = "UPDATE pending_relation SET accept_YN = 'C' WHERE requester_email = '".$requester."' AND responser_email = '".$responser."'";
            mysqli_query($db_connect, $query);
        }
    }
?>