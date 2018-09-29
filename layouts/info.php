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
                            <button type="button" class="btn btn-default" data-dismiss="modal" id="batal">Batal</button>
                            <button type="submit" class="btn btn-primary" name="hapus">Hapus</a></button>
            
                    </div>
                </div><!-- /.modal-content -->
                </form><!-- /.form -->
            </div><!-- /.modal dialog -->
        </div><!-- /.modal -->
<?php
// pesan kesalahan

if(isset($sukses))
{
    foreach($sukses as $sukses)
    {
         ?>
            <div class="alert bg-success" role="alert">
                <svg class="glyph stroked checkmark"><use xlink:href="#stroked-checkmark"></use></svg> <?php echo $sukses; ?><a href="#" data-dismiss="alert" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a>
            </div>
         <?php   
    }
}


if(isset($error))
{
    foreach($error as $error)
    {
         ?>
            <div class="alert bg-danger" role="alert">
                <svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"></use></svg>  &nbsp; <?php echo $error; ?><a href="#" class="pull-right" data-dismiss="alert"><span class="glyphicon glyphicon-remove"></span></a>
            </div>
         <?php   
    }
}

else if(isset($_GET['sukses'])) 
{
    ?>
    <div class="alert bg-success" role="alert">
        <svg class="glyph stroked checkmark"><use xlink:href="#stroked-checkmark"></use></svg> <strong>Sukses!</strong> data telah berhasil disimpan.
<a href="#" data-dismiss="alert" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a>
    </div>
<?php
}

else if(isset($_GET['gagal']))
{
    ?>
<div class="alert bg-danger" role="alert">
                    <svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"></use></svg> Maaf telah terjadi kesalahan. Periksa data masukkan anda. <a href="#" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a>
                </div><?php
}

else if(isset($_GET['terhapus'])) 
{
    ?>
    <div class="alert bg-warning" role="alert">
        <svg class="glyph stroked checkmark"><use xlink:href="#stroked-checkmark"></use></svg> <strong>Terhapus!</strong> data telah berhasil dihapus.
<a href="#" data-dismiss="alert" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a>
    </div>
<?php
}


/* Akhir Pesan Kesalahan*/
?>                  
