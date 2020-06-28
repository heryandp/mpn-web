<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json; charset=UTF-8');
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    function getConnection()
    {
        $host = '10.5.7.220';
        $db_name = 'mpninfo';
        $username = 'user';
        $password = '';
        $conn= new mysqli($host, $username, $password, $db_name);
        if ($conn->connect_error) {
            $conn= null;
        }
        return $conn;
    }

    function sendResponse($resp_code,$data,$message){
        echo json_encode(array('code'=>$resp_code,'message'=>$message,'data'=>$data));
    }
?>