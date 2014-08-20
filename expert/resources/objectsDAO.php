<?php
namespace expert\resources;
use expert\user\InternalUser as InternalUser;
use expert\user\Role as Role;
use expert\user\VKUser as VKUser;
use expert\user\GPUser as GPUser;
use expert\user\FBUser as FBUser;
use expert\user\User as User;
use expert\user\SocialUser as SocialUser;
use expert\linker\VKLinker as VKLinker;
use expert\linker\FBLinker as FBLinker;
use expert\linker\GpLinker as GpLinker;
use expert\resources\UserDAO as UserDAO;
use expert\resources\UserDAOArr;
use expert\resources\QuestionDAOArr as QuestionDAOArr;
use expert\resources\Question as Question;
use expert\resources\ResourceDAO as ResourceDAO;

//require_once('ResourceDAO.php');
//require_once('UserDAO.php');

//�������� ������
$userDAO = new UserDAOArr();
$role=new Role();
$role->addRole(Role::USER);
$user=new InternalUser("Vasya","v@gmail.com",$role,"Aa12345");
$role->addRole(Role::ADMIN);
$user->setRole($role);
$userDAO->create($user);
unset($role);
$role=new Role();
$role->addRole(Role::USER);
$userDAO->create(new InternalUser("Peter","peter@gmail.com",$role,"qwerty"));
$userDAO->create(new VKUser(VKLinker::getInstance(),$role));
$userDAO->create(new VKUser(VKLinker::getInstance(),$role));
$userDAO->create(new GPUser(GpLinker::getInstance(),$role));
$userDAO->create(new GPUser(GpLinker::getInstance(),$role));
$userDAO->create(new FBUser(FBLinker::getInstance(),$role));
file_put_contents("expert/resources/userDAO.txt",serialize($userDAO));
//�������� ��������
//$quest[0]=new Question ("Sport","����� �������� ����� ������ ���������-���� ������?");
$questionDAO = new QuestionDAOArr();
$question = new Question("Football", "Real - Milan. Who will won?", $userDAO->find(1));
$questionDAO->save($question);
$question = new Question("Tennis", "Federer or Djokovic?", $userDAO->find(2));
$questionDAO->save($question);
//print_r($questionDAO->questions);
// $questionDAO->delete(1);
//print_r($questionDAO->find(2));


//����� ��������� ��������

$i=0;
foreach($userDAO->getAll() as $user){
	//print_r($user);
	echo "User ".$user->getId();
	echo " name - ".$user->getName()."\n";
	$i++;
}




?>