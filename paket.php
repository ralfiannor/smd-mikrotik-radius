<?php
    require_once("class/session.class.php");  


    require_once("class/paket.class.php");

    if(isset($_GET['data']) && $_GET['data']=="paket")
    {
    header('Content-Type: application/json');
    //$query = "select a.groupname,b.harga,b.deskripsi from radgroupcheck as a LEFT JOIN harga as b ON a.groupname=b.groupname WHERE a.groupname<>'Disabled-Users' ORDER BY a.groupname";
    $query = "select * from harga ORDER BY groupname";       
    $crud->daftarpaket($query);
    exit();
    }


    else if(isset($_GET['data']) && $_GET['data']=="radgroupreply")
    {
    header('Content-Type: application/json');
    $query = "select * from radgroupreply";       
    $crud->dataview($query);
    exit();
    }

    $judul = "Paket Hotspot";
    include("layouts/header.php");


// ISI Halaman

if(isset($_GET['page']) && $_GET['page']=="tambah")
{
  require_once("paket_tambah.php");
}

else if(isset($_GET['page']) && $_GET['page']=="detail")
{
  require_once("paket_detail.php");
}

else if(isset($_GET['page']) && $_GET['page']=="ubah")
{
  require_once("paket_ubah.php");
}
else
{
  require_once("paket_tampil.php");
}


// Footer
  include("layouts/footer.php");
?>
  <script src="assets/js/bootstrap-datepicker.js"></script>
  <script src="assets/js/bootstrap-table.js"></script>
<script type="text/javascript" charset="utf-8">
$(function () {
    var $remove = $('#remove');
    var selections = [];
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
            return row.groupname
        });
    }
 
    $('#table').on('all.bs.table', function (e, name, args) {
        //console.log('Event:', name, ', data:', args);
    })
    .on('check.bs.table uncheck.bs.table ' +
                'check-all.bs.table uncheck-all.bs.table', function (e, row) {
          $remove.prop('disabled', !$('#table').bootstrapTable('getSelections').length);

            // save your data, here just save the current page
            selections = getIdSelections();
            console.log(selections);
     })
});  
</script>
</body>
</html>