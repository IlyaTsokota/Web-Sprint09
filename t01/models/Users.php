<?php
require('./models/Model.php');

class Users extends Model
{
    public $id;
    public $login;
    public $password;
    public $name;
    public $email;
	public $is_admin;

    public function find_by_field($field, $value)
    {
        $query = "SELECT * FROM $this->tableName where $field = '$value'";
		$user = $this->db->conn->query($query)->fetch();
		
		if(is_bool($user)){
			$this->setDefaultValues();
			return false;
		}
		
		$this->id = $user["u_id"];
		$this->login = $user["u_login"];
		$this->password = $user["u_password"];
		$this->name = $user["u_name"];
		$this->email = $user["u_email"];
		$this->is_admin = $user["u_isadmin"];

		return true;
	}

	private function setDefaultValues(){
		$this->id = null;
		$this->login = null;
		$this->password = null;
		$this->name = null;
		$this->email = null;
		$this->is_admin = null;
	}

	public function setUser($login, $password, $name, $email, $id = null){
		$this->login = $login;
		$this->password = $password;
		$this->name = $name;
		$this->email = $email;
		$this->id = $id;
	}

	function delete(){
		$query = "DELETE FROM $this->tableName WHERE u_id = $this->id";
		$request = $this->db->conn->prepare($query);
		$request->execute();
		
		if(!$request->rowCount()){
			return;
		}
		
		$this->setDefaultValues();
	}
	
	private function is_have($id)
	{
		$id = $id == null ? -1 : $id;
		$prevQuery = "SELECT * FROM $this->tableName where u_id = $id";
		$user = $this->db->conn->query($prevQuery)->fetch();
		return is_bool($user);
	}
	
	function save(){
		if (!$this->is_have($this->id)) {
			$query = "UPDATE $this->tableName  SET `u_login`= :login, `u_password`= :pass, `u_name`= :name, `u_email`= :email WHERE `u_id`= :id";
		} else {
			$query = "INSERT INTO  $this->tableName ( u_login, u_password, u_name, u_email, u_isadmin) VALUES (:login, :pass, :name, :email, false)";
		}
		
		$request = $this->db->conn->prepare($query);
		$request->execute(array(
			':name' => $this->name,
			':login' => $this->login,
			':email' => $this->email,
			':pass' => $this->password
		));
	}

	function sign_in($login, $password){	
		
		$query = "SELECT * FROM $this->tableName where u_login = '$login' and u_password = '$password'";
		$user = $this->db->conn->query($query)->fetch();
		
		if(is_bool($user)){
			$this->setDefaultValues();
			return false;
		}
		
		$_SESSION['user_id'] = $user["u_id"];
		$_SESSION['is_admin'] = $user["u_isadmin"];

		return true;
	}
	
}

?>