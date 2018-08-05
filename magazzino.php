<?php
require_once './restricted/structure.php';
$x = new mysqli($host,$username,$password,$database);

$q = $x->query("SELECT * FROM tecnico");
$q1 = $x->query("SELECT * FROM magaz");
$q2 = $x->query("SELECT * FROM etichette");

$n = $q->num_rows;
$n1 = $q1->num_rows;
$n2 = $q2->num_rows;

if ($n == 0){
	header("Location: modifica.php");
} else if ($n1 == 0){
	header("Location: modifica.php");
} else if ($n2 == 0){
	header("Location: modifica.php");
} else {
	
if (((isset($_GET['id']))) && ($_GET['id'] !== "")){

?>
<!Doctype html>
<html>

<head>

<?php
$id = $_GET['id'];
$titolo = $x->query("SELECT * FROM magaz WHERE id='$id'");
$du = $titolo->fetch_array();
echo '<title>'.$du['nome'].'</title>';
?>

<link rel="shortcut icon" type="image/jpg" href="magico.jpg" />

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

<script type="text/javascript">

function mostra(id){
	var a = document.getElementById(id).style;
	a.display = a.display=='block'?'none':'block'
}

</script>

</head>

<body bgcolor="#E6E6FA">

<center>

<H3>GESTIONE MAGAZZINO</H3>

<div id="header">

<ul id="menu">
<li><a href="./">HOME</a></li>
<?php
$q = $x->query("SELECT * FROM magaz WHERE nome<>'ACQUISTO'");
while($d = $q->fetch_array()){
	echo '<li><a href="magazzino.php?id='.$d['id'].'">'.$d['nome'].'</a></li>';
}
  
?>
</ul>
</div>

<h3></h3>
<?php
$id = $_GET['id'];
$q = $x->query("SELECT * FROM magaz WHERE id=$id");
$d = $q->fetch_array();

echo '<H3>MAGAZZINO '.$d['nome'].'</H3>';
?>

<!--Tabella totale -->

<table width="100%">

<tr>
<td><strong>Bene</strong></td>
<td><strong>Totale</strong></td>
<td><strong>Note</strong></td>
<td><strong>Operazioni</strong></td>
</tr>

<tr>
<?php
$q = $x->query("SELECT * FROM etichette");
$id = $_GET['id'];

while ($d = $q->fetch_array()){
	
	$q2 = $x->query('SELECT * FROM magazzini WHERE magaz_id='.$id.' AND bene_et_id='.$d['id'].'');
	
	
	echo '<tr><td>'.$d['campo'].'</td>';
	
	
	while ($d2 = $q2->fetch_array()){
		echo '<td>';
		echo $d2['totale'];
		echo '</td>';
		
		echo '<td>';
		echo $d2['note'];
		echo '</td>';

		echo '</td>';
		echo '<td><button onclick="javascript:location.href=\'note.php?id='.$d2['id'].'&magazzino='.$id.'\';">Modifica</button>';

		
		
		
		echo '</tr>';
	}
	
}

?>

</tr>

</table>

<br><br>

<button onclick="mostra('car')">Carico - Spostamento</button>
<button onclick="mostra('scar')">Scarico</button>

<div id="car" style="display:none;">

<h3>CARICO - SPOSTAMENTO</h3>

<table width="100%"><tr>
<td><strong>Da</strong></td>
<td><strong>A</strong></td>
<td><strong>Tipologia bene</strong></td>
<td><strong>Quantit&agrave;</strong></td>
<td><strong>Tecnico</strong></td>
<td><strong>Data e ora</strong></td>
<td><strong>Allegato</strong></td>
</tr>

<?php
$q = $x->query("SELECT * FROM carico WHERE magaz_id='$id' OR da_magaz_id='$id' ORDER BY id DESC");
while($d = $q->fetch_array()){
	
	echo '<tr>';
	
	$da = $d['da_magaz_id'];
	$q2 = $x->query("SELECT * FROM magaz WHERE id='$da'");
	while ($d2 = $q2->fetch_array()){
		echo '<td>'.$d2['nome'].'</td>';
	}
	
	
	
	$a = $d['magaz_id'];
	$q3 = $x->query("SELECT * FROM magaz WHERE id='$a'");
	while ($d3 = $q3->fetch_array()){
		echo '<td>'.$d3['nome'].'</td>';
	}
	
	$bene = $d['bene_et_id'];
	$q4 = $x->query("SELECT * FROM etichette WHERE id='$bene'");
	while ($d4 = $q4->fetch_array()){
		echo '<td>'.$d4['campo'].'</td>';
	}
	
	echo '<td>'.$d['quantit'].'</td>';
	
	$tecn = $d['tecnico_id'];
	$q5 = $x->query("SELECT * FROM tecnico WHERE id='$tecn'");
	while ($d5 = $q5->fetch_array()){
		echo '<td>'.$d5['nome'].'</td>';
	
	}
	
	$now = date ('d-m-Y - H:i:s', $d['timestamp']);
	echo '<td>'.$now.'</td>';
	
	echo '<td><a href="./carico/'.$d['allegato'].'" target="_blank">'.$d['allegato'].'</a></td>';
	
	echo '</tr>';
}
	//<tr><td>'.$d['da_magaz_id'].'</td><td>'.$d['magaz_id'].'</td><td>'.$d['bene_et_id'].'</td><td>'.$d['quantit'].'</td><td>'.$d['tecnico_id'].'</td><td>'.$d['timestamp'].'</td><td>'.$d['allegato'].'</td></tr>
?>
</table>
</div>

<div id="scar" style="display:none;">
<h3>SCARICO</h3>

<table width="100%"><tr>
<td><strong>Data e ora</strong></td>
<td><strong>Da</strong></td>
<td><strong>Tecnico</strong></td>
<td><strong>Tipologia bene</strong></td>
<td><strong>Quantit&agrave;</strong></td>
<td><strong>Rif-Installazione/N. chiamata</strong></td>
<td><strong>Utente</strong></td>
<td><strong>Allegato</strong></td>
</tr>

<?php
$q = $x->query("SELECT * FROM scarico WHERE da_magaz_id='$id' ORDER BY id DESC");
while($d = $q->fetch_array()){
	
	echo '<tr>';
	
	$now = date ('d-m-Y - H:i:s', $d['timestamp']);
	echo '<td>'.$now.'</td>';
	
	$da = $d['da_magaz_id'];
	$q2 = $x->query("SELECT * FROM magaz WHERE id='$da'");
	while ($d2 = $q2->fetch_array()){
		echo '<td>'.$d2['nome'].'</td>';
	}
	
	$tecn = $d['tecnico_id'];
	$q5 = $x->query("SELECT * FROM tecnico WHERE id='$tecn'");
	while ($d5 = $q5->fetch_array()){
		echo '<td>'.$d5['nome'].'</td>';
	
	}
	
	
	$bene = $d['bene_et_id'];
	$q4 = $x->query("SELECT * FROM etichette WHERE id='$bene'");
	while ($d4 = $q4->fetch_array()){
		echo '<td>'.$d4['campo'].'</td>';
	}
	
	echo '<td>'.$d['quantit'].'</td>';
	
	echo '<td>'.$d['rif_inst'].'</td>';
	
	echo '<td>'.$d['utente'].'</td>';
	
	echo '<td><a href="./scarico/files/'.$d['Allegato'].'" target="_blank">'.$d['Allegato'].'</a></td>';
	
	echo '</tr>';
}
	//<tr><td>'.$d['da_magaz_id'].'</td><td>'.$d['magaz_id'].'</td><td>'.$d['bene_et_id'].'</td><td>'.$d['quantit'].'</td><td>'.$d['tecnico_id'].'</td><td>'.$d['timestamp'].'</td><td>'.$d['allegato'].'</td></tr>
?>
</table>
</div>

</center>

<br><br>

<div id="header">
<ul id="menu">
<li><a href="modifica.php">Modifica valori</a></li>
<li><a href="carico.php">Visualizza carico totale</a></li>
<li><a href="scarico.php">Visualizza scarico totale</a></li>
</ul>
</div>

<h3 style="text-align:center;"><img src="./AntiCopy.png" width="16" height="16"> 2018 Gestione Magazzino by Fabrizio Amorelli e Giulia Sedda</h3>

</body>

</html>
<?php
} else {
	header ("Location: ./");
}
}