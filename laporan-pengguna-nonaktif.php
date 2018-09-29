  <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">     
    <div class="row">
      <ol class="breadcrumb">
        <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
        <li>Laporan</li>
        <li class="active">Pengguna Nonaktif</li>
      </ol>
    </div><!--/.row-->


<?php
include("layouts/info.php");
?>

    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header">Laporan Pengguna Nonaktif</h1>
      </div>
    </div><!--/.row-->
        
    
    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading">Pilih Periode</div>
          <div class="panel-body">
            <div class="row">
              <form role="form" method="GET">
                <div class="col-lg-12">
                    <label>Tanggal Awal</label>
                    <div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                      <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                      <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                      <input class="form-control" size="16" type="text" name="tgl_awal" value="<?=((isset($_GET['tgl_awal']))?$_GET['tgl_awal']:'')?>" readonly>
                    </div>
                    <input type="hidden" id="dtp_input2" value="" /><br/>

                    <label>Tanggal Akhir</label>
                    <div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                        <input class="form-control" size="16" type="text" name="tgl_akhir" value="<?=((isset($_GET['tgl_akhir']))?$_GET['tgl_akhir']:'')?>" readonly>
                    </div>
                    <input type="hidden" id="dtp_input2" value="" /><br>
                    <input type="hidden" name="page" value="nonaktif" />
                <button type="submit" class="btn btn-primary">Lihat</button>
                <a href="#" onClick="MyWindow=window.open('laporan-pengguna.php?page=nonaktif&data=cetak&tgl_awal=<?= $_GET['tgl_awal']; ?>&tgl_akhir=<?= $_GET['tgl_akhir']; ?>','MyWindow',',titlebar=no,toolbar=no,menubar=no,resizable=yes,width=1200,height=600'); return false;" class="btn btn-primary">Cetak</a>

                </div>
              </form>
            </div>
          </div>
        </div>
                <table id="table" data-toggle="table"
                  data-url="laporan-pengguna.php?tgl_awal=<?= $_GET['tgl_awal']; ?>&tgl_akhir=<?= $_GET['tgl_akhir']; ?>&data=nonaktif"
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
                    <th data-field="no" data-sortable="true">No.</th>
                    <th data-field="username"  data-sortable="true">Nama Pengguna</th>
                    <th data-field="value" data-sortable="true">Password</th>
                    <th data-field="tgl_submit" data-sortable="true">Tanggal Nonaktif</th>
                </tr>
                </thead>
            </table>
          </div>
        </div>
      </div>
    </div><!--/.row-->      

</div><!--/.main-->
