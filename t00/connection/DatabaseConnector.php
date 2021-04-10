<?php

class DatabaseConnector
{
    public $conn;
	private $status = true;

    public function __construct($host, $port, $username, $password, $database)
    {
		try{
        $this->conn = new PDO("mysql:host=$host;dbname=$database;port=$port", $username, $password);
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	  } catch(PDOException $e) {
		$this->status = false;	
	}
	}

    public function __destruct()
    {
		$this->conn = null;
    }

    public function getConnectionStatus()
    {
        return $this->status;
    }

}