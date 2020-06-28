<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, shrink-to-fit=no">
    <title>MPN Info Web</title>
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="./assets/css/sweetalert2.min.css">
    <!-- CSS Penerimaan -->
    <style>
        .table-penerimaan{
            font-size: 11px;
        }
    </style>
</head>
<body>
    <nav class="navbar fixed-top navbar-expand-md navbar-light bg-light">
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav">
                <img src="./assets/logo.png" alt="logo" width="5%">
                <a href="./dashboard.php" class="nav-item nav-link">Dashboard</a>
                <a href="./penerimaan.php" class="nav-item nav-link">Penerimaan</a>
                <a href="./faq.php" class="nav-item nav-link">FAQ</a>
                <!-- <a href="#" class="nav-item nav-link">Effort</a> -->
            </div>
        </div>
    </nav>
    <div style="margin-top:80px" class="text-center">
        <h1>Penerimaan</h1>
        <div class="row justify-content-md-center">
            <div class="col-md-3">
                <form action="" class="justify-content-center">
                    <label>Periode Tanggal</label>
                    <div class="input-group">
                        <input type="text" class="form-control tanggal-awal" id="tanggal-awal"/>
                        <div class="input-group-append">
                            <span class="input-group-text">s/d</span>
                        </div>
                        <input type="text" class="form-control tanggal-akhir" id="tanggal-akhir"/>
                        <button type="submit" id="gas" class="btn btn-primary">Gas!</button>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
    <div id="loading" class="text-center" hidden="hidden">
        <img src="./assets/loading.svg" alt="Loading"><br>
        <i id="loading-text">Sabar bos, lagi kami hitung ...</i>
    </div>
    <div id="hasil" class="container">
        <!-- Penerimaan Total -->
        <p>
            <b>Penerimaan Total (Bruto dan Netto)</b><br>
            <i class="tanggal-hasil"></i>
        </p>
        <table class="table table-bordered table-penerimaan">
            <thead class="table-info">
            <tr align="center">
                <th colspan="2">Target</th>
                <th colspan="6">Penerimaan</th>
                <th colspan="6">Pertumbuhan (%)</th>
                <th colspan="2">Pencapaian (%)</th>
            </tr>
            </thead>
            <tbody>
            <tr class="table-warning" align="center">
                <td rowspan="2" class="tahun-1"></td>
                <td rowspan="2" class="tahun-2"></td>
                <td colspan="3" class="tahun-1"></td>
                <td colspan="3" class="tahun-2"></td>
                <td colspan="3" class="tahun-1"></td>
                <td colspan="3" class="tahun-2"></td>
                <td rowspan="2" class="tahun-1"></td>
                <td rowspan="2" class="tahun-2"></td>
            </tr>
            <tr class="table-primary">
                <td>Bruto</td>
                <td>Netto</td>
                <td>Total</td>
                <td>Bruto</td>
                <td>Netto</td>
                <td>Total</td>
                <td>Bruto</td>
                <td>Netto</td>
                <td>Total</td>
                <td>Bruto</td>
                <td>Netto</td>
                <td>Total</td>
            </tr>
            <tr>
                <td id="target_1"></td>
                <td id="target_2"></td>
                <td id="penerimaan_b_1"></td>
                <td id="penerimaan_n_1"></td>
                <td id="penerimaan_b_2"></td>
                <td id="penerimaan_n_2"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>99.9</td>
                <td>99.9</td>
            </tr>
            </tbody>
        </table>
        <!-- Detail Penerimaan Total -->
        <table id="penerimaan-detail" class="table table-bordered table-penerimaan penerimaan-detail">
            <tr align="center">
                <td class="table-primary" colspan="8">Bruto</td>
                <td class="table-danger" rowspan="2" colspan="2">SPMKP</td>
                <td class="table-success" rowspan="2" colspan="2">Netto</td>
                <td class="table-warning" rowspan="2" colspan="2">Total</td>
            </tr>
            <tr class="table-info" align="center">
                <td colspan="2">MPN</td>
                <td colspan="2">SPM</td>
                <td colspan="2">PBK Kirim</td>
                <td colspan="2">PBK Terima</td>
            </tr>
            <tr class="table-secondary" align="center">
                <td class="tahun-1"></td>
                <td class="tahun-2"></td>
                <td class="tahun-1"></td>
                <td class="tahun-2"></td>
                <td class="tahun-1"></td>
                <td class="tahun-2"></td>
                <td class="tahun-1"></td>
                <td class="tahun-2"></td>
                <td class="tahun-1"></td>
                <td class="tahun-2"></td>
                <td class="tahun-1"></td>
                <td class="tahun-2"></td>
                <td class="tahun-1"></td>
                <td class="tahun-2"></td>
            </tr>
        </table>

        <!-- Penerimaan Per Jenis Pajak -->
        <p>
            <b>Penerimaan Per Jenis Pajak</b><br>
            <i class="tanggal-hasil"></i>
        </p>

        <!-- Penerimaan WP terbesar -->
        <p>
            <b>10 WP dengan Pembayaran Terbesar</b><br>
            <i class="tanggal-hasil"></i>
        </p>
        <table id="wp-terbesar" class="table table-bordered wp-terbesar">
            <thead class="table-info">
                <tr align="center">
                    <th>No</th>
                    <th>Wajib Pajak</th>
                    <th>NPWP</th>
                    <th>Total</th>
                </tr>
            </thead>
        </table>

        <!-- Surplus WP terbesar -->
        <p>
            <b>10 WP dengan Surplus Terbesar</b><br>
            <i class="tanggal-hasil"></i>
        </p>
        <table id="wp-terbesar-surplus" class="table table-bordered wp-terbesar-surplus">
            <tr align="center" class="table-success" >
                <td rowspan="2">No</td>
                <td rowspan="2">Wajib Pajak</td>
                <td rowspan="2">NPWP</td>
                <td colspan="3">Total</td>
                <td rowspan="2">%</td>
            </tr>
            <tr align="center" class="table-warning">
                <td class="tahun-1"></td>
                <td class="tahun-2"></td>
                <td>Selisih</td>
            </tr>
        </table>

        <!-- Shortfall WP terbesar -->
        <p>
            <b>10 WP dengan Shortfall Terbesar</b><br>
            <i class="tanggal-hasil"></i>
        </p>
        <table id="wp-terbesar-shortfall" class="table table-bordered wp-terbesar-shortfall">
            <tr align="center" class="table-danger" >
                <td rowspan="2">No</td>
                <td rowspan="2">Wajib Pajak</td>
                <td rowspan="2">NPWP</td>
                <td colspan="3">Total</td>
                <td rowspan="2">%</td>
            </tr>
            <tr align="center" class="table-warning">
                <td class="tahun-1"></td>
                <td class="tahun-2"></td>
                <td>Selisih</td>
            </tr>
        </table>
    </div>
</body>

<script src="./assets/js/jquery.min.js" ></script>
<script src="./assets/js/popper.min.js"></script>
<script src="./assets/js/bootstrap.min.js"></script>
<script src="./assets/js/bootstrap-datepicker.min.js">
<script src="./assets/js/sweetalert2.min.js"></script>
<script src="./assets/js/moment.min.js"></script>

<script>
    $(document).ready(function(){
        $(".tanggal-awal").datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
        }).on('changeDate', function (selected) {
            var startDate = new Date(selected.date.valueOf());
            var endDate = new Date(startDate.getFullYear(),11,31);
            $('.tanggal-akhir').datepicker('setStartDate', startDate);
            $('.tanggal-akhir').datepicker('setEndDate', endDate);
            $(".tahun-1").text(startDate.getFullYear()-1);
            $(".tahun-2").text(startDate.getFullYear());
        }).on('clearDate', function (selected) {
            $('.tanggal-akhir').datepicker('setStartDate', null);
            $('.tanggal-akhir').datepicker('setEndDate', null);
        });

        $(".tanggal-akhir").datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
        }).on('changeDate', function (selected) {
            var endDate = new Date(selected.date.valueOf());
            var startDate = new Date(endDate.getFullYear()-1,12,1);
            $('.tanggal-awal').datepicker('setEndDate', endDate);
            $('.tanggal-awal').datepicker('setStartDate', startDate);
        }).on('clearDate', function (selected) {
            $('.tanggal-awal').datepicker('setEndDate', null);
            $('.tanggal-awal').datepicker('setStartDate', null);
        });

        // $("#hasil").hide();
        $("#gas").click(function(e){
          e.preventDefault();
          if ($('.tanggal-awal').val() == "" || $('.tanggal-akhir').val() == "") {
                alert('Tanggalnya bro, cek lagi!')
          } else {
            $.ajax({
                type:"GET",
                dataType: "json",
                data: {start : $('#tanggal-awal').val(),end: $('#tanggal-akhir').val()},
                url:"../api/penerimaan.php",
                beforeSend: function(){
                    $("#loading").removeAttr("hidden");
                    $("#hasil").hide();
                    $(".tr-hasil").remove();
                },
                success:function(data)
                {
                    console.log(data.data[1]);
                    $("#loading").attr("hidden",true);
                    $("#hasil").show();
                    $(".tanggal-hasil").text('Periode '+$('#tanggal-awal').val()+' sd '+ $('#tanggal-akhir').val())

                    // Penerimaan Total
                    $('#target_1').text(Number(data.data[0].renpen[1]).toLocaleString('id-ID'));
                    $('#target_2').text(Number(data.data[0].renpen[2]).toLocaleString('id-ID'));

                    // Penerimaan Total Detail
                    var trHTML0 = '';
                    trHTML0 += '<tr class="tr-hasil"><td>' + Number(data.data[1].mpn1).toLocaleString('id-ID') + '</td><td>' + Number(data.data[1].mpn2).toLocaleString('id-ID') + '</td><td>' + Number(data.data[1].spm1).toLocaleString('id-ID') + '</td><td>' + Number(data.data[1].spm2).toLocaleString('id-ID') + '</td></tr>';
                    $('#penerimaan-detail').append(trHTML0);

                    // 10 WP Pembayaran Terbesar
                    var trHTML = '';
                    $.each(data.data[2].wp_terbesar, function (i, item) {
                        trHTML += '<tr class="tr-hasil"><td>' + item.rank + '</td><td>' + item.nama + '</td><td>' + item.npwp + '</td><td>' + Number(item.nominal).toLocaleString('id-ID') +'</td></tr>' ;
                    });
                    $('#wp-terbesar').append(trHTML);

                    // 10 WP Surplus Terbesar
                    var trHTML1 = '';
                    $.each(data.data[3].wp_terbesar_surplus, function (i, item) {
                        var selisih = item[2]-item[1];
                        var persen = (selisih / item[1]) * 100; 
                        trHTML1 += '<tr class="tr-hasil"><td>' + item.rank + '</td><td>' + item.nama + '</td><td>' + item.npwp + '</td><td>' + Number(item[1]).toLocaleString('id-ID') +'</td><td>' + Number(item[2]).toLocaleString('id-ID') + '</td><td>' + Number(selisih).toLocaleString('id-ID') + '</td><td>' + persen.toFixed(2) + '</td></tr>' ;
                    });
                    $('#wp-terbesar-surplus').append(trHTML1);

                    // 10 WP Shortfall Terbesar
                    var trHTML2 = '';
                    $.each(data.data[4].wp_terbesar_shortfall, function (i, item) {
                        var selisih = item[2]-item[1];
                        var persen = (selisih / item[1]) * 100; 
                        trHTML2 += '<tr class="tr-hasil"><td>' + item.rank + '</td><td>' + item.nama + '</td><td>' + item.npwp + '</td><td>' + Number(item[1]).toLocaleString('id-ID') +'</td><td>' + Number(item[2]).toLocaleString('id-ID') + '</td><td>' + Number(selisih).toLocaleString('id-ID') + '</td><td>' + persen.toFixed(2) + '</td></tr>' ;
                    });
                    $('#wp-terbesar-shortfall').append(trHTML2);
                }
            });
          }          
        });
    });
</script>
</html>