<?php

if(isset($_POST['Btn-disable']))
{
  $user = $_POST['user'];
  $group = $_POST['group'];
  date_default_timezone_set('Asia/Makassar');
  $tglsubmit = date('Y-m-d H:i:s');  

  if($crud->disableuser($user,$group,$tglsubmit)) {
    $sukses[] = $user." berhasil dinonaktifkan.";
  }
}

elseif(isset($_POST['Btn-enable']))
{
  $user = $_POST['user'];
  date_default_timezone_set('Asia/Makassar');
  $tglsubmit = date('Y-m-d H:i:s');  

  if($crud->enableuser($user,$tglsubmit)) {
    $sukses[] = $user." berhasil diaktifkan.";
  }
}


//Hapus data
if(isset($_POST['hapus']))
{
  $username=explode(',', $_POST['id']);

  try
  {

    foreach($username as $user) {
        $user = trim($user);

      if($crud->delete($user)) {
        $sukses[] = $user." berhasil dihapus.";
      }
    }
  }

  catch(PDOException $e)
  {
      echo $e->getMessage();
  }
}

?>

  <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">     
    <div class="row">
      <ol class="breadcrumb">
        <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
        <li><a href="pengguna.php">Pengguna</a></li>
        <li class="active">Semua Pengguna</li>
      </ol>
    </div><!--/.row-->


<?php
include("layouts/info.php");
?>

    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header">Pengguna Hotspot</h1>
      </div>
    </div><!--/.row-->
        
    
    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading">Daftar Semua Pengguna <a href="?page=tambah" class="btn btn-primary btn-md">Tambah Data</a></div>
             <div id="toolbar">
                  <form method="POST" id="formcetak">
                  <input type='hidden' id='usercetak' name='usercetak' class='cetak' value=''>
                  <button name="btn-cetak" id="cetak" class="btn btn-primary btn-md" type="submit" disabled>
                      <i class="glyphicon glyphicon-print"></i> Cetak
                  </button>                  
                  <button id="remove" class="btn btn-danger btn-md" disabled>
                      <i class="glyphicon glyphicon-remove"></i> Hapus
                  </button>

                  </form>
              </div>
                <table id="table" data-toggle="table"
                  data-url="pengguna.php?data=tampil"
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
                    <th data-field="state" data-checkbox="true"></th>
                    <th data-field="no" data-sortable="true">No.</th>
                    <th data-field="username"  data-sortable="true">Nama Pengguna</th>
                    <th data-field="value" data-sortable="true">Password</th>
                    <th data-field="paket" data-sortable="true">Paket</th>
                    <th data-field="expired" data-sortable="true">Kadaluarsa</th>
                    <th data-field="status" data-sortable="true">Status</th>
                    <th data-field="tgl_dibuat" data-sortable="true">Tanggal Dibuat</th>
                    <th data-field="option" data-sortable="true">Opsi</th>
                </tr>
                </thead>
            </table>
          </div>
        </div>
      </div>
    </div><!--/.row-->      

</div><!--/.main-->
<script>
  window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 3000);

</script>