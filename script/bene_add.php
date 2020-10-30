<?php

if(isset($_POST['nome'])){
	require_once '../core/config.inc.php';
	$c = new mysqli($host,$username,$password,$database);
	
	if($c->query('INSERT INTO etichette(id, campo, magaz_tag) VALUES (NULL, "'.$_POST['nome'].'", "ALL");')){
		echo "ok";
	} else {
		echo "err";
	}
}

$c->close();