<?php
namespace expert\user;
use expert\user\Role as Role;
abstract class User{
  const TYPE_INTERNAL="InternalUser";
  const TYPE_SOCIAL_VK="VKUser";
  const TYPE_SOCIAL_FB="FBUser";
  const TYPE_SOCIAL_GP="GPUser";
  static $currentId=0;
	protected $name;
	protected $id;
	public $role;
	protected $type;
	private static function UpId(){
		return ++self::$currentId;
	}
	public function __construct(Role $role){
		$this->setRole($role);
	}
	public function getId(){
		return $this->id;
	}
	public function getType(){
		return $this->type;
	}
	static function loadCurrentId($id){
		self::$currentId=$id;
	}
	public function setId($id){
		//$this->id=self::UpId;
    $this->id=$id;
	}
	public function setIdFromFile($id){
		$this->id=$id;
	}
	public function getName(){
		return $this->name;	
	}
	public function setName($name){
		$str = strlen($name);
		if ($str>3 && $str<25) {
			$this->name=$name;
			// echo "Name is right</br>";
			return true;
		}else{
			// echo "Name is wrong</br>";
			return false;
		}
	}
	public function setRole(Role $role){
		$this->role = $role;
	}
	public function getRole(){
		return $this->role->getRole();
	}
	//ф-ция hasRole делегирована из класса Role, т.е. вызывается ф-ция из класса Role
	//(в свойстве role хранится оъект класса Role);
	public function hasRole(Role $role){
		return $this->role->hasRole($role);
	}
	public function addRole($role){
		$this->role->addRole($role);
	}
	
	public function removeRole($roleid){
		$this->role->removeRole($roleid);
	}
	public function getRoleNames(){
		$roles=$this->role->getRoleNames();
		
		$strRoles="";
		foreach($roles as $role){
			if ($role!="") {
				$strRoles .=$role;
				$strRoles .="; ";
			}
		}
		return $strRoles;
	}
	public function isAdmin(){
		//return $this->role->hasRole(Role::ADMIN);
		if ($this->role->hasRole(Role::ADMIN)) {
			echo "\n User ".$this->name." is admin. \n";
			return true;
		}
		else {
			echo "\n User ".$this->name." isn't admin. \n";
			return false;
		}
		// return $this->hasRole(User::ROLE_ADMIN);
	}
	
	
}

?>