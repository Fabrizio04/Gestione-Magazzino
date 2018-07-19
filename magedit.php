<?php
require_once './restricted/structure.php';
$x = new mysqli($host,$username,$password,$database);
$r=$_GET['id'];
?>
<!Doctype html>
<html>

<head>
<title>Modifica Valori</title>

<link rel="shortcut icon" type="image/jpg" href="magico.jpg" />

<script type="text/javascript">
function magazzinocanc(id){
	var domanda = confirm("Sei sicuri di voler cancellare ?");
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
<h3>MODIFICA VALORE MAGAZZINO</h3>

<form action="" method="POST" name="valorimag">

<?php
$id = $_GET['id'];
$q = $x->query('SELECT * FROM magaz WHERE id='.$id.'');
$d = $q->fetch_array();
?>

<input type="text" name="magaz" id="magaz" value="<?php echo $d['nome'];?>" required>
<input type="submit" name="etmag" value="MODIFICA">

</form>
<br>
<button onclick="javascript: history.go(-1);">ANNULLA</button>

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

if(isset($_POST['etmag'])){
	$magaz = $_POST['magaz'];
	$q = $x->query('UPDATE magaz SET nome="'.$magaz.'" WHERE id="'.$id.'"');
	header("Location: modifica.php");
}