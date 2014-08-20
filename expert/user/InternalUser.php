<?php
namespace expert\user;
use expert\user\User as User;
use expert\user\Role as Role;
class InternalUser extends User{
	private $password;
	private $email;
	public function __construct($name,$email, Role $role, $pass){
		parent::__construct($role);
		$this->type=User::TYPE_INTERNAL;
		$this->name=$name;
		if (!$this->setEmail($email)){
			die;
		}
		if ($pass=="") {	
			for ($i=0;$i<=2;$i++){
				$pass .=chr(rand(48,57)); 
				$pass .=chr(rand(95,122)); 
				$pass .=chr(rand(65,90)); 
			}
		}
		$this->setPassword($pass);
	}
	public function getEmail(){
		return $this->email;	
	}
	
	private function isEmailValid($email){
		$at=0; 
		$dot=0;
		for($i=0;$i<=strlen($email)-1;$i++)
			{	if ($email[$i]=="@") $at++;
				if ($email[$i]==".") $dot++;
			}
		if (($at==0)||($dot==0))	{
			echo "Wrong email";
			return false;	
		}
		else {return true;
		}
	}
	public function setEmail($email){
		if (!$this->isEmailValid($email)) {
			return false;
		}
		$this->email=$email;
		return true;
	}
	
	public function getPassword(){
		return $this->password;	
	}
	public function setPassword($password){
		if ($this->isPassValid($password)) {
			$this->password=$password;
			return true;
		}
		else {
			return false;
		}
	}
	private function isPassValid($password){
		$len=strlen($password);
		if (($len>3)and($len<100)){
			return true;
		}
		else {
			echo "\n Wrong password length.";
			return false;
		}
	
	}
	
	public function isValid(){
		if ((!$this->isPassValid($this->password))or(!$this->isEmailValid($this->email))) {
			return 0;
		}
		else {
			return 1;
		}
	}
/*	
	public function printUser($user){
		echo "\n User name: ".$user->name;
		echo "\n Email: ".$user->getEmail();
		echo "\n Password: ".$user->password;
		echo "\n Role: ".$user->role."\n ";
	}
*/
	public function register(){
		
	}
}



?>