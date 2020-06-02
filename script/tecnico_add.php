<?php

if(isset($_POST['nome'])){
	require_once '../core/config.inc.php';
	$c = new mysqli($host,$username,$password,$database);
	
	if($c->query('INSERT INTO tecnico(id, nome) VALUES (NULL, "'.$_POST['nome'].'");')){
		echo "ok";
	} else {
		echo "err";
	}
}

$c->close();