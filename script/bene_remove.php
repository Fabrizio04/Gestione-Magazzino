<?php

if(isset($_POST['id'])){
	require_once '../core/config.inc.php';
	$c = new mysqli($host,$username,$password,$database);
	
	if($c->query('DELETE from etichette WHERE id="'.$_POST['id'].'"')){
		echo "ok";
	} else {
		echo "err";
	}
}

$c->close();