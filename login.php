<?php
session_start();
require_once("class/login.class.php");
$login = new LOGIN();

if($login->is_loggedin()!="")
{
    $login->redirect('home.php');
}


if(isset($_POST['btn-login']))
{
    $uname = strip_tags($_POST['txt_uname_email']);
    $umail = strip_tags($_POST['txt_uname_email']);
    $upass = strip_tags($_POST['txt_password']);
    $loc = strip_tags($_POST['location']);    

    if($uname=="")  {
        $error = "Nama pengguna atau email tidak boleh kosong";    
    }
    
    else if($upass=="") {
        $error = "Kata sandi tidak boleh kosong";    
    }
    
    else
    {

        if($login->doLogin($uname,$umail,$upass))
        {
            $login->redirect(isset($_GET['location']) ? $loc :'home.php');
        }
        else
        {
            $error = "Nama pengguna atau kata sandi salah";
        }   
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>SMD Radius</title>

<link href="assets/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/css/styles.css" rel="stylesheet">

<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->

</head>

<body>

    <div class="row">
    <center><img src="assets/img/logo.png" alt=""></center><br>
        <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
<?php
if(isset($_GET['logout'])) 
    {
?>
    <div class="alert bg-success" role="alert">
        <svg class="glyph stroked checkmark"><use xlink:href="#stroked-checkmark"></use></svg> Telah berhasil logout.
<a href="#" data-dismiss="alert" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a>
    </div>
<?php
    }
?>    
                <div class="panel-heading">Log in</div>
                <div class="panel-body">
                    <form role="form" method="POST" accept-charset="utf-8">
                        <fieldset>
                            <div id="error">
                                <?php
                                    if(isset($error))
                                    {
                                        ?>
                                        <div class="alert alert-danger">
                                           <i class="glyphicon glyphicon-warning-sign"></i> &nbsp; <?php echo $error; ?> !
                                        </div>
                                        <?php
                                    }
                                ?>
                            </div>

                            <div class="form-group">
                                <input type="hidden" name="location" value="<?=((isset($_GET['location']))?htmlspecialchars($_GET['location']):'')?>" >
                                <input class="form-control" placeholder="E-mail atau nama pengguna" name="txt_uname_email" type="text" autofocus="">
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Kata Sandi" name="txt_password" type="password" value="">
                            </div>
                          <button name="btn-login" class="btn btn-info"><span class="glyphicon glyphicon-user"></span> &nbsp;Masuk</a>&nbsp;</button>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div><!-- /.col-->
    </div><!-- /.row -->    
    
        

    <script src="assets/js/jquery-1.11.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>





















