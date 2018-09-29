<?php
//require 'vendor/autoload.php';
//use Dompdf\Dompdf;

require_once("class/session.class.php");  
require_once("class/pengguna.class.php");

$user_id = $_SESSION['user_session'];    
$stmt = $crud->runQuery("SELECT * FROM admins WHERE id=:user_id");
$stmt->execute(array(":user_id"=>$user_id));
  
$userRow=$stmt->fetch(PDO::FETCH_ASSOC);



if(isset($_GET['data']) && $_GET['data']=="baru")
{
  $tglawal=$_GET['tgl_awal'];
  $tglakhir=$_GET['tgl_akhir'];
    header('Content-Type: application/json');
    $query = "select a.*,b.groupname,a.tgl_submit from radcheck as a left join radusergroup as b ON a.username = b.username where date(a.tgl_submit) between '".$tglawal."' and '".$tglakhir."'";       
    $crud->laporantampil($query);
    exit(); 
}

else if(isset($_GET['data']) && $_GET['data']=="nonaktif")
{
  $tglawal=$_GET['tgl_awal'];
  $tglakhir=$_GET['tgl_akhir'];
    header('Content-Type: application/json');
    $query = "select a.*,b.groupname,b.tgl_submit from radcheck as a left join radusergroup as b ON a.username = b.username WHERE b.groupname = 'Disabled-Users' AND date(b.tgl_submit) between '".$tglawal."' and '".$tglakhir."'";       
    $crud->laporantampil($query);
    exit(); 
}


if(isset($_GET['data']) && $_GET['data']=="cetak")
{
  $tglawal=$_GET['tgl_awal'];
  $tglakhir=$_GET['tgl_akhir'];
  $page=$_GET['page'];
?>
<!DOCTYPE html>
<html>
<head>
  <title>Laporan Paket</title>
<style type="text/css">
@media print {
html {
  height: 100%;
  box-sizing: border-box;
}

*,
*:before,
*:after {
  box-sizing: inherit;
}

body {
  position: relative;
  margin: 0;
  padding-bottom: 6rem;
  min-height: 100%;
  font-family: "Helvetica Neue", Arial, sans-serif;
}

.demo {
  margin: 0 auto;
  padding-top: 64px;
  max-width: 640px;
  width: 94%;
}

.demo h1 {
  margin-top: 0;
}

/**
 * Footer Styles
 */

.footer {
  padding: 1rem;
  text-align: center;
}
  @media print {
    .footer table {
      page-break-inside: avoid;
    }
  }

}  
</style>
</head>
<body>
<div style='position:absolute;z-index:0;left:0;top:0;width:100%;height:100%'>
  <img src='kop.png' style='width:100%;height:100%' alt='[]'>
</div><br><br><br><br><br><br><br><br><center><h2><b><u>Laporan Pengguna <?= ($page=='baru' ? 'Baru' : 'Nonaktif' ) ?></u></b></h2>
<p>Periode <?= $tglawal ?> s.d. <?= $tglakhir ?></p><br><br>

<table border="1" width="80%">
  <thead>
    <tr>
      <th>No.</th>
      <th>Nama Pengguna</th>
      <th>Password</th>
      <th>Tanggal <?= ($page=='baru' ? 'Dibuat' : 'Nonaktif' ) ?></th>
    </tr>
  </thead>
<tbody>
<?php
if ($page == 'baru') {
  $query = "select * from radcheck where date(tgl_submit) between '".$tglawal."' and '".$tglakhir."'";       
  $crud->cetakdatabaru($query);
}
else {
  $query = "select a.*,b.groupname,b.tgl_submit from radcheck as a left join radusergroup as b ON a.username = b.username WHERE b.groupname = 'Disabled-Users' AND date(b.tgl_submit) between '".$tglawal."' and '".$tglakhir."'";       
  $crud->cetakdatabaru($query);
}
?>
</tbody></table>
</center>
</div>

<div class="footer">
<table border="0" align="right" style="margin-right: 10%">
<tr>
  <td><center><b>Mengetahui,</b></center></td>
</tr>
<tr>
  <td><br><br><br></td>
</tr>
<tr>
  <td><center><b><?= $userRow['nama_kepala']?></b></center></td>
</tr>
<tr>
  <td><center><b><?= $userRow['jabatan_kepala']?></b></center></td>
</tr>

</table>
</div>

<script type="text/javascript" charset="utf-8">
window.print();
</script>
</body>
</html>
<?php
    exit(); 
}


else if(isset($_GET['data']) && $_GET['data']=="disabled")
{
header('Content-Type: application/json');
$query = "select a.*,b.groupname from radcheck as a left join radusergroup as b ON a.username = b.username WHERE b.groupname = 'Disabled-Users'";       
$crud->datadisable($query);
exit();
}

else if(isset($_GET['data']) && $_GET['data']=="log")
{
header('Content-Type: application/json');
$query = "select * from radpostauth";       
$crud->datalog($query);
exit();
}


$judul = "Laporan Pengguna";

include("layouts/header.php");
?>
<link href="vendor/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet">


<?php
// ISI Halaman

if(isset($_GET['page']) && $_GET['page']=="baru")
{
  require_once("laporan-pengguna-baru.php");
}

else if(isset($_GET['page']) && $_GET['page']=="nonaktif")
{
  require_once("laporan-pengguna-nonaktif.php");
}

else
{
  require_once("pengguna_tampil.php");
}




// FOOTER

include("layouts/footer.php");
?>

<script src="vendor/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="vendor/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.id.js" charset="UTF-8"></script>
<script type="text/javascript">
    $('.form_datetime').datetimepicker({
        //language:  'fr',
        weekStart: 1,
        todayBtn:  1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 2,
    forceParse: 0,
        showMeridian: 1
    });
  $('.form_date').datetimepicker({
        language:  'id',
        weekStart: 1,
        todayBtn:  1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 2,
    minView: 2,
    forceParse: 0
    });
  $('.form_time').datetimepicker({
        language:  'fr',
        weekStart: 1,
        todayBtn:  1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 1,
    minView: 0,
    maxView: 1,
    forceParse: 0
    });
</script>
<script src="assets/js/bootstrap-table.js"></script>
            <script>
                $(function () {
                    $('#hover, #striped, #condensed').click(function () {
                        var classes = 'table';
            
                        if ($('#hover').prop('checked')) {
                            classes += ' table-hover';
                        }
                        if ($('#condensed').prop('checked')) {
                            classes += ' table-condensed';
                        }
                        $('#table-style').bootstrapTable('destroy')
                            .bootstrapTable({
                                classes: classes,
                                striped: $('#striped').prop('checked')
                            });
                    });
                });
            
                function rowStyle(row, index) {
                    var classes = ['active', 'success', 'info', 'warning', 'danger'];
            
                    if (index % 2 === 0 && index / 2 < classes.length) {
                        return {
                            classes: classes[index / 2]
                        };
                    }
                    return {};
                }
  </script>
</body>
</html>