<?php
require_once '../core/config.inc.php';
if (((!isset($_GET['id']))) || ($_GET['id'] == "")) header("Location: ./");
$c = new mysqli($host,$username,$password,$database);

if (((!isset($_GET['x_pag']))) || ($_GET['x_pag'] == ""))
	$x_pag = 10;
else
	$x_pag = $_GET['x_pag'];

$selected5=$selected10=$selected25=$selected50=$selected100 = "";

switch($x_pag){
	case 5: $selected5='selected="selected"'; break;
	case 10: $selected10='selected="selected"'; break;
	case 25: $selected25='selected="selected"'; break;
	case 50: $selected50='selected="selected"'; break;
	case 100: $selected100='selected="selected"'; break;
}

$pag = isset($_GET['pag']) ? $_GET['pag'] : 1;
if (!$pag || !is_numeric($pag)) $pag = 1;

$q = $c->query("SELECT * FROM carico WHERE magaz_id='{$_GET['id']}' OR da_magaz_id='{$_GET['id']}' ORDER BY id DESC");
$all_rows = $q->num_rows;
$all_pages = ceil($all_rows / $x_pag);
$first = ($pag - 1) * $x_pag;

$q = $c->query("SELECT * FROM carico WHERE magaz_id='{$_GET['id']}' OR da_magaz_id='{$_GET['id']}' ORDER BY id DESC LIMIT $first, $x_pag");
$nr = $q->num_rows;

if ($nr != 0){
	
	echo '<h3>Carico</h3>

<select id="tot_row" class="mySelect" onchange="reload_tot_row()">
    <option value="5" '.$selected5.'>5 record</option>
	<option value="10" '.$selected10.'>10 record</option>
	<option value="25" '.$selected25.'>25 record</option>
	<option value="50" '.$selected50.'>50 record</option>
	<option value="100" '.$selected100.'>100 record</option>
</select>

<br><br>
	
<table align="center">
  <thead>
    <tr>
	  <td class="tab_tit" scope="col">Update</td>
      <td class="tab_tit" scope="col">DA</td>
	  <td class="tab_tit" scope="col">A</td>
	  <td class="tab_tit" scope="col">BENE</td>
	  <td class="tab_tit" scope="col">N.</td>
	  <td class="tab_tit" scope="col">Tecnico</td>
	  <td class="tab_tit" scope="col">Attach</td>
	</tr>
  </thead>
  <tbody>';
	
	while($d = $q->fetch_array()){
		
		echo '<tr>';
		
		$now = date_format(new DateTime($d['dataora']),'d/m/Y - H:i:s');
		echo '<td data-label="UPDATE">'.$now.'</td>';
		
		$da = $d['da_magaz_id'];
		$q2 = $c->query("SELECT * FROM magaz WHERE id='$da'");
		$d2 = $q2->fetch_array();
		echo '<td data-label="DA">'.$d2['nome'].'</td>';
		
		
		
		$a = $d['magaz_id'];
		$q3 = $c->query("SELECT * FROM magaz WHERE id='$a'");
		$d3 = $q3->fetch_array();
		echo '<td data-label="A">'.$d3['nome'].'</td>';
		
		$bene = $d['bene_et_id'];
		$q4 = $c->query("SELECT * FROM etichette WHERE id='$bene'");
		$d4 = $q4->fetch_array();
		echo '<td data-label="BENE">'.$d4['campo'].'</td>';
		
		echo '<td data-label="N.">'.$d['quantit'].'</td>';
		
		$tecn = $d['tecnico_id'];
		$q5 = $c->query("SELECT * FROM tecnico WHERE id='$tecn'");
		$d5 = $q5->fetch_array();
		echo '<td data-label="TECNICO">'.$d5['nome'].'</td>';
		
		if($d['allegato'] == "")
			$d['allegato'] = "N/D";
		else
			$d['allegato'] = '<a href="./carico/'.$d['allegato'].'" target="_blank">'.$d['allegato'].'</a>';
		
		echo '<td data-label="ATTACH"><a href="javascript:remove_car('.$d['id'].');" style="color:red;"><span class="fa fa-times" aria-hidden="true"></span></a> '.$d['allegato'].'</td>';
		
		echo '</tr>';
	}
	
	echo '</tbody>
	</table>';
	
	if ($all_pages > 1){
		
		echo '<br><div class="row">';
		
	  if ($pag > 1){
		  echo '<button id="arrow" onclick="up_page(\'?id='.$_GET['id'].'&pag='.($pag - 1).'&x_pag='.$x_pag.'\')"><span class="fa fa-arrow-left" aria-hidden="true"></span> Prev</button> ';
	  } 
	  if ($all_pages > $pag){
		  echo '<button id="arrow" onclick="up_page(\'?id='.$_GET['id'].'&pag='.($pag + 1).'&x_pag='.$x_pag.'\')">Next <span class="fa fa-arrow-right" aria-hidden="true"></span></button>';
	  }
	  echo '</div><p><a href="javascript:load_page();"><strong>'.$pag.' / '.$all_pages.'</strong></a></p><br>';
	}
	
	echo '<input type="hidden" value="'.$pag.'" id="n_pag">
	<input type="hidden" value="'.$x_pag.'" id="x_pag">
	<br>';
	
} else {
	echo '<h3>Nessun Log di Carico</h3>';
}
?>
<script>
function load_page(){
	var num = prompt ("Inserisci la pagina:", "");
	var num2 = parseInt(num);

	if(num2 >= 1 && num2 <= <?php echo $all_pages; ?>){
		$("#car").load('script/magazzino_car.php?id=<?php echo $_GET['id']; ?>&x_pag=<?php echo $x_pag; ?>&pag='+num2);
		location.href="#car";
	}
}

function up_page(url){
	$("#car").load('script/magazzino_car.php'+url);
}

function reload_tot_row(){
	var n = document.getElementById("tot_row").value;
	$("#car").load('script/magazzino_car.php?id=<?php echo $_GET['id']; ?>&x_pag='+n);
}

function remove_car(id){
	var req = window.confirm("Intendi davero rimuovere il record ed eventuali file?\n(Potrebbe influire sulle statistiche)");
	var cur_row = <?php echo $nr; ?>;
	
	if (req == true){
		
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "script/car_del.php"); 
		xhr.onload = function(event){
			if (event.target.response == "err"){
				alert("Errore");
			} else {
				if(cur_row == 1){
					$("#car").load('script/magazzino_car.php?id=<?php echo $_GET['id']; ?>&x_pag=<?php echo $x_pag; ?>&pag=<?php echo $pag-1; ?>');
				} else {
					$("#car").load('script/magazzino_car.php?id=<?php echo $_GET['id']; ?>&x_pag=<?php echo $x_pag; ?>&pag=<?php echo $pag; ?>');
				}
				
			}
		};
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send("id="+id);
	}
}
</script>
<?php
$c->close();
?>