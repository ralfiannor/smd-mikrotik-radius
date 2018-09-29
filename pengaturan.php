<?php
	require_once("class/session.class.php");	

  $judul = "Beranda";
  include("layouts/header.php");
  require_once("class/home.class.php");
?>
  <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">     
    <div class="row">
      <ol class="breadcrumb">
        <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
        <li class="active">Pengaturan</li>
      </ol>
    </div><!--/.row-->
    
    <div class="row">
<?php

  if(isset($_GET['sukses1'])) {

?>
    <div class="alert bg-success" role="alert">
        <svg class="glyph stroked checkmark"><use xlink:href="#stroked-checkmark"></use></svg> <strong>Sukses!</strong> data administrator berhasil diubah.
<a href="#" data-dismiss="alert" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a>
    </div>

<?php
}
  else if(isset($_GET['sukses2'])) {
?>
    <div class="alert bg-success" role="alert">
        <svg class="glyph stroked checkmark"><use xlink:href="#stroked-checkmark"></use></svg> <strong>Sukses!</strong> data kepala perusahaan berhasil diubah.
<a href="#" data-dismiss="alert" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a>
    </div>

<?php
}

?>
      <div class="col-lg-12">
        <h1 class="page-header">Pengaturan Aplikasi</h1>
      </div>
    </div><!--/.row-->

   <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading">Data Administrator Aplikasi <a href="pengaturan_admin.php" class="btn btn-primary btn-sm">Ubah</a></div>
          <div class="panel-body">
            <table class="table table-striped table-bordered table-hover">
            <?php
              $home->admintampil();
            ?>
            </table>
          </div>
        </div>
      </div>
    </div><!--/.row-->               

   <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading">Data Kepala Perusahaan <a href="pengaturan_kepala.php" class="btn btn-primary btn-sm">Ubah</a></div>
          <div class="panel-body">
            <table class="table table-striped table-bordered table-hover">
            <?php
              $home->kepalatampil();
            ?>
            </table>
          </div>
        </div>
      </div>
    </div><!--/.row-->               

      </div><!--/.col-->
    </div><!--/.row-->
  </div>  <!--/.main-->


<?php 
    include("layouts/footer.php");
?>