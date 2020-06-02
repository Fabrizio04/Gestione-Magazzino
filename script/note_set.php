<?php

if(isset($_POST['magaz_id']) && isset($_POST['note']) && isset($_POST['bene_id'])){
	require_once '../core/config.inc.php';
	$c = new mysqli($host,$username,$password,$database);
	
	$beni = $_POST['bene_id'];
	$a = $_POST['magaz_id'];
	$quantit = 0;
	$note = $c->real_escape_string($_POST['note']);
	
	if($c->query('INSERT INTO magazzini (bene_et_id, magaz_id, totale, note) VALUES ("'.$beni.'","'.$a.'","'.$quantit.'","'.$note.'")')){
		echo "ok";
	} else {
		echo "err";
	}
}

$c->close();