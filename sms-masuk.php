<?php
    require_once("class/session.class.php");  


    require_once("class/sms.class.php");

    $user_id = $_SESSION['user_session'];    
    $stmt = $crud->runQuery("SELECT * FROM admins WHERE id=:user_id");
    $stmt->execute(array(":user_id"=>$user_id));
      
    $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
  

    if(isset($_GET['data']))
    {
      header('Content-Type: application/json');
      $query = "select * from inbox ORDER BY ReceivingDateTime DESC";       
      $crud->smsMasuk($query);
      exit();
    }

// Lihat Detail
if (isset($_GET['open'])) {
    $id = $_GET['open'];
    extract($crud->getID("inbox",$id));
?>
  <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Pesan Masuk dari <b><?= $SenderNumber ?></b></h4>
      </div>
      <div class="modal-body">
      <table class="table no-border">
              <tbody>
                <tr>
                    <th>Nomor/Nama</th>
                    <th>:</th>
                    <th><?= $SenderNumber ?></th>
                </tr>
                <tr>
                    <th>Waktu</th>
                    <th>:</th>
                    <th><?= $ReceivingDateTime ?></th>
                </tr>
                <tr>
                    <th>Pesan</th>
                    <th>:</th>
                    <th><?= $TextDecoded ?></th>
                </tr>
              </tbody>
            </table>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Keluar</button>
      </div>
<?php 
exit();
}

else if(isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    extract($crud->getID("inbox",$id));
?>
  <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Hapus Pesan Dari <b><?= $SenderNumber ?></b></h4>
      </div>
      <div class="modal-body">
        Apakah yakin ingin menghapus data ?<br><br>
      <table class="no-border">
              <tbody>
                <tr>
                    <th width="145">Nomor/Nama</th>
                    <th width="15">:</th>
                    <th><?= $SenderNumber ?></th>
                </tr>
                <tr>
                    <th>Waktu</th>
                    <th>:</th>
                    <th><?= $ReceivingDateTime ?></th>
                </tr>
                <tr>
                    <th>Pesan</th>
                    <th>:</th>
                    <th><?= $TextDecoded ?></th>
                </tr>
              </tbody>
            </table>
      </div>
      <div class="modal-footer">
      <form method="POST">
        <input type="hidden" name="id_hapus" value="<?= $id ?>">
        <button type="submit" class="btn btn-warning" name="btn-hapus">Hapus</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
      </form>
      </div>

<?php
exit();
}

//Hapus data
if (isset($_POST['btn-hapus'])) {
    $id_hapus = $_POST['id_hapus'];
    $crud->delete("inbox",$id_hapus);
    echo '<script>window.location.replace("?terhapus")</script>';
}

$judul = "Pesan Masuk";
include("layouts/header.php");
?>
<link href="vendor/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet">

  <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">     
    <div class="row">
      <ol class="breadcrumb">
        <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
        <li>SMS Gateway</li>
        <li class="active">Pesan Masuk</li>
      </ol>
    </div><!--/.row-->


<?php
include("layouts/info.php");
?>

    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header">Pesan Masuk</h1>
      </div>
    </div><!--/.row-->    
    <div class="row">
        <div class="col-lg-12">
                <table id="table" data-toggle="table"
                  data-url="sms-masuk.php?data"
                  data-pagination="true"
                  data-search="true"
                  data-show-refresh="true"
                  data-show-toggle="true"
                  data-show-columns="true"
                  data-toolbar="#toolbar"
                  data-id-field="id"
                  data-show-refresh="true">
                <thead>
                <tr>
                    <th data-field="no" data-sortable="true">No</th>
                    <th data-field="nomor"  data-sortable="true">Nama/Nomor</th>
                    <th data-field="pesan"  data-sortable="true">Pesan</th>
                    <th data-field="tgl_masuk"  data-sortable="true">Tgl Masuk</th>
<th data-field="action" data-formatter="actionFormatter" data-events="actionEvents">Action</th>
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
function actionFormatter(value, row, index) {
    return [
        '<a class="lihat btn btn-info btn-xs" href="javascript:void(0)" title="Lihat">',
        '<i class="glyphicon glyphicon-eye-open"></i>',
        '</a> ',
        ' <a class="hapus btn btn-danger btn-xs" href="javascript:void(0)" title="Hapus">',
        '<i class="glyphicon glyphicon-remove"></i> ',
        '</a>'
    ].join('');
}

window.actionEvents = {
    'click .lihat': function (e, value, row, index) {
      //alert('You click like icon, row: ' + JSON.stringify(row));
      var url = 'sms-masuk.php?open='+row['id'];
      $.get(url, function (data) {
        var modal = $('<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"><div class="modal-dialog" role="document"><div class="modal-content">' + data + '</div></div></div>').modal();

        modal.on("hidden.bs.modal", function () {
          $(this).remove();
        });

        setTimeout(function(){
          modal.modal('hide');
          },15000);
      });

    },

    'click .hapus': function (e, value, row, index) {
      var url = 'sms-masuk.php?hapus='+row['id'];
      $.get(url, function (data) {
        var modal = $('<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"><div class="modal-dialog" role="document"><div class="modal-content">' + data + '</div></div></div>').modal();

        modal.on("hidden.bs.modal", function () {
          $(this).remove();
        });

        setTimeout(function(){
          modal.modal('hide');
          },15000);
      });
    }
};

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