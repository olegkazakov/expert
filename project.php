<?php

use expert\services\UserService as UserService;
use expert\services\ResourceService as ResourceService;
use expert\user\User as User;
use expert\controller\Request as Request;
use expert\controller\UserController as UserController;
use expert\controller\ResourceController as ResourceController;


date_default_timezone_set('Europe/Kiev');
function autoload($className){
    $className = str_replace('\\','/',$className).'.php';
   // echo "\n".$className;
		require_once $className;
}
spl_autoload_register('autoload');

//require "expert/resources/objectsDAO.php";
//require "expert/resources/objectsDAOSerFile.php";
require "expert/resources/objectsDAOCSV.php";

unset($argv[0]);
$action = array_shift($argv);
switch($action) {
		case "newUser":
		//request: c:\php project.php newUser name email password
		$request = new Request();
		$request -> setParam('name',$argv[0]);
		$request -> setParam('email',$argv[1]);
		$request -> setParam('password',$argv[2]);
		if (($argv[0]!="")&&(strlen($argv[0])>3)){
			$ctrl= new UserController(UserService::getInstance($userDAO));
			$ctrl->setRequest($request);
			$ctrl->setView(new \stdClass());
			if ($view=$ctrl->newUser()){ 
			require "expert/views/newuser.php";
			}
			else {
				throw new \Exception('Error user creating!');
			}
		}
		else { 
			echo	"\n Login is too short";
			return 0;
			die;
		}	
		break;
		case "showUser":
		//request: c:\php project.php showUser UserId
		$request = new Request();
		$request -> setParam('id',$argv[0]);
		if (($argv[0]!="")&&($argv[0]!=0)&&($argv[0]<=User::$currentId)){
			$ctrl= new UserController(UserService::getInstance($userDAO));
			$ctrl->setRequest($request);
			$ctrl->setView(new \stdClass());
			$view=$ctrl->showUser();
			require "expert/views/showuser.php";
		}
		else { 
			echo	"\n There is no such User";
			return 0;
			die;
		}	
		break;
		case "changePassword":
		//request: c:\php project.php changePassword UserId OldPass NewPass
			$request = new Request();
			$request -> setParam('id',$argv[0]);
			$request -> setParam('oldPass',$argv[1]);
			$request -> setParam('newPass',$argv[2]);
			$ctrl= new UserController(UserService::getInstance($userDAO));
			//$user=$ctrl->showUser($argv[0]);
			$ctrl->setRequest($request);
			$ctrl->setView(new \stdClass());
			$view=$ctrl->changePassword();
			if ($view) {
				require "expert/views/changepassword.php";
			}
		break;
		case "showQuestions":
		//request: c:\php project.php showQuestions UserId
			$request = new Request();
			$request -> setParam('id',$argv[0]);
			$ctrl= new ResourceController(ResourceService::getInstance($questionDAO));
			//$user=$ctrl->showUser($argv[0]);
			$ctrl->setRequest($request);
			$ctrl->setView(new \stdClass());
			$view=$ctrl->showQuestions();
			if ($view) {
				require "expert/views/showquestions.php";
			}
		break;
	}


?>