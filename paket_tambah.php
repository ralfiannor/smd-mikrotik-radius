<?php

//Simpan data
if(isset($_POST['simpan-1']))
{
    $paket = $_POST['paket'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];
    $timeout = $_POST['timeout'];   
    $simultan = $_POST['simultan'];
    $timelimit = $_POST['timelimit'];
    $timelimit_select = $_POST['timelimit_select'];
    $updown_limit = $_POST['updown_limit'];
    $updown_select = $_POST['updown_select'];
    $downspeed_limit = $_POST['downspeed_limit'];   
    $upspeed_limit = $_POST['upspeed_limit'];
    $tgl_expire = $_POST['tgl_expire'];


    if($paket=="")  {
        $error[] = "Nama paket harus diisi !";    
    }

    else if($harga=="") {
        $error[] = "Harga tidak boleh kosong !";    
    }
    
    else if($timeout=="") {
        $error[] = "Idle Timeout masih kosong ! Harap isikan minimal 60 detik";    
    }

    else if($simultan=="") {
        $error[] = "Penggunaan secara bersamaan masih kosong ! Harap isikan minimal 60 detik";    
    }

    else if($harga<1000) {
        $error[] = "Harga tidak boleh kurang dari 1000 !";    
    }

    else if($timeout<60) {
        $error[] = "Idle Timeout minimal 60";    
    }

    else if($simultan<1) {
        $error[] = "Penggunaan secara bersamaan minimal 1";    
    }
    
    else if(isset($timelimit) && ($timelimit!='') && ($timelimit_select=='none')) {
            $error[] = "Silahkan pilih batasan waktu";
    }

    else if(isset($updown_limit) && ($updown_limit!='') && ($updown_select=='none')) {
            $error[] = "Silahkan pilih batasan unduh/unggah";
    }

    else
    {
        try
        {
            $stmt = $crud->runQuery("SELECT groupname FROM radgroupcheck WHERE groupname=:paket");
            $stmt->execute(array(':paket'=>$paket));
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
                
            if(strtolower($row['groupname'])==strtolower($paket)) {
                $error[] = "Maaf Nama Paket sudah ada !";
            }

            else
            {
                if($crud->create($paket,$harga,$deskripsi,$timeout,$simultan,$timelimit,$timelimit_select,$updown_limit,$updown_select,$downspeed_limit,$upspeed_limit,$tgl_expire))

                {
                    echo '<script>window.location.replace("paket.php?page=tampil&sukses")</script>';
                }

               else
                {
                    echo '<script>window.location.replace("paket.php?paket=tampil&gagal")</script>';
                }

            }
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }

    }
}

?>
<link href="vendor/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet">

	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<li><a href="paket.php">Paket</a></li>
                <li class="active">Tambah Paket</li>
			</ol>
		</div><!--/.row-->


		<div class="row">

<?php
include("layouts/info.php");
if(isset($sukses)) {
?>
    <div class="alert alert-info">
        Halaman akan dialihkan dalam <span id="countdown">5</span> detik.
    </div>

<?php } ?>

            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Tambah Paket Hotspot</div>
                    <div class="panel-body">
                        <form role="form" method="post">                            
                            <div class="col-md-8 form-group">
                                <label>Nama Paket</label>
                                <input type="input" class="form-control" name="paket" onkeypress="return blockSpecialChar(event)" maxlength="64" value="<?=((isset($_POST['simpan-1']))?$paket:'')?>">
                                <p class="help-block">* Harus diisi</p>
                            </div>
                            <div class="col-md-8 form-group">
                                <label>Harga</label>
                                <input type="input" class="form-control" id="harga" name="harga" maxlength="14" onkeypress="return validateNumber(event)" value="<?=((isset($_POST['simpan-1']))?$harga:'')?>">
                                <p class="help-block">* Harus diisi</p>
                            </div>
                            <div class="col-md-8 form-group">
                                <label>Deskripsi</label>
                                <textarea class="form-control" name="deskripsi"><?=((isset($_POST['simpan-1']))?$deskripsi:'')?></textarea>
                                <p class="help-block">* Harus diisi</p>
                            </div>                                                                                                                                
                            <div class="col-md-8 form-group">
                                <label>Idle Timeout (per detik)</label>
                                <input class="form-control" id="waktu" name="timeout" value="<?=((isset($_POST['simpan-1']))?$timeout:'')?>" onkeypress="return validateNumber(event)" maxlength="253">
                                <p class="help-block">* Min 60</p>
                            </div>
                            <div class="col-md-8 form-group">
                                <label>Penggunaan secara bersamaan</label>
                                <input class="form-control" id="angka" name="simultan" value="<?=((isset($_POST['simpan-1']))?$simultan:'')?>" onkeypress="return validateNumber(event)" maxlength="253">
                                <p class="help-block">* Min 1</p>

                            </div>                                                          
                                                          
                            <div class="col-md-6 form-group">
                                <label>Batas Waktu (detik)</label>
                                <input class="form-control" id="waktu" name="timelimit" value="<?=((isset($_POST['simpan-1']))?$timelimit:'')?>" onkeypress="return validateNumber(event)" maxlength="253">
                            </div>

                            <div class="col-md-2 form-group">
                                    <label>Pilih Batasan</label><select class="form-control" name="timelimit_select">
                                        <option value="none">Tidak Ada</option>
                                        <option value="all">Setiap Waktu</option>
                                        <option value="daily">Per Hari</option>
                                        <option value="weekly">Per Minggu</option>
                                        <option value="monthly">Per Bulan</option>
                                    </select>
                            </div>                                                          

                            <div class="col-md-6 form-group">
                                <label>Batasan Unduh/Unggah (Bytes)</label>
                                <input class="form-control" name="updown_limit" onkeypress="return validateNumber(event)" value="<?=((isset($_POST['simpan-1']))?$updown_limit:'')?>" maxlength="253">
                            </div>                                                          
                            <div class="col-md-2 form-group">
                                <label>Pilih Batasan</label>
                                    <select class="form-control" name="updown_select">
                                        <option value="none">Tidak Ada</option>
                                        <option value="all">Setiap Waktu</option>
                                        <option value="daily">Per Hari</option>
                                        <option value="weekly">Per Minggu</option>
                                        <option value="monthly">Per Bulan</option>
                                    </select>
                            </div>

                            <div class="col-md-8 form-group">
                                <label>Batasan kecepatan unduh (b/s)</label>
                                <input class="form-control" name="downspeed_limit" onkeypress="return validateNumber(event)" value="<?=((isset($_POST['simpan-1']))?$downspeed_limit:'')?>" maxlength="253">
                            </div>                                                                                  
                            <div class="col-md-8 form-group">
                                <label>Batasan kecepatan unggah (b/s)</label>
                                <input class="form-control" name="upspeed_limit" onkeypress="return validateNumber(event)" value="<?=((isset($_POST['simpan-1']))?$updown_limit:'')?>" maxlength="253">
                            </div>                                                                                  
                            <div class="col-md-8 form-group">
                                <label>Tanggal Kadaluarsa (Expired)</label>
                                <div class="input-group date form_date col-md-5" data-date="" data-date-format="d M yyyy" data-link-field="dtp_input2" data-link-format="d M yyyy">
                                  <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                  <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                  <input class="form-control" size="16" type="text" name="tgl_expire" value="<?=((isset($_POST['simpan-1']))?$tgl_expire:'')?>" readonly>
                                </div>
                                <input type="hidden" id="dtp_input2" value="" /><br/>
                            </div>                                                                                  

                            <div class="col-md-8 form-group">
                            <button type="submit" class="btn btn-primary" name="<?=((isset($_GET['edit_id']))?'btn-update':'simpan-1')?>">Simpan</button>
                            <button type="reset" class="btn btn-default">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>                
			</div><!--/.col-->						
		</div><!-- /.row -->

	</div><!--/.main-->

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
        language:  'en',
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
<script type="text/javascript">
    function blockSpecialChar(e){
        var k;
        document.all ? k = e.keyCode : k = e.which;
        return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 || (k >= 48 && k <= 57));
        }

    function validateNumber(event) {
        var key = window.event ? event.keyCode : event.which;
        if (event.keyCode === 8) {
            return true;
        } else if ( key < 48 || key > 57 ) {
            return false;
        } else {
            return true;
        }
    };
    </script>