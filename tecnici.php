<?php
require_once './core/config.inc.php';
$c = new mysqli($host,$username,$password,$database);
?>
<!DOCTYPE html>
<html lang="it" class="nav-no-js">

<head>

<title>Tecnici</title>

<?php require_once './core/header_settings.php'; ?>

<style>
.main {
	margin: auto;
	padding-top: 150px;
	padding-bottom: 15px;
	width: 100%;
}


@media only screen and (min-width:997px){
	.main {
		margin: auto;
		width: 100%;
		padding-top: 150px;
		padding-bottom: 15px;
	}
}
</style>

</head>

<body>

<a href="javascript:" id="return-to-top"><i class="fa fa-chevron-up"></i></a>

<?php require_once './core/menu.php'; ?>

<div style="padding: 0px;padding-top: 4.4rem;text-align:center;">

<h3>Tecnici</h3>

<button id="arrow" onclick="new_tecnico()"><span class="fa fa-plus" aria-hidden="true"></span> Nuovo</span></button>

<br><br>

<div id="main_tab">
</div>

</div>

<?php require_once './core/footer.php'; ?>

<script>
$(document).ready(function(){
	$("#main_tab").load('script/tecnici.php');
});

function new_tecnico(){

	var nome = prompt ("Inserisci il nome:");
	
	if (nome != null && nome != ""){
		
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "script/tecnico_add.php"); 
		xhr.onload = function(event){
			if (event.target.response == "err"){
				alert("Errore");
			} else {
				$("#main_tab").load('script/tecnici.php');
			}
		};
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send("nome="+nome);
	}
	
	
}

function nome(id){
	
	var cont = document.getElementById( id ).innerText;
	var nome = prompt ("Modifica nome:", cont);
	
	if (nome != null && nome != cont && nome != ""){
		
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "script/tecnico_edit.php"); 
		xhr.onload = function(event){
			if (event.target.response == "err"){
				alert("Errore");
			} else {
				$("#main_tab").load('script/tecnici.php');
			}
		};
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send("id="+id+"&nome="+nome);
	}
	
	
}

function remove_tec(id){
	
	var req = window.confirm("Intendi davero rimuovere questo tecnico?");
	
	if (req == true){
		
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "script/tecnico_remove.php"); 
		xhr.onload = function(event){
			if (event.target.response == "err"){
				alert("Errore");
			} else {
				$("#main_tab").load('script/tecnici.php');
			}
		};
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send("id="+id);
	}
	
	
}
</script>

</body>

</html>