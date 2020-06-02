<?php

if(isset($_POST['nome'])){
	require_once '../core/config.inc.php';
	$c = new mysqli($host,$username,$password,$database);
	
	if($c->query('INSERT INTO magaz(id, nome, fam) VALUES (NULL, "'.$_POST['nome'].'", 0);')){
		echo "ok";
	} else {
		echo "err";
	}
}

$c->close();