<?php
    require_once("class/session.class.php");  
    require_once("class/paket.class.php");

    $user_id = $_SESSION['user_session'];    
    $stmt = $crud->runQuery("SELECT * FROM admins WHERE id=:user_id");
    $stmt->execute(array(":user_id"=>$user_id));
      
    $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
  

    if(isset($_GET['data']) && $_GET['data']=="paket")
    {
    $tglawal=$_GET['tgl_awal'];
    $tglakhir=$_GET['tgl_akhir'];
    header('Content-Type: application/json');
    $query = "select * from harga where date(tgl_dibuat) between '".$tglawal."' and '".$tglakhir."' ORDER BY groupname";       
    $crud->daftarpaket($query);
    exit();
    }

    else if(isset($_GET['data']) && $_GET['data']=="cetak")
    {
      $tglawal=$_GET['tgl_awal'];
      $tglakhir=$_GET['tgl_akhir'];

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
  <img src='assets/img/kop.png' style='width:100%;height:100%' alt='[]'>
</div><br><br><br><br><br><br><br><center><h2><b><u>Laporan Paket</u></b></h2>
<div class="demo"><p>Periode <?= $tglawal ?> s.d. <?= $tglakhir ?></p>
<table border="1" width="80%" height="100%">
  <thead>
    <tr>
      <th>No.</th>
      <th>Nama Paket</th>
      <th>Harga</th>
      <th>Deskripsi</th>
      <th>Tanggal Dibuat</th>
    </tr>
  </thead>
<?php
$query = "select * from harga where date(tgl_dibuat) between '".$tglawal."' and '".$tglakhir."' ORDER BY groupname";
echo $crud->laporanpaket($query);
?> 
</table></center>

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

$judul = "Laporan Paket";
include("layouts/header.php");
?>
<link href="vendor/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet">

  <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">     
    <div class="row">
      <ol class="breadcrumb">
        <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
        <li>Laporan</li>
        <li class="active">Paket</li>
      </ol>
    </div><!--/.row-->


<?php
include("layouts/info.php");
?>

    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header">Laporan Paket</h1>
      </div>
    </div><!--/.row-->    
    <div class="row">
        <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading">Pilih Periode</div>
          <div class="panel-body">
            <div class="row">
              <form role="form" method="GET">
                <div class="col-lg-12">
                    <label>Tanggal Awal</label>
                    <div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                      <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                      <input class="form-control" size="16" type="text" name="tgl_awal" value="<?=((isset($_GET['tgl_akhir']))?$_GET['tgl_awal']:'')?>" readonly>
                    </div>
                    <input type="hidden" id="dtp_input2" value="" /><br/>

                    <label>Tanggal Akhir</label>
                    <div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                        <input class="form-control" size="16" type="text" name="tgl_akhir" value="<?=((isset($_GET['tgl_akhir']))?$_GET['tgl_akhir']:'')?>" readonly>
                    </div>
                    <input type="hidden" id="dtp_input2" value="" /><br>
                    <input type="hidden" name="page" value="baru" />
                <button type="submit" class="btn btn-primary">Lihat</button>
                <a href="#" onClick="MyWindow=window.open('laporan-paket.php?page=baru&data=cetak&tgl_awal=<?= $_GET['tgl_awal']; ?>&tgl_akhir=<?= $_GET['tgl_akhir']; ?>','MyWindow',',titlebar=no,toolbar=no,menubar=no,resizable=yes,width=1200,height=600'); return false;" class="btn btn-primary">Cetak</a>

                </div>
              </form>
            </div>
          </div>
        </div>
                <table id="table" data-toggle="table"
                  data-url="laporan-paket.php?tgl_awal=<?= $_GET['tgl_awal']; ?>&tgl_akhir=<?= $_GET['tgl_akhir']; ?>&data=paket"
                  data-pagination="true"
                  data-search="true"
                  data-show-refresh="true"
                  data-show-toggle="true"
                  data-show-columns="true"
                  data-toolbar="#toolbar"
                  data-show-refresh="true"
                  data-sort-name="no"
                  data-sort-order="asc">
                <thead>
                <tr>
                    <th data-field="no" data-sortable="true">No</th>
                    <th data-field="groupname"  data-sortable="true">Nama Paket</th>
                    <th data-field="harga"  data-sortable="true">Harga</th>
                    <th data-field="expired"  data-sortable="true">Kadaluarsa</th>
                    <th data-field="deskripsi"  data-sortable="true">Deskripsi</th>
                    <th data-field="tgl_dibuat"  data-sortable="true">Tanggal Dibuat</th>
                </tr>
                </thead>
            </table>
          </div>
        </div>
      </div>
    </div><!--/.row-->      

</div><!--/.main-->



<?php

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