<?php
require_once '../core/config.inc.php';

$c = new mysqli($host,$username,$password,$database);
$where = "";

if(isset($_GET['id'])){
	$id = $_GET['id'];
	
	if($id == 1){//carico
	
		$years = $_GET['years'];
		$where .= "WHERE dataora LIKE '$years-%'";
		
		$da2 = $_GET['da'];
		if ($da2 != "ALL") $where .= " AND da_magaz_id = '$da2'";
		
		$a2 = $_GET['a'];
		if ($a2 != "ALL") $where .= " AND magaz_id = '$a2'";
		
		$bene2 = $_GET['bene'];
		if ($bene2 != "ALL") $where .= " AND bene_et_id = '$bene2'";
		
		$tecnico2 = $_GET['tec'];
		if ($tecnico2 != "ALL") $where .= " AND tecnico_id= '$tecnico2'";
		
		$x_pag = $_GET['x_pag'];
		$pag = isset($_GET['pag']) ? $_GET['pag'] : 1;
		
		if($x_pag == "ALL"){
			
			$q = $c->query("SELECT * FROM carico $where ORDER BY id DESC");
			
		} else {
			
			if(!$pag || !is_numeric($pag)) $pag = 1;
			$q = $c->query("SELECT * FROM carico $where ORDER BY id DESC");
			$first = ($pag - 1) * $x_pag;

			$q = $c->query("SELECT * FROM carico $where ORDER BY id DESC LIMIT $first, $x_pag");
			
		}
		
		echo chr (0xEF). chr (0xBB). chr (0xBF)."UPDATE;DA;A;BENE;N.;TECNICO;ATTACH";
		
		while($d = $q->fetch_array()){
			$now = date_format(new DateTime($d['dataora']),'d/m/Y - H:i:s');
			
			$da = $d['da_magaz_id'];
			$q2 = $c->query("SELECT * FROM magaz WHERE id='$da'");
			$d2 = $q2->fetch_array();
			$da = $d2['nome'];
			
			$a = $d['magaz_id'];
			$q3 = $c->query("SELECT * FROM magaz WHERE id='$a'");
			$d3 = $q3->fetch_array();
			$a = $d3['nome'];
			
			$bene = $d['bene_et_id'];
			$q4 = $c->query("SELECT * FROM etichette WHERE id='$bene'");
			$d4 = $q4->fetch_array();
			$bene = $d4['campo'];
			
			$tecn = $d['tecnico_id'];
			$q5 = $c->query("SELECT * FROM tecnico WHERE id='$tecn'");
			$d5 = $q5->fetch_array();
			$tecn = $d5['nome'];
			
			if($d['allegato'] == "") $d['allegato'] = "N/D";
			
			echo "\n".$now.";'".$da."';'".$a."';".$bene.";".$d['quantit'].";".$tecn.";".$d['allegato'];
		}
		
		$a=time();
		$b=date('d-m-y_H-i-s', $a);
		$nomefile = 'Export_Carico_'.$b.'.csv';
		
	}
	
	else if($id == 2){//scarico
		
		$years = $_GET['years'];
		$where .= "WHERE dataora LIKE '$years-%'";
		
		$da2 = $_GET['da'];
		if ($da2 != "ALL") $where .= " AND da_magaz_id = '$da2'";
		
		$bene2 = $_GET['bene'];
		if ($bene2 != "ALL") $where .= " AND bene_et_id = '$bene2'";
		
		$tecnico2 = $_GET['tec'];
		if ($tecnico2 != "ALL") $where .= " AND tecnico_id= '$tecnico2'";
		
		$x_pag = $_GET['x_pag'];
		$pag = isset($_GET['pag']) ? $_GET['pag'] : 1;
		
		if($x_pag == "ALL"){
			
			$q = $c->query("SELECT * FROM scarico $where ORDER BY id DESC");
			
		} else {
			
			if(!$pag || !is_numeric($pag)) $pag = 1;
			$q = $c->query("SELECT * FROM scarico $where ORDER BY id DESC");
			$first = ($pag - 1) * $x_pag;

			$q = $c->query("SELECT * FROM scarico $where ORDER BY id DESC LIMIT $first, $x_pag");
			
		}
		
		echo chr (0xEF). chr (0xBB). chr (0xBF)."UPDATE;DA;BENE;N.;TECNICO;NOTE;RIFERIMENTO;ATTACH";
		
		while($d = $q->fetch_array()){
			$now = date_format(new DateTime($d['dataora']),'d/m/Y - H:i:s');
			
			$da = $d['da_magaz_id'];
			$q2 = $c->query("SELECT * FROM magaz WHERE id='$da'");
			$d2 = $q2->fetch_array();
			$da = $d2['nome'];
			
			
			$bene = $d['bene_et_id'];
			$q4 = $c->query("SELECT * FROM etichette WHERE id='$bene'");
			$d4 = $q4->fetch_array();
			$bene = $d4['campo'];
			
			$tecn = $d['tecnico_id'];
			$q5 = $c->query("SELECT * FROM tecnico WHERE id='$tecn'");
			$d5 = $q5->fetch_array();
			$tecn = $d5['nome'];
			
			if($d['Allegato'] == "") $d['Allegato'] = "N/D";
			
			echo "\n".$now.";'".$da."';".$bene.";".$d['quantit'].";".$tecn.";".$d['rif_inst'].";".$d['utente'].";".$d['Allegato'];
		}
		
		$a=time();
		$b=date('d-m-y_H-i-s', $a);
		$nomefile = 'Export_Scarico_'.$b.'.csv';
	}
	
	
	header ("Content-Type: text/html; charset=UTF-8");
	header ("Content-Transfer-Encoding: UTF-8");
	header ("Content-Disposition: attachment; filename=$nomefile"); 
} else {
	header("Location: ../");
}