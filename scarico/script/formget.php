<?php
require_once '../../core/config.inc.php';
$c = new mysqli($host,$username,$password,$database);
		
// $qs = $c->query('INSERT INTO scarico (timestamp, da_magaz_id, tecnico_id, bene_et_id, quantit, rif_inst, utente, Allegato) VALUES ("'.$t.'","'.$da.'","'.$tecnici.'","'.$beni.'","'.$quantit.'","'.$riferimento.'","'.$utente.'","'.$nomefile.'");');

$da = $c->real_escape_string($_POST['da']);
$beni = $c->real_escape_string($_POST['Beni']);
$tecnici = $c->real_escape_string($_POST['Tecnici']);
$quantit = $c->real_escape_string($_POST['num']);
$riferimento = $c->real_escape_string($_POST['rif']);
$utente = $c->real_escape_string($_POST['user']);
$nomefile = $c->real_escape_string($_FILES["file"]["name"]);

$target_dir  = '../files/';
$target_file = $target_dir . basename($_FILES["file"]["name"]);
$uploadOk = 1;
$FileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

if ($nomefile != ""){

	// Check if file already exists
	if (file_exists($target_file)) {
		header("Location: ../index.php?err=1");
		exit;
	}
	// Check file size
	if ($_FILES["file"]["size"] > 10485760) {//1048576000
		header("Location: ../index.php?err=2");
		exit;
	}
	// Allow certain file formats
	if($FileType != "pdf" && $FileType != "zip" && $FileType != "doc" && $FileType != "docx" && $FileType != "xls" && $FileType != "xlsx" && $FileType != "txt") {
		header("Location: ../index.php?id=scarico&err=3");
		exit;
	}

}

$q1 = $c->query("SELECT * FROM magazzini WHERE bene_et_id=$beni AND magaz_id=$da");
$n = $q1->num_rows;
	
	if($n != 0){
		
		$dda = $q1->fetch_array();
		
		if($quantit > $dda['totale']){
			header("Location: ../index.php?errs=$da;$quantit;$beni");
			exit;
		}
		
		$sottrazione = $dda['totale']-$quantit;
		$id1 = $dda['id'];
		
		if ($nomefile != ""){
			
			
			if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
				echo "The file ". basename( $_FILES["file"]["name"]). " has been uploaded.";
				$qs = $c->query('UPDATE magazzini SET totale="'.$sottrazione.'" WHERE id="'.$id1.'"');
				$qs = $c->query('INSERT INTO scarico (dataora, da_magaz_id, tecnico_id, bene_et_id, quantit, rif_inst, utente, Allegato) VALUES (CURRENT_TIMESTAMP,"'.$da.'","'.$tecnici.'","'.$beni.'","'.$quantit.'","'.$riferimento.'","'.$utente.'","'.$nomefile.'");');
				header("Location: ../index.php?scar=$beni;$da;$quantit");
			} else {
				echo "<br><br><button onclick=\"javascript: history.go(-1)\">Go Back</button>";
			}
		
		
		
		} else {
			$qs = $c->query('UPDATE magazzini SET totale="'.$sottrazione.'" WHERE id="'.$id1.'"');
			$qs = $c->query('INSERT INTO scarico (dataora, da_magaz_id, tecnico_id, bene_et_id, quantit, rif_inst, utente, Allegato) VALUES (CURRENT_TIMESTAMP,"'.$da.'","'.$tecnici.'","'.$beni.'","'.$quantit.'","'.$riferimento.'","'.$utente.'","");');
			header("Location: ../index.php?scar=$beni;$da;$quantit");
		}
		
		
	} else header("Location: ../index.php?errs=$da;$quantit;$beni");