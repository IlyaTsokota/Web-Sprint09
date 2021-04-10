<?php
include('./Model.php');

class Users extends Model
{

    public int $id;
    public string $login;
    public string $password;
    public string $name;
    public string $email;

    public function find_by_field($field, $value)
    {
        $query = "SELECT * FROM $this->tableName where $field = $value";
		$user = $this->db->connection->query($query)->fetch();
		
		if(is_bool($user)){
			$this->setDefaultValues();
			return false;
		}
		
		$this->id = $user["u_id"];
		$this->login = $user["u_login"];
		$this->password = $user["u_password"];
		$this->name = $user["u_name"];
		$this->email = $user["u_email"];

		return true;
	}

	private function setDefaultValues(){
		$this->id = null;
		$this->login = null;
		$this->password = null;
		$this->name = null;
		$this->email = null;
	}

	function delete(){
		$query = "DELETE FROM $this->tableName WHERE u_id = $this->id";
		$request = $this->db->connection->prepare($query);
		$request->execute();
		
		if(!$request->rowCount()){
			return;
		}
		
		$this->setDefaultValues();
	}
	
	private function is_have($id)
	{
		$prevQuery = "SELECT * FROM $this->tableName where u_id = $id";
		$hero = $this->db->connection->query($prevQuery)->fetch();
		return is_bool($hero);
	}
	
	function save(){
		if(!$this->is_have($this->id)){
			$query = "UPDATE $this->tableName  SET `u_login`= :login, `u_password`= :pass, `u_name`= :name, `u_email`= :email WHERE `u_id`= :id";
		} else {
			$query = "INSERT INTO  $this->tableName ( u_login, u_password, u_name, u_email) VALUES (:login,:pass, :name, :email)";
		}
		
		$request = $this->db->connection->prepare($query);
		$request->execute(array(
			':name' => $this->name,
			':login' => $this->login,
			':email' => $this->email,
			':pass' => $this->password,
			':id' => $this->id
		));
	}
}

// $hero = new Heroes('heroes');

// $hero->find(10);

// echo $hero->name ."<br>";

// $hero->id = 41;
// $hero->name = "Good";

// $hero->desc = "wadwadawawdawddawdwad";

// $hero->save();

?>