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
	
	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}

	
	public function dataview($query)
	{
		$stmt = $this->conn->prepare($query);
		$stmt->execute();

		$linklist=array();
		$link=array();

		if($stmt->rowCount()>0)
		{
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				 $link['id']=$row['radacctid'];
				 $link['username']=$row['username'];
 				 $link['ipaddress']=$row['framedipaddress'];
 				 $link['nasporttype']=$row['nasporttype'];
 				 $link['nama_hotspot']=$row['calledstationid'];
				 $link['start_time']=$row['acctstarttime'];
				 $link['stop_time']=$row['acctstoptime'];
 				 $link['session_time']=$row['acctsessiontime'];
				 $link['upload']=$row['acctinputoctets'];
				 $link['download']=$row['acctoutputoctets'];
 				 $link['terminate_cause']=$row['acctterminatecause'];

 				array_push($linklist,$link);
			}
				echo json_encode($linklist);
		}			

	}
	
}

$crud = new crud();