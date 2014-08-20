<?php
namespace expert\resources;
use expert\resources\IResource as IResource;
use expert\user\User as User;
use expert\user\Role as Role;

class Question implements IResource{
	public $category;
	public $text;
	public $author;
	public $raiting = 0;
	public $dateTime;
	public $idQuestion;
	static $currentId = 0;
	function __construct($category,$text,User $user){
		$this->category=$category;
		$this->text=$text;
		$this->setAuthor($user);
		$this->dateTime=time();
		$this->idQuestion=self::UpId();
	}
	private static function UpId(){
		return self::$currentId++;
	}
	public function display(){
		echo "The question is - ".$this->text." created at ".date('r',$this->dateTime);
		}
	public function hasPermition(Role $role){
		
		return $role->getRole() & Role::USER;
	}
	public function setAuthor(User $user){
		$this->author = $user;
	}
	public function getId(){
		return $this->idQuestion;
	}
	public function setId($idQuestion){
		$this->idQuestion=$idQuestion;
	}
	public function setDateTime($dateTime){
		$this->dateTime=$dateTime;
	}
	public function setRait($raiting){
		$this->raiting=$raiting;
	}
	
	public function getCurrentId(){
		return self::$currentId;
	}
	static function loadCurrentId($id){
		self::$currentId=++$id;
	}
	public function raitUp($rait){
		$this->raiting += $rait;
	}
	public function raitDown($rait){
		$this->raiting -= $rait;
	}
}



?>