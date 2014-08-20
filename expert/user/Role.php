<?php
namespace expert\user;
class Role{
	const ADMIN=32;
	const MODERATOR=16;
	const PREMIUM_EXPERT=8;
	const EXPERT=4;
	const PREMIUM_USER=2;
	const USER=1;
	private $roleSet;
	public function getRole(){
		return $this->roleSet;
	}
	public function getRoleNames(){
		$roles=array();
		if ($this->hasRole(self::USER)) { $roles[]="User";}
		if ($this->hasRole(self::PREMIUM_USER)) { $roles[]="Premium User";}
		if ($this->hasRole(self::EXPERT)) { $roles[]="Expert";}
		if ($this->hasRole(self::PREMIUM_EXPERT)) { $roles[]="Premium Expert";}
		if ($this->hasRole(self::MODERATOR)) { $roles[]="Moderator";}
		if ($this->hasRole(self::ADMIN)) { $roles[]="Admin";}
		return $roles;
	}
	public function addRole($roleid){
		$this->roleSet |=$roleid;
	}
	public function hasRole($roleid){
		return $this->roleSet & $roleid;
	}
	public function removeRole($roleid){
		if ($this->hasRole($roleid)) {
			$this->roleSet &= (~$roleid);
			echo "Role $roleid has been removed successfully.";
			return 1;
		}
		else {
			echo "Role $roleid can't being removed.";
			return 0;
		}
	}
}


?>