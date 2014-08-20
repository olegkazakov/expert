<?php

namespace expert\resources;
use expert\resources\MysqlConnection;
use expert\resources\UserDAO;
use expert\user\User;
use expert\user\InternalUser as InternalUser;
use expert\user\Role as Role;
use expert\user\VKUser as VKUser;
use expert\user\GPUser as GPUser;
use expert\user\FBUser as FBUser;
use expert\user\SocialUser as SocialUser;
use expert\linker\VKLinker as VKLinker;
use expert\linker\FBLinker as FBLinker;
use expert\linker\GpLinker as GpLinker;
use PDO;
use expert\user\UserFabric;

class MysqlUserDAO implements UserDAO{
    public function find($id){  
        $stmt = MysqlConnection::$dbh->prepare("SELECT t.name as type, u.id as id, u.email as email, u.name as name, "
            ."u.password as password, u.link as link, ru.roleid as role "
            ."FROM user u " 
            ."JOIN type t ON u.typeid=t.id "
            ."JOIN role_user ru ON ru.userid=u.id "
            ."WHERE u.id=:id");
        try{ 
            $stmt->bindParam('id', $id);
            $stmt->execute();
            $obj = $stmt->fetch(PDO::FETCH_ASSOC);
            if (($obj!=0)){
                $userFabric = new UserFabric();
                $user = $userFabric->GenerateUser($obj['id'],$obj['name'], $obj['type'], $obj['role'], $obj['link'],$obj['password'], $obj['email']);
                return $user;
            }
            return null;
        }
        catch (PDOException $e) {
            print $e->getMessage();
        } 
    }

    public function findByNameAndPass($name, $pass) {
        $stmt = MysqlConnection::$dbh->prepare("SELECT t.name as type, u.id as id, u.email as email, u.name as name, "
            ."u.password as password, u.link as link, ru.roleid as role "
            ."FROM user u " 
            ."JOIN type t ON u.typeid=t.id "
            ."JOIN role_user ru ON ru.userid=u.id "
            ."WHERE u.name=:name and password=password(:pass)");
        try{
            $stmt->bindParam('name', $name);
            $stmt->bindParam('pass', $pass);
            $stmt->execute();
            $obj = $stmt->fetch(PDO::FETCH_ASSOC);
            if (($obj!=0)){
             $userFabric = new UserFabric();
             $user = $userFabric->GenerateUser($obj['id'],$obj['name'], $obj['type'], $obj['role'], $obj['link'],$obj['password'], $obj['email']);
             return $user;
            }
            return null;
        }
        catch (PDOException $e) {
            print $e->getMessage();
        }
    }
  public function checkUserName($name){
      try{
          MysqlConnection::$dbh->beginTransaction();
          $stmt = MysqlConnection::$dbh->prepare("SELECT id FROM user "
          . "WHERE name=:name");
          $stmt->bindParam('name', $name);
          $stmt->execute();
          $obj = $stmt->fetch(PDO::FETCH_ASSOC);
          MysqlConnection::$dbh->commit();
          if ($obj['id']!=0){
              return null;
          }
          return true;
      } 
      catch(PDOExecption $e) {
          MysqlConnection::$dbh->rollback();
          print "Error!: " . $e->getMessage();
      } 
  }
  
  public function checkUserEmail($email){
      try{
          MysqlConnection::$dbh->beginTransaction();
          $stmt = MysqlConnection::$dbh->prepare("SELECT id FROM user "
          . "WHERE name=:email");
          $stmt->bindParam('email', $email);
          $stmt->execute();
          $obj = $stmt->fetch(PDO::FETCH_ASSOC);
          MysqlConnection::$dbh->commit();
          if ($obj['id']!=0){
              return null;
          }
          return true;
      } 
      catch(PDOExecption $e) {
          MysqlConnection::$dbh->rollback();
          print "Error!: " . $e->getMessage();
      } 
  }
    
  function createInternalUser($name,$email,$password){
        $checkName = $this->checkUserName($name);
        $checkEmail = $this->checkUserName($email);
        if(!(isset($checkName))){
            return "Login";
        }
        if(!(isset($checkEmail))){
            return "Email";  
        }
        else {
            $role=new Role();
            $role->addRole(Role::USER);
            $user=new InternalUser($name,$email,$role,$password);
            if ($user) {
                $this->create($user);
                return $user;
            }
        }
    }
  
  public function create(User $user) {
      try{
          MysqlConnection::$dbh->beginTransaction();
          $stmt1 = MysqlConnection::$dbh->prepare("INSERT INTO user "
          . "(`typeid`,`email`,`name`,`password`) "
          . "VALUES "
          . "('1', :email, :name, password(:password));");
          $stmt1->bindParam('name', $user->getName());
          $stmt1->bindParam('email', $user->getEmail());
          $stmt1->bindParam('password', $user->getPassword());
          $stmt1->execute();
          $stmt2 = MysqlConnection::$dbh->prepare("INSERT INTO role_user "
                  . "(`roleid`,`userid`) "
                  . "VALUES "
                  . "('1', :userid)");
          $userid=MysqlConnection::$dbh->lastInsertId();
          if ($userid==0){
            MysqlConnection::$dbh->rollback();
            return null;
          }
          $user->setId($userid);
          $stmt2->bindParam('userid',$userid);
          $stmt2->execute();
          MysqlConnection::$dbh->commit();
      } 
      catch(PDOExecption $e) {
          MysqlConnection::$dbh->rollback();
          print "Error!: " . $e->getMessage();
      } 
  }

  public function delete($name) {

  }
  
  public function save(User $user) {

  }
  
  
  public function findByName($name) {

  }

  public function getAll() {

  }

  public function getLastUserNumber() {
  
  }

  

}
