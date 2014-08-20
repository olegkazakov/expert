<p>Name: <?=$this -> view -> user->getName()."\n";?></p>
<p>User ID: <?=$this -> view -> user->getId()."\n"?></p>
<p>Roles: <?=$this -> view-> user->getRoleNames()."\n"?></p>
<?php 
  if ($this -> view -> user->getType()!=="InternalUser"){
    echo '<p>'.$this -> view -> user->getLink().'</p>';
  }
?>