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


require_once('UserDAO.php');

//создание Юзеров
if (file_exists("expert/resources/userDAO.txt")){
	$data = file_get_contents("expert/resources/userDAO.txt");
	if (isset($data)){
		$userDAO = unserialize($data);
		$userNumber=$userDAO->getLastUserNumber();
		if ($userNumber) {
			$user=$userDAO->find($userNumber);
			User::loadCurrentId($user->getId());
		}
		$role=new Role();
		$role->addRole(Role::USER);
		$user=new InternalUser("John","john@gmail.com",$role,"jonny");
		$userDAO->create($user);
				
		//Создание вопросов
		$questionDAO = new QuestionDAOArr();
		$question = new Question("Football", "Real - Milan. Who will won?", $userDAO->find(1));
		$questionDAO->save($question);
		$question = new Question("Tennis", "Federer or Djokovic?", $userDAO->find(2));
		$questionDAO->save($question);
	}
	else {
		echo "\nError reading of file.";
		return 0;
	}
}
else {
	echo "\nFile error.";
	return 0;
}
/*
//Вывод созданных объектов
$i=0;
foreach($userDAO->getAll() as $user){
	//print_r($user);
	echo "User ".$user->getId();
	echo " name - ".$user->getName()."\n";
	$i++;
}
*/




?>