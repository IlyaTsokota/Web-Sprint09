<?php

class Router {
	public $params = array();

	public function __construct(){
		$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$query =  parse_url($actual_link);
		$paramsStr =  isset($query['query']) ? $query['query'] : null;
		if ($paramsStr){
			$arr = explode( "&" , $paramsStr );
			foreach ($arr as $value) {
				list($key, $val) = explode('=', $value, 2);

    			$this->params += [$key => $val];
			} 
		} else {
			$this->params = null;
		}
	}

}