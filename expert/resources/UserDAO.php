<?php
namespace expert\resources;
use expert\user\User as User;
Interface UserDAO{
	function find($id);
	function findByName($name);
	function save(User $user);
	function create(User $user);
	function delete($name);
	function getAll();
	function getLastUserNumber();
	//function openFile($filename,$mode);
}

?>