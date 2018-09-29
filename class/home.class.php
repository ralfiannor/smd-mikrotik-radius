<?php
require_once('./config/database.php');

class home
{
	private $conn;
	
	function __construct()
	{
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
	}		

	public function getID()
	{
		$stmt = $this->conn->prepare("SELECT * FROM admins");
		$stmt->execute();
		$editRow=$stmt->fetch(PDO::FETCH_ASSOC);
		return $editRow;
	}
	
	public function pengguna()
	{
		$stmt = $this->conn->prepare("select count(username) as pengguna from radcheck");
		$stmt->execute();

		if($stmt->rowCount()>0)
		{
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				 echo $row['pengguna'];
			}
		}			

	}

	public function paket()
	{
		$stmt = $this->conn->prepare("select * from radgroupcheck WHERE groupname<>'Disabled-Users' ORDER BY groupname");
		$stmt->execute();

		$i = 0;
		$lastkategori = '';
		
		if($stmt->rowCount()>0)
		{
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				if($row['groupname'] != $lastkategori) {
//					echo $row['groupname'];
					$i++;
				}

			$lastkategori = $row['groupname'];

//			echo count($row['groupname']);
			}
		echo $i;
		}

		else
		{
			echo "0";		
		}
	}

	public function login()
	{
		$stmt = $this->conn->prepare("select count(username) as login from radacct");
		$stmt->execute();

		if($stmt->rowCount()>0)
		{
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				 echo $row['login'];
			}
		}			

	}

	public function log()
	{
		$stmt = $this->conn->prepare("select count(username) as log from radpostauth");
		$stmt->execute();

		if($stmt->rowCount()>0)
		{
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				 echo (int)$row['log']+10;
			}
		}			

	}

	public function baruperbulan()
	{
		$stmt = $this->conn->prepare("select count(username) as barubulan from radcheck WHERE date(tgl_submit) >= date(now()-interval 30 day)");
		$stmt->execute();

		if($stmt->rowCount()>0)
		{
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				 echo $row['barubulan'];
			}
		}			

	}

	public function aktifperbulan()
	{
		$stmt = $this->conn->prepare("select count(username) as aktif from radacct WHERE date(acctstarttime) >= date(now()-interval 30 day)");
		$stmt->execute();

		if($stmt->rowCount()>0)
		{
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				 echo $row['aktif'];
			}
		}			

	}

	public function gantisandi($passbaru)
	{
		try
			{

				$pass = password_hash($passbaru, PASSWORD_DEFAULT);

				$stmt = $this->conn->prepare("UPDATE admins SET password=:pass");
				$stmt->bindparam(":pass", $pass);					
				$stmt->execute();	
				
				return $stmt;	
			}

		catch(PDOException $e)
			{
				echo $e->getMessage();
			}				
	}

	public function admintampil()
	{
		$stmt = $this->conn->prepare("select * from admins");
		$stmt->execute();

		if($stmt->rowCount()>0)
		{
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
?>
				<tr>
					<td width="190"><b>Nama Pengguna</b></td>
					<td><?= $row['username']?></td>
				</tr>
				<tr>
					<td width="190"><b>Nama Lengkap</b></td>
					<td><?= $row['nama']?></td>
				</tr>
				<tr>
					<td width="190"><b>Email</b></td>
					<td><?= $row['email']?></td>
				</tr>

<?php
			}
		}			
	}

	public function kepalatampil()
	{
		$stmt = $this->conn->prepare("select * from admins");
		$stmt->execute();

		if($stmt->rowCount()>0)
		{
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
?>
				<tr>
					<td width="190"><b>Nama</b></td>
					<td><?= $row['nama_kepala']?></td>
				</tr>
				<tr>
					<td width="190"><b>Jabatan</b></td>
					<td><?= $row['jabatan_kepala']?></td>
				</tr>

<?php
			}
		}			
	}

	public function gantiadmin($username,$nama,$email)
	{
		try
		{
			$stmt=$this->conn->prepare("UPDATE admins SET username=:username, nama=:nama, email=:email WHERE id=1");
			$stmt->bindparam(":username",$username);
			$stmt->bindparam(":nama",$nama);
			$stmt->bindparam(":email",$email);
			$stmt->execute();
			
			return true;	
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();	
			return false;
		}
	}

	public function gantikepala($nama,$jabatan)
	{
		try
		{
			$stmt=$this->conn->prepare("UPDATE admins SET nama_kepala=:nama, jabatan_kepala=:jabatan WHERE id=1");
			$stmt->bindparam(":nama",$nama);
			$stmt->bindparam(":jabatan",$jabatan);
			$stmt->execute();
			
			return true;	
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();	
			return false;
		}
	}


}

$home = new home();