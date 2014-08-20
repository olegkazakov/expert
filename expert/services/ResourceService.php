<?php
namespace expert\services;
use expert\resources\resourceDAO as resourceDAO;
class ResourceService{
	private $resourceDAO;
	private static $instance;
	
	public function __construct($resourceDAO){
		$this->resourceDAO = $resourceDAO;	
	}
	public static function getInstance($resourceDAO){
		if (is_null(self::$instance)){
			self::$instance=new ResourceService($resourceDAO);
		}
		return self::$instance;
	}
	
	public function showQuestions($id){
		return $this->resourceDAO->showResource($id);
	}







}

?>