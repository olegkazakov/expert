<?php
namespace expert\controller;
class Request{
	private $request=array();
	public function getParam($key){
		return $this->request[$key];
	}
	public function setParam($key,$value){
		$this -> request[$key] = $value;
	}
}
?>