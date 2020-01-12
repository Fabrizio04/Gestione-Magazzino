<?php
require_once '../restricted/structure.php';
$x = new mysqli($host,$username,$password,$database);
?>
<!Doctype html>
<html>

<head>

<title>Scarico</title>

<link rel="shortcut icon" type="image/jpg" href="./magico.jpg" />

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

<!-- scarico -->
<br><br>
<h2>SCARICO</h2>

<form action="formget.php?id=scarico" method="post" name="scarico" enctype="multipart/form-data">

<table>

<tr>
<td>Da</td>
<td>Tipologia (bene)</td>
<td>Tecnico</td>
<td>Quantit&agrave;</td>
<td>Rif-Installazione/N. chiamata</td>
<td>Utente</td>
<td>Allegato</td>

</tr>

<td>
<select name="da" required>
<option value=""></option>
<?php
$J = $x->query("SELECT * FROM magaz WHERE nome<>'ACQUISTO'");

while($f = $J->fetch_array()){
echo '<option value="'.$f['id'].'">'.$f['nome'].'</option>';
	
	
}
?>

</select>
</td>


<td>
<select name="Beni" required>
<option value=""></option>
<?php
$J = $x->query("SELECT * FROM etichette");

while($f = $J->fetch_array()){
echo '<option value="'.$f['id'].'">'.$f['campo'].'</option>';
	
	
}

?>

</select>
</td>

<td>
<select name="Tecnici" required>
<option value=""></option>

<?php
$J = $x->query("SELECT * FROM tecnico");

while($f = $J->fetch_array()){
echo '<option value="'.$f['id'].'">'.$f['nome'].'</option>';
	
	
}

?>

 
</select>
</td>

<td>
<input type="number" id="num" name="num" required>
</td>

<td>
<input type="text" id="rif" name="rif" size="25px" required>
</td>

<td>
<input type="text" id="user" name="user" required>
</td>

<td>
<input type="file" name="file" id="file" required>
</td>

</tr>
</table>
<br>
<input type="submit" value="Invia" name="Inserisci">
</form>

<br>

<h3>TABELLA TOTALE</h3>

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
$q = $x->query("SELECT * FROM scarico ORDER BY id DESC");
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
	
	echo '<td><a href="./files/'.$d['Allegato'].'" target="_blank">'.$d['Allegato'].'</a></td>';
	
	echo '</tr>';
}
	//<tr><td>'.$d['da_magaz_id'].'</td><td>'.$d['magaz_id'].'</td><td>'.$d['bene_et_id'].'</td><td>'.$d['quantit'].'</td><td>'.$d['tecnico_id'].'</td><td>'.$d['timestamp'].'</td><td>'.$d['allegato'].'</td></tr>
?>
</table>

<br>

<h3 style="text-align:center;"><img src="./AntiCopy.png" width="16" height="16"> 2018 Gestione Magazzino by Fabrizio Amorelli</h3>

</center>

</body>

</html>