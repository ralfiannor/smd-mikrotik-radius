<?php
require_once('./config/database.php');

class crud
{
	private $conn;
	
	function __construct()
	{
		$database = new Database();
		$db = $database->dbConnection();
		$dbgammu = $database->gammuConnection();
		$this->conn = $db;
		$this->conngammu = $dbgammu;

	}		

    public function hitungexpired($datetime, $full = false) {
    	date_default_timezone_set('Asia/Makassar');
	    $now = new DateTime;
	    $ago = new DateTime($datetime);
	    $diff = $now->diff($ago);

	    $diff->w = floor($diff->d / 7);
	    $diff->d -= $diff->w * 7;

	    $string = array(
	        'y' => 'tahun',
	        'm' => 'bulan',
	        'w' => 'minggu',
	        'd' => 'hari',
	        'h' => 'jam',
	        'i' => 'menit',
	        's' => 'detik',
	    );
	    foreach ($string as $k => &$v) {
	        if ($diff->$k) {
	            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? '' : '');
	        } else {
	            unset($string[$k]);
	        }
	    }

	    if (!$full) $string = array_slice($string, 0, 1);
	    return $string ? implode(', ', $string) . ' Lagi' : 'Beberapa detik lagi';
	}


    public function hitungwaktu($datetime, $full = false) {
    	date_default_timezone_set('Asia/Makassar');
	    $now = new DateTime;
	    $ago = new DateTime($datetime);
	    $diff = $now->diff($ago);

	    $diff->w = floor($diff->d / 7);
	    $diff->d -= $diff->w * 7;

	    $string = array(
	        'y' => 'tahun',
	        'm' => 'bulan',
	        'w' => 'minggu',
	        'd' => 'hari',
	        'h' => 'jam',
	        'i' => 'menit',
	        's' => 'detik',
	    );
	    foreach ($string as $k => &$v) {
	        if ($diff->$k) {
	            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? '' : '');
	        } else {
	            unset($string[$k]);
	        }
	    }

	    if (!$full) $string = array_slice($string, 0, 1);
	    return $string ? implode(', ', $string) . ' yang lalu' : 'Baru saja';
	}

	public function createsingle($username,$password,$paket,$nohp)
	{

		if ($nohp == NULL) {
			try
			{
				$stmt = $this->conn->prepare("
					INSERT INTO radcheck(username,attribute,op,value) VALUES(:username, 'Cleartext-Password', ':=', :password);
					INSERT INTO radusergroup(username,groupname,priority,groupname_awal) VALUES(:username, :paket, 0, :username);
					SET time_zone = 'Asia/Makassar';
					");
				$stmt->bindparam(":username",$username);
				$stmt->bindparam(":password",$password);
				$stmt->bindparam(":paket",$paket);
				$stmt->execute();
				return true;
			}
			catch(PDOException $e)
			{
				echo $e->getMessage();	
				return false;
			}
		}
		else {
			try
			{
				$stmt = $this->conn->prepare("
					INSERT INTO radcheck(username,attribute,op,value,no_hp) VALUES(:username, 'Cleartext-Password', ':=', :password, :nohp);
					INSERT INTO radusergroup(username,groupname,priority,groupname_awal) VALUES(:username, :paket, 0, :username);
					SET time_zone = 'Asia/Makassar';
					");
				$stmt->bindparam(":username",$username);
				$stmt->bindparam(":password",$password);
				$stmt->bindparam(":paket",$paket);
				$stmt->bindparam(":nohp",$nohp);
				$stmt->execute();

				$pesan = "Selamat ! akun anda telah berhasil dibuat. \n\nUsername : ".$username."\nPassword : ".$password."\nPaket: ".$paket;
				$stmt2 = $this->conngammu->prepare("INSERT INTO outbox(DestinationNumber, TextDecoded, CreatorID) VALUES(:nohp, :pesan, 'System')");
				$stmt2->bindparam(":nohp",$nohp);
				$stmt2->bindparam(":pesan",$pesan);
				$stmt2->execute();


				return true;
			}
			catch(PDOException $e)
			{
				echo $e->getMessage();	
				return false;
			}

		}
		
	}
	
	public function create($username,$password,$paket)
	{
		try
		{
			$stmt = $this->conn->prepare("
				INSERT INTO radcheck(username,attribute,op,value) VALUES(:username, 'Cleartext-Password', ':=', :password);
				INSERT INTO radusergroup(username,groupname,priority,groupname_awal) VALUES(:username, :paket, 0, :username);
				SET time_zone = 'Asia/Makassar';
				");
			$stmt->bindparam(":username",$username);
			$stmt->bindparam(":password",$password);
			$stmt->bindparam(":paket",$paket);
			$stmt->execute();
			return true;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();	
			return false;
		}
		
	}
	
	public function acakString($length = 6, $charset = 0 ) {
		$charactersall = array();
	    $charactersall[0] = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersall[1] = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersall[2] = '0123456789abcdefghijklmnopqrstuvwxyz';
		$charactersall[3] = '0123456789';
		$characters = $charactersall[$charset];
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, strlen($characters) - 1)];
	    }
	    return $randomString;
	}

	public function sec2str($s) { 
	    if ($s >= 604800) { 
	        $w = floor($s / 604800); 
	        $s = $s % 604800; 
	        $string = $w.'w '; 
	    } else @$string .= '0w '; 
	     
	    if ($s >= 86400) { 
	        $d = floor($s / 86400); 
	        $s = $s % 86400; 
	        $string .= $d.'d '; 
	    } else @$string .= '0d '; 
	     
	    if ($s >= 3600) { 
	        $h = floor($s / 3600); 
	        $s = $s % 3600; 
	        $string .= str_pad($h,2,'0',STR_PAD_LEFT).':'; 
	    } else $string .= '00:'; 
	     
	    if ($s >= 60) { 
	        $i = floor($s / 60); 
	        $s = $s % 60; 
	        $string .= str_pad($i,2,'0',STR_PAD_LEFT).':'; 
	    } else $string .= '00:'; 
	     
	    return $string.str_pad($s,2,'0',STR_PAD_LEFT); 
     
	} 

	public function str2sec($str) { 
	    preg_match('|([0-9]+)w|siU',$str,$w); 
	    preg_match('|([0-9]+)d|siU',$str,$d); 
	    preg_match('|([0-9]+):([0-9]+):([0-9]+)|siU',$str,$m); 
	    @$s += $w[1] * 604800; 
	    @$s += $d[1] * 86400; 
	    @$s += $m[1] * 3600; 
	    @$s += $m[2] * 60; 
	    @$s += $m[3]; 
	    return $s; 
	} 


	public function getID($user)
	{
		$stmt = $this->conn->prepare("SELECT a.*,b.groupname FROM radcheck as a LEFT JOIN radusergroup as b ON a.username = b.username WHERE a.username=:user");
		$stmt->execute(array(":user"=>$user));
		$editRow=$stmt->fetch(PDO::FETCH_ASSOC);
		return $editRow;
	}
	
	public function update($user,$userbaru,$password,$paket,$nohp)
	{
		if ($nohp == NULL) {
			try
			{
				$stmt=$this->conn->prepare("
											UPDATE radcheck SET username=:userbaru,value=:password WHERE username=:user;
											UPDATE radusergroup SET username=:userbaru,groupname=:paket,priority=0 WHERE username=:user;
											SET time_zone = 'Asia/Makassar';

											");

				$stmt->bindparam(":user",$user);
				$stmt->bindparam(":userbaru",$userbaru);
				$stmt->bindparam(":password",$password);
				$stmt->bindparam(":paket",$paket);
				$stmt->execute();
				
				return true;	
			}

			catch(PDOException $e)
			{
				echo $e->getMessage();	
				return false;
			}
		}

		else {

			try
			{
				$stmt=$this->conn->prepare("
											UPDATE radcheck SET username=:userbaru,value=:password WHERE username=:user;
											UPDATE radusergroup SET username=:userbaru,groupname=:paket,priority=0 WHERE username=:user;
											SET time_zone = 'Asia/Makassar';

											");

				$stmt->bindparam(":user",$user);
				$stmt->bindparam(":userbaru",$userbaru);
				$stmt->bindparam(":password",$password);
				$stmt->bindparam(":paket",$paket);
				$stmt->execute();

				$pesan = "Akun anda telah diubah. \n\nUsername : ".$userbaru."\nPassword : ".$password."\nPaket: ".$paket;
				$stmt2 = $this->conngammu->prepare("INSERT INTO outbox(DestinationNumber, TextDecoded, CreatorID) VALUES(:nohp, :pesan, 'System')");
				$stmt2->bindparam(":nohp",$nohp);
				$stmt2->bindparam(":pesan",$pesan);
				$stmt2->execute();
				
				return true;	
			}
			catch(PDOException $e)
			{
				echo $e->getMessage();	
				return false;
			}

		}
	}
	
	public function delete($user)
	{
		$stmt = $this->conn->prepare("
			DELETE FROM radcheck WHERE username=:user;
			DELETE FROM radusergroup WHERE username=:user;
			");
		$stmt->bindparam(":user",$user);
		$stmt->execute();
		return true;
	}
	

	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}

	public function lihat($data) { 
	    preg_match('|([0-9]+)w|siU',$str,$w); 
	    preg_match('|([0-9]+)d|siU',$str,$d); 
	    preg_match('|([0-9]+):([0-9]+):([0-9]+)|siU',$str,$m); 
	    @$s += $w[1] * 604800; 
	    @$s += $d[1] * 86400; 
	    @$s += $m[1] * 3600; 
	    @$s += $m[2] * 60; 
	    @$s += $m[3]; 
	    return $s; 
	} 

	public function pilihpaket($query)
	{
		$stmt = $this->conn->prepare($query);
		$stmt->execute();

		$i = 1;
		$lastkategori = '';
		
		if($stmt->rowCount()>0)
		{
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				if($row['groupname'] != $lastkategori) {
					echo '<option value="'.$row['groupname'].'">'.$row['groupname'].'</option>';
				}

			$lastkategori = $row['groupname'];
			}
		}

		else
		{
		
		?>
			<p>Nothing here...</p>
        <?php
		}
		
	}

	
	public function datatampil($query)
	{
		$stmt = $this->conn->prepare($query);
		$stmt->execute();

		$i=1;
		$lastrow = '';
		$linklist=array();
		$link=array();

		if($stmt->rowCount()>0)
		{
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				if($row['username'] != $lastrow) {
					$link['no']=$i;
					 //$link['id']=$row['id'];
					 $link['username']=$row['username'];
	 				 $link['value']=$row['value'];

					 if($row['groupname']!='Disabled-Users') {
	 				 	$link['paket']=$row['groupname'];
	 				 } else { $link['paket']=$row['groupname_awal']; }


 					$stmt2 = $this->conn->prepare("SELECT user.*, a.groupname, b.attribute as grupattr, b.value as grupval FROM radcheck as user LEFT JOIN radusergroup as a ON user.username = a.username LEFT JOIN radgroupcheck as b on a.groupname=b.groupname WHERE user.username='".$row['username']."'");
					$stmt2->execute();
					while($row2=$stmt2->fetch(PDO::FETCH_ASSOC))
					{
						if ($row2['grupattr']=="Expiration") {
					    	date_default_timezone_set('Asia/Makassar');
							$tgl = $row2['grupval'];
							$tglformat = date('Y-m-d', strtotime($tgl));
							$sisatgl = new DateTime($tglformat);
							$now         = new DateTime();
							//echo ($now < $tgl ? 'Tidak ada sisa waktu' : 'Sisa ');

							$link['expired']=$row2['grupval']."<br><small>".($now < $sisatgl ? 'Sisa '.$this->hitungexpired($tglformat) : 'Tidak ada sisa waktu')."</small>";
					
						}
						
					}

 				 $link['tgl_dibuat']=$row['tgl_dibuat']."<br><small>".$this->hitungwaktu($row['tgl_dibuat'])."</small>";

					if($row['groupname']=='Disabled-Users') {
						$link['status']="<label class='btn btn-danger btn-xs'><span class='glyphicon glyphicon-ban-circle' aria-hidden='true'></span> Nonaktif</label>";
		  				 $link['option']="<form method='POST'><a href='?page=detail&username=".$row['username']."' data-id='".$row['username']."' class='btn btn-success btn-xs' id='detail'>Detail</a> <input type='hidden' value='".$row['username']."' name='user'><button class='btn btn-primary btn-xs' id='enable' type='submit' name='Btn-enable'>Aktifkan</button></form>";
					}
					else {
						$link['status']="<label class='btn btn-primary btn-xs'><span class='glyphicon glyphicon-ok-circle' aria-hidden='true'></span> Aktif</label>";
		  				 $link['option']="<form method='POST'><a href='pengguna.php?page=detail&username=".$row['username']."' data-id='".$row['username']."' class='btn btn-success btn-xs' id='detail'>Detail</a> <a href='pengguna.php?page=ubah&nama=".$row['username']."' class='btn btn-warning btn-xs' id='detail'>Ubah</a> <input type='hidden' value='".$row['username']."' name='user'><input type='hidden' value='".$row['groupname']."' name='group'><button data-id='".$row['username']."' class='btn btn-danger btn-xs' id='disable' type='submit' name='Btn-disable'>Nonaktifkan</button></form>";
					}

	 				array_push($linklist,$link);
	 				$i++;
				}

				$lastrow = $row['username'];
			}

				echo json_encode($linklist);
		}			

	}

	public function detail($query)
	{
		$stmt = $this->conn->prepare($query);
		$stmt->execute();


		if($stmt->rowCount()>0)
		{
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
?>
	                <tr>
	                <td>ID</td>
	                <td><?php print($row['id']); ?></td>
	                <tr>
	                <tr>
	                <td>Username</td>
	                <td><?php print($row['username']); ?></td>
	                <tr>
	                <tr>
	                <td>Attribute</td>
	                <td><?php print($row['attribute']); ?></td>
	                <tr>
	                <tr>
	                <td>Operator</td>
	                <td><?php print($row['op']); ?></td>
	                <tr>
	                <tr>
	                <td>Value</td>
	                <td><?php print($row['value']); ?></td>
	                <tr>

<?php
			}
		}			

	}

	public function detail2($query)
	{
		$stmt = $this->conn->prepare($query);
		$stmt->execute();


		if($stmt->rowCount()>0)
		{
?>

<?php
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
?>
					<tr>
	                <td><?php print($row['attribute']); ?></td>
	                <td><?php print($row['op']); ?></td>
	                <td><?php print($row['value']); ?></td>
	                </tr>

<?php
			}
		}			

	}


	public function datadisable($query)
	{
		$stmt = $this->conn->prepare($query);
		$stmt->execute();

		$linklist=array();
		$link=array();

		if($stmt->rowCount()>0)
		{
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				 $link['id']=$row['id'];
				 $link['username']=$row['username'];
 				 $link['value']=$row['value'];
  				 $link['option']="<form method='POST'><a href='?page=detail&username=".$row['username']."' data-id='".$row['username']."' class='btn btn-success btn-xs' id='detail'>Detail</a> <input type='hidden' value='".$row['username']."' name='user'><button class='btn btn-primary btn-xs' id='enable' type='submit' name='Btn-enable'>Aktifkan</button></form>";
 				array_push($linklist,$link);
			}
				echo json_encode($linklist);
		}			

	}

	public function disableuser($user,$group,$tglsubmit)
	{
		try
		{
			$stmt=$this->conn->prepare("UPDATE radusergroup SET groupname='Disabled-Users', groupname_awal=:group, tgl_submit=:tglsubmit WHERE username=:user");
			$stmt->bindparam(":user",$user);
			$stmt->bindparam(":group",$group);
			$stmt->bindparam(":tglsubmit",$tglsubmit);
			$stmt->execute();
			
			return true;	
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();	
			return false;
		}
	}

	public function enableuser($user,$tglsubmit)
	{
		try
		{
			$stmt=$this->conn->prepare("UPDATE radusergroup SET groupname=groupname_awal,tgl_submit=:tglsubmit WHERE username=:user");
			$stmt->bindparam(":user",$user);
			$stmt->bindparam(":tglsubmit",$tglsubmit);
			$stmt->execute();
			
			return true;	
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();	
			return false;
		}
	}

	public function datalog($query)
	{
		$stmt = $this->conn->prepare($query);
		$stmt->execute();

		$linklist=array();
		$link=array();

		if($stmt->rowCount()>0)
		{
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				 $link['id']=$row['id'];
				 $link['username']=$row['username'];
 				 $link['reply']=$row['reply'];
 				 $link['authdate']=$row['authdate']."<br><small>".$this->hitungwaktu($row['authdate'])."</small>";
 				array_push($linklist,$link);
			}
				echo json_encode($linklist);
		}			

	}

	public function cetakdatabaru($query)
	{
		$stmt = $this->conn->prepare($query);
		$stmt->execute();

		$i=1;

		if($stmt->rowCount()>0)
		{
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
?>
				  <tbody>
				    <tr>
				      <td><?= $i ?></td>
				      <td><?= $row['username']; ?></td>
				      <td><?= $row['value']; ?></td>
				      <td><?= $row['tgl_submit']; ?></td>
				    </tr>
				  </tbody>
<?php
	 				$i++;
		}			

	}	
}

	public function cetak($query)
    {
		$stmt = $this->conn->prepare($query);
		$stmt->execute();
	
		if($stmt->rowCount()>0)
		{

//		header('Content-Type: text');
			$myfile = fopen("voucher.html", "w") or die("Unable to open file!");
			$txt = '<style>
@media print {
.noprint {
display: none;
}
.pagebreak {
page-break-after: always;
}
}
</style>';
			fwrite($myfile, $txt);

			$txt = '<center>';
			fwrite($myfile, $txt);

			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				$txt='<table width="280" border="1" style="float:left;margin: 10px;"><tr><td colspan="2" align="center"><img src="assets/img/logo.png" sizes="75%"></td></tr><tr><td width="40%">Nama pengguna</td><td width="60%">'.$row['username'].'</td></tr><tr><td width="20%">Kata sandi</td><td>'.$row['value'].'</td></tr></table>';
				fwrite($myfile, $txt);


	        }
			 	$txt = '</center><script>window.print();</script>';
				fwrite($myfile, $txt);

			fclose($myfile);


    	}

      else
      {
?>
		Tidak ada data

<?php
      }
    }

	public function laporantampil($query)
	{
		$stmt = $this->conn->prepare($query);
		$stmt->execute();

		$i=1;
		$lastrow = '';
		$linklist=array();
		$link=array();

		if($stmt->rowCount()>0)
		{
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				if($row['username'] != $lastrow) {
					$link['no']=$i;
					 //$link['id']=$row['id'];
					 $link['username']=$row['username'];
	 				 $link['value']=$row['value'];
	 				 $link['paket']=$row['groupname'];
	 				 $link['tgl_submit']=$row['tgl_submit'];


 					$stmt2 = $this->conn->prepare("SELECT user.*, a.groupname, b.attribute as grupattr, b.value as grupval FROM radcheck as user LEFT JOIN radusergroup as a ON user.username = a.username LEFT JOIN radgroupcheck as b on a.groupname=b.groupname WHERE user.username='".$row['username']."'");
					$stmt2->execute();
					while($row2=$stmt2->fetch(PDO::FETCH_ASSOC))
					{
						if ($row2['grupattr']=="Expiration") {
					    	date_default_timezone_set('Asia/Makassar');
							$tgl = $row2['grupval'];
							$tglformat = date('Y-m-d', strtotime($tgl));
							$sisatgl = new DateTime($tglformat);
							$now         = new DateTime();
							//echo ($now < $tgl ? 'Tidak ada sisa waktu' : 'Sisa ');

							$link['expired']=$row2['grupval']."<br><small>".($now < $sisatgl ? 'Sisa '.$this->hitungexpired($tglformat) : 'Tidak ada sisa waktu')."</small>";
							//$link['expired']=($now < $sisatgl ? 'Tidak ada sisa waktu' : 'Sisa');

						}
						
					}

	 				array_push($linklist,$link);
	 				$i++;
				}

				$lastrow = $row['username'];
			}

				echo json_encode($linklist);
		}			

	}
	


}



$crud = new crud();