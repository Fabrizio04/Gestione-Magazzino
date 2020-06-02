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
			
			$q = $c->query("SELECT * FROM magaz WHERE fam='0'");

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

/* Select A */

$a2 = isset($_GET['a']) ? $_GET['a'] : "ALL";

if ($a2 != "ALL") $where .= " AND magaz_id = '$a2'";

	echo ' <select id="a" class="mySelect" onchange="reload_tot_row()">
	<option value="ALL">A:</option>';
			
			$q = $c->query("SELECT * FROM magaz WHERE fam='0' AND nome<>'ACQUISTO'");

			while($d = $q->fetch_array()){
				
				if($a2 == $d['id'])
					$selected='selected="selected"';
				else
					$selected='';
				
				echo '<option value="'.$d['id'].'" '.$selected.'>'.$d['nome'].'</option>';
				
				$q2 = $c->query("SELECT * FROM magaz WHERE fam='{$d['id']}'");
				while($d2 = $q2->fetch_array()){
					if($a2 == $d2['id'])
						$selected2='selected="selected"';
					else
						$selected2='';
					echo '<option value="'.$d2['id'].'" '.$selected2.'>'.$d['nome'].' / '.$d2['nome'].'</option>';
				}
			}
			
			echo '</select>';

/* Fine select A */

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
	$q = $c->query("SELECT * FROM carico $where ORDER BY id DESC");
	$all_pages = 10;
	
} else {
	
	if(!$pag || !is_numeric($pag)) $pag = 1;
	$q = $c->query("SELECT * FROM carico $where ORDER BY id DESC");
	$all_rows = $q->num_rows;
	$all_pages = ceil($all_rows / $x_pag);
	$first = ($pag - 1) * $x_pag;

	$q = $c->query("SELECT * FROM carico $where ORDER BY id DESC LIMIT $first, $x_pag");
	
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
	
	if($x_pag != "ALL"){
	
		if ($all_pages > 1){
			
			echo '<br><div class="row">';
			
		  if ($pag > 1){
			  echo '<button id="arrow" onclick="up_page(\'?pag='.($pag - 1).'&x_pag='.$x_pag.'&years='.$years.'&da='.$da2.'&a='.$a2.'&bene='.$bene2.'&tec='.$tecnico2.'\')"><span class="fa fa-arrow-left" aria-hidden="true"></span> Prev</button> ';
		  } 
		  if ($all_pages > $pag){
			  echo '<button id="arrow" onclick="up_page(\'?pag='.($pag + 1).'&x_pag='.$x_pag.'&years='.$years.'&da='.$da2.'&a='.$a2.'&bene='.$bene2.'&tec='.$tecnico2.'\')">Next <span class="fa fa-arrow-right" aria-hidden="true"></span></button>';
		  }
		  echo '</div><p><a href="javascript:load_page();"><strong>'.$pag.' / '.$all_pages.'</strong></a></p><br>';
		}
	}
	
	echo '<input type="hidden" value="'.$pag.'" id="n_pag">
	<input type="hidden" value="'.$x_pag.'" id="x_pag">
	<input type="hidden" value="'.$years.'" id="anno">
	<input type="hidden" value="'.$da2.'" id="da_magaz">
	<input type="hidden" value="'.$a2.'" id="a_magaz">
	<input type="hidden" value="'.$bene2.'" id="bene_id">
	<input type="hidden" value="'.$tecnico2.'" id="tecnico_id">
	<br>';
	
	
} else {
	echo '<h3>Nessun Log di Carico</h3>';
}

/* Fine select righe + Query */

?>
<script>
function load_page(){
	var num = prompt ("Inserisci la pagina:", "");
	var num2 = parseInt(num);
	
	var y = document.getElementById("years").value;
	var da = document.getElementById("da").value;
	var a = document.getElementById("a").value;
	var bene = document.getElementById("Beni").value;
	var tec = document.getElementById("Tecnici").value;

	if(num2 >= 1 && num2 <= <?php echo $all_pages; ?>){
		$("#car").load('script/carico.php?x_pag=<?php echo $x_pag; ?>&pag='+num2+'&years='+y+'&da='+da+'&a='+a+'&bene='+bene+'&tec='+tec);
		location.href="#car";
	}
}

function reload_tot_row(){
	var y = document.getElementById("years").value;
	var da = document.getElementById("da").value;
	var a = document.getElementById("a").value;
	var bene = document.getElementById("Beni").value;
	var tec = document.getElementById("Tecnici").value;
	
	if(document.getElementById("tot_row") != null){
		var n = document.getElementById("tot_row").value;
		$("#car").load('script/carico.php?x_pag='+n+'&years='+y+'&da='+da+'&a='+a+'&bene='+bene+'&tec='+tec);
	} else {
		$("#car").load('script/carico.php?years='+y+'&da='+da+'&a='+a+'&bene='+bene+'&tec='+tec);
	}
	
}
function up_page(url){
	$("#car").load('script/carico.php'+url);
}

function remove_car(id){
	var req = window.confirm("Intendi davero rimuovere il record ed eventuali file?\n(Potrebbe influire sulle statistiche)");
	var cur_row = <?php echo $nr; ?>;
	var x_pag = "<?php echo $x_pag; ?>";
	
	var y = document.getElementById("years").value;
	var da = document.getElementById("da").value;
	var a = document.getElementById("a").value;
	var bene = document.getElementById("Beni").value;
	var tec = document.getElementById("Tecnici").value;
	
	if (req == true){
		
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "script/car_del.php"); 
		xhr.onload = function(event){
			if (event.target.response == "err"){
				alert("Errore");
			} else {
				
				if(x_pag !== "ALL"){
				
					if(cur_row == 1){
						$("#car").load('script/carico.php?x_pag=<?php echo $x_pag; ?>&pag=<?php echo $pag-1; ?>&years='+y+'&da='+da+'&a='+a+'&bene='+bene+'&tec='+tec);
					} else {
						$("#car").load('script/carico.php?x_pag=<?php echo $x_pag; ?>&pag=<?php echo $pag; ?>&years='+y+'&da='+da+'&a='+a+'&bene='+bene+'&tec='+tec);
					}
				} else {
					$("#car").load('script/carico.php?x_pag=ALL&years='+y+'&da='+da+'&a='+a+'&bene='+bene+'&tec='+tec);
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