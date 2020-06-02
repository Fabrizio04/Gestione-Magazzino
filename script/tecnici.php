<?php
require_once '../core/config.inc.php';
$c = new mysqli($host,$username,$password,$database);
?>
<table align="center">
  
  <tbody>
	<?php
	$q = $c->query("SELECT * FROM tecnico ORDER BY nome");
	
	while ($d = $q->fetch_array()){
	
		echo '<tr><td data-label="'.$d['nome'].'"><a href="javascript:remove_tec('.$d['id'].');" style="color:red;"><span class="fa fa-times" aria-hidden="true"></span></a> <a href="javascript:nome('.$d['id'].');" style="color:black;"><span class="fa fa-pencil" aria-hidden="true"></span></a> <span class="nome_tec" id="'.$d['id'].'">'.$d['nome'].'</span></td></tr>';
		
	}
	?>
  </tbody>
  
</table>
<?php
$c->close();
?>