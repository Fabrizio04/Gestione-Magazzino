<?php
if (isset($_POST['magaz_id'])){
	$magaz_id = $_POST['magaz_id'];
	
	if ($magaz_id != ""){
		
		require_once '../../core/config.inc.php';
		$c = new mysqli($host,$username,$password,$database);
		$stringa = "";
		
		$q = $c->query('SELECT * FROM etichette WHERE magaz_tag LIKE \'%-'.$magaz_id.'-%\' OR magaz_tag LIKE \'%ALL%\' ORDER BY campo');
		if($q->num_rows > 0){
			
			while($d = $q->fetch_array()){
				$stringa .= $d['id']."-";
			}
			
			$stringa = rtrim($stringa, "-");
			echo $stringa;
			
			
		} else {
			echo "err";
		}

		$c->close();
		
	}
}