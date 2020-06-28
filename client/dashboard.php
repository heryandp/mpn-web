<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, shrink-to-fit=no">
    <title>MPN Info Web</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-md navbar-light bg-light">
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav">
            <a href="#" class="nav-item nav-link">Dashboard</a>
            <a href="#" class="nav-item nav-link">Penerimaan</a>
            <a href="#" class="nav-item nav-link">Effort</a>
        </div>
    </div>
</nav>
    <div class="text-center">
            <img src="./assets/logo.png" alt="logo" width="10%">
            <h1>MPN Info</h1>
            <b>Tanggal MPN</b> <span id="mpn"></span> || <b>Tanggal SPM</b> <span id="spm"></span>
    </div>
</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.14.1/moment.min.js"></script>

<script>
    $(document).ready(function(){
        $.ajax({
            type:"GET",
            dataType: "json",
            url:"../api/info.php",
            success:function(data)
            {
                // console.log(data.data);
                $('#mpn').text(moment(data.data.tanggal_mpn).format('DD/MM/YYYY'))
                $('#spm').text(moment(data.data.tanggal_spm).format('DD/MM/YYYY'))
            }
        });
    });
</script>
</html>