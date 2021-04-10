<?php

include('../connection/DatabaseConnection.php');

abstract class Model
{
	protected $tableName;
	protected $db;

	function __construct($tableName){
		$this->setConnection();
		$this->setTable($tableName);
	}

	protected function setTable($tableName){
		$this->tableName = $tableName;
	}

	function setConnection(){
		$this->db = new DatabaseConnector('localhost', '3306', 'root', '13Asuburus', 'sword');
	}

	abstract function find_by_field($field, $value);
	abstract function delete();
	abstract function save();
}