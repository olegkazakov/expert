<?php
namespace expert\resources;
use expert\resources\ResourceDAO as ResourceDAO;
class AnswerDAOArr implements ResourceDAO{
	// function __construct(){
	// 	$this->save($answer);
	// }
	public $answers = array();
	function showResource($userId){}
	public function find($idAnswer){
		//как-то найти нужный ответ
		return $this->answers[$idAnswer];
	}
	public function save(IResource $answer){
		$this->answers[$answer->idAnswer] = $answer;

	}
	public function delete($idAnswer){
		//как-то удалить именно нужный ответ
		unset($this->answers[$idAnswer]);
	}
	public function getAll(){
		return $this->answers;

	}

}
?>