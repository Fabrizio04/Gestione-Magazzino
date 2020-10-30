<?php
require_once './core/config.inc.php';
$c = new mysqli($host,$username,$password,$database);
?>
<!DOCTYPE html>
<html lang="it" class="nav-no-js">

<head>

<title>Reports - Carico</title>

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

<h3>Reports - Carico</h3>

<div class="row">
<button id="arrow" onclick="refresh_table()"><span class="fa fa-refresh" aria-hidden="true"></span></button>
<button id="arrow" onclick="auto_refresh()"><span class="fa fa-clock-o" aria-hidden="true"></span></button>
</div>

<br>

<div id="car" align="center">
</div>

</div>

<?php require_once './core/footer.php'; ?>

<script>
$(document).ready(function(){
	$("#car").load('script/carico.php');
});

function refresh_table(){

	if(document.getElementById("n_pag") != null){
		var n_pag = document.getElementById("n_pag").value;
		var x_pag = document.getElementById("x_pag").value;
		var y = document.getElementById("anno").value;
		var da = document.getElementById("da_magaz").value;
		var a = document.getElementById("a_magaz").value;
		var bene = document.getElementById("bene_id").value;
		var tec = document.getElementById("tecnico_id").value;
		$("#car").load('script/carico.php?x_pag='+x_pag+'&pag='+n_pag+'&years='+y+'&da='+da+'&a='+a+'&bene='+bene+'&tec='+tec);
		changebene();
		
	} else {
		var y = document.getElementById("years").value;
		var da = document.getElementById("da").value;
		var a = document.getElementById("a").value;
		var bene = document.getElementById("Beni").value;
		var tec = document.getElementById("Tecnici").value;
		$("#car").load('script/carico.php?years='+y+'&da='+da+'&a='+a+'&bene='+bene+'&tec='+tec);
		changebene();
	}
	
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

function exp(){

	if(document.getElementById("n_pag") != null){
		var n_pag = document.getElementById("n_pag").value;
		var x_pag = document.getElementById("x_pag").value;
		var y = document.getElementById("anno").value;
		var da = document.getElementById("da_magaz").value;
		var a = document.getElementById("a_magaz").value;
		var bene = document.getElementById("bene_id").value;
		var tec = document.getElementById("tecnico_id").value;
		
		location.href='script/export.php?id=1&x_pag='+x_pag+'&pag='+n_pag+'&years='+y+'&da='+da+'&a='+a+'&bene='+bene+'&tec='+tec
	}
	
}

function updatebeni(magaz_id){
	selectBox = document.getElementById('Beni');
	
	for (var i = 0; i < selectBox.options.length; i++) { 
		selectBox.options[i].disabled = true; 
	}
	
	var xhr = new XMLHttpRequest();
	xhr.open("POST", "script/beni_form_query.php"); 
	xhr.onload = function(event){
		if (event.target.response == "err"){
			alert('Errore');
		} else {
			
			var res = event.target.response.split("-");			
				
			for (var j = 0; j < selectBox.options.length; j++) {
					
				for(var i=0; i<res.length; i++){
					if(selectBox.options[j].value == res[i]){
						selectBox.options[j].disabled = false; 
					}
				}
			}
			
		}
	};
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("magaz_id="+magaz_id);
}
</script>

</body>

</html>