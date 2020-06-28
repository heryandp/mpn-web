<?php
    // Apabila punya resep query yang lebih ringan atau ada kriteria yang ingin ditambah,
    // silakan edit pada bagian query
    // Error ditanggung masing-masing yaa

    include('./common/server.php');    
    $conn=getConnection();
    if($conn==null){
        //send response if connection error occurred.
        sendResponse(500,$conn,'Server Connection Error');
    }else{
        // Tanggal
        $tgl_awal = explode("-",$_GET['start']);
        $tgl_akhir = explode("-",$_GET['end']);

        // Renpen
        $renpen_query = "SELECT tahun, SUM(target) AS target
                            FROM renpen
                            WHERE tahun BETWEEN (".$tgl_akhir[2]."-2) AND ".$tgl_akhir[2]."
                            GROUP BY tahun";
        $renpen_result = $conn->query($renpen_query);

        // Penerimaan
        // Bruto
        
        // MPN
        // MPN Tahun Sebelumnya
        $mpn1_query = "SELECT SUM(nominal) AS nominal
                        FROM mpn
                        WHERE source=1 AND tahunbayar =(".$tgl_awal[2]."-1) AND bulanbayar BETWEEN ".ltrim($tgl_awal[1],'0')." AND ".ltrim($tgl_akhir[1],'0')." AND tanggalbayar BETWEEN ".ltrim($tgl_awal[0],'0')." AND ".ltrim($tgl_akhir[0],'0');
        $mpn1_result = $conn->query($mpn1_query)->fetch_assoc();

        // MPN Tahun yang diminta
        $mpn2_query = "SELECT SUM(nominal) AS nominal
                        FROM mpn
                        WHERE source=1 AND tahunbayar =".$tgl_awal[2]." AND bulanbayar BETWEEN ".ltrim($tgl_awal[1],'0')." AND ".ltrim($tgl_akhir[1],'0')." AND tanggalbayar BETWEEN ".ltrim($tgl_awal[0],'0')." AND ".ltrim($tgl_akhir[0],'0');
        $mpn2_result = $conn->query($mpn2_query)->fetch_assoc();

        // SPM
        // SPM Tahun Sebelumnya
        $spm1_query = "SELECT SUM(nominal) AS nominal
                        FROM mpn
                        WHERE source=2 AND tahunbayar =(".$tgl_awal[2]."-1) AND bulanbayar BETWEEN ".ltrim($tgl_awal[1],'0')." AND ".ltrim($tgl_akhir[1],'0')." AND tanggalbayar BETWEEN ".ltrim($tgl_awal[0],'0')." AND ".ltrim($tgl_akhir[0],'0');
        $spm1_result = $conn->query($spm1_query)->fetch_assoc();
        
        // SPM Tahun yang diminta
        $spm2_query = "SELECT SUM(nominal) AS nominal
                        FROM mpn
                        WHERE source=2 AND tahunbayar =".$tgl_awal[2]." AND bulanbayar BETWEEN ".ltrim($tgl_awal[1],'0')." AND ".ltrim($tgl_akhir[1],'0')." AND tanggalbayar BETWEEN ".ltrim($tgl_awal[0],'0')." AND ".ltrim($tgl_akhir[0],'0');
        $spm2_result = $conn->query($spm2_query)->fetch_assoc();

        // PBK
        // PBK Tahun Sebelumnya
        $pbk1_query = "";
        // $pbk1_result = $conn->query($pbk1_query);

        // SPMKP
        // SPMKP Tahun Sebelumnya
        $spmkp1_query = "";
        // $spmkp1_result = $conn->query($spmkp1_query);

        // SPMKP Tahun yang Diminta
        $spmkp2_query = "";
        // $spmkp2_result = $conn->query($spmkp2_query);
        
        // 10 WP Terbesar Pembayaran
        $wp_terbesar_query = "SELECT nama,CONCAT(npwp,kpp,cabang) AS npwp,SUM(nominal) AS pembayaran
                                FROM mpn
                                WHERE tahunbayar BETWEEN ".$tgl_awal[2]." AND ".$tgl_akhir[2]."
                                AND bulanbayar BETWEEN ".ltrim($tgl_awal[1],'0')." AND ".ltrim($tgl_akhir[1],'0')."
                                AND tanggalbayar BETWEEN ".ltrim($tgl_awal[0],'0')." AND ".ltrim($tgl_akhir[0],'0')."
                                GROUP BY nama,npwp
                                ORDER BY pembayaran
                                DESC LIMIT 10";
        $wp_terbesar_result = $conn->query($wp_terbesar_query);

        // 10 WP Terbesar Surplus
        $wp_terbesar_surplus_query = "SELECT a.nama,CONCAT(a.npwp,a.kpp,a.cabang) AS npwp, COALESCE(a.nominal_a,0) AS nominal_a,COALESCE(b.nominal_b,0) AS nominal_b,SUM(COALESCE(b.nominal_b,0) - COALESCE(a.nominal_a,0)) AS selisih 
                                        FROM (SELECT nama,npwp,kpp,cabang,SUM(nominal) AS nominal_a FROM mpn WHERE tahunbayar=(".$tgl_akhir[2]."-1) AND bulanbayar BETWEEN ".ltrim($tgl_awal[1],'0')." AND ".ltrim($tgl_akhir[1],'0')." AND tanggalbayar BETWEEN ".ltrim($tgl_awal[0],'0')." AND ".ltrim($tgl_akhir[0],'0')." GROUP BY npwp,kpp,cabang) a
                                        LEFT JOIN (SELECT npwp,kpp,cabang,SUM(nominal) AS nominal_b FROM mpn WHERE tahunbayar=".$tgl_akhir[2]." AND bulanbayar BETWEEN ".ltrim($tgl_awal[1],'0')." AND ".ltrim($tgl_akhir[1],'0')." AND tanggalbayar BETWEEN ".ltrim($tgl_awal[0],'0')." AND ".ltrim($tgl_akhir[0],'0')." GROUP BY npwp,kpp,cabang) b
                                        ON a.npwp=b.npwp
                                        AND a.kpp=b.kpp
                                        AND a.cabang=b.cabang
                                        GROUP BY npwp
                                        ORDER BY selisih
                                        DESC
                                        LIMIT 10";
        $wp_terbesar_surplus_result = $conn->query($wp_terbesar_surplus_query);

        // 10 WP Terbesar Shortfall
        $wp_terbesar_shortfall_query = "SELECT a.nama,CONCAT(a.npwp,a.kpp,a.cabang) AS npwp, COALESCE(a.nominal_a,0) AS nominal_a,COALESCE(b.nominal_b,0) AS nominal_b,SUM(COALESCE(b.nominal_b,0) - COALESCE(a.nominal_a,0)) AS selisih 
                                        FROM (SELECT nama,npwp,kpp,cabang,SUM(nominal) AS nominal_a FROM mpn WHERE tahunbayar=(".$tgl_akhir[2]."-1) AND bulanbayar BETWEEN ".ltrim($tgl_awal[1],'0')." AND ".ltrim($tgl_akhir[1],'0')." AND tanggalbayar BETWEEN ".ltrim($tgl_awal[0],'0')." AND ".ltrim($tgl_akhir[0],'0')." GROUP BY npwp,kpp,cabang) a
                                        LEFT JOIN (SELECT npwp,kpp,cabang,SUM(nominal) AS nominal_b FROM mpn WHERE tahunbayar=".$tgl_akhir[2]." AND bulanbayar BETWEEN ".ltrim($tgl_awal[1],'0')." AND ".ltrim($tgl_akhir[1],'0')." AND tanggalbayar BETWEEN ".ltrim($tgl_awal[0],'0')." AND ".ltrim($tgl_akhir[0],'0')." GROUP BY npwp,kpp,cabang) b
                                        ON a.npwp=b.npwp
                                        AND a.kpp=b.kpp
                                        AND a.cabang=b.cabang
                                        GROUP BY npwp
                                        ORDER BY selisih
                                        ASC
                                        LIMIT 10";
        $wp_terbesar_shortfall_result = $conn->query($wp_terbesar_shortfall_query);

        if ($renpen_result->num_rows > 0) {
            // Renpen
            $renpen = array();
            while($row = $renpen_result->fetch_assoc()) {
                $renpen[] = $row['target'];
            }

            // 10 WP Terbesar
            $wp_terbesar = array();
            $i = 1;
            while($row = $wp_terbesar_result->fetch_assoc()) {
                $wp_terbesar[] = array(
                    'rank' => $i,
                    'nama' => $row['nama'],
                    'npwp' => $row['npwp'],
                    'nominal' => $row['pembayaran']
                );
                $i++;
            }

            // 10 WP Surplus Terbesar
            $wp_terbesar_surplus = array();
            $i = 1;
            while($row = $wp_terbesar_surplus_result->fetch_assoc()) {
                $wp_terbesar_surplus[] = array(
                    'rank' => $i,
                    'nama' => $row['nama'],
                    'npwp' => $row['npwp'],
                    '1' => $row['nominal_a'],
                    '2' => $row['nominal_b']
                );
                $i++;
            }

            // 10 WP Shortfall Terbesar
            $wp_terbesar_shortfall = array();
            $i = 1;
            while($row = $wp_terbesar_shortfall_result->fetch_assoc()) {
                $wp_terbesar_shortfall[] = array(
                    'rank' => $i,
                    'nama' => $row['nama'],
                    'npwp' => $row['npwp'],
                    '1' => $row['nominal_a'],
                    '2' => $row['nominal_b']
                );
                $i++;
            }

            // Kumpulin data
            $data = array(
                array('renpen' => $renpen),
                array(
                    'mpn1' => $mpn1_result['nominal'],
                    'mpn2'  => $mpn2_result['nominal'],
                    'spm1' => $spm1_result['nominal'],
                    'spm2' => $spm2_result['nominal'],
                ),
                array('wp_terbesar' => $wp_terbesar),
                array('wp_terbesar_surplus' => $wp_terbesar_surplus),
                array('wp_terbesar_shortfall' => $wp_terbesar_shortfall)
            );

            // kirim respon
            sendResponse(200,$data,'penerimaan');
        } else {
            sendResponse(404,[],'error');
        }

        //closing connection
        $conn->close();
    }
?>