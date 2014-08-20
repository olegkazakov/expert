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
use expert\resources\UserDAOCSV as UserDAOCSV;
use expert\resources\QuestionDAOCSV as QuestionDAOCSV;
use expert\resources\Question as Question;
use expert\resources\ResourceDAO as ResourceDAO;

//require_once('ResourceDAO.php');
//require_once('UserDAO.php');
/*
//создание Юзеров
$userDAO = new UserDAOCSV();
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
*/
$userDAO = new UserDAOCSV();
$userDAO->getLastUserNumber();
//Создание вопросов
//$quest[0]=new Question ("Sport","Какие расклады перед матчем Барселона-Реал Мадрид?");

$questionDAO = new QuestionDAOCSV();
$question = new Question("Football", "Real - Milan. Who will won?", $userDAO->find(1));
$questionDAO->getLastResourceNumber($question);
/*
$question = new Question("Football", "Real - Milan. Who will won?", $userDAO->find(1));
$questionDAO->save($question);
$question = new Question("Tennis", "Federer or Djokovic?", $userDAO->find(2));
$questionDAO->save($question);

$question = new Question("Football", "Real or Bayern Munchen", $userDAO->find(2));
print_r($question->getId());
$questionDAO->save($question);
*/
//Вывод созданных объектов

//unset($userDAO);


/*
$arr=$userDAO->getAll();
for($i=0;$i<count($arr)-1;$i++){
	//print_r($user);
	echo "User ".$arr[$i][1];
	echo " name - ".$arr[$i][0]."\n";
}

foreach($userDAO->getAll() as $user){
	//print_r($user);
	echo "User ".$user->getId();
	echo "  name - ".$user->getName()."\n";
	echo "\troles: ".$user->getRoleNames()."\n";
	if ($user instanceof InternalUser){
		echo "\temail - ".$user->getEmail()."\n";
		
	}
}
*/


?>