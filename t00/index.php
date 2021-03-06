<?php

require('./models/Users.php');
header('Content-Type: application/json');
session_start();

$_POST = json_decode(file_get_contents("php://input"), true);



if (isset($_POST['fullname']) && isset($_POST['login']) && isset($_POST['password']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirmpassword']))
{
	create_user($_POST['login'],$_POST['password'],$_POST['fullname'], $_POST['email']);
}

if (isset($_POST['password']) && isset($_POST['login']) && isset($_POST['form_login'])){
	login($_POST['login'], $_POST['password']);
}



if (isset($_POST['load'])){
	echo json_encode(
		array('result' => $_SESSION["is_admin"])
	);
}



function create_user($login, $password, $name, $email,){
	$user = new Users('users');
	$res = false;
	if(!$user->find_by_field('u_login', $login) && !$user->find_by_field('u_email', $email) ){
		$user->setUser($login, $password, $name, $email);
		$user->save();
		$res = true;
	}
	echo json_encode(
		array('result' => $res)
	);
}

function login($login, $password){
	$user = new Users('users');
	$res = false;
	
	if($user->sign_in($login, $password)){
		$res = true;
	}

	echo json_encode(
		array('result' => $res)
	);
}