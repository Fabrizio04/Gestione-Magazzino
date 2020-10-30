<?php
require_once '../core/config.inc.php';
if (((!isset($_GET['id']))) || ($_GET['id'] == "")) header("Location: ./");
$c = new mysqli($host,$username,$password,$database);
?>
<table align="center">
  <thead>
    <tr>
      <td class="tab_tit" scope="col">BENE</td>
	  <td class="tab_tit" scope="col">TOTALE</td>
	  <td class="tab_tit" scope="col">NOTE</td>
	</tr>
  </thead>
  
  <tbody>
	<?php
	$q = $c->query('SELECT * FROM etichette WHERE magaz_tag LIKE \'%-'.$_GET['id'].'-%\' OR magaz_tag LIKE \'%ALL%\' ORDER BY campo');
	
	while ($d = $q->fetch_array()){
		
		$q2 = $c->query('SELECT * FROM magazzini WHERE magaz_id='.$_GET['id'].' AND bene_et_id='.$d['id'].'');
	
		echo '<tr><td data-label="BENE">'.$d['campo'].'</td>';
	
	
		if ($q2->num_rows > 0){
			while ($d2 = $q2->fetch_array()){
				echo '<td data-label="TOTALE">';
				echo $d2['totale'];
				echo '</td>';
				
				echo '<td data-label="NOTE">';
				echo '<a href="javascript:note('.$d2['id'].');" style="color:black;"><span class="fa fa-pencil" aria-hidden="true"></span></a> <span id="'.$d2['id'].'">'.$d2['note'].'</span>';
				echo '</td>';
				
			}
		} else echo '<td data-label="TOTALE">0</td><td data-label="NOTE"><a href="javascript:note_set('.$d['id'].');" style="color:black;"><span class="fa fa-pencil" aria-hidden="true"></span></a></td>';
	
		echo '</tr>';
		
	}
	?>
  </tbody>
  
</table>
<?php
$c->close();
?>