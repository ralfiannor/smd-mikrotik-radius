<?php
class Database
{   
    private $host = "localhost";
    private $db_name = "radius";
    private $username = "root";
    private $password = "";
    public $conn;
     
    public function dbConnection()
	{
     
	    $this->conn = null;    
        try
		{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
        }
		catch(PDOException $exception)
		{
            echo "Connection error: " . $exception->getMessage();
        }
         
        return $this->conn;
    }

    public function gammuConnection()
    {
     
        $this->conngammu = null;    
        try
        {
            $this->conngammu = new PDO("mysql:host=" . $this->host . ";dbname=gammu", $this->username, $this->password);
            $this->conngammu->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   
        }
        catch(PDOException $exception)
        {
            echo "Connection error: " . $exception->getMessage();
        }
         
        return $this->conngammu;
    }

}
?>