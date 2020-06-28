<?php
    include('./common/server.php');    
    $conn=getConnection();
    if($conn==null){
        //send response if connection error occurred.
        sendResponse(500,$conn,'Server Connection Error');
    }else{
        $sql = "SELECT SUM(nominal) as nominal FROM mpn WHERE tahunbayar='2020'";
        $sql2 = "SELECT datebayar FROM mpn WHERE source=1 ORDER BY datebayar DESC LIMIT 1";
        $sql3 = "SELECT datebayar FROM mpn WHERE source=2 ORDER BY datebayar DESC LIMIT 1";
        $sql4 = "SELECT SUM(nominal) AS nominal FROM spmkp WHERE tahun='2020'";

        $result_total = $conn->query($sql)->fetch_assoc();
        $result_total_spmkp = $conn->query($sql4)->fetch_assoc();
        $result_tglmpn = $conn->query($sql2)->fetch_assoc();
        $result_tglspm = $conn->query($sql3)->fetch_assoc();

        if ($result_total != NULL) {
            $data = array(
                'tanggal_mpn' => $result_tglmpn['datebayar'],
                'tanggal_spm' => $result_tglspm['datebayar'],
                'total_penerimaan' => $result_total['nominal'],
                'total_spmkp' => $result_total_spmkp['nominal'],
                array(
                    'mpn_2018' => '2018',
                    'mpn_2019' => '2019',
                    'mpn_2020' => '2020',
                ),
                array(
                    'spmkp_2018' => '2018',
                    'spmkp_2019' => '2019',
                    'spmkp_2020' => '2020',
                )
            );
            sendResponse(200,$data,'mpn');
        } else {
            sendResponse(404,[],'error');
        }
        //closing connection
        $conn->close();
    }
?>