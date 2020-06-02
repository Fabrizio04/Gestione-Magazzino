<?php require_once './core/config.inc.php'; ?>
<?php
$titolo = "";
$form = "";
$err = "";

if(isset($_GET['id'])){
	
	if($_GET['id'] == "carico"){
		$c = new mysqli($host,$username,$password,$database);
		$titolo = "Carico";
		
		$form .= '<form action="script/formget.php?id=carico" method="post" id="myForm" name="carico" enctype="multipart/form-data">
		<div class="row">
		<select name="da" id="da" required class="mySelect">
		<option value="">DA:</option>';
		
		$q = $c->query("SELECT * FROM magaz WHERE fam='0'");

		while($d = $q->fetch_array()){
			$form .= '<option value="'.$d['id'].'">'.$d['nome'].'</option>';
			
			$q2 = $c->query("SELECT * FROM magaz WHERE fam='{$d['id']}'");
			while($d2 = $q2->fetch_array()){
				$form .= '<option value="'.$d2['id'].'">'.$d['nome'].' / '.$d2['nome'].'</option>';
			}
		}
		
		$form .= '</select>
		<select name="a" id="a" required class="mySelect">
		<option value="">A:</option>';
		
		$q = $c->query("SELECT * FROM magaz WHERE fam='0' AND nome<>'ACQUISTO'");

		while($d = $q->fetch_array()){
			$form .= '<option value="'.$d['id'].'">'.$d['nome'].'</option>';
			
			$q2 = $c->query("SELECT * FROM magaz WHERE fam='{$d['id']}'");
			while($d2 = $q2->fetch_array()){
				$form .= '<option value="'.$d2['id'].'">'.$d['nome'].' / '.$d2['nome'].'</option>';
			}
		}
		
		$form .= '</select>
		</div>
		
		<br>
		
		<div class="row">
		<select name="Beni" id="Beni" required class="mySelect">
		<option value="">BENE:</option>';
		
		$q = $c->query("SELECT * FROM etichette");

		while($d = $q->fetch_array()){
			$form .= '<option value="'.$d['id'].'">'.$d['campo'].'</option>';
		}
		
		$form .= '</select>
		<select name="Tecnici" id="Tecnici" required class="mySelect">
		<option value="">TECNICO:</option>';
		
		$q = $c->query("SELECT * FROM tecnico");

		while($d = $q->fetch_array()){
			$form .= '<option value="'.$d['id'].'">'.$d['nome'].'</option>';
		}
		
		$form .= '</select>
		</div>
		
		<br>
		<input type="number" id="num" name="num" required="" placeholder="Quantità" onkeypress="return stop1(event);">
		
		<br><br><br>
		<button onclick="allega();return false;" id="last_selected">Allegato <span class="fa fa-paperclip" aria-hidden="true"></span></button>
		<input type="file" name="file" id="file" style="display:none;" onchange="showname()">
		<span id="nome"></span>
		
		
		<br><br>
		<input type="submit" value="Invia" name="Inserisci">
		
		</form>';		
	}
	
	else if($_GET['id'] == "scarico"){
		$titolo = "Scarico";
		$c = new mysqli($host,$username,$password,$database);
		
		$form .= '<form action="script/formget.php?id=scarico" method="post" id="myForm" name="scarico" enctype="multipart/form-data">
		
		<div class="row">
		<select name="da" id="da" required class="mySelect">
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
	}
	
	else header("Location: ./");
	
} else header("Location: ./");

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

<h3><?php echo $titolo; ?></h3>

<?php
echo $form;
echo $err;
?>

<br>

</div>

<?php require_once './core/footer.php'; ?>

<script>
function allega(){
	document.getElementById("file").click();
}

function showname () {
	var name = document.getElementById('file');
    document.getElementById('nome').innerHTML = "<br><br>"+name.files.item(0).name+' <a href="javascript:remove_File();" style="color:red;"><span class="fa fa-times" aria-hidden="true"></span></a>'; 
}

function stop1(event){
	
	var x = event.which || event.keyCod;
	
	if (x == 13){
		var da = document.getElementById("da").value;
		var a = document.getElementById("a").value;
		var beni = document.getElementById("Beni").value;
		var tecnici = document.getElementById("Tecnici").value;
		var num = document.getElementById("num").value;

		if (da !== "" && a !== "" && beni !== "" && tecnici !== "" && num !== "")
			document.getElementById("myForm").submit();

		return false;
		
		

	}
	
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

		if (da !== "" && beni !== "" && tecnici !== "" && num !== "" && rif !== "" && user !== "")
			document.getElementById("myForm").submit();

		return false;
		
		

	}
	
}

function remove_File() {
	document.getElementById('file').value = "";
	document.getElementById('nome').innerHTML = "";
}
</script>

</body>

</html>