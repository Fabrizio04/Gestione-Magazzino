<?php
if (isset($_POST['bene_id'])){
	$bene_id = $_POST['bene_id'];
	
	if ($bene_id != ""){
		
		require_once '../core/config.inc.php';
		$c = new mysqli($host,$username,$password,$database);
		
		$q = $c->query("SELECT * FROM etichette WHERE id='$bene_id'");
		if($q->num_rows > 0){
			$d = $q->fetch_array();
			
			if($d['magaz_tag'] == "ALL"){
				echo "ALL";
			} else {
				$magaz_tag = ltrim($d['magaz_tag'], '-');
				$magaz_tag = rtrim($magaz_tag, "-");
				echo $magaz_tag;
			}
			
		} else {
			echo "err";
		}

		$c->close();
		
	}
}