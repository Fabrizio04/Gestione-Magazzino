<?php

if(isset($_POST['id'])){
	
	require_once '../core/config.inc.php';
	$c = new mysqli($host,$username,$password,$database);
	
	$q = $c->query("SELECT * FROM carico WHERE id='{$_POST['id']}'");
	
	if($q->num_rows == 0){
		echo "err";
	} else {
		
		$d = $q->fetch_array();
		
		if($d['allegato'] != ""){
			unlink("../carico/".$d['allegato']);
		}
		
		if($c->query("DELETE FROM carico WHERE id='{$_POST['id']}'")){
			echo "ok";
		}
		
	}
	$c->close();
}