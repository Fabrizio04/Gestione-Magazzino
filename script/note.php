<?php

if(isset($_POST['id']) && isset($_POST['note'])){
	require_once '../core/config.inc.php';
	$c = new mysqli($host,$username,$password,$database);
	
	if($c->query('UPDATE magazzini SET note="'.$c->real_escape_string($_POST['note']).'" WHERE id="'.$_POST['id'].'"')){
		echo "ok";
	} else {
		echo "err";
	}
}

$c->close();