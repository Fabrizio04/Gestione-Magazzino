<!DOCTYPE html>
<html>
<head>
<link rel="shortcut icon" type="image/jpg" href="../img/magico.jpg" />
<title>Statistiche - Beni</title>
</head>
<?php require_once '../core/config.inc.php'; ?>
<?php

	$id = isset($_GET['id']) ? $_GET['id'] : "50";

	$c = new mysqli($host,$username,$password,$database);
	$q = $c->query("SELECT * FROM etichette");
	$etichette = "";
	$i = 1;
	while ($d = $q->fetch_array()){
		$etichette .= "'".$d['campo']."',";
	}
?>
<body style="background-color: #d9d9d9;">
<style>
	canvas {
		-moz-user-select: none;
		-webkit-user-select: none;
		-ms-user-select: none;
	}
	</style>
<script src="../js/Chart.min.js"></script>
<script src="../js/utils.js"></script>
<div align="center">
	<div id="container" style="width: <?php echo $id; ?>%;">
		<canvas id="canvas"></canvas>
	</div>	
</div>

	<script>
		var MONTHS = [<?php echo substr($etichette, 0, -1); ?>];
		var color = Chart.helpers.color;
		var barChartData = {
			labels: [<?php echo substr($etichette, 0, -1); ?>],
			datasets: [
			<?php
			
			function conteggio($magaz_id){
				$count = "";
				
				$c = new mysqli($GLOBALS['host'],$GLOBALS['username'],$GLOBALS['password'],$GLOBALS['database']);
				
				$q = $c->query("SELECT * FROM etichette");
	
				while ($d = $q->fetch_array()){
					
					$q2 = $c->query('SELECT * FROM magazzini WHERE magaz_id='.$magaz_id.' AND bene_et_id='.$d['id'].'');


					if ($q2->num_rows > 0){
						while ($d2 = $q2->fetch_array()){
							
							$count .= $d2['totale'].",";
							
						}
					} else $count .= '0,';
					
				}
				
				$c->close();
				return $count;
				
			}
			
			$q2 = $c->query("SELECT * FROM magaz WHERE nome<>'ACQUISTO'");
			while ($d2 = $q2->fetch_array()){
				
				$count = conteggio($d2['id']);
				$hidden = "false";
				if($count == "0,0,0,0,0,0,0,0,0,0,0,") $hidden = "true";
				
				echo "{
				label: '{$c->real_escape_string($d2['nome'])}',
				backgroundColor: color(window.chartColors.colore{$i}).alpha(0.5).rgbString(),
				borderColor: window.chartColors.colore{$i},
				borderWidth: 1,
				data: [".$count."],
				hidden: $hidden
			},";
			$i++;
			}
			?>
			]

		};

		window.onload = function() {
			var ctx = document.getElementById('canvas').getContext('2d');
			window.myBar = new Chart(ctx, {
				type: 'bar',
				data: barChartData,
				options: {
					responsive: true,
					legend: {
						position: 'top',
					},
					scales: {
						yAxes: [{
							ticks: {
								suggestedMin: 0
							}
						}]
					}
				}
				
			});

		};



	</script>
	<?php
$c->close();
?>
</body>

</html>