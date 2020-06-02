<?php require_once './core/config.inc.php'; ?>
<!DOCTYPE html>
<html lang="it" class="nav-no-js">

<head>

<title>Home</title>

<?php require_once './core/header_file.php'; ?>

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

@media only screen and (max-width: 996px) {
	iframe {
		display: none;
	}

	select {
		display:none;
	}
}

</style>

</head>

<body>

<a href="javascript:" id="return-to-top"><i class="fa fa-chevron-up"></i></a>

<?php require_once './core/menu.php'; ?>

<div style="padding: 0px;padding-top: 4.4rem;text-align:center;">

<h3>Home</h3>

<div class="row">
<button id="arrow" onclick="refresh_table()"><span class="fa fa-refresh" aria-hidden="true"></span></button>
<button id="arrow" onclick="auto_refresh()"><span class="fa fa-clock-o" aria-hidden="true"></span></button>
</div>

<br>

<div id="main_tab">
</div>

<br>

<!-- Grafico -->
<select id="zoom" class="mySelect" onchange="chart_zoom()">
<option value="50">50%</option>
<option value="75">75%</option>
<option value="90">90%</option>
</select>

<button id="arrow2" onclick="open_tab()"><span class="fa fa-window-maximize" aria-hidden="true"></span></button>

<iframe id="gra" src="script/index_chart.php" scrolling="no" style="border: 0;height: auto;width: 100%;"></iframe>
<!-- -->

</div>

<br>

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

function chart_zoom(){
	var iframe = document.getElementById('gra');
	iframe.src = "script/index_chart.php?id="+document.getElementById("zoom").value;
	setTimeout(function () {
		segui();
    }, 300);
}

$(document).ready(function(){
	$("#main_tab").load('script/home_tab.php');
});

function refresh_table(){
	$("#main_tab").load('script/home_tab.php');
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

function open_tab(){

	window.open("script/index_chart.php?id=90");
}
</script>

</body>

</html>