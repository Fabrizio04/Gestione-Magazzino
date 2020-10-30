<?php require_once '../core/config.inc.php'; ?>
<?php
$titolo = "";
$form = "";
$err = "";

$titolo = "Scarico";
$c = new mysqli($host,$username,$password,$database);

$form .= '<form action="script/formget.php" method="post" id="myForm" name="scarico" enctype="multipart/form-data" onsubmit="return checkfile();">

<div class="row">
<select name="da" id="da" required class="mySelect" onchange="updatebeni(this.value)">
<option value="">DA:</option>';

$q = $c->query("SELECT * FROM magaz WHERE fam='0' AND nome<>'ACQUISTO'");

while($d = $q->fetch_array()){
	$form .= '<option value="'.$d['id'].'">'.$d['nome'].'</option>';
	
	$q2 = $c->query("SELECT * FROM magaz WHERE fam='{$d['id']}'");
	while($d2 = $q2->fetch_array()){
		$form .= '<option value="'.$d2['id'].'">'.$d['nome'].' / '.$d2['nome'].'</option>';
	}
}

$form .= '</select>

<select name="Beni" id="Beni" required class="mySelect">
<option value="">BENE:</option>';

$q = $c->query("SELECT * FROM etichette");

while($d = $q->fetch_array()){
	$form .= '<option value="'.$d['id'].'">'.$d['campo'].'</option>';
}

$form .= '</select>

</div>

<br>

<div class="row">

<select name="Tecnici" id="Tecnici" required class="mySelect">
<option value="">TECNICO:</option>';

$q = $c->query("SELECT * FROM tecnico");

while($d = $q->fetch_array()){
	$form .= '<option value="'.$d['id'].'">'.$d['nome'].'</option>';
}

$form .= '</select>
</div>

<br>
<input type="number" id="num" name="num" required="" placeholder="Quantità" onkeypress="return stop2(event);">

<br><br>
<input type="text" id="rif" name="rif" required placeholder="Rif / N. Doc" onkeypress="return stop2(event);">

<br><br>
<input type="text" id="user" name="user" required placeholder="Utente" onkeypress="return stop2(event);">

<br><br><br>
<button onclick="allega();return false;" id="last_selected">Allegato <span class="fa fa-paperclip" aria-hidden="true"></span></button>
<input type="file" name="file" id="file" style="display:none;" onchange="showname()">
<span id="nome"></span>


<br><br>
<input type="submit" value="Invia" name="Inserisci">

</form>';


if(isset($_GET['err'])){
			
	switch($_GET['err']){
		case 1: $err = '<p style="color:red">Il file che tenti di caricare risulta esistente sul server</p>';
		break;
		case 2: $err = '<p style="color:red">Il file che tenti di caricare supera 10 MB</p>';
		break;
		case 3: $err = '<p style="color:red">Il file che tenti di caricare non &egrave; supportato<br>File supportati: .pdf .zip .doc .docx .xls .xlsx .txt</p>';
		break;
	}
}

if(isset($_GET['errs'])){
	$a = explode(";",$_GET['errs']);
	$q = $c->query("SELECT * FROM magaz WHERE id='{$a[0]}'");
	$d1 = $q->fetch_array();
	$q = $c->query("SELECT * FROM etichette WHERE id='{$a[2]}'");
	$d2 = $q->fetch_array();
	$err = '<p style="color:red">La quantità di '.$d2['campo'].' che tenti di spostare/scaricare ('.$a[1].') da '.$d1['nome'].' non &egrave; disponibile</p>';
}

if(isset($_GET['car'])){
	$a = explode(";",$_GET['car']);
	$q = $c->query("SELECT * FROM magaz WHERE id='{$a[1]}'");
	$d = $q->fetch_array();
	$q2 = $c->query("SELECT * FROM etichette WHERE id='{$a[0]}'");
	$d2 = $q2->fetch_array();
	$err = '<p style="color:green">'.$a[2].' '.$d2['campo'].' inseriti correttamente in '.$d['nome'].'</p>';
}

if(isset($_GET['scar'])){
	$a = explode(";",$_GET['scar']);
	$q = $c->query("SELECT * FROM magaz WHERE id='{$a[1]}'");
	$d = $q->fetch_array();
	$q2 = $c->query("SELECT * FROM etichette WHERE id='{$a[0]}'");
	$d2 = $q2->fetch_array();
	$err = '<p style="color:green">'.$a[2].' '.$d2['campo'].' scaricati correttamente da '.$d['nome'].'</p>';
}

if(isset($_GET['mov'])){
	$a = explode(";",$_GET['mov']);
	$q = $c->query("SELECT * FROM magaz WHERE id='{$a[1]}'");
	$d1 = $q->fetch_array();
	$q = $c->query("SELECT * FROM magaz WHERE id='{$a[2]}'");
	$d2 = $q->fetch_array();
	$q = $c->query("SELECT * FROM etichette WHERE id='{$a[0]}'");
	$d3 = $q->fetch_array();
	$err = '<p style="color:green">'.$a[3].' '.$d3['campo'].' spostati correttamente da '.$d1['nome'].' a '.$d2['nome'].'</p>';
}

$c->close();
?>
<!DOCTYPE html>
<html lang="it" class="nav-no-js">

<head>

<title><?php echo $titolo; ?></title>

<?php require_once './core/header_file.php'; ?>

<style>

table {
  border: 1px solid #ccc;
  border-collapse: collapse;
  padding: 0;
  width: 75%;
}

table caption {
  font-size: 1.5em;
  margin: .5em 0 .75em;
}

table tr {
  background-color: #f8f8f8;
  border: 1px solid #ddd;
  padding: .35em;
}


.linea:hover {
	background-color:#bfbebe;
}

table th,
table td {
  padding: .625em;
  text-align: left;
}

table th {
  font-size: .85em;
  letter-spacing: .1em;
  text-transform: uppercase;
}

@media screen and (max-width: 997px) {
	
	
	table {
	  border: 0;
	  width: 90%;
	  table-layout: fixed;
	}
  
	table caption {
	  font-size: 1.3em;
	}
	
	table thead {
	  border: none;
	  clip: rect(0 0 0 0);
	  height: 1px;
	  margin: -1px;
	  overflow: hidden;
	  padding: 0;
	  position: absolute;
	  width: 1px;
	}
	
	table tr {
	  border-bottom: 3px solid #ddd;
	  display: block;
	  margin-bottom: .625em;
	}
	
	table td {
	  border-bottom: 1px solid #ddd;
	  display: block;
	  font-size: .8em;
	  text-align: right;
	}
	
	table td::before {
	  content: attr(data-label);
	  float: left;
	  font-weight: bold;
	  text-transform: uppercase;
	}
	
	table td:last-child {
	  border-bottom: 0;
	}
  }

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

<div style="padding: 0px;text-align:center;">

<h3><?php echo $titolo; ?></h3>

<?php
echo $form;
echo $err;
?>

<span id="err_file"></span>

<br>

<div id="scar">
</div>

</div>

<?php require_once './core/footer.php'; ?>

<script>
$(document).ready(function(){
	$("#scar").load('script/magazzino_scar.php');
});

function allega(){
	document.getElementById("file").click();
}

function showname () {
	var name = document.getElementById('file');
    document.getElementById('nome').innerHTML = "<br><br>"+name.files.item(0).name+' <a href="javascript:remove_File();" style="color:red;"><span class="fa fa-times" aria-hidden="true"></span></a>'; 
}

function stop2(event){
	
	var x = event.which || event.keyCod;
	
	if (x == 13){
		var da = document.getElementById("da").value;
		var beni = document.getElementById("Beni").value;
		var tecnici = document.getElementById("Tecnici").value;
		var num = document.getElementById("num").value;
		var rif = document.getElementById("rif").value;
		var user = document.getElementById("user").value;
		var file = document.getElementById('file').value;

		if (da !== "" && beni !== "" && tecnici !== "" && num !== "" && rif !== "" && user !== "" && file !== "")
			document.getElementById("myForm").submit();

		return false;
		
		

	}
	
}

function checkfile(){
	var file = document.getElementById('file').value;

	if (file == "") {
		document.getElementById("err_file").innerHTML = '<p style="color:red">Selezionare un file!</p>';
		//alert(file);
		return false;
	}
		
	else
		return true;
}

function remove_File() {
	document.getElementById('file').value = "";
	document.getElementById('nome').innerHTML = "";
}

function updatebeni(magaz_id){
	selectBox = document.getElementById('Beni');
	
	selectBox.selectedIndex = "0";
	
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