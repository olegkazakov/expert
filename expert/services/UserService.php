<?php
namespace expert\services;
use expert\resources\UserDAOCSV as UserDAO;
class UserService{
    private $userDAO;
    private static $instance;

    public function __construct($userDAO){
        $this->userDAO = $userDAO;	
    }
    public static function getInstance($userDAO){
        if (is_null(self::$instance)){
            self::$instance=new UserService($userDAO);
        }
        return self::$instance;
    }
    public function create($name,$email,$password){
        return $this->userDAO->createInternalUser($name,$email,$password);
    }
    public function find($id){
        return $this->userDAO->find($id);
    }
    public function save($user){
        return $this->userDAO->save($user);
    }
    public function authorize($name, $pass) {
        return $this->userDAO->findByNameAndPass($name, $pass);
    }
}


?>