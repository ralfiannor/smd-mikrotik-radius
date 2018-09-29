<?php
chdir('/var/www/');
require 'config/database.php';

class Proses {

	private $conn;

	function __construct()
	{
		$database = new Database();
		$db = $database->dbConnection();
		$dbgammu = $database->gammuConnection();
		$this->conn = $db;
		$this->conngammu = $dbgammu;

	}

	public function run($query) {
			$stmt = $this->conngammu->prepare($query);
			return $stmt;
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

	

	public function execute() {
			$stmt = $this->conngammu->prepare("SELECT ReceivingDateTime as tgl_masuk, SenderNumber as pengirim, TextDecoded as pesan, Processed FROM inbox WHERE Processed='False' AND SUBSTR(SenderNumber,1,3)='+62' ORDER BY ReceivingDateTime desc");
			$stmt->execute();

			if($stmt->rowCount()>0)
			{
				while($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
					$pesan = explode(" ", strtoupper($row['pesan']));
					if (strlen($row['pesan'])>6 && $pesan[0]=='INFO') {
						$username = $pesan[1];
						if ($this->data($username) == NULL) {
							$this->kirim("INSERT INTO outbox(DestinationNumber, TextDecoded, CreatorID) VALUES('".$row['pengirim']."', 'Perintah INFO untuk nama pengguna ".$username." tidak ditemukan.', 'Sistem')");
							$this->kirim("UPDATE inbox SET Processed='true' WHERE SenderNumber='".$row['pengirim']."'");					
						}
						else {
							foreach ($this->data($username) as $data) {
								$this->kirim('INSERT INTO outbox(DestinationNumber, TextDecoded, CreatorID) VALUES("'.$row['pengirim'].'", "INFORMASI KODE VOUCHER '.$data['username'].'\r\nPassword: '.$data['value'].'\r\nPaket: '.$data['paket'].'\r\nStatus: '.$data['status'].'\r\nKadaluarsa: '.$data['expired'].'", "Sistem")');
								$this->kirim("UPDATE inbox SET Processed='true' WHERE SenderNumber='".$row['pengirim']."'");				
							}
						}
					}
					else if (strlen($row['pesan'])>6 && $pesan[0]=='BANTUAN') {
						$this->kirim('INSERT INTO outbox(DestinationNumber, TextDecoded, CreatorID) VALUES("'.$row['pengirim'].'", "Informasi kode voucher:\r\nKetik INFO<spasi>NAMA_PENGGUNA\r\n\r\nUntuk Bantuan :\r\nKetik BANTUAN\r\n\r\nKirim ke SMS Center Kami +6287891589506 (SMD Network)", "Sistem")');
						$this->kirim("UPDATE inbox SET Processed='true' WHERE SenderNumber='".$row['pengirim']."'");					
					}
					else {
						$this->kirim("INSERT INTO outbox(DestinationNumber, TextDecoded, CreatorID) VALUES('".$row['pengirim']."', 'Format yang anda kirim salah.', 'Sistem')");
						$this->kirim("UPDATE inbox SET Processed='true' WHERE SenderNumber='".$row['pengirim']."'");						
					}
				}
			}			

			return true;

	}


	public function tampil() {
			$stmt = $this->conngammu->prepare("SELECT * FROM inbox");
			$stmt->execute();

			if($stmt->rowCount()>0)
			{
				while($row=$stmt->fetch(PDO::FETCH_ASSOC))
				{
					echo $row['tes'];
				}
			}			
	}

	public function kirim($query) {
			try
			{
				$stmt = $this->conngammu->prepare($query);
				//$stmt->bindparam(":tes",$tes);
				$stmt->execute();
				return true;
			}
			catch(PDOException $e)
			{
				echo $e->getMessage();	
				return false;
			}

	}

	public function tes($query) {
			try
			{
				$stmt = $this->conngammu->prepare($query);
				//$stmt->bindparam(":tes",$tes);
				$stmt->execute();
				return true;
			}
			catch(PDOException $e)
			{
				echo $e->getMessage();	
				return false;
			}

	}

	public function data($username)
	{
		$stmt = $this->conn->prepare("SELECT user.*, a.groupname, a.groupname_awal, b.attribute as grupattr, b.value as grupval, a.tgl_dibuat FROM radcheck as user LEFT JOIN radusergroup as a ON user.username = a.username LEFT JOIN radgroupcheck as b on a.groupname=b.groupname  WHERE b.groupname <> 'Disabled-Users' AND user.username=:username GROUP BY username");
		$stmt->execute(array(":username"=>$username));

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

							$link['expired']=$row2['grupval'].($now < $sisatgl ? 'Sisa '.$this->hitungexpired($tglformat) : 'Tidak ada sisa waktu');					
						}
						else {
							$link['expired'] = "Tidak ada";
						}						
					}

 				 $link['tgl_dibuat']=$row['tgl_dibuat'].$this->hitungwaktu($row['tgl_dibuat']);
 				 $link['no_hp'] = $row['no_hp'];
					if($row['groupname']=='Disabled-Users') {
						$link['status']="Nonaktif";
		  				 $link['option']="Aktifkan";
					}
					else {
						$link['status']="Aktif";
					}

	 				array_push($linklist,$link);
	 				$i++;
				}

				$lastrow = $row['username'];
			}

				return $linklist;
		}			

	}

}
$i = 1;
while($i <= 15) {
	$proses = new Proses();
	$proses->execute();
	$i++;
	sleep(3);
}

//var_dump($proses->datatampil());
//echo json_encode($proses->datatampil());
//$username = substr("INFO OfJYm",5);
//var_dump($proses->data("sadsa"));
//foreach ($proses->data($username) as $data) {
//}



?>