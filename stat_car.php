<?php
require_once './core/config.inc.php';
$c = new mysqli($host,$username,$password,$database);
?>
<!DOCTYPE html>
<html lang="it" class="nav-no-js">

<head>

<title>Statistiche - Carico</title>

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

<h3>Statistiche - Carico</h3>

<div class="row">
<button id="arrow" onclick="refresh_table()"><span class="fa fa-refresh" aria-hidden="true"></span></button>
<button id="arrow" onclick="auto_refresh()"><span class="fa fa-clock-o" aria-hidden="true"></span></button>
</div>

<br>

<div class="row">
<select id="years" class="mySelect" onchange="reload_chart()">
<?php
for($i = date("Y"); $i>=1970; $i-=1){	
	echo '<option value="'.$i.'">'.$i.'</option>';
}
?>
</select>

<select id="da" class="mySelect" onchange="reload_chart()">
	<option value="ALL">DA:</option>';
<?php
$q = $c->query("SELECT * FROM magaz WHERE fam='0'");

while($d = $q->fetch_array()){
	
	echo '<option value="'.$d['id'].'">'.$d['nome'].'</option>';
	
	$q2 = $c->query("SELECT * FROM magaz WHERE fam='{$d['id']}'");

	while($d2 = $q2->fetch_array()){
		echo '<option value="'.$d2['id'].'">'.$d['nome'].' / '.$d2['nome'].'</option>';
	}
}
?>
</select>

<select id="a" class="mySelect" onchange="reload_chart()">
	<option value="ALL">A:</option>';
<?php
$q = $c->query("SELECT * FROM magaz WHERE fam='0' AND nome<>'ACQUISTO'");

while($d = $q->fetch_array()){
	
	echo '<option value="'.$d['id'].'" '.$selected.'>'.$d['nome'].'</option>';
	
	$q2 = $c->query("SELECT * FROM magaz WHERE fam='{$d['id']}'");

	while($d2 = $q2->fetch_array()){
		echo '<option value="'.$d2['id'].'" '.$selected2.'>'.$d['nome'].' / '.$d2['nome'].'</option>';
	}
}
?>
</select>

<select id="Beni" class="mySelect" onchange="reload_chart()">
	<option value="ALL">BENE:</option>
<?php
$q = $c->query("SELECT * FROM etichette");

while($d = $q->fetch_array()){
	
	echo '<option value="'.$d['id'].'">'.$d['campo'].'</option>';
}
?>
</select>

<select id="Tecnici" class="mySelect" onchange="reload_chart()">
	<option value="ALL">TECNICO:</option>
<?php
$q = $c->query("SELECT * FROM tecnico");

while($d = $q->fetch_array()){
	
	echo '<option value="'.$d['id'].'">'.$d['nome'].'</option>';
}
?>
</select>
</div>

<br>

<select id="zoom" class="mySelect" onchange="reload_chart()">
<option value="50">50%</option>
<option value="75">75%</option>
<option value="90">90%</option>
</select>

<button id="arrow2" onclick="open_tab()"><span class="fa fa-window-maximize" aria-hidden="true"></span></button>

<br>

<iframe id="gra" src="script/carico_chart.php" scrolling="no" style="border: 0;height: auto;width: 100%;"></iframe>

</div>

<?php require_once './core/footer.php'; ?>

<script>
var resizeTimer;

$(window).on('resize', function(e) {

  clearTimeout(resizeTimer);
  resizeTimer = setTimeout(function() {
	segui();
  }, 300);

});

$(window).on('load', function(e) {
	
	setTimeout(function () {
		segui();
    }, 300);

});

function segui(){
	var iframe = document.getElementById("gra");
	var elmnt = iframe.contentWindow.document.getElementsByTagName("canvas")[0];
	var a = elmnt.style.height;
	var num = parseInt(a, 10);
	iframe.style.height = num+5 + "px";
}

function refresh_table(){
	document.getElementById("gra").contentDocument.location.reload(true);
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

function reload_chart(){
	var y = document.getElementById("years").value;
	var da = document.getElementById("da").value;
	var a = document.getElementById("a").value;
	var beni = document.getElementById("Beni").value;
	var tec = document.getElementById("Tecnici").value;

	var iframe = document.getElementById('gra');
	iframe.src = "script/carico_chart.php?id="+document.getElementById("zoom").value+"&years="+y+"&da="+da+"&a="+a+"&bene="+beni+"&tec="+tec;
	
	setTimeout(function () {
		segui();
    }, 300);
	
}

function open_tab(){
	var y = document.getElementById("years").value;
	var da = document.getElementById("da").value;
	var a = document.getElementById("a").value;
	var beni = document.getElementById("Beni").value;
	var tec = document.getElementById("Tecnici").value;

	window.open("script/carico_chart.php?id=90&years="+y+"&da="+da+"&a="+a+"&bene="+beni+"&tec="+tec);
}
</script>

</body>

</html>