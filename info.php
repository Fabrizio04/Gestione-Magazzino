<?php
require_once './core/config.inc.php';
$c = new mysqli($host,$username,$password,$database);
?>
<!DOCTYPE html>
<html lang="it" class="nav-no-js">

<head>

<title>Contatti</title>

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

ul {
    list-style-type: none;
}

.socialmedia a {
	display: inline-block;
	width: 60px;
	height: 60px;
	color: #bfbebe;
	background-color: #333;
	line-height: 60px;
	border-radius: 50%;
	margin: 0 6px;
	font-size: 40px;
	transition: .3s linear;
	
}

.socialmedia #yt:hover{
	background-color: #ff0000;
	color: white;
}

.socialmedia #lnk:hover{
	background-color: #0274b3;
	color: white;
}

.socialmedia #git:hover{
	background-color: #f3f2f2;
	color: #333;
}
</style>

</head>

<body>

<a href="javascript:" id="return-to-top"><i class="fa fa-chevron-up"></i></a>

<?php require_once './core/menu.php'; ?>

<div style="padding: 0px;padding-top: 4.4rem;text-align:center;">

<h3>Gestione Magazzino</h3>
<h3>Un piccolo programma per la gestione del carico e scarico del proprio magazzino.</h3>
<br>
<h3>Realizzato da Fabrizio Amorelli</h3>
<br>
<h3><a href="mailto:postmaster@multi-installer.it">postmaster@multi-installer.it</a></h3>

<div class="socialmedia">
<a href="https://www.youtube.com/c/FabriTutorial" target="_blank" title="YouTube" id="yt"><span class="fa fa-youtube fa-fabri"></span></a>
<a href="https://www.linkedin.com/in/fabrizio-amorelli/" target="_blank" title="LinkedIn" id="lnk"><span class="fa fa-linkedin fa-fabri"></a>
<a href="https://github.com/Fabrizio04" target="_blank" title="GitHub" id="git"><span class="fa fa-github fa-fabri fa-github2"></a>
</div>
<br>
<em>"Prosegui sempre, non mollare Mai".</em>

</div>

<?php require_once './core/footer.php'; ?>


</body>

</html>
