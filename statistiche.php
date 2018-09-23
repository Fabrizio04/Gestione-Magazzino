<?php
require_once './restricted/structure.php';
$x = new mysqli($host,$username,$password,$database);
?>
<!Doctype html>
<html>

<head>

<title>Statistiche</title>

<link rel="shortcut icon" type="image/jpg" href="magico.jpg" />
<script type="text/javascript" src="jquery.min.js"></script>

<style>
ul, ol { margin: 10px; list-style: disc inside; line-height: 20px; }
ol { list-style-type: decimal; }

#header {
    background-color: #333;
	
}


ul#menu {
	list-style: none;
	margin:0;
  padding:0;
  text-align:center;
}

#menu li {display:inline;}

#menu li a {
  color: white;
  display:inline-block;
  padding:10px;
  line-height: 30px;
  text-decoration: none;
}

#menu li a:hover, #menu li a.active {
  background-color: #000000;/**F58529**/
}

table {
    border-collapse: collapse;
}

table, td, th {
    border: 1px solid black;
}

</style>

</head>

<body bgcolor="#E6E6FA">

<center>

<h3>STATISTICHE</h3>

<form action="" method="POST">

<table>

<tr>
<td>Mese</td><td>Anno</td><td>Bene</td><td>Magazzino</td>
</tr>

<tr>

<?php
$mese = array("Gennaio"=>"01", "Febbraio"=>"02", "Marzo"=>"03", "Aprile"=>"04", "Maggio"=>"05", "Giugno"=>"06", "Luglio"=>"07", "Agosto"=>"08", "Settembre"=>"09", "Ottobre"=>"10", "Novembre"=>"11", "Dicembre"=>"12");

echo '<td>';

echo '<select name="mese" required="">
<option value=""></option>';

foreach ($mese as $key => $value){
	echo '<option value="'.$value.'">'.$key.'</option>';
}

echo '</select>';



?>
</td>

<td>
<?php

echo '<select name="anno" required="">
<option value=""></option>';

$annocr = date ('Y', time());
//echo $annocr;
$annopast = $annocr-60;
for ($i=$annocr;$i>=$annopast;$i--){
	echo '<option value="'.$i.'">'.$i.'</option>';
}

echo '</select>';

?>
</td>

<td>
<select name="beni" required>
<option value=""></option>
<option value="TUTTI">TUTTI</option>

<?php
$J = $x->query("SELECT * FROM etichette");

while($f = $J->fetch_array()){
echo '<option value="'.$f['id'].'">'.$f['campo'].'</option>';
	
	
}

?>

</select>
</td>

<td>
<select name="magazzino" required>
<option value=""></option>
<option value="TUTTI">TUTTI</option>
<?php
$J = $x->query("SELECT * FROM magaz WHERE nome<>'ACQUISTO'");

while($f = $J->fetch_array()){
echo '<option value="'.$f['id'].'">'.$f['nome'].'</option>';
	
	
}
?>

</select>
</td>


<td><input type="submit" name="Filtra" value="Filtra"></td>
</tr>
<table>

</form>

<?php

if (isset($_POST['Filtra'])){
	
	$mese = $_POST['mese'];
	$mese2 = '';
	
	$anno = $_POST['anno'];
	
	$bene_id = $_POST['beni'];
	$bene_id2 = '';
	
	$magaz_id = $_POST['magazzino'];
	$magaz_id2 = '';
	
	if ($mese == '01') { $mese2 = 'Gennaio'; }
	else if ($mese == '02') { $mese2 = 'Febbraio'; }
	else if ($mese == '03') { $mese2 = 'Marzo'; }
	else if ($mese == '04') { $mese2 = 'Aprile'; }
	else if ($mese == '05') { $mese2 = 'Maggio'; }
	else if ($mese == '06') { $mese2 = 'Giugno'; }
	else if ($mese == '07') { $mese2 = 'Luglio'; }
	else if ($mese == '08') { $mese2 = 'Agosto'; }
	else if ($mese == '09') { $mese2 = 'Settembre'; }
	else if ($mese == '10') { $mese2 = 'Ottobre'; }
	else if ($mese == '11') { $mese2 = 'Novembre'; }
	else if ($mese == '12') { $mese2 = 'Dicembre'; }
	
	if ($bene_id == 'TUTTI'){
		$bene_id2 = 'TUTTI';
	} else {
		$q2 = $x->query("SELECT * FROM etichette WHERE id='$bene_id'");
		$d2 = $q2->fetch_array();
		$bene_id2 = $d2['campo'];
	}
	
	if ($magaz_id == 'TUTTI'){
		$magaz_id2 = 'TUTTI';
	} else {
		$q3 = $x->query("SELECT * FROM magaz WHERE id='$magaz_id'");
		$d3 = $q3->fetch_array();
		$magaz_id2 = $d3['nome'];
	}
	
	if (($bene_id == 'TUTTI') && ($magaz_id == 'TUTTI')){
		$q = $x->query("SELECT * FROM scarico ORDER BY id DESC");
	
	} else if (($bene_id != 'TUTTI') && ($magaz_id == 'TUTTI')){
		$q = $x->query("SELECT * FROM scarico WHERE bene_et_id='$bene_id' ORDER BY id DESC");
	
	} else if (($bene_id == 'TUTTI') && ($magaz_id != 'TUTTI')){
		$q = $x->query("SELECT * FROM scarico WHERE da_magaz_id='$magaz_id' ORDER BY id DESC");
	
	}  else if (($bene_id != 'TUTTI') && ($magaz_id != 'TUTTI')){
		$q = $x->query("SELECT * FROM scarico WHERE bene_et_id='$bene_id' AND da_magaz_id='$magaz_id' ORDER BY id DESC");
	}
	
	echo '<br><table><tr><td>&ensp;Mese: <strong>'.$mese2.'&ensp;</strong></td><td>&ensp;Anno: <strong>'.$anno.'&ensp;</strong></td><td>&ensp;Bene: <strong>'.$bene_id2.'&ensp;</strong></td><td>&ensp;Magazzino: <strong>'.$magaz_id2.'&ensp;</strong></td></tr></table><br>';
	
	echo '<table id="sum_table" width="100" border="1" style="text-align:center;">
<tr class="titlerow">
<td><strong>Totale</strong></td>
</tr>';

while($d = $q->fetch_array()){
	
	$now = date ('d-m-Y - H:i:s', $d['timestamp']);
	
	$quantita = $d['quantit'];
	$id = $d['id'];
	$pos = strpos($now, ''.$mese.'-'.$anno.'');
	$tecnico_id = $d['tecnico_id'];
	
	if (( $pos !== false ) && ( $tecnico_id !== '24' )) { // $tecnico_id corrisponde all'ID del tecnico CORREZIONE, che deve essere escluso dal conteggio.
		
		echo '<tr style="display:none;">';
		
		echo '<td class="rowDataSd">'.$quantita.'</td>';
		
		echo '</tr>';
		
	}
	
	
}

echo '<tr class="totalColumn">
<td class="totalCol"></td>
</tr>
</table>
<br>
<button onclick="javascript: location.href=\'./statistiche.php\'">Pulisci</button>';
	
}
?>

<script>
var totals=[0,0,0];
$(document).ready(function(){

    var $dataRows=$("#sum_table tr:not('.totalColumn, .titlerow')");
    
    $dataRows.each(function() {
        $(this).find('.rowDataSd').each(function(i){        
            totals[i]+=parseInt( $(this).html());
        });
    });
    $("#sum_table td.totalCol").each(function(i){  
        $(this).html(""+totals[i]);
    });

});
</script>

</center>

</body>
</html>