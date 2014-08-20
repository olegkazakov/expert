<?php
namespace expert\resources;
use expert\resources\ResourceDAO as ResourceDAO;
class QuestionDAOCSV implements ResourceDAO{
	static $file = 'expert/resources/QuestionDAO.csv';
	// function __construct(){
	// 	$this->save($question);
	// }
	public $questions = array();
	
	public function showResource($userId){
		$retQuestions = array();
		try{
			if ($questions=file(QuestionDAOCSV::$file)) {
				foreach($questions as $quest){
					$arr=explode(";",$quest);
					if ($userId==$arr[2]) {
						$userDAO = new UserDAOCSV();
						$q = new Question($arr[3], $arr[4], $userDAO->find($userId));
						$q->setId($arr[0]);
						$q->setDateTime($arr[5]);
						$q->setRait($arr[6]);
						$retQuestions[] = $q;
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
			else {
				throw new \Exception('Can\'t open file!');
			}
			
			
		}
		catch (Exception $e) {
        $e->getMessage();
		}
		
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
		//return $this->questions[$idQuestion];
	}
	
	private function openFile($filename,$mode){
		$handle=fopen($filename,$mode);
		if (!$handle){
			throw new \Exception('Can\'t open file!');
		}
		else return $handle;
	}
	
	public function save(IResource $question){
		$arr=array();
		try{
			if ($questions=file(QuestionDAOCSV::$file)) { 
				$i=$question->getId();
				$str=$question->idQuestion.';'.$question->author->getName().';'.$question->author->getId().';';
				$str.=$question->category.';'.$question->text.';';
				$str.=$question->dateTime.';'.$question->raiting."\n";
				$questions[$i]=$str;
				if (!file_put_contents(QuestionDAOCSV::$file,$questions)) {
					throw new \Exception('Can\'t write to file!');
				}
				
			}
			else {
				$handle=$this->openFile(QuestionDAOCSV::$file,'a+');
				$str=$question->idQuestion.';'.$question->author->getName().';'.$question->author->getId().';';
				$str.=$question->category.';'.$question->text.';';
				$str.=$question->dateTime.';'.$question->raiting."\n";
				fwrite($handle,$str);
				fclose($handle);
				return 0;
			}
		}	
		catch (Exception $e) {
		}
	}
	
	public function delete($idQuestion){
	
	}
	
	public function getAll(){
		//return $this->questions;
	}
	
	function getLastResourceNumber(IResource $question){
		try{
			$i=0;
			if ($questions=file(QuestionDAOCSV::$file)) {
				foreach($questions as $quest){
					$arr=explode(";",$quest);
					if ($i<$arr[0]) {
						$i=$arr[0];
					}
				}
			}
			$question->loadCurrentId($i);
		}
		catch (Exception $e) {
		}
	}
}

?>