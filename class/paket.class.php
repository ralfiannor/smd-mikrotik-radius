<?php
require_once('./config/database.php');

class crud
{
	private $conn;
	
	function __construct()
	{
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
	}

	public function getID($paket)
	{
		$stmt = $this->conn->prepare("SELECT * FROM harga WHERE groupname=:paket");
		$stmt->execute(array(":paket"=>$paket));
		$editRow=$stmt->fetch(PDO::FETCH_ASSOC);
		return $editRow;
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

	public function update($paket,$paketbaru,$hargabaru,$deskripsi)
	{
		try
		{
			$stmt=$this->conn->prepare("
				UPDATE radgroupcheck SET groupname=:paketbaru WHERE groupname=:paket;
				UPDATE radgroupreply SET groupname=:paketbaru WHERE groupname=:paket;
				UPDATE radusergroup SET groupname=:paketbaru WHERE groupname=:paket;
				UPDATE harga SET groupname=:paketbaru, harga=:hargabaru, deskripsi=:deskripsi WHERE groupname=:paket;
			");

			$stmt->bindparam(":paket",$paket);
			$stmt->bindparam(":paketbaru",$paketbaru);
			$stmt->bindparam(":hargabaru",$hargabaru);
			$stmt->bindparam(":deskripsi",$deskripsi);
			$stmt->execute();		
			return true;	
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();	
			return false;
		}

	}		
	
	public function create($paket,$harga,$deskripsi,$timeout,$simultan,$timelimit,$timelimit_select,$updown_limit,$updown_select,$downspeed_limit,$upspeed_limit,$tgl_expire)
	{
		try
		{

			$stmt = $this->conn->prepare("INSERT INTO harga(groupname, harga, deskripsi) VALUES(:paket, :harga, :deskripsi)");
			$stmt->bindparam(":paket",$paket);
			$stmt->bindparam(":harga",$harga);
			$stmt->bindparam(":deskripsi",$deskripsi);
			$stmt->execute();


			// Jika timeout diisi
			if (isset($timeout)&&($timeout!='')) {
				$stmt = $this->conn->prepare("INSERT INTO radgroupcheck(GroupName, Attribute, op, Value) VALUES(:paket, 'Idle-Timeout', ':=', :timeout)");
				$stmt->bindparam(":paket",$paket);
				$stmt->bindparam(":timeout",$timeout);
				$stmt->execute();
			}


			// Jika simultan Diisi
			if (isset($simultan)&&($simultan!='')) {
				$stmt = $this->conn->prepare("INSERT INTO radgroupcheck(GroupName, Attribute, op, Value) VALUES(:paket, 'Simultaneous-Use', ':=', :simultan)");
				$stmt->bindparam(":paket",$paket);
				$stmt->bindparam(":simultan",$simultan);
				$stmt->execute();
			}

			// Jika Timelimit Diisi
			if (isset($timelimit)&&($timelimit!='')) {

				switch ($timelimit_select) {
					case "all":
						$attr="Max-All-Session"; break;
					case "daily":
						$attr="Max-Daily-Session"; break;
					case "weekly":
						$attr="Max-Weekly-Session"; break;
					case "monthly":
						$attr="Max-Monthly-Session"; break;
					default:
						$attr="none";
				}
		
				if ($attr!="none")
					$stmt = $this->conn->prepare("INSERT INTO radgroupcheck(GroupName, Attribute, op, Value) VALUES(:paket, :attr, ':=', :timelimit)");
					$stmt->bindparam(":paket",$paket);
					$stmt->bindparam(":attr",$attr);
					$stmt->bindparam(":timelimit",$timelimit);
					$stmt->execute();
			}

			// Jika Updown limit Diisi
			if (isset($updown_limit)&&($updown_limit!='')) {

				switch ($updown_select) {
					case "all":
						$attr="Max-Octets"; break;
					case "daily":
						$attr="Max-Daily-Octets"; break;
					case "weekly":
						$attr="Max-Weekly-Octets"; break;
					case "monthly":
						$attr="Max-Monthly-Octets"; break;
					default:
						$attr="none";
				}

				if ($attr!="none")
					$stmt = $this->conn->prepare("INSERT INTO radgroupcheck(GroupName, Attribute, op, Value) VALUES(:paket, $attr, ':=', :updown_limit)");
					$stmt->bindparam(":paket",$paket);
					$stmt->bindparam(":updown_limit",$updown_limit);
					$stmt->execute();
			}

			// Jika downspeed Diisi
			if (isset($downspeed_limit)&&($downspeed_limit!='')) {
				$stmt = $this->conn->prepare("INSERT INTO radgroupreply(GroupName, Attribute, op, Value) VALUES(:paket, 'WISPr-Bandwidth-Max-Down', ':=', :downspeed_limit)");
				$stmt->bindparam(":paket",$paket);
				$stmt->bindparam(":downspeed_limit",$downspeed_limit);
				$stmt->execute();
			}

			// Jika simultan Diisi
			if (isset($upspeed_limit)&&($upspeed_limit!='')) {
				$stmt = $this->conn->prepare("INSERT INTO radgroupreply(GroupName, Attribute, op, Value) VALUES(:paket, 'WISPr-Bandwidth-Max-Up', ':=', :upspeed_limit)");
				$stmt->bindparam(":paket",$paket);
				$stmt->bindparam(":upspeed_limit",$upspeed_limit);
				$stmt->execute();
			} 

			// Jika downspeed Diisi
			if (isset($tgl_expire)&&($tgl_expire!='')) {
				$stmt = $this->conn->prepare("INSERT INTO radgroupcheck(GroupName, Attribute, op, Value) VALUES(:paket, 'Expiration', ':=', :tglexpire)");
				$stmt->bindparam(":paket",$paket);
				$stmt->bindparam(":tglexpire",$tgl_expire);
				$stmt->execute();
			}

			return true;

		}
		catch(PDOException $e)
		{
			echo $e->getMessage();	
			return false;
		}
		
	}
	
	
	public function delete($user,$paket)
	{

		if ($user!="tidak ada") {
			foreach ($user as $user) {
				$stmt2 = $this->conn->prepare("DELETE FROM radcheck WHERE username=:user");
				$stmt2->bindparam(":user",$user);
				$stmt2->execute();
			}
		}

		$stmt = $this->conn->prepare("
			DELETE FROM harga WHERE groupname=:paket;
			DELETE FROM radusergroup WHERE groupname=:paket;
			DELETE FROM radgroupcheck WHERE groupname=:paket;
			DELETE FROM radgroupreply WHERE groupname=:paket;");
		$stmt->bindparam(":paket",$paket);
		$stmt->execute();

		return true;
	}
	

	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}

	public function daftarpaket($query)
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
				if($row['groupname'] != $lastrow) {
					$link['no']=$i;
					$link['groupname']=$row['groupname'];
					$link['harga']=$row['harga'];

					$stmt2 = $this->conn->prepare("SELECT * FROM radgroupcheck WHERE groupname='".$row['groupname']."'");
					$stmt2->execute();
					while($row2=$stmt2->fetch(PDO::FETCH_ASSOC))
					{

						if ($row2['attribute']=="Expiration") {
							$link['expired']=$row2['value'];
						}						
					}

					$link['deskripsi']=$row['deskripsi'];
					$link['tgl_dibuat']=$row['tgl_dibuat']."<br><small>".$this->hitungwaktu($row['tgl_dibuat'])."</small>";

					$link['option']="<a href='paket.php?page=detail&tampil=".$row['groupname']."' class='btn btn-success btn-xs'>Detail</a> <a href='paket.php?page=ubah&paket=".$row['groupname']."' class='btn btn-warning btn-xs'>Ubah</a>";
					array_push($linklist,$link);
	 				$i++;
 				}
				$lastrow = $row['groupname'];
			}

			echo json_encode($linklist);
		}			

	}	

	public function dataview($query)
	{
		$stmt = $this->conn->prepare($query);
		$stmt->execute();


		if($stmt->rowCount()>0)
		{
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
?>
                <tr>
                <td><?php print($row['id']); ?></td>
                <td><?php print($row['attribute']); ?></td>
                <td><?php print($row['op']); ?></td>
                <td><?php print($row['value']); ?></td>
                <tr>
<?php
			}
		}			

	}


	public function laporanpaket($query)
	{
		$stmt = $this->conn->prepare($query);
		$stmt->execute();

		$i=1;
		$lastrow = '';

		if($stmt->rowCount()>0)
		{
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				if($row['groupname'] != $lastrow) {
?>
				  <tbody>
				    <tr>
				      <td><?= $i ?></td>
				      <td><?= $row['groupname']; ?></td>
				      <td><?= $row['harga']; ?></td>
				      <td><?= $row['deskripsi']; ?></td>
				      <td><?= $row['tgl_dibuat']; ?></td>
				    </tr>
				  </tbody>
<?php

/*
					$stmt2 = $this->conn->prepare("SELECT * FROM radgroupcheck WHERE groupname='".$row['groupname']."'");
					$stmt2->execute();
					while($row2=$stmt2->fetch(PDO::FETCH_ASSOC))
					{
						if ($row2['attribute']=="Expiration") {
							$link['expired']=$row2['value'];
						}

						else if ($row2['attribute']=="Expiration") {
							$link['expired']=$row2['value'];
						}
						
					}
*/
	 				$i++;
 				}

				$lastrow = $row['groupname'];
			}
		}			

	}	
}


$crud = new crud();