<?php
namespace expert\resources;
use expert\resources\ResourceDAO as ResourceDAO;
class QuestionDAOArr implements ResourceDAO{
	// function __construct(){
	// 	$this->save($question);
	// }
	public $questions = array();
	
	public function showResource($userId){
		$retQuestions = array();
		
		foreach($this->questions as $quest){
			if ($quest->author->getId()==$userId){
				$retQuestions[] = $quest;
			}
		}
		if (isset($retQuestions)) {
			echo "\n User has been found.\n";
			return $retQuestions;
		}
		else {
			echo "\n User has not been found.\n";
			return 0;
		}
			
			
	}
	public function find($idQuestion){
		//как-то найти нужный вопрос
		return $this->questions[$idQuestion];
	}
	public function save(IResource $question){
		$this->questions[$question->idQuestion] = $question;
		// $this->id[] = $question->idQuestion; 
	}
	public function delete($idQuestion){
		//как-то удалить именно нужный вопрос
		unset($this->questions[$idQuestion]);
	}
	public function getAll(){
		return $this->questions;

	}

}



?>