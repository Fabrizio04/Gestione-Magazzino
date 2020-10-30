<?php
require_once '../core/config.inc.php';
$c = new mysqli($host,$username,$password,$database);
?>
<table align="center">
  
  <tbody>
	<?php
	$q = $c->query("SELECT * FROM etichette ORDER BY campo");
	
	while ($d = $q->fetch_array()){
	
		echo '<tr><td data-label="'.$d['campo'].'"><a href="javascript:remove_bene('.$d['id'].');" style="color:red;"><span class="fa fa-times" aria-hidden="true"></span></a> <a href="javascript:nome('.$d['id'].');" style="color:black;"><span class="fa fa-pencil" aria-hidden="true"></span></a> <a onclick="loadform('.$d['id'].',\''.$d['campo'].'\')" rel="modal:open" href="#magaz_tag" style="color:black;"><span class="fa fa-truck" aria-hidden="true"></span></a> <span class="nome_tec" id="'.$d['id'].'">'.$d['campo'].'</span></td></tr>';
		
	}
	?>
  </tbody>
  
</table>
<?php
$c->close();
?>