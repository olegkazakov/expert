<?php
foreach($view->QuestionsArr as $quest){
	echo "<div><p>\n Category: ".$quest->category."\t Author: ".$quest->author->getName()."</p>";
	echo "<p>\n ".$quest->text."</p>";
	echo "<p>\n Raiting: ".$quest->raiting."\t Date-Time ".date('d-m-Y H:i:s',$quest->dateTime)."</p></div>";
	}
?>