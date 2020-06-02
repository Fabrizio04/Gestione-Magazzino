<?php require_once '../core/config.inc.php'; ?>
<table align="center">
  <thead>
    <tr>
      <td class="tab_tit" scope="col">BENE</td>
	  <td class="tab_tit" scope="col">TOTALE</td>
	  <td class="tab_tit" scope="col">LAST UPDATE</td>
	</tr>
  </thead>
  
  <tbody>
	<?php
	$c = new mysqli($host,$username,$password,$database);
	$q = $c->query("SELECT * FROM etichette");

	while ($d = $q->fetch_array()){
		
		$q2 = $c->query('SELECT SUM(totale) FROM magazzini WHERE bene_et_id='.$d['id'].'');
		
		$q3 = $c->query('SELECT dataora FROM carico WHERE bene_et_id='.$d['id'].' ORDER BY id DESC LIMIT 1');
		$q4 = $c->query('SELECT dataora FROM scarico WHERE bene_et_id='.$d['id'].' ORDER BY id DESC LIMIT 1');
		
		if ($q3->num_rows == 0 && $q4->num_rows == 0){
			$data = "";
		} else if ($q3->num_rows > 0 && $q4->num_rows == 0){
			$data3 = $q3->fetch_array();
			$data = date_format(new DateTime($data3['dataora']),'d/m/Y - H:i:s');
		} else if ($q3->num_rows == 0 && $q4->num_rows > 0){
			$data4 = $q4->fetch_array();
			$data = date_format(new DateTime($data4['dataora']),'d/m/Y - H:i:s');
		} else {
			$data3 = $q3->fetch_array();
			$data4 = $q4->fetch_array();
			$data3_3 = new DateTime($data3['dataora']);
			$data4_4 = new DateTime($data4['dataora']);
			if ($data3_3 > $data4_4)
				$data = date_format(new DateTime($data3['dataora']),'d/m/Y - H:i:s');
			else
				$data = date_format(new DateTime($data4['dataora']),'d/m/Y - H:i:s');
		}
		
		
		echo '<tr><td data-label="BENE">'.$d['campo'].'</td>';
		
		if($q2->num_rows != 0){
			while ($d2 = $q2->fetch_array()){
				echo '<td data-label="TOTALE">';
				if($d2[0]) echo $d2[0]; else echo '0';
				echo '</td><td data-label="UPDATE">';
				if($data) echo $data; else echo 'N/D';
				echo '</td>';
				echo '</tr>';
			}
		}
	}

	?>
  </tbody>
  
</table>
<?php
$c->close();
?>