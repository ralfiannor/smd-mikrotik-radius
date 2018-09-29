<?php
if(isset($_GET['nama']))
{
    $user = $_GET['nama'];
    extract($crud->getID($user));
}

//Simpan data

if(isset($_POST['simpan']))
{
    $user = $_GET['nama'];
    $userbaru = $_POST['username'];
    $password = $_POST['password'];
    $paket = $_POST['paket'];   
    $nohp = $_POST['no_hp'];   
    if($userbaru=="")  {
        $error[] = "Nama pengguna masih kosong !";    
    }
    
    else if($password=="") {
        $error[] = "Kata sandi masih kosong !";    
    }
    
    else
    {
        if($crud->update($user,$userbaru,$password,$paket,$nohp))
        {
            echo '<script>window.location.replace("pengguna.php?sukses")</script>';
        }
        else
        {
            echo '<script>window.location.replace("pengguna.php?gagal")</script>';
        }                
    }
}

?>
  <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">     
    <div class="row">
      <ol class="breadcrumb">
        <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
        <li><a href="pengguna.php?page=tampil">Pengguna</a></li>
        <li class="active">Ubah Data Pengguna</li>
      </ol>
    </div><!--/.row-->

<?php
include("layouts/info.php");
?>

<script>
    $(function() {
        $('[name=paket] option').filter(function() { 
            return ($(this).text() == '<?= $groupname ?>');
        }).prop('selected', true);
    })
</script>

            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Ubah Data Pengguna</div>
                    <div class="panel-body">
                        <form role="form" method="post">                            
                            <div class="form-group">
                                <label>Nama Pengguna</label>
                                <input class="form-control" name="username" value="<?= $username ?>">
                            </div>
                                                            
                            <div class="form-group">
                                <p class="help-block"><b>Kata Sandi Lama : </b><?= $value ?></p>
                                <label>Kata Sandi Baru</label>
                                <input type="password" class="form-control" name="password">
                            </div>                                                          
                            
                            <div class="form-group">
                                <label>Paket</label>
                                <select class="paket form-control" name="paket" id="paket">
        <?php 
            $query = "SELECT * FROM radgroupcheck WHERE groupname <> 'Disabled-Users' ORDER BY groupname";       
            $crud->pilihpaket($query);
        ?>            
                                </select>
                            </div>  
                            <div class="form-group">
                                <label>Nomor HP</label>
                                <input class="form-control" name="no_hp" value="<?= $no_hp ?>">
                            </div>

                            <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
                            <button type="reset" class="btn btn-default">Reset</button>
                        </form>
                    </div>
                </div>                
            </div><!--/.col-->                      
        </div><!-- /.row -->
        
    </div><!--/.main-->
