<?php
require_once './restricted/structure.php';
$x = new mysqli($host,$username,$password,$database);

if(isset($_POST['invia'])){

$ma=$x->real_escape_string($_POST['magazzino']);
$q = $x->query("INSERT INTO magaz(nome) VALUES('$ma')");
header("Location: ./modifica.php");
}

else if(isset($_POST['inserisci'])){
	$b=$x->real_escape_string($_POST['etichet']);
	$q = $x->query("INSERT INTO etichette(campo) VALUES('$b')");
	header("Location: ./modifica.php");
}

else if(isset($_POST['inserimento'])){

$ma=$x->real_escape_string($_POST['tecnici']);
$q = $x->query("INSERT INTO tecnico(nome) VALUES('$ma')");
header("Location: ./modifica.php");
}
