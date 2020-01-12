<?php
require_once './restricted/structure.php';
$x = new mysqli($host,$username,$password,$database);
?>
<!Doctype html>
<html>

<head>
<title>Modifica Valori</title>

<link rel="shortcut icon" type="image/jpg" href="magico.jpg" />

<script type="text/javascript">

function magazzinocanc(id){
	var domanda = confirm("Sei sicuro di voler cancellare ?");
	if (domanda === true) {
		//alert("Hai premuto OK");
		location.href="magcanc.php?id="+id;
	}else{
		//alert("Hai premuto Annulla");
		return false;
	}
}

function magazzinoedit(id){
	location.href="magedit.php?id="+id;
}

function benecanc(id){
	var domanda = confirm("Sei sicuro di voler cancellare ?");
	if (domanda === true) {
		//alert("Hai premuto OK");
		location.href="bencanc.php?id="+id;
	}else{
		//alert("Hai premuto Annulla");
		return false;
	}
}

function benedit(id){
	location.href="bedit.php?id="+id;
}

function tecremove(id){
	var domanda = confirm("Sei sicuro di voler cancellare ?");
	if (domanda === true) {
		//alert("Hai premuto OK");
		location.href="tecrem.php?id="+id;
	}else{
		//alert("Hai premuto Annulla");
		return false;
	}
}

function tecedit(id){
	location.href="tedit.php?id="+id;
}

</script>


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
<h3>MODIFICA MAGAZZINI</h3>

<table>
<tr>
<td><strong>NOME</strong></td>
<td><strong>OPERAZIONI</strong></td>
</tr>

<?php
$q = $x->query("SELECT * FROM magaz");//magedit.php?id='.$d['id'].'
while($d = $q->fetch_array()){
	echo '<tr><td>'.$d['nome'].'</td><td><button onclick="magazzinoedit('.$d['id'].')">Modifica</button> - <button onclick="magazzinocanc('.$d['id'].')">Elimina</button></td></tr>';
}
?>

</table><br><br>

<form action="elabora.php" method="POST" name="magaz">

<input type="text" name="magazzino" id="magazzino" required>
<input type="submit" name="invia" value="Aggiungi">

</form>

<h3>MODIFICA BENI</h3>
<table>
<tr>
<td><strong>NOME</strong></td>
<td><strong>OPERAZIONI</strong></td>
</tr>

<?php
$q = $x->query("SELECT * FROM etichette");//magedit.php?id='.$d['id'].'
while($d = $q->fetch_array()){
	echo '<tr><td>'.$d['campo'].'</td><td><button onclick="benedit('.$d['id'].')">Modifica</button> - <button onclick="benecanc('.$d['id'].')">Elimina</button></td></tr>';
}
?>


</table><br><br>

<form action="elabora.php" method="POST" name="etichette">

<input type="text" name="etichet" id="etichet" required>
<input type="submit" name="inserisci" value="Aggiungi">

</form>

<h3>MODIFICA TECNICI</h3>
<table>
<tr>
<td><strong>NOME</strong></td>
<td><strong>OPERAZIONI</strong></td>
</tr>

<?php
$q = $x->query("SELECT * FROM tecnico");//magedit.php?id='.$d['id'].'
while($d = $q->fetch_array()){
	echo '<tr><td>'.$d['nome'].'</td><td><button onclick="tecedit('.$d['id'].')">Modifica</button> - <button onclick="tecremove('.$d['id'].')">Elimina</button></td></tr>';
}
?>

</table><br><br>

<form action="elabora.php" method="POST" name="tecn">

<input type="text" name="tecnici" id="tecnici" required>
<input type="submit" name="inserimento" value="Aggiungi">

</form>



<!--Tabella totale -->

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