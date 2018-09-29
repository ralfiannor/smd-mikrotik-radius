<?php

//Simpan data

if(isset($_POST['simpan-1']))
{
    $username = $_POST['username'];
    $password = $_POST['password'];
    $paket = $_POST['paket'];   
    $nohp = $_POST['no_hp'];   
    if($username=="")  {
        $error[] = "Nama pengguna masih kosong !";    
    }

    else if($password=="") {
        $error[] = "Kata sandi masih kosong !";    
    }

    else if($paket=="none") {
        $error[] = "Paket harus dipilih !";    
    }

    else if(strlen($username) < 3 ) {
        $error[] = "Nama pengguna minimal berjumlah 3 karakter !";    
    }

    else if(strlen($password) < 3 ) {
        $error[] = "Kata sandi minimal berjumlah 3 karakter !";    
    }

    else if(strlen($username) > 64 ) {
        $error[] = "Nama pengguna maksimal berjumlah 64 karakter !";    
    }

    else if(strlen($password) > 64 ) {
        $error[] = "Kata sandi maksimal berjumlah 64 karakter !";    
    }
    
    else
    {
        try
        {
            $stmt = $crud->runQuery("SELECT * FROM radcheck WHERE username=:username OR value=:password");
            $stmt->execute(array(':username'=>$username, ':password'=>$password));
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
                
            if($row['username']==$username) {
                $error[] = "Maaf Nama pengguna sudah ada !";
            }
            else
            {
                if($crud->createsingle($username,$password,$paket,$nohp))
                {
                    $sukses[] = "Nama Pengguna <b>".$username."</b> berhasil dibuat";
                    echo "<script>
                            (function () {
                                var timeLeft = 5,
                                    cinterval;

                                var timeDec = function (){
                                    timeLeft--;
                                    document.getElementById('countdown').innerHTML = timeLeft;
                                    if(timeLeft === 0){
                                        clearInterval(cinterval);
                                        window.location.replace('pengguna.php');
                                    }
                                };

                                cinterval = setInterval(timeDec, 1000);
                            })();
                            </script>";
                }

                else
                {
                    echo '<script>window.location.replace("pengguna.php?gagal")</script>';
                }

            }
        }
        catch(PDOException $e)
        {
            echo $e->getMessage();
        }

    }
}

if(isset($_POST['simpan-2']))
{

  $jml_user = $_POST['jml_user'];
  $awalan_nama = $_POST['awalan_nama'];
  $nama_len = $_POST['nama_len'];
  $password_len = $_POST['password_len'];
  $type = $_POST['type_acak'];
  $paket = $_POST['paket'];

    if(!isset($_POST['awalan']) && ($awalan_nama=="")) {
        $error[] = "Nama awalan masih kosong !";
    }

    else if($_POST['type_acak']=="none") {
        $error[] = "Silahkan pilih tipe acakan";
    }

    else if($_POST['nama_len']=="none") {
        $error[] = "Silahkan pilih panjang nama acakan";
    }

    else if(!isset($_POST['passwordsama']) && ($_POST['password_len']=="none")) {
        $error[] = "Silahkan pilih panjang kata sandi";
    }

    else if($paket=="none") {
        $error[] = "Paket harus dipilih !";
    }

    else {

        for($num=1;$num<=$jml_user;$num++){

            if(isset($_POST['awalan']) && $_POST['awalan']==='true') {
            $username = $crud->acakString($nama_len,$type);
            } else { $username = $awalan_nama.$crud->acakString($nama_len,$type); }

            if(isset($_POST['passwordsama']) && $_POST['passwordsama']==='true') {
            $password = $username;
            } else { $password = $crud->acakString($password_len,$type); }

            try
            {
                $stmt = $crud->runQuery("SELECT * FROM radcheck WHERE username=:username OR value=:password");
                $stmt->execute(array(':username'=>$username, ':password'=>$password));
                $row=$stmt->fetch(PDO::FETCH_ASSOC);
                    
                if($row['username']==$username) {
                    $error[] = "Maaf Nama pengguna sudah ada !";
                }
                else
                {
                    if($crud->create($username,$password,$paket))
                    {
                        $sukses[] = "Nama pengguna <b>".$username."</b> berhasil dibuat";
                        echo "<script>
                                (function () {
                                    var timeLeft = 5,
                                        cinterval;

                                    var timeDec = function (){
                                        timeLeft--;
                                        document.getElementById('countdown').innerHTML = timeLeft;
                                        if(timeLeft === 0){
                                            clearInterval(cinterval);
                                            window.location.replace('pengguna.php');
                                        }
                                    };

                                    cinterval = setInterval(timeDec, 1000);
                                })();
                                </script>";
                    }

                    else
                    {
                        $error[] = $username." gagal dibuat !";
                    }

                }
            }

            catch(PDOException $e)
            {
                echo $e->getMessage();
            }
        }
    }
}
?>
  <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">     
    <div class="row">
      <ol class="breadcrumb">
        <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
        <li><a href="pengguna.php">pengguna</a></li>
        <li class="active">Tambah Data pengguna</li>
      </ol>
    </div><!--/.row-->

<?php
include("layouts/info.php");
if(isset($sukses)) {
?>
    <div class="alert alert-info">
        Halaman akan dialihkan dalam <span id="countdown">5</span> detik.
    </div>

<?php } ?>

			<div class="col-lg-12">
				<h2>Tambah Data pengguna Hotspot</h2>
			</div>
			
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-body tabs">
						<ul class="nav nav-tabs">
							<li class="active"><a href="#tab1" data-toggle="tab">Single User</a></li>
							<li><a href="#tab2" id="btn-tab2" data-toggle="tab">Batch User</a></li>
						</ul>
		
						<div class="tab-content">
							<div class="tab-pane fade in active" id="tab1">
        						<div class="col-md-6">
        							<form role="form" method="post">							
        								<div class="form-group">
        									<label>Nama pengguna</label>
        									<input type="text" class="form-control" name="username" id="username" maxlength="64" onkeypress="return blockSpecialChar(event)" value="<?=((isset($_POST['simpan-1']))?$username:'')?>">
        								</div>        																
        								<div class="form-group">
        									<label>Kata Sandi</label>
        									<input type="password" class="form-control" name="password" id="username" maxlength="64" value="<?=((isset($_POST['simpan-1']))?$password:'')?>">
        								</div>															
        								<div class="form-group">
        									<label>Paket</label>
        									<select class="form-control" name="paket">
                                            <option selected value="none"> -- Pilih Paket -- </option>

                    <?php 
                        $query = "SELECT * FROM radgroupcheck WHERE groupname <> 'Disabled-Users' ORDER BY groupname";
                        $crud->pilihpaket($query);
                    ?>            
        									</select>
        								</div>	
                                        <div class="form-group">
                                            <label>Nomor HP</label>
                                            <input type="text" class="form-control" name="no_hp" id="no_hp" maxlength="12" onkeypress="return blockSpecialChar(event)" value="<?=((isset($_POST['simpan-1']))?$nohp:'')?>" placeholder="Kosongkan jika tidak ingin dikirim ke pengguna">
                                        </div>                       
                                        <div class="form-group">
        								<button type="submit" class="btn btn-primary" name="simpan-1">Simpan</button>
        								<button type="reset" class="btn btn-default">Reset</button>
                                        </div>
							        </form>
                                </div>
                            </div>

							<div class="tab-pane fade" id="tab2">
                                <div class="col-md-6">
                                    <form role="form" method="post">                            
                                        <div class="form-group">
                                            <label>Jumlah pengguna</label>
                                            <input class="form-control" name="jml_user" id="jml_user" maxlength="12" onkeypress="return validateNumber(event)" value="<?=((isset($_POST['simpan-2']))?$jml_user:'')?>">
                                        </div>
                                                                        
                                        <div class="form-group">
                                            <label>Tipe Pengacakan</label>
                                            <select class="form-control" name="type_acak" id="type_acak">
                                                <option selected value="none"> -- Pilih Tipe Pengacakan -- </option>
                                                <option value="3">Type 1 (123)</option>
                                                <option value="2">Type 2 (123abc)</option>
                                                <option value="1">Type 3 (123ABC)</option>
                                                <option value="0">Type 4 (123abcABC)</option>
                                            </select>
                                        </div>                                                          
                                        <div class="form-group checkbox">
                                          <label>
                                            <input type="checkbox" name="awalan" id="awalan" value="true">Gunakan tanpa awalan (prefiks)</label>
                                        </div>

                                        <div class="form-group">
                                            <label>Nama Awal</label>
                                            <input class="form-control" name="awalan_nama" id="awalan_nama" maxlength="35" onkeypress="return blockSpecialChar(event)" value="<?=((isset($_POST['simpan-2']))?$awalan_nama:'')?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Panjang Acakan Nama pengguna</label>
                                            <select class="form-control" name="nama_len" id="nama_len">
                                                <option selected value="none"> -- Pilih Panjang Acakan -- </option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                            </select>
                                        </div>                                                          

                                         <div class="form-group checkbox">
                                          <label>
                                            <input type="checkbox" name="passwordsama" id="passwordsama" value="true">Samakan katasandi dengan nama pengguna</label>
                                        </div>

                                        <div class="form-group">
                                            <label>Panjang Kata Sandi</label>
                                              <select class="form-control" name="password_len" id="password_len">
                                                <option selected value="none"> -- Pilih Panjang Kata Sandi -- </option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                                <option value="10">11</option>
                                                <option value="10">12</option>
                                              </select>
                                        </div>                                                          
                                       
                                        <div class="form-group">
                                            <label>Paket</label>
                                            <select class="form-control" name="paket">
                                            <option selected value="none"> -- Pilih Paket -- </option>
                    <?php 
                        $query = "SELECT * FROM radgroupcheck WHERE groupname <> 'Disabled-Users' ORDER BY groupname";       
                        $crud->pilihpaket($query);
                    ?>            
                                            </select>
                                        </div>  
                                        <div class="form-group">
                                        <button type="submit" class="btn btn-primary" name="simpan-2">Simpan</button>
                                        <button type="reset" class="btn btn-default">Reset</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
						</div>
					</div>
				</div><!--/.panel-->
			</div><!--/.col-->
						
		</div><!-- /.row -->
		
	</div><!--/.main-->

    <script>
        $(function() {
             $('#username').on('keypress', function(e) {
                if (e.which == 32) {
                    alert('Tidak diperbolehkan menggunakan spasi !');
                    return false;
                }
             });
        });

          $('#awalan').change(function() {
            if(this.checked) {
                $('#awalan_nama').attr("readonly",true);
                $('#awalan_nama').val("");
                //alert($(this).data("id"));
            }

            else {
                $('#awalan_nama').attr("readonly",false);
            }
          });


        $(function() {
             $('#awalan_nama').on('keypress', function(e) {
                if (e.which == 32) {
                    alert('Tidak diperbolehkan menggunakan spasi !');
                    return false;
                }
             });
        });


          $('#passwordsama').change(function() {
            if(this.checked) {
                $('[name=password_len] option').filter(function() { 
                    return ($(this).val() == 'none');
                }).prop('selected', true);

                $('#password_len').attr("disabled",true);
            }
            else {
                $('#password_len').attr("disabled",false);
            }
          });

        function blockSpecialChar(e){
            var k;
            document.all ? k = e.keyCode : k = e.which;
            return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 95 || k == 45 || k == 46 || k == 32 || (k >= 48 && k <= 57));
            }


        function validateNumber(event) {
            var key = window.event ? event.keyCode : event.which;
            if (event.keyCode === 8 || event.keyCode === 46) {
                return true;
            } else if ( key < 48 || key > 57 ) {
                return false;
            } else {
                return true;
            }
        };
    </script>