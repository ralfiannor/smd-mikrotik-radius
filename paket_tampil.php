<?php

//Hapus data
if(isset($_POST['hapus']))
{

  $paket=explode(',', $_POST['id']);

  try
  {

    foreach($paket as $paket) {
      $paket = trim($paket);

      $stmt = $crud->runQuery("SELECT * FROM radusergroup WHERE groupname=:paket");
      $stmt->execute(array(':paket'=>$paket));
    if($stmt->rowCount()>0) {
      while ($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
        $user[] = $row['username'];
      }
    }

    else {
      $user="tidak ada";
    }

      if($crud->delete($user,$paket)) {
        $sukses[] = $paket." berhasil dihapus.";
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
        <li><a href="paket.php">Paket</a></li>
        <li class="active">Semua Paket</li>
      </ol>
    </div><!--/.row-->


    <div class="row">
<?php
  include("layouts/info.php");
?>
      <div class="col-lg-12">
        <h1 class="page-header">Paket</h1>
      </div>
    </div><!--/.row-->

    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading">Menampilkan daftar paket</div>
          <div class="panel-body">
             <div id="toolbar">
                  <a href="?page=tambah" class="btn btn-primary btn-md">
                      <i class="glyphicon glyphicon-plus"></i> Tambah Paket
                  </a>
                  <button id="remove" class="btn btn-danger btn-md" disabled>
                      <i class="glyphicon glyphicon-remove"></i> Hapus
                  </button>
              </div>
            <table id="table" data-toggle="table"
                  data-url="paket.php?data=paket"
                  data-pagination="true"
                  data-search="true"
                  data-show-refresh="true"
                  data-show-toggle="true"
                  data-show-columns="true"
                  data-toolbar="#toolbar"
                  data-sort-name="no"
                  data-sort-order="asc">
                <thead>
                <tr>
                    <th data-field="state" data-checkbox="true"></th>
                    <th data-field="no" data-sortable="true">No</th>
                    <th data-field="groupname"  data-sortable="true">Nama Paket</th>
                    <th data-field="harga"  data-sortable="true">Harga</th>
                    <th data-field="expired"  data-sortable="true">Kadaluarsa</th>
                    <th data-field="deskripsi"  data-sortable="true">Deskripsi</th>
                    <th data-field="tgl_dibuat"  data-sortable="true">Tanggal Dibuat</th>
                    <th data-field="option"  data-sortable="true">Opsi</th>
                </tr>
                </thead>
            </table>
          </div>
        </div>
      </div>
    </div><!--/.row-->      
  </div><!--/.main-->
