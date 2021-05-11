<?php
require_once './core/config.inc.php';
$c = new mysqli($host,$username,$password,$database);
?>
<!DOCTYPE html>
<html lang="it" class="nav-no-js">

<head>

<title>Licenza</title>

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
</style>

</head>

<body>

<a href="javascript:" id="return-to-top"><i class="fa fa-chevron-up"></i></a>

<?php require_once './core/menu.php'; ?>

<div style="padding: 0px;padding-top: 4.4rem;text-align:center;">

<h3>Gestione Magazzino</h3>

<h3>Un piccolo programma per la gestione del carico e scarico del proprio magazzino.</h3>

<br>

<h3>Gestione Magazzino è:

<ul>
<li>un prodotto italiano, Gratuito e Open Source</li>
<li>compatibile con tutti i Browsers moderni (ad esempio Chrome, Firefox, Edge)</li>
</ul>

</h3>

<br>

<h3>
Versione: 1.3.1
<br>
Anno: 2018-2020
<br>
Released By: Fabrizio Amorelli
</h3>

<br>

<h3>
<a href="CHANGELOG" target="_blank">Changelog</a>
</h3>

<br>

<h3>
Terze parti<br>
<a href="https://github.com/codezero-be/responsive-nav/blob/master/LICENSE" target="_blank">Codezero-be</a><br>
<a href="https://codepen.io/rdallaire/" target="_blank">Rdallaire</a>
</h3>

<br>

<h3>
Consultare il manuale per le istruzioni d'installazione e d'uso.
</h3>

</div>

<?php require_once './core/footer.php'; ?>


</body>

</html>
