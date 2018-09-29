<?php

if(isset($_POST['Btn-enable']))
{
  $user = $_POST['user'];
  date_default_timezone_set('Asia/Makassar');
  $tglsubmit = date('Y-m-d H:i:s');  

  if($crud->enableuser($user,$tglsubmit)) {
    $sukses[] = $user." berhasil diaktifkan.";
  }
}


?>

  <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">     
    <div class="row">
      <ol class="breadcrumb">
        <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
        <li><a href="pengguna.php">Pengguna</a></li>
        <li class="active">Pengguna Nonaktif</li>
      </ol>
    </div><!--/.row-->


<?php
include("layouts/info.php");
?>

    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header">Pengguna Hotspot Non Aktif</h1>
      </div>
    </div><!--/.row-->
        
    
    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading">Daftar Pengguna Non Aktif (Disabled Users)</div>
             <div id="toolbar">
                  <button id="remove" class="btn btn-danger btn-md" disabled>
                      <i class="glyphicon glyphicon-remove"></i> Hapus
                  </button>

                  </form>
              </div>
                <table id="table" data-toggle="table"
                  data-url="pengguna.php?data=disabled"
                  data-pagination="true"
                  data-search="true"
                  data-show-refresh="true"
                  data-show-toggle="true"
                  data-show-columns="true"
                  data-toolbar="#toolbar"
                  data-show-refresh="true"
                  data-sort-name="ID"
                  data-sort-order="asc">
                <thead>
                <tr>
                    <th data-field="state" data-checkbox="true"></th>
                    <th data-field="id" data-sortable="true">ID</th>
                    <th data-field="username"  data-sortable="true">Nama Pengguna</th>
                    <th data-field="value" data-sortable="true">Password</th>
                    <th data-field="option" data-sortable="true">Opsi</th>
                </tr>
                </thead>
            </table>
          </div>
        </div>
      </div>
    </div><!--/.row-->      

</div><!--/.main-->
