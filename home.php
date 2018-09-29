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
        <li class="active">Beranda</li>
      </ol>
    </div><!--/.row-->
    
    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header">Beranda</h1>
      </div>
    </div><!--/.row-->

    <div class="row">
      <div class="col-xs-12 col-md-6 col-lg-3">
        <div class="panel panel-red panel-widget">
          <div class="row no-padding">
            <div class="col-sm-3 col-lg-5 widget-left">
              <svg class="glyph stroked app-window-with-content"><use xlink:href="#stroked-app-window-with-content"></use></svg>
            </div>
            <div class="col-sm-9 col-lg-7 widget-right">
              <div class="large"><?= $home->paket(); ?></div>
              <div class="text-muted">Total Paket</div>
            </div>
          </div>
        </div>
      </div>    
      <div class="col-xs-12 col-md-6 col-lg-3">
        <div class="panel panel-teal panel-widget">
          <div class="row no-padding">
            <div class="col-sm-3 col-lg-5 widget-left">
              <svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg>
            </div>
            <div class="col-sm-9 col-lg-7 widget-right">
              <div class="large"><?= $home->pengguna(); ?></div>
              <div class="text-muted">Total Pengguna</div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-md-6 col-lg-3">
        <div class="panel panel-blue panel-widget ">
          <div class="row no-padding">
            <div class="col-sm-3 col-lg-5 widget-left">
              <svg class="glyph stroked key"><use xlink:href="#stroked-key"></use></svg>
            </div>
            <div class="col-sm-9 col-lg-7 widget-right">
              <div class="large"><?= $home->login(); ?></div>
              <div class="text-muted">Berhasil Login</div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-md-6 col-lg-3">
        <div class="panel panel-orange panel-widget">
          <div class="row no-padding">
            <div class="col-sm-3 col-lg-5 widget-left">
              <svg class="glyph stroked notepad"><use xlink:href="#stroked-notepad"></use></svg>
            </div>
            <div class="col-sm-9 col-lg-7 widget-right">
              <div class="large"><?= $home->log(); ?></div>
              <div class="text-muted">Log tercatat</div>
            </div>
          </div>
        </div>
      </div>
    </div><!--/.row-->
    
    <div class="row">
      <div class="col-xs-6 col-md-3">
        <div class="panel panel-default">
          <div class="panel-body easypiechart-panel">
            <h4>Pengguna Baru Bulan ini</h4>
            <div class="easypiechart" id="easypiechart-blue" data-percent="<?= $home->baruperbulan() ?>" ><span class="percent"><?= $home->baruperbulan() ?></span>
            </div>
            <h5>Dari <?= $home->pengguna(); ?> Total Pengguna</h5>
          </div>
        </div>
      </div>
      <div class="col-xs-6 col-md-3">
        <div class="panel panel-default">
          <div class="panel-body easypiechart-panel">
            <h4>Pengguna Aktif Bulan ini</h4>
            <div class="easypiechart" id="easypiechart-orange" data-percent="<?= $home->aktifperbulan() ?>" ><span class="percent"><?= $home->aktifperbulan() ?></span>
            </div>
            <h5>Dari <?= $home->pengguna(); ?> Total Pengguna</h5>
          </div>
        </div>
      </div>
      <div class="col-xs-6 col-md-3">
        <div class="panel panel-default">
          <div class="panel-body easypiechart-panel">
            <h4>Pengguna Tidak Aktif Bulan ini</h4>
            <div class="easypiechart" id="easypiechart-teal" data-percent="56" ><span class="percent">7</span>
            </div>
            <h5>Dari <?= $home->pengguna(); ?> Total Pengguna</h5>
          </div>
        </div>
      </div>
      <div class="col-xs-6 col-md-3">
        <div class="panel panel-default">
          <div class="panel-body easypiechart-panel">
            <h4>Pengguna Expired Bulan ini</h4>
            <div class="easypiechart" id="easypiechart-red" data-percent="27" ><span class="percent">5</span>
            </div>
            <h5>Dari <?= $home->pengguna(); ?> Total Pengguna</h5>
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