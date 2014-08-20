<?php
namespace expert\user;
use expert\user\SocialUser as SocialUser;
use expert\user\Role as Role;
use expert\linker\VKLinker as VKLinker;
class VKUser extends SocialUser{
	public function __construct(VKLinker $linker, Role $role){
		parent::__construct($linker,$role);
    $this->setName("VKUser".$this->link);
    $this->link="http://vk.com/id".$this->link;
		$this->type=User::TYPE_SOCIAL_VK;
	}
}
?>