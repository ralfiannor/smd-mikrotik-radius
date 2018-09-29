<?php
    error_reporting(0);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= $judul ?> - Mikrotik User Management</title>

<link href="assets/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/css/datepicker3.css" rel="stylesheet">
<link href="assets/css/styles.css" rel="stylesheet">

<script src="assets/js/jquery-1.11.1.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

<!--Icons-->
<script src="assets/js/lumino.glyphs.js"></script>

<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->


</head>

<body>
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><span>SMD</span>Radius</a>
                <ul class="user-menu">
                    <li class="dropdown pull-right">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Administrator <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="ganti_sandi.php"><svg class="glyph stroked key"><use xlink:href="#stroked-key"></use></svg> Ganti Kata Sandi</a></li>
                            <li><a href="logout.php?logout"><svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"></use></svg> Keluar</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
                            
        </div><!-- /.container-fluid -->
    </nav>
        
    <div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
        <form role="search">
            <div class="form-group">
                
            </div>
        </form>
<?php 
    function echo_Active_Tab ($requestUri){
        $current_file_name = basename($_SERVER['REQUEST_URI'], ".php");

        if ($current_file_name == $requestUri)
            echo 'active';
    }
?>
        <ul class="nav menu">
            <li class="<?=echo_Active_Tab("home")?>"><a href="home.php"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Beranda</a></li>
            <li class="<?=echo_Active_Tab("paket")?><?=echo_Active_Tab("tambah_paket")?> parent">
                <a data-toggle="collapse" href="#paket">
                    <span><svg class="glyph stroked app-window-with-content"><use xlink:href="#stroked-app-window-with-content"></use></svg></span> Paket
                </a>
                <ul class="children collapse" id="paket">
                    <li>
                        <a class="" href="paket.php">
                            <svg class="glyph stroked blank document"><use xlink:href="#stroked-blank-document"/></svg> Semua Paket
                        </a>
                    </li>
                    <li>
                        <a class="" href="paket.php?page=tambah">
                            <svg class="glyph stroked plus sign"><use xlink:href="#stroked-plus-sign"></use></svg> Tambah Paket
                        </a>
                    </li>
                </ul>
            </li>
            <li class="<?=echo_Active_Tab("pengguna")?><?=echo_Active_Tab("tambah_pengguna")?> parent">
                <a data-toggle="collapse" href="#pengguna">
                    <span><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg></span> Pengguna 
                </a>
                <ul class="children collapse" id="pengguna">
                    <li class="">
                        <a class="" href="pengguna.php?page=tampil">
                            <svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Semua Pengguna
                        </a>
                    </li>
                    <li class="">
                        <a class="" href="pengguna.php?page=disabled">
                            <svg class="glyph stroked clock"><use xlink:href="#stroked-clock"/></svg> Pengguna Tidak Aktif
                        </a>
                    </li>
                    <li class="">
                        <a class="" href="pengguna.php?page=log">
                            <svg class="glyph stroked clipboard with paper"><use xlink:href="#stroked-clipboard-with-paper"/></svg> Log Pengguna
                        </a>
                    </li>
                    <li class="">
                        <a class="" href="pengguna.php?page=tambah">
                            <svg class="glyph stroked plus sign"><use xlink:href="#stroked-plus-sign"></use></svg> Tambah Pengguna
                        </a>
                    </li>
                </ul>
            </li>
            <li class="<?=echo_Active_Tab("akunting")?>"><a href="akunting.php"><svg class="glyph stroked line-graph"><use xlink:href="#stroked-line-graph"></use></svg> Akunting</a></li>
            <li class="parent ">
                <a data-toggle="collapse" href="#laporan">
                    <span><svg class="glyph stroked table"><use xlink:href="#stroked-table"/></svg> Laporan 
                </a>
                <ul class="children collapse" id="laporan">
                    <li class="">
                        <a class="" href="laporan-paket.php">
                            <svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg>Paket
                        </a>
                    </li>
                    <li class="">
                        <a class="" href="laporan-pengguna.php?page=baru">
                            <svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg>Pengguna Baru / Aktif
                        </a>
                    </li>
                    <li class="">
                        <a class="" href="laporan-pengguna.php?page=nonaktif">
                            <svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg>Pengguna Nonaktif
                        </a>
                    </li>
                </ul>
            </li>
            <li class="parent ">
                <a data-toggle="collapse" href="#sms">
                    <span><svg class="glyph stroked email"><use xlink:href="#stroked-email"/></svg> SMS Gateway 
                </a>
                <ul class="children collapse" id="sms">
                    <li class="">
                        <a class="" href="sms-masuk.php">
                            <svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg>SMS Masuk
                        </a>
                    </li>
                    <li class="">
                        <a class="" href="sms-keluar.php">
                            <svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg>SMS Keluar
                        </a>
                    </li>
                    <li class="">
                        <a class="" href="sms-terkirim.php">
                            <svg class="glyph stroked chevron-right"><use xlink:href="#stroked-chevron-right"></use></svg>SMS Terkirim
                        </a>
                    </li>
                </ul>
            </li>
            <li class="<?=echo_Active_Tab("pengaturan")?>"><a href="pengaturan.php"><svg class="glyph stroked gear"><use xlink:href="#stroked-gear"></use></svg> Pengaturan</a></li>
            <li role="presentation" class="divider"></li>
            <li><a href="logout.php?logout"><svg class="glyph stroked chevron-left"><use xlink:href="#stroked-chevron-left"></use></svg> Keluar</a></li>
        </ul>
    </div><!--/.sidebar-->
