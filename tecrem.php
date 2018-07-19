<?php
require_once './restricted/structure.php';
$x = new mysqli($host,$username,$password,$database);
$r=$_GET['id'];
$f=$x->query('DELETE FROM tecnico WHERE id='.$r.'');
header('Location: modifica.php');