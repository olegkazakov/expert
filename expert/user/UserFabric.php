<?php
namespace expert\user;
use expert\user\User as User;
use expert\resources\UserDAO as UserDAO;
use expert\user\InternalUser as InternalUser;
use expert\user\Role as Role;
use expert\user\VKUser as VKUser;
use expert\user\GPUser as GPUser;
use expert\user\FBUser as FBUser;
use expert\user\SocialUser as SocialUser;
use expert\linker\VKLinker as VKLinker;
use expert\linker\FBLinker as FBLinker;
use expert\linker\GpLinker as GpLinker;

class UserFabric{
  public function GenerateUser($id, $name, $type, $roleid, $link=NULL,$pass=NULL, $email=NULL){
    $role = new Role();
    $role->addRole($roleid);
    switch ($type){
      case User::TYPE_SOCIAL_VK:
        $user = new VKUser(VKLinker::getInstance(),$role);
        $user->setLink($link);
        $user->setName($name);
        $user->setId($id);
      break;
      case User::TYPE_SOCIAL_FB:
        $user = new FBUser(FBLinker::getInstance(),$role);
        $user->setName($name);
        $user->setId($id);
      break;
      case User::TYPE_SOCIAL_GP:
        $user = new GPUser(GpLinker::getInstance(),$role);
        $user->setName($name);
        $user->setId($id);
      break;
      case User::TYPE_INTERNAL:
        $user = new InternalUser($name,$email,$role,$pass);
        $user->setId($id);
      break;
      default:
        $user = NULL;
    }
    return $user;
  }
}
