<?php
if (isset($_POST['bene_id'])){
	$bene_id = $_POST['bene_id'];
	
	if ($bene_id != ""){
		
			require_once '../core/config.inc.php';
			$c = new mysqli($host,$username,$password,$database);
			
			$magazz_tag_value = str_replace(",","-",$magazz_tag_value);
			
			if($c->query("UPDATE etichette SET magaz_tag='ALL' WHERE id='$bene_id'")){
				echo "ok";
			} else {
				echo "err";
			}

		$c->close();
		
	}
}