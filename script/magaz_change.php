<?php

if(isset($_POST['id']) && isset($_POST['fam'])){
	require_once '../core/config.inc.php';
	$c = new mysqli($host,$username,$password,$database);
	
	if($c->query('UPDATE magaz SET fam="'.$_POST['fam'].'" WHERE id="'.$_POST['id'].'"')){
		echo "ok";
	} else {
		echo "err";
	}
}

$c->close();