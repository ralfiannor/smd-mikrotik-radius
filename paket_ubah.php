<?php

if(isset($_GET['paket']))
{
    $paket = $_GET['paket'];
    extract($crud->getID($paket));
}

if(isset($_POST['simpan']))
{
    $paket = $_GET['paket'];     
    $paketbaru = $_POST['paketbaru'];
    $hargabaru = $_POST['hargabaru'];
    $deskripsi = $_POST['deskripsi'];

    if($paketbaru=="")  {
        $error[] = "Nama paket harus diisi !";    
    }    
    else if($hargabaru=="")  {
        $error[] = "Harga harus diisi !";    
    }    

    else
    {
        try
        {
            $stmt = $crud->runQuery("SELECT groupname FROM radgroupcheck WHERE groupname<>:paket");
            $stmt->execute(array(':paket'=>$paket));
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
                
            if(strtolower($row['groupname'])==strtolower($paketbaru)) {
                $error[] = "Tidak ada perubahan yang dilakukan. Nama Paket sudah ada!";
            }

            else
            {
                if($crud->update($paket,$paketbaru,$hargabaru,$deskripsi))

                {
                    echo '<script>window.location.replace("paket.php?sukses")</script>';
                }

                else
                {
                    echo '<script>window.location.replace("paket.php?gagal")</script>';
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

  <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">     
    <div class="row">
      <ol class="breadcrumb">
        <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
        <li><a href="paket.php">Paket</a></li>
        <li class="active">Ubah Paket</li>
      </ol>
    </div><!--/.row-->


<?php
include("layouts/info.php");
?>

    <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Ubah Paket Hotspot</div>
                    <div class="panel-body">
                        <form role="form" method="post">                            
                            <div class="col-md-8 form-group">
                                <label>Nama Paket</label>
                                <input class="form-control" name="paketbaru" value="<?= $groupname ?>">
                                <p class="help-block">* Harus diisi</p>
                            </div>                                                                                  
                            <div class="col-md-8 form-group">
                                <label>Harga</label>
                                <input class="form-control" name="hargabaru" value="<?= $harga ?>">
                                <p class="help-block">* Harus diisi</p>
                            </div>                                                                                  
                            <div class="col-md-8 form-group">
                                <label>Deskripsi</label>
                                <textarea class="form-control" name="deskripsi"><?= $deskripsi ?></textarea>
                            </div>                                                                                  
                            <div class="col-md-8 form-group">
                            <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
                            <button type="reset" class="btn btn-default">Reset Button</button>
                            </div>
                        </form>
                    </div>
                </div>                
            </div><!--/.col-->                      
        </div><!-- /.row -->
  </div><!--/.main-->