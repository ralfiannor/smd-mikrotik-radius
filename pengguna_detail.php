<?php

if(isset($_GET['username'])) {
    $username = $_GET['username'];     

?>
  <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">     
    <div class="row">
      <ol class="breadcrumb">
        <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
        <li><a href="pengguna.php">Pengguna</a></li>
        <li class="active">Detail Pengguna Hotspot</li>
      </ol>
    </div><!--/.row-->


<?php
include("layouts/info.php");
?>

    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header">Detail Pengguna Hotspot</h1>
      </div>
    </div><!--/.row-->
        
    
    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading">Informasi Akun</div>
          <div class="panel-body">
            <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
 <?php
              
                $query = "select a.*, b.groupname from radcheck as a LEFT JOIN radusergroup as b ON a.username=b.username WHERE a.username='".$username."'";       
                $crud->detail($query);
?>
            </table>
          </div>
        </div>
      </div>
    </div><!--/.row-->      

    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading">Informasi Batasan</div>
          <div class="panel-body">
            <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <h5>Radgroupcheck</h5>
                  <tr>
                  <td><center>Attribute</center></td>
                  <td><center>Operator</center></td>
                  <td><center>Value</center></td>
                  </tr>
 <?php
                $user = $_GET['username'];
                $query = "select a.username, a.groupname as grup, b.* FROM radusergroup as a LEFT JOIN radgroupcheck as b ON a.groupname = b.groupname WHERE a.username='adit'";                $crud->detail2($query);
?>
            </table>
          </div>
          <div class="panel-body">
            <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <h5>Radgroupreply</h5>
                  <tr>
                  <td><center>Attribute</center></td>
                  <td><center>Operator</center></td>
                  <td><center>Value</center></td>
                  </tr>
 <?php
                $user = $_GET['username'];
                $query = "select a.username, a.groupname as grup, b.* FROM radusergroup as a LEFT JOIN radgroupreply as b ON a.groupname = b.groupname WHERE a.username='adit'";                $crud->detail2($query);
?>
            </table>
          </div>

        </div>
      </div>
    </div><!--/.row-->      

  </div><!--/.main-->

<?php } ?>