<?php
if (isset($_POST['bene_id']) && isset($_POST['magazz_tag_value'])){
	$bene_id = $_POST['bene_id'];
	$magazz_tag_value = $_POST['magazz_tag_value'];
	
	if ($bene_id != "" && $magazz_tag_value!= ""){
		
			require_once '../core/config.inc.php';
			$c = new mysqli($host,$username,$password,$database);
			
			$magazz_tag_value = str_replace(",","-",$magazz_tag_value);
			
			if($c->query("UPDATE etichette SET magaz_tag='-$magazz_tag_value-' WHERE id='$bene_id'")){
				echo "ok";
			} else {
				echo "err";
			}

		$c->close();
		
	}
}