<table align="center">
  
  <tbody>
	<?php
	$q = $c->query("SELECT * FROM magaz WHERE nome<>'ACQUISTO' ORDER BY nome");
	
	while ($d = $q->fetch_array()){
		

		echo '<tr><td data-label="'.$d['nome'].'"><a href="javascript:remove_mag('.$d['id'].');" style="color:red;"><span class="fa fa-times" aria-hidden="true"></span></a> <a href="javascript:nome('.$d['id'].');" style="color:black;"><span class="fa fa-pencil" aria-hidden="true"></span></a> <span class="nome_tec" id="'.$d['id'].'">'.$d['nome'].'</span></td>
		
		<td style="text-align:center;">
		<select id="mag'.$d['id'].'" class="mySelect" onchange="change_position('.$d['id'].')">';
		
		if($d['fam'] == '0'){
			echo '<option value="0">Main</option>';

			$q2 = $c->query("SELECT * FROM magaz WHERE nome<>'ACQUISTO' AND fam='0' AND id<>'{$d['id']}' ORDER BY nome");

			while ($d2 = $q2->fetch_array()){
				echo '<option value="'.$d2['id'].'">'.$d2['nome'].'</option>';
			}
		} else {
			
			$q2 = $c->query("SELECT * FROM magaz WHERE nome<>'ACQUISTO' AND id='{$d['fam']}'");
			$d2 = $q2->fetch_array();
			
			echo '<option value="'.$d2['id'].'">'.$d2['nome'].'</option>';

			$q3 = $c->query("SELECT * FROM magaz WHERE nome<>'ACQUISTO' AND id<>'{$d['fam']}' AND fam='0'");

			while ($d3 = $q3->fetch_array()){
				echo '<option value="'.$d3['id'].'">'.$d3['nome'].'</option>';
			}

			echo '<option value="0">Main</option>';
		}
		
		echo '</select>
		</td>
		</tr>';
		
	}
	?>
  </tbody>
  
</table>