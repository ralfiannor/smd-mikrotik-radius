<?php
if(isset($_GET['tampil'])) {
    $groupname = $_GET['tampil'];     
?>
  <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">     
    <div class="row">
      <ol class="breadcrumb">
        <li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
        <li><a href="paket.php">Paket</a></li>
        <li class="active">Detail Paket</li>
      </ol>
    </div><!--/.row-->

<?php
include("layouts/info.php");
?>

    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header">Detail Paket <b><?= $groupname ?></b></h1>
      </div>
    </div><!--/.row-->

    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading">RadGroupCheck</div>
          <div class="panel-body">
            <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Attribute</th>
                    <th>Operator</th>
                    <th>Value</th>
                </tr>
                </thead>
                <tbody>
<?php
                $query = "select * from radgroupcheck WHERE groupname='".$groupname."'";       
                $crud->dataview($query);
?>
                </tbody>
            </table>
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-heading">RadGroupReply</div>
          <div class="panel-body">
            <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Attribute</th>
                    <th>Operator</th>
                    <th>Value</th>
                </tr>
                </thead>
                <tbody>
<?php
                $query = "select * from radgroupreply WHERE groupname='".$groupname."'";       
                $crud->dataview($query);
?>
                </tbody>
            </table>
          </div>
        </div>
      </div>
    </div><!--/.row-->      
  </div><!--/.main-->

  <?php } ?>