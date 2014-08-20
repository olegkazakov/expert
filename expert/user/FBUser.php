<?php
namespace expert\user;
use expert\user\SocialUser as SocialUser;
use expert\user\Role as Role;
use expert\linker\FBLinker as FBLinker;

class FBUser extends SocialUser{
	public function __construct(FBLinker $linker,Role $role){
		parent::__construct($linker,$role);
    $this->setName("FBUser".$this->link);
    $this->link="http://facebook.com/id".$this->link;
		$this->type=User::TYPE_SOCIAL_FB;		
	}
}
?>