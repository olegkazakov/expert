<?php
namespace expert\resources;
interface ResourceDAO{
	function showResource($userId);
	function find($id);
	function save(IResource $state);
	function delete($id);
	function getAll();
	function getLastResourceNumber(IResource $resource);
}

?>