<?php
namespace expert\resources;
use expert\user\User as User;
use expert\resources\UserDAO as UserDAO;
use expert\user\InternalUser as InternalUser;

class UserDAOArr implements UserDAO{
	private $users = array();
	function find($id){
		$fUser=NULL;
		foreach ($this->users as $user){
			if ($user->getId()==$id) {
				$fUser = $user;
				break;
			}
		}
		if (isset($fUser)) {
				return $fUser;
		}
		else {return 0;
		}
	}
	function findByName($name){
		return $this->users[$name];
	}
	function save(User $user){
		$this->users[$user->getName()]=$user;
	}
	function create(User $user){
		$user->setId();
		$this->users[$user->getName()]=$user;
	}
	function delete($name){
		unset($this->users[$name]);
	}
	function getAll(){
		return $this->users;
	}
	function getLastUserNumber(){
		return count($this->users);	
	}
	
}


?>