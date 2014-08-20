<?php
namespace expert\resources;
use expert\resources\IResource as IResource;
use expert\user\User as User;
use expert\user\Role as Role;
require_once "user/Role.php";
require_once "IResource.php";

class Answer implements IResource{
	public $category;
	public $text;
	public $author;
	public $dateTime;
	public $idAnswer;
	static $currentId = 0;
	public $raiting;
	function __construct($category,$text,User $user){
		$this->category=$category;
		$this->text=$text;
		$this->setAuthor($user);
		$this->dateTime=time();
		$this->idAnswer=self::UpId();
	}
	private static function UpId(){
		return self::$currentId++;
	}
	public function display(){
		echo "The answer is - ".$this->text." created at ".date('r',$this->dateTime);
		}
	public function hasPermition(Role $role){
		
		return $role->getRole() & Role::USER;
	}
	public function setAuthor(User $user){
		$this->author = $user->getName();
	}
	public function getId(){
		return $this->idAnswer;
	}
	public function raitUp($rait){
		$this->raiting += $rait;
	}
	public function raitDown($rait){
		$this->raiting -= $rait;
	}
}


?>