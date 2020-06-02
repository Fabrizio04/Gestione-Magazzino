<?php

if(isset($_POST['id']) && isset($_POST['nome'])){
	require_once '../core/config.inc.php';
	$c = new mysqli($host,$username,$password,$database);
	
	if($c->query('UPDATE etichette SET campo="'.$c->real_escape_string($_POST['nome']).'" WHERE id="'.$_POST['id'].'"')){
		echo "ok";
	} else {
		echo "err";
	}
}

$c->close();