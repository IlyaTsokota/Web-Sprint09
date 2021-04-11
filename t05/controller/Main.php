<?php
require('../view/View.php');


interface ControllerInterface {
    public function execute();
}

class Main implements ControllerInterface {
	
	public $view;

	public function __construct($file){
		$this->view = new View($file);
	}


	public function execute(){
		 $this->view->render();
	}
}


$main = new Main('../view/templates/main.html');

$main->execute();