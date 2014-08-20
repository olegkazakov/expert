<?php
namespace expert\user;
use expert\user\SocialUser as SocialUser;
use expert\user\Role as Role;
use expert\linker\GPLinker as GPLinker;

class GPUser extends SocialUser{
	public function __construct(GPLinker $linker, Role $role){
		parent::__construct($linker,$role);
    $this->setName("GPUser".$this->link);
    $this->link="http://googleplus.com/id".$this->link;
		$this->type=User::TYPE_SOCIAL_GP;
	}
}
?>