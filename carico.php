<?php
require_once './restricted/structure.php';
$x = new mysqli($host,$username,$password,$database);
?>
<!Doctype html>
<html>

<head>

<title>Carico</title>

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
<h3>CARICO</h3>

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
$q = $x->query("SELECT * FROM carico ORDER BY id DESC");
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
</center>

<br><br>

<div id="header">
<ul id="menu">
<li><a href="modifica.php">Modifica valori</a></li>
<li><a href="carico.php">Visualizza carico totale</a></li>
<li><a href="scarico.php">Visualizza scarico totale</a></li>
</ul>
</div>

<h3 style="text-align:center;"><img src="./AntiCopy.png" width="16" height="16"> 2018 Gestione Magazzino by Fabrizio Amorelli</h3>

</body>

</html>
