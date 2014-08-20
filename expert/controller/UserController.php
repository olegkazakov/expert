<?php

namespace expert\controller;

use expert\services\UserService as UserService;
use expert\controller\Request as Request;
use expert\resources\QuestionDAOCSV as QuestionDAOCSV;
use expert\user\User as User;
use expert\user\InternalUser as InternalUser;
use expert\user\SocialUser as SocialUser;
use expert\user\VKUser as VKUser;
use expert\user\FBUser as FBUser;
use expert\user\GPUser as GPUser;
use stdClass;

class UserController extends AbstractController {
    private $userService;
    private $view;

    public function getView() {
        return $this->view;
    }
    public function setView($view) {
        $this->view = $view;
    }

    public function __construct(UserService $userService) {
        parent::__construct();
        $this->userService = $userService;
        $this->view = new \stdClass();
    }

    protected function getUserService() {
        return $this->userService;
    }

    public function newUser() {
        $name = $this->getRequestParam('name');
        $email = $this->getRequestParam('email');
        $password = $this->getRequestParam('password');
        $repass = $this->getRequestParam('repass');
        $view = new stdClass();
        if ((empty($name))||(strlen($name)<=3)){
            $this->view->error = "Login is too short.";
            return 'adduser';
        }
        if (($password !== $repass)||(strlen($password)<=3)){
            $this->view->error = "Password incorrect or mismatch.";
            return 'adduser';
        }
        try {
            $user=$this->userService->create($name, $email, $password);
            if ($user=="Login"){
                $this->view->error = "User login error.";
                return 'adduser';
            }
            if ($user=="Email") {
                $this->view->error = "User email error.";
                return 'adduser';
            }
            else{
                $this->view->user = $user;
                return "showuser";
            }
        } catch (Exception $ex) {
            echo "Error user creating:".$ex->getMessage();
        }
    }

    public function showUser() {
        $id = $this->getRequestParam('id');
       // if ((empty($id))||($id>User::$currentId)){
        if (empty($id)){
            $this->view->error = "There is no such User";
            //require_once 'expert/views/errors.php';
            return 'errors';
        }
        if (!($this->view->user = $this->userService->find($id))){
            $this->view->error = "User search error.";
            return 'errors';
        }
        else {
            return "showuser";
        }
    }

    function login() {
        $name = $this->getRequestParam('name');
        $pass = $this->getRequestParam('password');
        if (empty($name) || empty($pass)) {
            return 'login';
        }
        else
            if (FALSE != ($this->view->user = $this->userService->authorize($name, $pass))) {
                //setcookie('id', $view->user->getId(), time()+60);
                $_SESSION['id'] = $this->view->user->getId();
                return 'showuser';
                } 
            else {
                $this->view->error = "Login or password failed";
                //require_once 'expert/views/login.php';
                return 'login';
            }
    }

    public function changePassword() {
        $id = $this->getRequestParam('id');
        $oldpass = $this->getRequestParam('oldpass');
        $this->view->user = $this->userService->find($id);
        if (!($this->view->user instanceof InternalUser)){
            $this->view->error="Can't change SocialUser password \n";
        }
        if ($this->getRequestParam('newpass1') !== $this->getRequestParam('newpass2')){
            $this->view->error='New password missmatch';
        }
        if ($this->view->user->getPassword() !== $this->getRequestParam('oldpass')){
            $this->view->error="Enter the correct password \n";
        }
        if (isset($this->view->error)) {
            return 'errors';
        }
        if ($this->view->user->setPassword($this->getRequestParam('newpass1'))) {
            $this->userService->save($this->view->user);
            return "changepassword";
        }

    } 

    public function formChangePass() {
        if (isset($_SESSION['id'])){
            return "formchangepass";
        }
        else{
            $this->view->error='Log in, please.';
            return 'errors';
        }
    }
    public function formAddUser() {
        if (isset($_SESSION['id'])){
            $this->view->error='Log out, please.';  
            return "errors";
        }
        else{
            return 'adduser';
        }
    }
    public function index() {
        return 'index';
    }
  /*
    public function setRequest($request) {
      $this->request = $request;
    }
  */

}
?>