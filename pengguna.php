<?php
//require 'vendor/autoload.php';
//use Dompdf\Dompdf;

require_once("class/session.class.php");  
require_once("class/pengguna.class.php");


// Tampil data tabel 
if(isset($_GET['data']) && $_GET['data']=="tampil")
{
header('Content-Type: application/json');
$query = "SELECT user.*, a.groupname, a.groupname_awal, b.attribute as grupattr, b.value as grupval, a.tgl_dibuat FROM radcheck as user LEFT JOIN radusergroup as a ON user.username = a.username LEFT JOIN radgroupcheck as b on a.groupname=b.groupname GROUP BY username";       
$crud->datatampil($query);
exit();
}

else if(isset($_GET['data']) && $_GET['data']=="disabled")
{
header('Content-Type: application/json');
$query = "select a.*,b.groupname from radcheck as a left join radusergroup as b ON a.username = b.username WHERE b.groupname = 'Disabled-Users' GROUP BY username";       
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

// Cetak data
if(isset($_POST['btn-cetak']))
{
    $username = $_POST['usercetak'];
    $userarray = explode(",",$username);
    $in = "('".implode("','",$userarray)."')";   
    $query = "SELECT * FROM radcheck WHERE username IN $in";

    $crud->cetak($query);

echo '<script>
    window.open("voucher.html","_blank")
    </script>';
}

$judul = "Pengguna Hotspot";
include("layouts/header.php");


// ISI Halaman

if(isset($_GET['page']) && $_GET['page']=="tambah")
{
  require_once("pengguna_tambah.php");
}

else if(isset($_GET['page']) && $_GET['page']=="detail")
{
  require_once("pengguna_detail.php");
}

else if(isset($_GET['page']) && $_GET['page']=="ubah")
{
  require_once("pengguna_ubah.php");
}

else if(isset($_GET['page']) && $_GET['page']=="log")
{
  require_once("pengguna_log.php");
}

else if(isset($_GET['page']) && $_GET['page']=="disabled")
{
  require_once("pengguna_disabled.php");
}


else
{
  require_once("pengguna_tampil.php");
}




// FOOTER

include("layouts/footer.php");
?>

  <script src="assets/js/bootstrap-datepicker.js"></script>
  <script src="assets/js/bootstrap-table.js"></script>
<script>
//window.setTimeout(function() {
//    $(".alert").fadeTo(500, 0).slideUp(500, function(){
//        $(this).remove(); 
//    });
//}, 3000);


$(function () {
    var $remove = $('#remove');
    var $cetak = $('#cetak');
    var selections = [];

$cetak.click(function () {
var ids = getIdSelections();
//            $('#table').bootstrapTable('remove', {
//                field: 'username',
//                values: ids
//            });
            $cetak.prop('disabled', false);
//        $('.modal#konfirmasi').find('form').attr('action', $(this).attr('href'));
        $('#formcetak').find('.cetak').val(ids);
        //$('#konfirmasi').modal('show');
            });


$remove.click(function () {
var ids = getIdSelections();
//            $('#table').bootstrapTable('remove', {
//                field: 'username',
//                values: ids
//            });
            $remove.prop('disabled', true);
//        $('.modal#konfirmasi').find('form').attr('action', $(this).attr('href'));
        $('.modal#konfirmasi').find('.delete-id').val(ids);
        $('.modal#konfirmasi').modal('show');
            });

$('#batal').click(function () {
      $remove.prop('disabled', false);
});

function getIdSelections() {
        return $.map($('#table').bootstrapTable('getSelections'), function (row) {
            return row.username
        });
    }
 
    $('#table').on('all.bs.table', function (e, name, args) {
        //console.log('Event:', name, ', data:', args);
    })
    .on('check.bs.table uncheck.bs.table ' +
                'check-all.bs.table uncheck-all.bs.table', function (e, row) {
          $remove.prop('disabled', !$('#table').bootstrapTable('getSelections').length);
          $cetak.prop('disabled', !$('#table').bootstrapTable('getSelections').length);

            // save your data, here just save the current page
            selections = getIdSelections();
            console.log(selections);
     })
});



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