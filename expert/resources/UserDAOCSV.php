<?php
namespace expert\resources;
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

class UserDAOCSV implements UserDAO{
  private $users = array();
  private $user;
  static $file = 'UserDAO.csv';
  private $filename; 
  
  public function __construct() {
    $this->filename=  \Config::$dataPath.self::$file;
  }
    function find($id){
    try{
      if (($id==0)||($id>User::$currentId)){
        throw new \LogicException('Error User number!');
      }
      $handle=$this->openFile($this->filename,'r');
      while (!feof($handle)){
          $arr=fgetcsv($handle, 1000, ";");
          //print_r($arr);
          if (($arr!=NULL)&&($arr[1]==$id)) {
            $role = new Role();
            $role->addRole($arr[2]);
            switch ($arr[3]){
              case User::TYPE_SOCIAL_VK:
                $user = new VKUser(VKLinker::getInstance(),$role);
                $user->setName($arr[0]);
              break;
              case User::TYPE_SOCIAL_FB:
                $role = new Role();
                $role->addRole($arr[2]);
                $user = new FBUser(FBLinker::getInstance(),$role);
                $user->setName($arr[0]);
              break;
              case User::TYPE_SOCIAL_GP:
                $role = new Role();
                $role->addRole($arr[2]);
                $user = new GPUser(GpLinker::getInstance(),$role);
                $user->setName($arr[0]);
              break;
              case User::TYPE_INTERNAL:
                $role = new Role();
                $role->addRole($arr[2]);
                $user = new InternalUser($arr[0],$arr[4],$role,$arr[5]);
              break;
              default:
                 throw new \LogicException('Invalid User type!');
            }
            $user->setIdFromFile($arr[1]);
            break;
          }
      }
        fclose($handle);
        return $user;
    }
    catch (LogicException $e) {
      $e->getMessage();
    } 
    catch (Exception $ex){
      $ex->getMessage();
    }
}
function findByName($name){
    //return $this->users[$name];
}
private function saveUserNumber(){
  try{
    $handle=$this->openFile("expert/resources/UserNumber.txt",'w');
    $num=User::$currentId;
    if ($num){
      fwrite($handle,$num);
    }
    else {
      echo "\nUser number Error!";
      throw new \LogicException('Invalid user number!');
    }
    fclose($handle);
  }
  catch (LogicException $e) {
  }
  catch (Exception $e) {
  }
}
private function openFile($filename,$mode){
  try {
    $handle=fopen($filename,$mode);
    if (!$handle){
      throw new \Exception('Can\'t open file!');
    }
    else return $handle;
  } catch (Exception $ex) {
    $ex->getMessage();
  }
  
}

function createInternalUser($name,$email,$password){
  $role=new Role();
  $role->addRole(Role::USER);
  $user=new InternalUser($name,$email,$role,$password);
  if ($user) {
    $this->create($user);
    return $user;
  } 
  else { return false;
  }
}

function create(User $user){
    $user->setId();
    try{
        $handle=$this->openFile($this->filename,'a');
        $str=$user->getName().';'.$user->getId().';'.$user->getRole().';'.$user->getType();
        if ($user instanceof InternalUser) {			
            $str.=';'.$user->getEmail().';'.$user->getPassword()."\n";
        }	
        else { $str.="\n";
        }
        fwrite($handle,$str);
        fclose($handle);
    }
    catch (Exception $e) {
    }
    $this->saveUserNumber();
}
function save(User $user){
    $arr=array();
    try{
        if ($userArray=file($this->filename)) { 
            $i=0;
            $arr=explode(";",$userArray[$i]);
            while(($arr[1]!=$user->getId())||($arr[$i]<=$this->getLastUserNumber())){
                $i++;
                $arr=explode(";",$userArray[$i]);
            }
            $str=$user->getName().';'.$user->getId().';'.$user->getRole().';'.$user->getType();
            if ($user instanceof InternalUser) {			
                $str.=';'.$user->getEmail().';'.$user->getPassword()."\n";
            }	
            else { $str.="\n";
            }
            $userArray[$i]=$str;
            if (!file_put_contents($this->filename,$userArray)) {
                throw new \Exception('Can\'t write to file!');
            }


        }
        else {
            throw new \Exception('Can\'t open file!');
        }
        return 0;
    }
    catch (Exception $e) {
    }
}

function delete($name){
    //unset($this->users[$name]);
}
function getAll(){
    try{
        $handle=$this->openFile($this->filename,'r');
        while (!feof($handle)){
            $arr=fgetcsv($handle, 1000, ";");
            //print_r($arr);
            if ($arr!=NULL) {
                $role = new Role();
                $role->addRole($arr[2]);
                switch ($arr[3]){
                    case User::TYPE_SOCIAL_VK:
                    $user = new VKUser(VKLinker::getInstance(),$role);
                    $user->setName($arr[0]);
                    break;
                    case User::TYPE_SOCIAL_FB:
                    $role = new Role();
                    $role->addRole($arr[2]);
                    $user = new FBUser(FBLinker::getInstance(),$role);
                    $user->setName($arr[0]);
                    break;
                    case User::TYPE_SOCIAL_GP:
                    $role = new Role();
                    $role->addRole($arr[2]);
                    $user = new GPUser(GpLinker::getInstance(),$role);
                    $user->setName($arr[0]);
                    break;
                    case User::TYPE_INTERNAL:
                    $role = new Role();
                    $role->addRole($arr[2]);
                    $user = new InternalUser($arr[0],$arr[4],$role,$arr[5]);
                    break;
                    default:
                        throw new \LogicException('Invalid User type!');
                }
                $user->setIdFromFile($arr[1]);
                $this->users[]=$user;
            }
        }
        fclose($handle);
        //print_r($this->users);
        return $this->users;
    }
    catch (LogicException $e) {
      $e->getMessage();
    } 
    catch (Exception $e){
    }
}

function getLastUserNumber(){
    //return count($this->users);	
    try{
        $handle=$this->openFile("expert/resources/UserNumber.txt",'r');
        $num=(int)fgets($handle);
        if ($num!=0){
            $role = new Role();
            $user=new InternalUser("V","v2@gmail.com",$role,"Aa12345");	
            $user->loadCurrentId($num);
        }
        else {
            echo "\nUser number Error!";
            throw new \LogicException('Invalid user number!');
        }
        fclose($handle);
    }
    catch (LogicException $e) {
    }
    catch (Exception $e) {
    }
}
	
  public function findByNameAndPass($name, $pass) {
    $this->getAll();
    foreach ($this->users as $user) {
        if ($user->getName() == $name && $user->getPassword() == $pass) {
            return $user;
        }
    }
    return false;
  }
	
	
}


?>