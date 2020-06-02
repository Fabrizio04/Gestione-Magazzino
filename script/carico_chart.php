<!DOCTYPE html>
<html>
<head>
<link rel="shortcut icon" type="image/jpg" href="../img/magico.jpg" />
<title>Statistiche - Carico</title>
</head>
<?php require_once '../core/config.inc.php'; ?>
<?php

	$id = isset($_GET['id']) ? $_GET['id'] : "50";
	$anno = isset($_GET['years']) ? $_GET['years'] : date("Y");
	$c = new mysqli($host,$username,$password,$database);
	$i = 1;
	$da = isset($_GET['da']) ? $_GET['da'] : "ALL";
	$a = isset($_GET['a']) ? $_GET['a'] : "ALL";
	$bene = isset($_GET['bene']) ? $_GET['bene'] : "ALL";
	$tecnico = isset($_GET['tec']) ? $_GET['tec'] : "ALL";

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
		var MONTHS = ['Gen','Feb','Mar','Apr','Mag','Giu','Lug','Ago','Set','Ott','Nov','Dic'];
		var color = Chart.helpers.color;
		var barChartData = {
			labels: ['Gen','Feb','Mar','Apr','Mag','Giu','Lug','Ago','Set','Ott','Nov','Dic'],
			datasets: [
			<?php
			
			function conteggio($bene_id){
				$count = "";
				$where = "";
				
				if ($GLOBALS['da'] != "ALL") $where .= " AND da_magaz_id = '{$GLOBALS['da']}'";
				if ($GLOBALS['a'] != "ALL") $where .= " AND magaz_id = '{$GLOBALS['a']}'";
				if ($GLOBALS['tecnico'] != "ALL") $where .= " AND tecnico_id = '{$GLOBALS['tecnico']}'";

				$c = new mysqli($GLOBALS['host'],$GLOBALS['username'],$GLOBALS['password'],$GLOBALS['database']);
				
				for($j = 1; $j < 13; $j++){
					if ($j < 10) $j = "0".$j;
					$q = $c->query("SELECT SUM(quantit) AS quantit FROM carico WHERE bene_et_id = '$bene_id' AND dataora LIKE '%{$GLOBALS['anno']}-{$j}%'{$where}");
					
					if ($q->num_rows > 0){
						$d = $q->fetch_array();
						$count .= $d['quantit'].",";

					} else $count .= '0,';

				}
				$c->close();
				return $count;
			}
			
			if ($bene != "ALL") {

				$q2 = $c->query("SELECT * FROM etichette WHERE id = '$bene'");
				$d2 = $q2->fetch_array();

				echo "{
					label: '{$c->real_escape_string($d2['campo'])}',
					backgroundColor: color(window.chartColors.colore{$i}).alpha(0.5).rgbString(),
					borderColor: window.chartColors.colore{$i},
					borderWidth: 1,
					data: [".conteggio($bene)."]
				},";

			} else {

				$q2 = $c->query("SELECT * FROM etichette");
				
				while ($d2 = $q2->fetch_array()){
					
					echo "{
					label: '{$c->real_escape_string($d2['campo'])}',
					backgroundColor: color(window.chartColors.colore{$i}).alpha(0.5).rgbString(),
					borderColor: window.chartColors.colore{$i},
					borderWidth: 1,
					data: [".conteggio($d2['id'])."]
				},";
				$i++;

				}

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