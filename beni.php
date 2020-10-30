<?php
require_once './core/config.inc.php';
$c = new mysqli($host,$username,$password,$database);
?>
<!DOCTYPE html>
<html lang="it" class="nav-no-js">

<head>

<title>Beni</title>

<?php require_once './core/header_settings.php'; ?>

<link rel="stylesheet" href="./modal/jquery.modal.min.css">

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

<h3>Beni</h3>

<button id="arrow" onclick="new_bene()"><span class="fa fa-plus" aria-hidden="true"></span> Nuovo</span></button>

<br><br>

<div id="main_tab">
</div>

</div>

<?php require_once './core/footer.php'; ?>

<script>
$(document).ready(function(){
	$("#main_tab").load('script/beni.php');
});

function new_bene(){

	var nome = prompt ("Inserisci il nome:");
	
	if (nome != null && nome != ""){
		
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "script/bene_add.php"); 
		xhr.onload = function(event){
			if (event.target.response == "err"){
				alert("Errore");
			} else {
				$("#main_tab").load('script/beni.php');
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
		xhr.open("POST", "script/bene_edit.php"); 
		xhr.onload = function(event){
			if (event.target.response == "err"){
				alert("Errore");
			} else {
				$("#main_tab").load('script/beni.php');
			}
		};
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send("id="+id+"&nome="+nome);
	}
	
	
}

function remove_bene(id){
	
	var req = window.confirm("Intendi davero rimuovere questo bene?");
	
	if (req == true){
		
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "script/bene_remove.php"); 
		xhr.onload = function(event){
			if (event.target.response == "err"){
				alert("Errore");
			} else {
				$("#main_tab").load('script/beni.php');
			}
		};
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send("id="+id);
	}
	
	
}

function loadform(bene_id,nome){
	document.getElementById('bene_id').value=bene_id;
	document.getElementById('messaggio').innerHTML='';
	document.getElementById('bene_nome').innerHTML=nome;
	selectBox = document.getElementById('magazz_tag_value');
	
	for (var k = 0; k < selectBox.options.length; k++) { 
		selectBox.options[k].selected = false; 
	}
	
	var xhr = new XMLHttpRequest();
	xhr.open("POST", "script/magaz_tag_load.php"); 
	xhr.onload = function(event){
		if (event.target.response == "err"){
			document.getElementById('messaggio').innerHTML='<br><span style="color:red">Errore nel caricamento</span>';
		} else {
			
			if (event.target.response == "ALL"){
				
				for (var k = 0; k < selectBox.options.length; k++) {
					selectBox.options[k].selected = true; 
				}
				
			} else {
			
				var res = event.target.response.split("-");			
				
				for (var j = 0; j < selectBox.options.length; j++) { 
					//console.log(selectBox.options[j].value);
						
					for(var i=0; i<res.length; i++){
						if(selectBox.options[j].value == res[i]){
							selectBox.options[j].selected = true; 
						}
					}
				}
			
			}
		}
	};
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("bene_id="+bene_id);
	
}

function update(){
	var bene_id = document.getElementById('bene_id').value;
	var selected = [];
	
	for (var option of document.getElementById('magazz_tag_value').options) {
		if (option.selected) {
		  selected.push(option.value);
		}
	}
	
	
	if(selected != ""){
		
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "script/magaz_tag.php"); 
		xhr.onload = function(event){
			if (event.target.response == "err"){
				document.getElementById('messaggio').innerHTML='<br><span style="color:red">Errore</span>';
			} else {
				document.getElementById('messaggio').innerHTML='<br><span style="color:green">Impostazione aggiornata</span>';
			}
		};
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send("bene_id="+bene_id+"&magazz_tag_value="+selected);
		
	}
	
}

function resetALL(){
	var bene_id = document.getElementById('bene_id').value;
	selectBox = document.getElementById('magazz_tag_value');
	
	var xhr = new XMLHttpRequest();
	xhr.open("POST", "script/magaz_tag_reset.php"); 
	xhr.onload = function(event){
		if (event.target.response == "err"){
			document.getElementById('messaggio').innerHTML='<br><span style="color:red">Errore</span>';
		} else {
			document.getElementById('messaggio').innerHTML='<br><span style="color:green">Impostazione aggiornata</span>';
			
			for (var i = 0; i < selectBox.options.length; i++) { 
				selectBox.options[i].selected = true; 
			} 
			
		}
	};
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("bene_id="+bene_id);
}
</script>

<div id="magaz_tag" class="modal">

<form id="magaz_tag_form">

<p>Seleziona magazzini [<span id="bene_nome"></span>]:</p>
<select name="magazz_tag_value[]" id="magazz_tag_value" class="mySelect" multiple style="height: 20rem;">
  
<?php
$c = new mysqli($host,$username,$password,$database);

$q = $c->query("SELECT * FROM magaz WHERE fam='0' AND nome<>'ACQUISTO'");

while($d = $q->fetch_array()){
	echo '<option value="'.$d['id'].'">'.$d['nome'].'</option>';
	
	$q2 = $c->query("SELECT * FROM magaz WHERE fam='{$d['id']}'");
	while($d2 = $q2->fetch_array()){
		echo '<option value="'.$d2['id'].'">'.$d['nome'].' / '.$d2['nome'].'</option>';
	}
}

$c->close();
?>
</select>
  
<input type="hidden" id="bene_id" name="bene_id" value="">
  
</form>

<br><br>
<button id="arrow" onclick="update()">Applica</button>
<button id="arrow" onclick="resetALL()">Reset ALL</button>

<div id="messaggio">

</div>

</div>

<script src="./modal/jquery.min.js"></script>
<script src="./modal/jquery.modal.min.js"></script>
</body>

</html>