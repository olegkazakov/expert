<?php
session_start();

use expert\controller\ResourceController as ResourceController;
use expert\controller\UserController as UserController;
use expert\layout\Layout;
use expert\resources\MysqlConnection;
use expert\resources\MysqlUserDAO;
use expert\resources\QuestionDAOCSV;
use expert\services\ResourceService as ResourceService;
use expert\services\UserService as UserService;
require_once './config.php';
date_default_timezone_set('Europe/Kiev');

function autoload($className){
$className = str_replace('\\','/',$className).'.php';
  require_once $className;
}
spl_autoload_register('autoload');

//require "expert/resources/objectsDAO.php";
//require "expert/resources/objectsDAOSerFile.php";
//require "expert/resources/objectsDAOCSV.php";
//require "expert/resources/objectsMysqlUserDAO.php";
MysqlConnection::$dbh = new PDO('mysql:host=' . Config::$dbhost . ';dbname=' .Config::$dbname, 
        Config::$dbuser, 
        Config::$dbpass);  

$action = filter_input(INPUT_GET, 'action' ,FILTER_SANITIZE_SPECIAL_CHARS);
if (empty($action)) {
    $action='index';
}
$userDAO = new MysqlUserDAO();
$ctrl= new UserController(UserService::getInstance($userDAO));
//$resCtrl= new ResourceController(ResourceService::getInstance($questionDAO));
$layout = new Layout();
switch($action) {
    case "newuser":
  //request: c:\php project.php newUser name email password
        $name=filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
        $email=filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password=filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
        $repass=filter_input(INPUT_POST, 'repass', FILTER_SANITIZE_SPECIAL_CHARS);
        $ctrl->setRequestParam('name',$name);
        $ctrl->setRequestParam('email',$email);
        $ctrl->setRequestParam('password',$password);
        $ctrl->setRequestParam('repass',$repass);
        $viewName = $ctrl->newUser();
        if (isset($viewName)){
          $layout->setView($ctrl->getView());
          $layout->render($viewName);
        }
        break;
    case "showuser":
  //request: c:\php project.php showUser UserId
        $id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
        $ctrl->setRequestParam('id',empty($id)?$_SESSION['id']:$id);
        $viewName = $ctrl->showUser();
        if (isset($viewName)){
          $layout->setView($ctrl->getView());
          $layout->render($viewName);
        }
        break;
    case "login" :
        $name=filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
        $password=filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
        $ctrl->setRequestParam('name', $name);
        $ctrl->setRequestParam('password', $password);
        $viewName = $ctrl->login();
        if (isset($viewName)){
          $layout->setView($ctrl->getView());
          $layout->render($viewName);
        }
        break;
    case "logout":
        setcookie(session_name(),'');
        echo "You are logged out.";
        break;
    case "changepassword":
    //request: c:\php project.php changePassword UserId OldPass NewPass
        $ctrl -> setRequestParam('id',$_SESSION['id']);
        if (count($_POST) > 0) {
          $param = array('oldpass', 'newpass1', 'newpass2');
          foreach ($param as $key) {
            $ctrl->setRequestParam($key, filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS));
          }
          $viewName = $ctrl->changePassword();
        }
        if (isset($viewName)){
          $layout->setView($ctrl->getView());
          $layout->render($viewName);
        }
        break;
    case "showquestions":/*
    //request: c:\php project.php showQuestions UserId
        $id=filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
        $resCtrl->setRequestParam('id',$id);
        $resCtrl->showQuestions();*/
        break;
    case "changepass":
        $viewName = $ctrl->formChangePass();
        if (isset($viewName)){
          $layout->setView($ctrl->getView());
          $layout->render($viewName);
        }
        break;
    case "adduser":
        $viewName = $ctrl->formAddUser();
        if (isset($viewName)){
          $layout->setView($ctrl->getView());
          $layout->render($viewName);
        }
        break;
    case "index" :
        $viewName = $ctrl->index();
        $layout->setView($ctrl->getView());
        $layout->render($viewName);
        break;
    default:
        http_response_code(404);
        echo "Page does not exist";
}
?>