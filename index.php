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


?>
<!Doctype html>
<html>

<head>

<title>Home</title>

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
<h3>TOTALE BENI</h3>

<!--Tabella totale -->

<table width="29%">

<tr>
<td><strong>Bene</strong></td>
<td><strong>Totale</strong></td>
</tr>

<tr>
<?php
$q = $x->query("SELECT * FROM etichette");

while ($d = $q->fetch_array()){
	
	$q2 = $x->query('SELECT SUM(totale) FROM magazzini WHERE bene_et_id='.$d['id'].'');
	//$q3 = $x->query('SELECT SUM(quantit) FROM scarico WHERE bene_et_id='.$d['id'].'');
	
	
	echo '<tr><td>'.$d['campo'].'</td>';
	
	
	
	
	while ($d2 = $q2->fetch_array()){
		echo '<td>';
			echo $d2[0];
		//echo (($d2[0])-4);
		//print_r ($d2);
		echo '</td></tr>';
	}
}

?>

</tr>

</table><br><br>

<!-- statistiche -->
<button onclick="mostra('stat')">Statistiche</button>

<div id="stat" style="display:none;">
<embed src="statistiche.php" width="100%" height="275">
</div>

<!-- carico -->

<h3>CARICO - SPOSTAMENTO</h3>

<form action="formget.php?id=carico" method="post" name="carico" enctype="multipart/form-data">

<table>

<tr>
<td>Da</td>
<td>A</td>
<td>Tipologia (bene)</td>
<td>Tecnico</td>
<td>Quantit&agrave;</td>
<td>Allegato</td>

</tr>

<td>
<select name="da" required>
<option value=""></option>
<?php
$J = $x->query("SELECT * FROM magaz");

while($f = $J->fetch_array()){
echo '<option value="'.$f['id'].'">'.$f['nome'].'</option>';
	
	
}
?>

</select>
</td>

<td>
<select name="a" required>
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
<input type="file" name="file" id="file">
</td>

</tr>
</table>
<br>
<input type="submit" value="Invia" name="Inserisci">
</form>

<br>

<!-- scarico -->

<h3>SCARICO</h3>

<form action="formget.php?id=scarico" method="post" name="scarico" enctype="multipart/form-data">

<table>

<tr>
<td>Da</td>
<td>Tipologia (bene)</td>
<td>Tecnico</td>
<td>Quantit&agrave;</td>
<td>Rif. installazione/N chiamata</td>
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
<input type="text" id="rif" name="rif" size="28px" required>
</td>

<td>
<input type="text" id="user" name="user" required>
</td>

<td>
<input type="file" name="file" id="file">
</td>

</tr>
</table>
<br>
<input type="submit" value="Invia" name="Inserisci">
</form>

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
<?php
}