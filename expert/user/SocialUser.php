<?php
namespace expert\user;
use expert\user\User as User;
use expert\user\Role as Role;
use expert\linker\SocialLinker as SocialLinker;

class SocialUser extends User{
	public $email;
  protected $password;
	protected $linker;
  protected $link;
  public function getLink() {
    return $this->link;
  }

  public function setLink($link) {
    $this->link = $link;
  }

    public function getEmail() {
    return $this->email;
  }

  public function getPassword() {
    return $this->password;
  }

  public function setEmail($email) {
    $this->email = $email;
  }

  public function setPassword($password) {
    $this->password = $password;
  }

  protected function setLinker(SocialLinker $linker){
		$this->linker=$linker;
	}
	function __construct(SocialLinker $linker, Role $role){
		parent::__construct($role);
		$this->setLinker($linker);
		$link=$this->linker->link("http://");
    $pass="";
		for ($i=0;$i<=2;$i++){
			$pass .=chr(rand(48,57)); 
			$pass .=chr(rand(95,122)); 
			$pass .=chr(rand(65,90)); 
		}
		$this->password=$pass;
	}
	public function register(){
		
	}
}
?>