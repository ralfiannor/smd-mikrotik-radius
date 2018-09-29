<?php
$id = "1";
extract($API->getID($id));

if(isset($_POST['btn-save-error']))
{
  $ip = $_POST['ip'];
  $uname = $_POST['uname'];
  $pass = $_POST['pass'];
  $server = $_POST['server'];
  $profile = $_POST['profile'];
  
    //Simpan Ke Database Program
    if($API->update($ip,$uname,$pass,$server,$profile))
    {
      echo '<script>window.location.reload();</script>';
    }
}

?>
<script type="text/javascript">
    $(window).load(function(){
        $('#error_mikrotik').modal('show');
    });
</script>

  <!-- Modal -->
<div class="modal fade" id="error_mikrotik">
    <div class="modal-dialog">
        <form data-parsley-validate class="form-horizontal form-label-left" method="post">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Gagal Tersambung Ke Router Mikrotik</h4>
            </div>
            <div class="modal-body">
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">IP Mikrotik
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="ip" required="required" class="form-control col-md-7 col-xs-12" value="<?= $mikrotik_ip ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Username Mikrotik
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="uname" required="required" class="form-control col-md-7 col-xs-12" value="<?= $username ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Password Mikrotik </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input class="form-control col-md-7 col-xs-12" type="text" name="pass" value="<?= $password ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Server Mikrotik </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input class="form-control col-md-7 col-xs-12" type="text" name="server" value="<?= $server ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Profile Mikrotik </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input class="form-control col-md-7 col-xs-12" type="text" name="profile" value="<?= $profile ?>">
                        </div>
                      </div>
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                 		  <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                          <button type="submit" class="btn btn-success" name="btn-save-error">Submit</button>
                        </div>
                      </div>
                    </form>
            </div>
        </div><!-- /.modal-content -->
        </form><!-- /.form -->
    </div><!-- /.modal dialog -->
</div><!-- /.modal -->
