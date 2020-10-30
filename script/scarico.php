<?php
require_once '../core/config.inc.php';

$c = new mysqli($host,$username,$password,$database);
$where = "";

/* Select anni */

$years = isset($_GET['years']) ? $_GET['years'] : date("Y");

$where .= "WHERE dataora LIKE '$years-%'";

echo '<div class="row">
<select id="years" class="mySelect" onchange="reload_tot_row()">';

for($i = date("Y"); $i>=1970; $i-=1){
	
	if($i == $years)
		$selectedY='selected="selected"';
	else
		$selectedY='';
	
	echo '<option value="'.$i.'" '.$selectedY.'>'.$i.'</option>';
}

echo '</select>';

/* Fine select anni */

/* Select DA */

$da2 = isset($_GET['da']) ? $_GET['da'] : "ALL";

if ($da2 != "ALL") $where .= " AND da_magaz_id = '$da2'";

	echo ' <select id="da" class="mySelect" onchange="reload_tot_row()">
	<option value="ALL">DA:</option>';
			
			$q = $c->query("SELECT * FROM magaz WHERE fam='0' AND nome<>'ACQUISTO'");

			while($d = $q->fetch_array()){
				
				if($da2 == $d['id'])
					$selected='selected="selected"';
				else
					$selected='';
				
				echo '<option value="'.$d['id'].'" '.$selected.'>'.$d['nome'].'</option>';
				
				$q2 = $c->query("SELECT * FROM magaz WHERE fam='{$d['id']}'");
				while($d2 = $q2->fetch_array()){
					if($da2 == $d2['id'])
						$selected2='selected="selected"';
					else
						$selected2='';
					echo '<option value="'.$d2['id'].'" '.$selected2.'>'.$d['nome'].' / '.$d2['nome'].'</option>';
				}
			}
			
			echo '</select>';

/* Fine select DA */

/* Select Bene */

$bene2 = isset($_GET['bene']) ? $_GET['bene'] : "ALL";

if ($bene2 != "ALL") $where .= " AND bene_et_id = '$bene2'";

echo ' <select id="Beni" class="mySelect" onchange="reload_tot_row()">
		<option value="ALL">BENE:</option>';
		
		$q = $c->query("SELECT * FROM etichette");

		while($d = $q->fetch_array()){
			
			if($bene2 == $d['id'])
				$selected='selected="selected"';
			else
				$selected='';
			
			echo '<option value="'.$d['id'].'" '.$selected.'>'.$d['campo'].'</option>';
		}
		
echo '</select>';

/* Fine select Bene */

/* Select tecnico */

$tecnico2 = isset($_GET['tec']) ? $_GET['tec'] : "ALL";

if ($tecnico2 != "ALL") $where .= " AND tecnico_id= '$tecnico2'";

echo ' <select id="Tecnici" class="mySelect" onchange="reload_tot_row()">
		<option value="ALL">TECNICO:</option>';
		
		$q = $c->query("SELECT * FROM tecnico");

		while($d = $q->fetch_array()){
			
			if($tecnico2 == $d['id'])
				$selected='selected="selected"';
			else
				$selected='';
			
			echo '<option value="'.$d['id'].'" '.$selected.'>'.$d['nome'].'</option>';
		}
		
echo '</select>';

/* Fine select tecnico */

echo '</div>
<br>';

/* Select righe + Query */

if (((!isset($_GET['x_pag']))) || ($_GET['x_pag'] == ""))
	$x_pag = 10;
else
	$x_pag = $_GET['x_pag'];

$selected5=$selected10=$selected25=$selected50=$selected100=$selectedALL = "";

switch($x_pag){
	case 5: $selected5='selected="selected"'; break;
	case 10: $selected10='selected="selected"'; break;
	case 25: $selected25='selected="selected"'; break;
	case 50: $selected50='selected="selected"'; break;
	case 100: $selected100='selected="selected"'; break;
	case 'ALL': $selectedALL='selected="selected"'; break;
}

$pag = isset($_GET['pag']) ? $_GET['pag'] : 1;

if($x_pag == "ALL"){
	$q = $c->query("SELECT * FROM scarico $where ORDER BY id DESC");
	$all_pages = 10;
	
} else {
	
	if(!$pag || !is_numeric($pag)) $pag = 1;
	$q = $c->query("SELECT * FROM scarico $where ORDER BY id DESC");
	$all_rows = $q->num_rows;
	$all_pages = ceil($all_rows / $x_pag);
	$first = ($pag - 1) * $x_pag;

	$q = $c->query("SELECT * FROM scarico $where ORDER BY id DESC LIMIT $first, $x_pag");
	
}


$nr = $q->num_rows;

if ($nr != 0){
	
	echo '
<select id="tot_row" class="mySelect" onchange="reload_tot_row()">
    <option value="5" '.$selected5.'>5 records</option>
	<option value="10" '.$selected10.'>10 records</option>
	<option value="25" '.$selected25.'>25 records</option>
	<option value="50" '.$selected50.'>50 records</option>
	<option value="100" '.$selected100.'>100 records</option>
	<option value="ALL" '.$selectedALL.'>ALL records</option>
</select>

<br><br>

<button id="arrow" onclick="exp()"><span class="fa fa-floppy-o" aria-hidden="true"></span></button>

<br><br>';


echo '	
<table align="center">
  <thead>
    <tr>
	  <td class="tab_tit" scope="col">Update</td>
      <td class="tab_tit" scope="col">DA</td>
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
		
		$da = $d['da_magaz_id'];
		$q2 = $c->query("SELECT * FROM magaz WHERE id='$da'");
		$d2 = $q2->fetch_array();
		echo '<td data-label="DA">'.$d2['nome'].'</td>';
		
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
			$d['Allegato'] = '<a href="./carico/'.$d['Allegato'].'" target="_blank">'.$d['Allegato'].'</a>';
		
		echo '<td data-label="ATTACH"><a href="javascript:remove_scar('.$d['id'].');" style="color:red;"><span class="fa fa-times" aria-hidden="true"></span></a> '.$d['Allegato'].'</td>';
		
		echo '</tr>';
	}
	
	echo '</tbody>
	</table>';
	
	if($x_pag != "ALL"){
	
		if ($all_pages > 1){
			
			echo '<br><div class="row">';
			
		  if ($pag > 1){
			  echo '<button id="arrow" onclick="up_page(\'?pag='.($pag - 1).'&x_pag='.$x_pag.'&years='.$years.'&da='.$da2.'&bene='.$bene2.'&tec='.$tecnico2.'\')"><span class="fa fa-arrow-left" aria-hidden="true"></span> Prev</button> ';
		  } 
		  if ($all_pages > $pag){
			  echo '<button id="arrow" onclick="up_page(\'?pag='.($pag + 1).'&x_pag='.$x_pag.'&years='.$years.'&da='.$da2.'&bene='.$bene2.'&tec='.$tecnico2.'\')">Next <span class="fa fa-arrow-right" aria-hidden="true"></span></button>';
		  }
		  echo '</div><p><a href="javascript:load_page();"><strong>'.$pag.' / '.$all_pages.'</strong></a></p><br>';
		}
	}
	
	echo '<input type="hidden" value="'.$pag.'" id="n_pag">
	<input type="hidden" value="'.$x_pag.'" id="x_pag">
	<input type="hidden" value="'.$years.'" id="anno">
	<input type="hidden" value="'.$da2.'" id="da_magaz">
	<input type="hidden" value="'.$bene2.'" id="bene_id">
	<input type="hidden" value="'.$tecnico2.'" id="tecnico_id">
	<br>';
	
	
} else {
	echo '<h3>Nessun Log di Scarico</h3>';
}

/* Fine select righe + Query */

?>
<script>
function load_page(){
	var num = prompt ("Inserisci la pagina:", "");
	var num2 = parseInt(num);
	
	var y = document.getElementById("years").value;
	var da = document.getElementById("da").value;
	var bene = document.getElementById("Beni").value;
	var tec = document.getElementById("Tecnici").value;

	if(num2 >= 1 && num2 <= <?php echo $all_pages; ?>){
		$("#scar").load('script/scarico.php?x_pag=<?php echo $x_pag; ?>&pag='+num2+'&years='+y+'&da='+da+'&bene='+bene+'&tec='+tec);
		location.href="#scar";
		changebene();
	}
}

function reload_tot_row(){
	var y = document.getElementById("years").value;
	var da = document.getElementById("da").value;
	var bene = document.getElementById("Beni").value;
	var tec = document.getElementById("Tecnici").value;
	
	if(document.getElementById("tot_row") != null){
		var n = document.getElementById("tot_row").value;
		$("#scar").load('script/scarico.php?x_pag='+n+'&years='+y+'&da='+da+'&bene='+bene+'&tec='+tec);
	} else {
		$("#scar").load('script/scarico.php?years='+y+'&da='+da+'&bene='+bene+'&tec='+tec);
	}
	
	changebene();
	
}
function up_page(url){
	$("#scar").load('script/scarico.php'+url);
	changebene();
}

function remove_scar(id){
	var req = window.confirm("Intendi davero rimuovere il record ed eventuali file?\n(Potrebbe influire sulle statistiche)");
	var cur_row = <?php echo $nr; ?>;
	var x_pag = "<?php echo $x_pag; ?>";
	
	var y = document.getElementById("years").value;
	var da = document.getElementById("da").value;
	var bene = document.getElementById("Beni").value;
	var tec = document.getElementById("Tecnici").value;
	
	if (req == true){
		
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "script/scar_del.php"); 
		xhr.onload = function(event){
			if (event.target.response == "err"){
				alert("Errore");
			} else {
				
				if(x_pag !== "ALL"){
				
					if(cur_row == 1){
						$("#scar").load('script/scarico.php?x_pag=<?php echo $x_pag; ?>&pag=<?php echo $pag-1; ?>&years='+y+'&da='+da+'&bene='+bene+'&tec='+tec);
					} else {
						$("#scar").load('script/scarico.php?x_pag=<?php echo $x_pag; ?>&pag=<?php echo $pag; ?>&years='+y+'&da='+da+'&bene='+bene+'&tec='+tec);
					}
				} else {
					$("#scar").load('script/scarico.php?x_pag=ALL&years='+y+'&da='+da+'&bene='+bene+'&tec='+tec);
				}
				
				changebene();
			}
		};
		xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhr.send("id="+id);
	}
}

function changebene(){
	if(document.getElementById("da").value != "ALL"){
		setTimeout(function () {
			updatebeni(document.getElementById("da").value);
			document.getElementById("Beni").options[0].disabled = false; 
		}, 300);
	}
}
</script>
<?php
$c->close();
?>