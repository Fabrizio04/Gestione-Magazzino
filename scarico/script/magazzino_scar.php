<?php
require_once '../../core/config.inc.php';

$c = new mysqli($host,$username,$password,$database);

if (((!isset($_GET['x_pag']))) || ($_GET['x_pag'] == ""))
	$x_pag = 5;
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

$q = $c->query("SELECT * FROM scarico ORDER BY id DESC");
$all_rows = $q->num_rows;
$all_pages = ceil($all_rows / $x_pag);
$first = ($pag - 1) * $x_pag;

$q = $c->query("SELECT * FROM scarico ORDER BY id DESC LIMIT $first, $x_pag");
$nr = $q->num_rows;

if ($nr != 0){
	
	echo '<h3>Lista</h3>

<select id="tot_row2" class="mySelect" onchange="reload_tot_row2()">
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
	  <td class="tab_tit" scope="col">BENE</td>
	  <td class="tab_tit" scope="col">N.</td>
	  <td class="tab_tit" scope="col">Tecnico</td>
	  <td class="tab_tit" scope="col">Note</td>
	  <td class="tab_tit" scope="col">Riferimento</td>
	  <td class="tab_tit" scope="col">Attach</td>
	</tr>
  </thead>
  <tbody>';
	
	while($d = $q->fetch_array()){
		
		echo '<tr>';
		
		$now = date_format(new DateTime($d['dataora']),'d/m/Y - H:i:s');
		echo '<td data-label="UPDATE">'.$now.'</td>';
		
		$bene = $d['bene_et_id'];
		$q4 = $c->query("SELECT * FROM etichette WHERE id='$bene'");
		$d4 = $q4->fetch_array();
		echo '<td data-label="BENE">'.$d4['campo'].'</td>';
		
		echo '<td data-label="N.">'.$d['quantit'].'</td>';
		
		$tecn = $d['tecnico_id'];
		$q5 = $c->query("SELECT * FROM tecnico WHERE id='$tecn'");
		$d5 = $q5->fetch_array();
		echo '<td data-label="TECNICO">'.$d5['nome'].'</td>';
		
		echo '<td data-label="NOTE">'.$d['rif_inst'].'</td>';
		echo '<td data-label="RIFERIMENTO">'.$d['utente'].'</td>';
		
		if($d['Allegato'] == "")
			$d['Allegato'] = "N/D";
		else
			$d['Allegato'] = '<a href="./files/'.$d['Allegato'].'" target="_blank">'.$d['Allegato'].'</a>';
		
		echo '<td data-label="ATTACH">'.$d['Allegato'].'</td>';
		
		echo '</tr>';
	}
	
	echo '</tbody>
	</table>';
	
	if ($all_pages > 1){
		
		echo '<br><div class="row">';
		
	  if ($pag > 1){
		  echo '<button id="arrow" onclick="up_page2(\'?pag='.($pag - 1).'&x_pag='.$x_pag.'\')"><span class="fa fa-arrow-left" aria-hidden="true"></span> Prev</button> ';
	  } 
	  if ($all_pages > $pag){
		  echo '<button id="arrow" onclick="up_page2(\'?pag='.($pag + 1).'&x_pag='.$x_pag.'\')">Next <span class="fa fa-arrow-right" aria-hidden="true"></span></button>';
	  }
	  echo '</div><p><a href="javascript:load_page2();"><strong>'.$pag.' / '.$all_pages.'</strong></a></p><br>';
	}
	
	echo '<input type="hidden" value="'.$pag.'" id="n_pag2">
	<input type="hidden" value="'.$x_pag.'" id="x_pag2">
	<br>';
	
} else {
	echo '<h3>Nessun Log di Scarico</h3>';
}
?>
<script>
function load_page2(){
	var num = prompt ("Inserisci la pagina:", "");
	var num2 = parseInt(num);

	if(num2 >= 1 && num2 <= <?php echo $all_pages; ?>){
		$("#scar").load('script/magazzino_scar.php?x_pag=<?php echo $x_pag; ?>&pag='+num2);
		location.href="#scar";
	}
}

function up_page2(url){
	$("#scar").load('script/magazzino_scar.php'+url);
}

function reload_tot_row2(){
	var n = document.getElementById("tot_row2").value;
	$("#scar").load('script/magazzino_scar.php?x_pag='+n);
}
</script>
<?php
$c->close();
?>