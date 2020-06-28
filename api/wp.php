<?php
    include('./common/server.php');    
    $conn=getConnection();
    if($conn==null){
        //send response if connection error occurred.
        sendResponse(500,$conn,'Server Connection Error');
    }else{
        $sql = "SELECT nama,alamat,nipar,nipeks FROM wp LIMIT 1";
        $result = $conn->query($sql);        
        //check if user list available 
        if ($result->num_rows > 0) {
            $data=array();
            while($row = $result->fetch_assoc()) {
                $mpn = array(
                    "nama" =>  $row["nama"],
                    "alamat" => $row["alamat"],
                    "nipar" => $row["nipar"],
                    "nipeks" => $row["nipeks"]
                );
                array_push($data,$mpn);
            }
            sendResponse(200,$data,'wp');
        } else {
            sendResponse(404,[],'WP tidak ditemukan');
        }
        //closing connection
        $conn->close();
    }
?>