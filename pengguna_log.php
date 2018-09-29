  <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">     
    <div class="row">
      <ol class="breadcrumb">
        <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
        <li><a href="pengguna.php">Pengguna</a></li>
        <li class="active">Log Pengguna</li>
      </ol>
    </div><!--/.row-->


<?php
include("layouts/info.php");
?>

    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header">Log Pengguna Hotspot</h1>
      </div>
    </div><!--/.row-->
        
    
    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading">Daftar Log</div>
             <div id="toolbar">
              </div>
                <table id="table" data-toggle="table"
                  data-url="pengguna.php?data=log"
                  data-pagination="true"
                  data-search="true"
                  data-show-refresh="true"
                  data-show-toggle="true"
                  data-show-columns="true"
                  data-toolbar="#toolbar"
                  data-show-refresh="true"
                  data-show-toggle="true"
                  data-show-columns="true">
                <thead>
                <tr>
                    <th data-field="id" data-sortable="true">ID</th>
                    <th data-field="username"  data-sortable="true">Nama Pengguna</th>
                    <th data-field="reply" data-sortable="true">Respond</th>
                    <th data-field="authdate" data-sortable="true">Tanggal Log</th>
                </tr>
                </thead>
            </table>
          </div>
        </div>
      </div>
    </div><!--/.row-->      

</div><!--/.main-->
