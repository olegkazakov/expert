<?php
namespace expert\resources;
use expert\user\Role as Role;
use expert\user\User as User;
interface IResource {
//function create($id,$category);
//function find($category);
	function display();
	function hasPermition(Role $role);
	function setAuthor(User $user);
	function getId();
	function getCurrentId();
	function setId($idQuestion);
	function setDateTime($dateTime);
	function setRait($raiting);
//	function delete();
//	function getAll();
//	function raitUp();
//	function raitDown();
}

?>