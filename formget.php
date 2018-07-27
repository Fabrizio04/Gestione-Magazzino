<?php

if (isset($_GET['id'])){
	
	$id = $_GET['id'];
	require_once './restricted/structure.php';
	$c = new mysqli($host,$username,$password,$database);
	
	if ($id == "carico"){
		
		$da = $c->real_escape_string($_POST['da']);
		$a = $c->real_escape_string($_POST['a']);
		$beni = $c->real_escape_string($_POST['Beni']);
		$tecnici = $c->real_escape_string($_POST['Tecnici']);
		$quantit = $c->real_escape_string($_POST['num']);
		$nomefile = $c->real_escape_string($_FILES["file"]["name"]);
		$t=time();
		
		$target_dir  = './carico/';
		$target_file = $target_dir . basename($_FILES["file"]["name"]);
		$uploadOk = 1;
		$FileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		
		if ($nomefile != ""){
		
			// Check if file already exists
			if (file_exists($target_file)) {
				echo "Il file che tenti di caricare &egrave; gi&agrave; presente.";
				$uploadOk = 0;
			}
			// Check file size
			if ($_FILES["file"]["size"] > 10485760) {//1048576000
				echo "Il file che tenti di caricare &egrave; troppo grande.";
				$uploadOk = 0;
			}
			// Allow certain file formats
			if($FileType != "pdf" && $FileType != "zip") {
				echo "Il file che tenti di caricare non &egrave; un PDF o ZIP.";
				$uploadOk = 0;
			}
		
		}
		
		$q = $c->query("SELECT * FROM magaz WHERE id=$da");
		$da_magazzino = $q->fetch_array();
		
		
		if($da_magazzino['nome'] == 'ACQUISTO'){
			
			$q1 = $c->query("SELECT * FROM magazzini WHERE bene_et_id=$beni AND magaz_id=$a");
			$n = $q1->num_rows;
			
			if($n == 0){
				
				if ($nomefile != ""){
					
				
				// Check if $uploadOk is set to 0 by an error
				if ($uploadOk == 0) {
					echo "<br><br><button onclick=\"javascript: history.go(-1)\">Go Back</button>";
				// if everything is ok, try to upload file
				} else {
					
					if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
						echo "The file ". basename( $_FILES["file"]["name"]). " has been uploaded.";
						$qs = $c->query('INSERT INTO magazzini (bene_et_id, magaz_id, totale, note) VALUES ("'.$beni.'","'.$a.'","'.$quantit.'","")');
						$qs = $c->query('INSERT INTO carico (da_magaz_id, magaz_id, bene_et_id, quantit, tecnico_id, timestamp, allegato) VALUES ("'.$da.'","'.$a.'","'.$beni.'","'.$quantit.'","'.$tecnici.'","'.$t.'","'.$nomefile.'");');
						header("Location: index.php");
					} else {
						echo "<br><br><button onclick=\"javascript: history.go(-1)\">Go Back</button>";
					}
				
				}
				
				} else {
					$qs = $c->query('INSERT INTO magazzini (bene_et_id, magaz_id, totale, note) VALUES ("'.$beni.'","'.$a.'","'.$quantit.'","")');
					$qs = $c->query('INSERT INTO carico (da_magaz_id, magaz_id, bene_et_id, quantit, tecnico_id, timestamp, allegato) VALUES ("'.$da.'","'.$a.'","'.$beni.'","'.$quantit.'","'.$tecnici.'","'.$t.'","");');
					header("Location: index.php");
				}
				
				
				
			} else { //riga giò presente
				$d = $q1->fetch_array();
				$somma = $d['totale']+$quantit;
				$id = $d['id'];
				/**
				$qs = $c->query('UPDATE magazzini SET totale="'.$somma.'" WHERE id="'.$id.'"');
				$qs = $c->query('INSERT INTO carico (da_magaz_id, magaz_id, bene_et_id, quantit, tecnico_id, timestamp, allegato) VALUES ("'.$da.'","'.$a.'","'.$beni.'","'.$quantit.'","'.$tecnici.'","'.$t.'","'.$nomefile.'");');
				**/
				if ($nomefile != ""){
					
				
				// Check if $uploadOk is set to 0 by an error
				if ($uploadOk == 0) {
					echo "<br><br><button onclick=\"javascript: history.go(-1)\">Go Back</button>";
				// if everything is ok, try to upload file
				} else {
					
					if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
						echo "The file ". basename( $_FILES["file"]["name"]). " has been uploaded.";
						$qs = $c->query('UPDATE magazzini SET totale="'.$somma.'" WHERE id="'.$id.'"');
						$qs = $c->query('INSERT INTO carico (da_magaz_id, magaz_id, bene_et_id, quantit, tecnico_id, timestamp, allegato) VALUES ("'.$da.'","'.$a.'","'.$beni.'","'.$quantit.'","'.$tecnici.'","'.$t.'","'.$nomefile.'");');
						header("Location: index.php");
					} else {
						echo "<br><br><button onclick=\"javascript: history.go(-1)\">Go Back</button>";
					}
				
				}
				
				} else {
					$qs = $c->query('UPDATE magazzini SET totale="'.$somma.'" WHERE id="'.$id.'"');
					$qs = $c->query('INSERT INTO carico (da_magaz_id, magaz_id, bene_et_id, quantit, tecnico_id, timestamp, allegato) VALUES ("'.$da.'","'.$a.'","'.$beni.'","'.$quantit.'","'.$tecnici.'","'.$t.'","");');
					header("Location: index.php");
				}
			
			}
			
		} else { // form spostamento
			$daquery = $c->query("SELECT * FROM magazzini WHERE bene_et_id=$beni AND magaz_id=$da");
			$aquery = $c->query("SELECT * FROM magazzini WHERE bene_et_id=$beni AND magaz_id=$a");
			$numa = $aquery->num_rows;
			$dda = $daquery->fetch_array();
			$dda1 = $aquery->fetch_array();
			$sottrazione = $dda['totale']-$quantit;
			$somma = $dda1['totale']+$quantit;
			$id1 = $dda['id'];
			$id2 = $dda1['id'];
			
			if($numa != 0){
			
				if ($nomefile != ""){
					
				
				// Check if $uploadOk is set to 0 by an error
				if ($uploadOk == 0) {
					echo "<br><br><button onclick=\"javascript: history.go(-1)\">Go Back</button>";
				// if everything is ok, try to upload file
				} else {
					
					if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
						echo "The file ". basename( $_FILES["file"]["name"]). " has been uploaded.";
						$qs = $c->query('UPDATE magazzini SET totale="'.$sottrazione.'" WHERE id="'.$id1.'"');
						$qs = $c->query('UPDATE magazzini SET totale="'.$somma.'" WHERE id="'.$id2.'"');	
						$qs = $c->query('INSERT INTO carico (da_magaz_id, magaz_id, bene_et_id, quantit, tecnico_id, timestamp, allegato) VALUES ("'.$da.'","'.$a.'","'.$beni.'","'.$quantit.'","'.$tecnici.'","'.$t.'","'.$nomefile.'");');
						header("Location: index.php");
					} else {
						echo "<br><br><button onclick=\"javascript: history.go(-1)\">Go Back</button>";
					}
				
				}
				
				} else {
					$qs = $c->query('UPDATE magazzini SET totale="'.$sottrazione.'" WHERE id="'.$id1.'"');
					$qs = $c->query('UPDATE magazzini SET totale="'.$somma.'" WHERE id="'.$id2.'"');	
					$qs = $c->query('INSERT INTO carico (da_magaz_id, magaz_id, bene_et_id, quantit, tecnico_id, timestamp, allegato) VALUES ("'.$da.'","'.$a.'","'.$beni.'","'.$quantit.'","'.$tecnici.'","'.$t.'","");');
					header("Location: index.php");
				}
			
			// sposto ed inserisco
			} else {
				
				if ($nomefile != ""){
				// Check if $uploadOk is set to 0 by an error
				if ($uploadOk == 0) {
					echo "Sorry, your file was not uploaded.";
				// if everything is ok, try to upload file
				} else {
					
					if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
						echo "The file ". basename( $_FILES["file"]["name"]). " has been uploaded.";
						$qs = $c->query('UPDATE magazzini SET totale="'.$sottrazione.'" WHERE id="'.$id1.'"');
						$qs = $c->query('INSERT INTO magazzini (bene_et_id, magaz_id, totale) VALUES ("'.$beni.'","'.$a.'","'.$quantit.'")');
						$qs = $c->query('INSERT INTO carico (da_magaz_id, magaz_id, bene_et_id, quantit, tecnico_id, timestamp, allegato) VALUES ("'.$da.'","'.$a.'","'.$beni.'","'.$quantit.'","'.$tecnici.'","'.$t.'","'.$nomefile.'");');
						header("Location: index.php");
					} else {
						echo "<br><br><button onclick=\"javascript: history.go(-1)\">Go Back</button>";
					}
				
				}
				
				} else {
					$qs = $c->query('UPDATE magazzini SET totale="'.$sottrazione.'" WHERE id="'.$id1.'"');
					$qs = $c->query('INSERT INTO magazzini (bene_et_id, magaz_id, totale) VALUES ("'.$beni.'","'.$a.'","'.$quantit.'")');
					$qs = $c->query('INSERT INTO carico (da_magaz_id, magaz_id, bene_et_id, quantit, tecnico_id, timestamp, allegato) VALUES ("'.$da.'","'.$a.'","'.$beni.'","'.$quantit.'","'.$tecnici.'","'.$t.'","");');
					header("Location: index.php");
				}
			}
			/**
			$qs = $c->query('UPDATE magazzini SET totale="'.$sottrazione.'" WHERE id="'.$id1.'"');
			$qs = $c->query('UPDATE magazzini SET totale="'.$somma.'" WHERE id="'.$id2.'"');
			$qs = $c->query('INSERT INTO carico (da_magaz_id, magaz_id, bene_et_id, quantit, tecnico_id, timestamp, allegato) VALUES ("'.$da.'","'.$a.'","'.$beni.'","'.$quantit.'","'.$tecnici.'","'.$t.'","'.$nomefile.'");');
			**/
		}
		
		
		/**		
		$qs = $c->query('INSERT INTO carico (da_magaz_id, magaz_id, bene_et_id, quantit, tecnico_id, timestamp, allegato) VALUES ("'.$da.'","'.$a.'","'.$beni.'","'.$quantit.'","'.$tecnici.'","'.$t.'","'.$nomefile.'");');
		**/
		
		//fine del form di carico e spostamento.
		
	} else if ($id == "scarico"){
		
		// $qs = $c->query('INSERT INTO scarico (timestamp, da_magaz_id, tecnico_id, bene_et_id, quantit, rif_inst, utente, Allegato) VALUES ("'.$t.'","'.$da.'","'.$tecnici.'","'.$beni.'","'.$quantit.'","'.$riferimento.'","'.$utente.'","'.$nomefile.'");');
		
		$da = $c->real_escape_string($_POST['da']);
		$beni = $c->real_escape_string($_POST['Beni']);
		$tecnici = $c->real_escape_string($_POST['Tecnici']);
		$quantit = $c->real_escape_string($_POST['num']);
		$riferimento = $c->real_escape_string($_POST['rif']);
		$utente = $c->real_escape_string($_POST['user']);
		$nomefile = $c->real_escape_string($_FILES["file"]["name"]);
		$t=time();
		
		$target_dir  = './scarico/files/';
		$target_file = $target_dir . basename($_FILES["file"]["name"]);
		$uploadOk = 1;
		$FileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		
		if ($nomefile != ""){
		
			// Check if file already exists
			if (file_exists($target_file)) {
				echo "Il file che tenti di caricare &egrave; gi&agrave; presente.";
				$uploadOk = 0;
			}
			// Check file size
			if ($_FILES["file"]["size"] > 10485760) {//1048576000
				echo "Il file che tenti di caricare &egrave; troppo grande.";
				$uploadOk = 0;
			}
			// Allow certain file formats
			if($FileType != "pdf" && $FileType != "zip") {
				echo "Il file che tenti di caricare non &egrave; un PDF o ZIP.";
				$uploadOk = 0;
			}
		
		}
		
		$q1 = $c->query("SELECT * FROM magazzini WHERE bene_et_id=$beni AND magaz_id=$da");
		$n = $q1->num_rows;
			
			if($n != 0){
				
				$dda = $q1->fetch_array();
				$sottrazione = $dda['totale']-$quantit;
				$id1 = $dda['id'];
				
				if ($nomefile != ""){
					
				
				// Check if $uploadOk is set to 0 by an error
				if ($uploadOk == 0) {
					echo "<br><br><button onclick=\"javascript: history.go(-1)\">Go Back</button>";
				// if everything is ok, try to upload file
				} else {
					
					if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
						echo "The file ". basename( $_FILES["file"]["name"]). " has been uploaded.";
						$qs = $c->query('UPDATE magazzini SET totale="'.$sottrazione.'" WHERE id="'.$id1.'"');
						$qs = $c->query('INSERT INTO scarico (timestamp, da_magaz_id, tecnico_id, bene_et_id, quantit, rif_inst, utente, Allegato) VALUES ("'.$t.'","'.$da.'","'.$tecnici.'","'.$beni.'","'.$quantit.'","'.$riferimento.'","'.$utente.'","'.$nomefile.'");');
						header("Location: index.php");
					} else {
						echo "<br><br><button onclick=\"javascript: history.go(-1)\">Go Back</button>";
					}
				
				}
				
				} else {
					$qs = $c->query('UPDATE magazzini SET totale="'.$sottrazione.'" WHERE id="'.$id1.'"');
					$qs = $c->query('INSERT INTO scarico (timestamp, da_magaz_id, tecnico_id, bene_et_id, quantit, rif_inst, utente, Allegato) VALUES ("'.$t.'","'.$da.'","'.$tecnici.'","'.$beni.'","'.$quantit.'","'.$riferimento.'","'.$utente.'","");');
					header("Location: index.php");
				}
				
				
			}
		
		
		
	}
	
}
