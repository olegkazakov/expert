<?php
namespace expert\controller;

abstract class AbstractController {
  protected $request;
  
  function __construct() {
    $this->request = new \stdClass();
  }
  
  function getRequestParam($key) {
    return $this->request->$key;
  }
  
  function setRequestParam($key,$value) {
    $this->request->$key = $value;      
  }
}


