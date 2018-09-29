<?php

    require_once("class/session.class.php");  


    require_once("class/akunting.class.php");

    if(isset($_GET['data'])=="json")
    {
        header('Content-Type: application/json');
        $query = "select * from radacct";       
        $crud->dataview($query);
        exit();
    }

    $judul = "Akunting";
    include("layouts/header.php");


//Hapus data
if(isset($_GET['hapus_id']))
{
   if(isset($_POST['id']))
    {
      if ($API->connect(MIKROTIK_IP, MIKROTIK_USERNAME, MIKROTIK_PASSWORD))
      {
        $id = $_POST['id'];
        $tampiluser = $API->comm("/ip/hotspot/user/print", array('.proplist' => '.id', '?name' => $id));
        $HAPUS = $API->comm('/ip/hotspot/user/remove', array('numbers' => $tampiluser[0]['.id']));

    //  $id = $_GET['hapus_id'];
        $crud->delete($id);
        echo '<script>window.location.replace("user.php?sukses")</script>';
      }
    }
}

?>

        <!-- Modal -->
        <div class="modal fade" id="konfirmasi">
            <div class="modal-dialog">
                <form method="POST">
                <input type="hidden" name="id" class="delete-id">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Konfirmasi Menghapus Data</h4>
                    </div>
                    <div class="modal-body">
                        Apakah anda yakin ingin menghapus data ini ?
                    </div>
                    <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Hapus</a></button>
            
                    </div>
                </div><!-- /.modal-content -->
                </form><!-- /.form -->
            </div><!-- /.modal dialog -->
        </div><!-- /.modal -->


  <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">     
    <div class="row">
      <ol class="breadcrumb">
        <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
        <li class="active">Akunting</li>
      </ol>
    </div><!--/.row-->
    
    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header">Akunting</h1>
      </div>
    </div><!--/.row-->
        
    
    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading">Daftar Akunting</div>
          <div class="panel-body">
            <table data-toggle="table" data-url="akunting.php?data=json" data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
                <thead>
                <tr>
                    <th data-field="id" data-sortable="true">ID</th>
                    <th data-field="username"  data-sortable="true">Nama Pengguna</th>
                    <th data-field="ipaddress" data-sortable="true">Alamat IP</th>
                    <th data-field="nasporttype" data-sortable="true">Tipe Port</th>
                    <th data-field="nama_hotspot" data-sortable="true">Nama Hotspot</th>
                    <th data-field="start_time" data-sortable="true">Waktu Masuk</th>
                    <th data-field="stop_time"  data-sortable="true">Waktu Berakhir</th>
                    <th data-field="session_time" data-sortable="true">Waktu Sesi</th>
                    <th data-field="upload" data-sortable="true">Total Upload (bytes)</th>
                    <th data-field="download"  data-sortable="true">Total Download (bytes)</th>
                </tr>
                </thead>
            </table>
          </div>
        </div>
      </div>
    </div><!--/.row-->  
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
          </div>
        </div>
      </div>
    </div><!--/.row-->  
    
    
  </div><!--/.main-->


<?php
  include("layouts/footer.php");
?>
  <script src="assets/js/bootstrap-datepicker.js"></script>
  <script src="assets/js/bootstrap-table.js"></script>
