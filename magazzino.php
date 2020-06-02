<?php
if (((!isset($_GET['id']))) || ($_GET['id'] == "")) header("Location: ./");
require_once './core/config.inc.php';
$c = new mysqli($host,$username,$password,$database);
$titolo = $c->query("SELECT * FROM magaz WHERE id='{$_GET['id']}'")->fetch_array();
$main = "";
if ($titolo['fam'] != '0'){
	$d = $c->query("SELECT * FROM magaz WHERE id='{$titolo['fam']}'")->fetch_array();
	$main = $d['nome']." / ";
}
?>
<!DOCTYPE html>
<html lang="it" class="nav-no-js">

<head>

<title><?php echo $main.$titolo['nome']; ?></title>

<?php require_once './core/header_mag.php'; ?>

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

<h3><?php echo $titolo['nome']; ?></h3>

<div class="row">
<button id="arrow" onclick="refresh_table()"><span class="fa fa-refresh" aria-hidden="true"></span></button>
<button id="arrow" onclick="auto_refresh()"><span class="fa fa-clock-o" aria-hidden="true"></span></button>
</div>

<br>

<div id="main_tab">
</div>

<br>

<div class="row">
  <button id="last_selected" onclick="mostra('car')">Log Carico <span class="fa fa-upload" aria-hidden="true"></span></button>
  <button id="last_selected" onclick="mostra('scar')">Log Scarico <span class="fa fa-download" aria-hidden="true"></span></button>
</div>

<div id="car" style="display:none;" align="center">
</div>

<div id="scar" style="display:none;">
</div>

</div>

<?php require_once './core/footer.php'; ?>

<script>
$(document).ready(function(){
	$("#main_tab").load('script/magazzino_tab.php?id=<?php echo $_GET['id']; ?>');
	$("#car").load('script/magazzino_car.php?id=<?php echo $_GET['id']; ?>');
	$("#scar").load('script/magazzino_scar.php?id=<?php echo $_GET['id']; ?>');
});

function refresh_table(){

	if(document.getElementById("n_pag") != null){
		var n_pag = document.getElementById("n_pag").value;
		var x_pag = document.getElementById("x_pag").value;
		$("#car").load('script/magazzino_car.php?id=<?php echo $_GET['id']; ?>&x_pag='+x_pag+'&pag='+n_pag);
	} else {
		$("#car").load('script/magazzino_car.php?id=<?php echo $_GET['id']; ?>');
	}
	
	if(document.getElementById("n_pag2") != null){
		var n_pag2 = document.getElementById("n_pag2").value;
		var x_pag2 = document.getElementById("x_pag2").value;
		$("#scar").load('script/magazzino_scar.php?id=<?php echo $_GET['id']; ?>&x_pag='+x_pag2+'&pag='+n_pag2);
	} else {
		$("#scar").load('script/magazzino_scar.php?id=<?php echo $_GET['id']; ?>');
	}
	
	$("#main_tab").load('script/magazzino_tab.php?id=<?php echo $_GET['id']; ?>');
	
}

function timeout() {
    setTimeout(function () {
		
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "script/refresh.php"); 
		xhr.onload = function(event){
			if (event.target.response == "on"){
				document.getElementsByClassName("fa fa-clock-o")[0].style.color="#00ff00";
				refresh_table()
			} else {
				document.getElementsByClassName("fa fa-clock-o")[0].style.color="red";
			}
		};
		
		xhr.send();
        timeout();
    }, 60000);
}

window.onload = function() {
	var xhr = new XMLHttpRequest();
	xhr.open("POST", "script/refresh.php"); 
	xhr.onload = function(event){
		if (event.target.response == "on"){
			document.getElementsByClassName("fa fa-clock-o")[0].style.color="#00ff00";
		} else {
			document.getElementsByClassName("fa fa-clock-o")[0].style.color="red";
		}
	};
	
	xhr.send();
	timeout();
};

function auto_refresh(){
	var color = document.getElementsByClassName("fa fa-clock-o")[0].style.color;
	var valore;
	if(color == "rgb(0, 255, 0)"){//verde
		valore = "off";
	} else {
		valore = "on";
	}
	
	var xhr = new XMLHttpRequest();
	xhr.open("POST", "script/refresh.php"); 
	xhr.onload = function(event){
		if (event.target.response == "on"){
			document.getElementsByClassName("fa fa-clock-o")[0].style.color="#00ff00";
		} else {
			document.getElementsByClassName("fa fa-clock-o")[0].style.color="red";
		}
	};
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("ref="+valore);
	
}

function note(id){
	
	var cont = document.getElementById( id ).innerText;
	var note = prompt ("Inserisci una nota:", cont);
	
	if (note != null && note != cont){
		
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "script/note.php"); 
		xhr.onload = function(event){
			if (event.target.response == "err"){
				alert("Errore");
			} else {
				$("#main_tab").load('script/magazzino_tab.php?id=<?php echo $_GET['id']; ?>');
			}
		};
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send("id="+id+"&note="+note);
	}
	
	
}

function note_set(bene_id){
	var magaz_id = <?php echo $_GET['id']; ?>;
	var note = prompt ("Inserisci una nota:", "");
	
	if (note != null){
		
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "script/note_set.php"); 
		xhr.onload = function(event){
			if (event.target.response == "err"){
				alert("Errore");
			} else {
				$("#main_tab").load('script/magazzino_tab.php?id=<?php echo $_GET['id']; ?>');
			}
		};
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send("magaz_id="+magaz_id+"&note="+note+"&bene_id="+bene_id);
	}
	
	
}
</script>

</body>

</html>