<?php
class Proses {

	private $conn;

	function __construct()
	{
		require 'config/database.php';
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

	public function inbox() {
			$stmt = $this->conngammu->prepare("SELECT ReceivingDateTime as tgl_masuk, SenderNumber as pengirim, TextDecoded as pesan, Processed FROM inbox ORDER BY ReceivingDateTime desc");
			$stmt->execute();

			if($stmt->rowCount()>0)
			{
				$row=$stmt->fetch(PDO::FETCH_ASSOC);
			}			
			return $row;
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

}
$proses = new Proses();
//echo $proses->inbox()['pengirim'];
$query = "INSERT INTO outbox(DestinationNumber, TextDecoded, CreatorID) VALUES('".$proses->inbox()['pengirim']."', 'Terima Kasih.', 'Sistem')";
$proses->kirim($query);
var_dump($proses);
?>