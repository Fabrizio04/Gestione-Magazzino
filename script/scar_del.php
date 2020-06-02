<?php

if(isset($_POST['id'])){
	
	require_once '../core/config.inc.php';
	$c = new mysqli($host,$username,$password,$database);
	
	$q = $c->query("SELECT * FROM scarico WHERE id='{$_POST['id']}'");
	
	if($q->num_rows == 0){
		echo "err";
	} else {
		
		$d = $q->fetch_array();
		
		if($d['Allegato'] != ""){
			unlink("../scarico/files/".$d['Allegato']);
		}
		
		if($c->query("DELETE FROM scarico WHERE id='{$_POST['id']}'")){
			echo "ok";
		}
		
	}
	$c->close();
}