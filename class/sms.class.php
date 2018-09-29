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

	public function getID($table,$id)
	{
		$stmt = $this->conngammu->prepare("SELECT * FROM ".$table." WHERE id=:id");
		$stmt->execute(array(":id"=>$id));
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
	
	public function delete($table,$id_hapus)
	{

		$stmt = $this->conngammu->prepare("DELETE FROM ".$table." WHERE ID=:id;");
		$stmt->bindparam(":id",$id_hapus);
		$stmt->execute();

		return true;
	}
	

	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}

	public function smsMasuk($query)
	{
		$stmt = $this->conngammu->prepare($query);
		$stmt->execute();

		$i=1;
		$linklist=array();
		$link=array();

		if($stmt->rowCount()>0)
		{
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
					$link['no']=$i;
					$link['id']=$row['ID'];
					$link['smsc']=$row['SMSCNumber'];
					$link['nomor']=$row['SenderNumber'];
					$link['pesan']=(strlen($row['TextDecoded']) > 55) ? substr($row['TextDecoded'],0,55)."..." : $row['TextDecoded'];
					$link['tgl_masuk']=$row['ReceivingDateTime']."<br><small>".$this->hitungwaktu($row['ReceivingDateTime'])."</small>";
					array_push($linklist,$link);
	 				$i++;
			}

			echo json_encode($linklist);
		}			

	}	

	public function smsKeluar($query)
	{
		$stmt = $this->conngammu->prepare($query);
		$stmt->execute();

		$i=1;
		$linklist=array();
		$link=array();

		if($stmt->rowCount()>0)
		{
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
					$link['no']=$i;
					$link['id']=$row['ID'];
					$link['nomor']=$row['DestinationNumber'];
					$link['pesan']=(strlen($row['TextDecoded']) > 55) ? substr($row['TextDecoded'],0,55)."..." : $row['TextDecoded'];
					$link['tgl_kirim']=$row['SendingDateTime']."<br><small>".$this->hitungwaktu($row['SendingDateTime'])."</small>";
					array_push($linklist,$link);
	 				$i++;
			}

			echo json_encode($linklist);
		}			

	}	

	public function smsTerkirim($query)
	{
		$stmt = $this->conngammu->prepare($query);
		$stmt->execute();

		$i=1;
		$linklist=array();
		$link=array();

		if($stmt->rowCount()>0)
		{
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
					$link['no']=$i;
					$link['id']=$row['ID'];
					$link['nomor']=$row['DestinationNumber'];
					$link['pesan']=(strlen($row['TextDecoded']) > 55) ? substr($row['TextDecoded'],0,55)."..." : $row['TextDecoded'];
					$link['status']=($row['Status'] == "SendingOKNoReport") ? "Terkirim" : "Gagal";
					$link['tgl_kirim']=$row['SendingDateTime']."<br><small>".$this->hitungwaktu($row['SendingDateTime'])."</small>";
					array_push($linklist,$link);
	 				$i++;
			}

			echo json_encode($linklist);
		}			

	}	


}


$crud = new crud();