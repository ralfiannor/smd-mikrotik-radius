<?php

require_once("class/session.class.php");  

require_once("class/home.class.php");

$judul = "Ganti Katasandi";
include("layouts/header.php");

//Simpan data
if(isset($_POST['simpan-1']))
{
    $passbaru = $_POST['pass_baru'];
    $passkonf = $_POST['pass_konfirmasi'];


    if($passbaru=="") {
        $error[] = "Katasandi baru harus diisi !";    
    }
    
    else if($passkonf=="") {
        $error[] = "Harap isi konfirmasi Katasandi baru !";    
    }
    
    else if (strtolower($passbaru)!=strtolower($passkonf)) {
        $error[] = "Katasandi tidak cocok, harap konfirmasi dengan benar !";    
    }

    else {

        if($home->gantisandi($passbaru))
        {
            echo '<script>window.location.replace("ganti_sandi.php?sukses")</script>';
        }

       else

        {
            echo '<script>window.location.replace("ganti_sandi.php?gagal")</script>';
        }
    }
}

?>
<link href="vendor/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet">

	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
                <li class="active">Ganti Kata Sandi</li>
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
                    <div class="panel-heading">Ganti Kata sandi</div>
                    <div class="panel-body">
                        <form role="form" method="post">                            
                            <div class="col-md-8 form-group">
                                <label>Kata sandi baru</label>
                                <input class="form-control" name="pass_baru">
                            </div>
                            <div class="col-md-8 form-group">
                                <label>Konfirmasi kata sandi</label>
                                <input class="form-control" name="pass_konfirmasi">
                                <p class="help-block">* Tulis ulang kata sandi yang baru</p>
                            </div>
                            <div class="col-md-8 form-group">
                            <button type="submit" class="btn btn-primary" name="simpan-1">Simpan</button>
                            <button type="reset" class="btn btn-default">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>                
			</div><!--/.col-->						
		</div><!-- /.row -->

	</div><!--/.main-->

<?php
  include("layouts/footer.php");
?>
<script type="text/javascript">
    function blockSpecialChar(e){
        var k;
        document.all ? k = e.keyCode : k = e.which;
        return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 || (k >= 48 && k <= 57));
        }
    </script>