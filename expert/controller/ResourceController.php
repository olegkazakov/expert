<?php
namespace expert\controller;
use expert\services\ResourceService as ResourceService;
use expert\controller\Request as Request;
use expert\resources\QuestionDAOArr as QuestionDAOArr;
use expert\user\User as User;
use stdClass;
class ResourceController extends AbstractController{
	private $resourceService;
	public $view;
	
	public function __construct($resourceService){
		$this->resourceService = $resourceService;
		//$this->view = new \stdClass();
	}
	protected function getResourceService(){
		return $this->resourceService;	
	}
	
	public function showQuestions(){
    $id = $this->getRequestParam('id');
    $view = new stdClass();
    if ((empty($id))||($id>=User::$currentId)){
      $view->error = "There is no such User";
      require_once '/expert/views/errors.php';
      return;
    }
		$view->QuestionsArr=$this->resourceService->showQuestions($id);
		require "expert/views/showquestions.php";
	}
	
	public function setRequest($request){
		$this->request = $request;
	}
	public function setView($view){
		$this->view = $view;
	}
	
}




?>