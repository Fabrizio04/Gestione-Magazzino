<header style="position: fixed;">
    <h1 id="barra"></h1>
	<nav class="nav">
		<ul id="menu">
			<li><a href="./"><span class="fa fa-home"></span> Home</a></li>
			<!-- Dynamic menu -->
			<?php
			$li = '';
			$content = '';
			$c = new mysqli($host,$username,$password,$database);
			$q = $c->query("SELECT * FROM magaz WHERE nome<>'ACQUISTO' AND fam='0'");
			
			if ($q->num_rows > 0){
				while($d = $q->fetch_array()){
					
					$q2 = $c->query("SELECT * FROM magaz WHERE nome<>'ACQUISTO' AND fam={$d['id']}");
					if ($q2->num_rows > 0){
						$sub = 'class="nav-submenu"';
						while($d2 = $q2->fetch_array()){
							$content .= '<li><a href="magazzino.php?id='.$d2['id'].'"><span class="fa fa-briefcase" aria-hidden="true"></span> '.$d2['nome'].'</a></li>';
						}
					} else {
						$sub = '';
						$content = '';
					}
					
					if ($sub == "") { $href='magazzino.php?id='.$d['id'].''; $main=''; $faicon='briefcase'; }
					else { $href="#"; $main='<li><a href="magazzino.php?id='.$d['id'].'"><span class="fa fa-briefcase" aria-hidden="true"></span> Main</a></li>'; $faicon='folder-open'; }//briefcase
					
					$li .= '<li '.$sub.'><a href="'.$href.'" onclick="javascript: return true;"><span class="fa fa-'.$faicon.'" aria-hidden="true"></span> '.$d['nome'].'</a><ul>'.$main.''.$content.'</ul></li>';
					$content = '';
				}
			}
			
			echo $li;
			?>
			<!-- -->
			<li class="nav-submenu"><a href="#"><span class="fa fa-database"></span> Dati</a>
				<ul>
					<li><a href="form.php?id=carico"><span class="fa fa-upload" aria-hidden="true"></span> Carico</a></li>
					<li><a href="form.php?id=scarico"><span class="fa fa-download" aria-hidden="true"></span> Scarico</a></li>
					<li class="nav-submenu nav-right"><a href="#"><span class="fa fa-list-alt" aria-hidden="true"></span> Reports</a>
						<ul>
							<li><a href="carico.php"><span class="fa fa-list-alt"></span> Carico</a></li>
							<li><a href="scarico.php"><span class="fa fa-list-alt"></span> Scarico</a></li>
						</ul>
					</li>
					<li class="nav-submenu nav-right"><a href="#"><span class="fa fa-bar-chart" aria-hidden="true"></span> Statistiche</a>
						<ul>
							<li><a href="stat_car.php"><span class="fa fa-bar-chart"></span> Carico</a></li>
							<li><a href="stat_scar.php"><span class="fa fa-bar-chart"></span> Scarico</a></li>
						</ul>
					</li>
				</ul>
			</li>
			<li class="nav-submenu"><a href="#"><span class="fa fa-cog"></span> Modifica</a>
				<ul>
					<li><a href="magazzini.php"><span class="fa fa-truck" aria-hidden="true"></span> Magazzini</a></li>
					<li><a href="tecnici.php"><span class="fa fa-users" aria-hidden="true"></span> Tecnici</a></li>
					<li><a href="beni.php"><span class="fa fa-laptop"></span> Beni</a></li>
				</ul>
			</li>
			<li class="nav-submenu"><a href="#"><span class="fa fa-info-circle"></span> About</a>
				<ul>
					<li><a href="manuale/Gestione Magazzino v1.2.pdf" target="_blank"><span class="fa fa-book"></span> Manuale</a></li>
					<li><a href="info.php"><span class="fa fa-id-card"></span> Contatti</a></li>
					<li><a href="licenza.php"><span class="fa fa-user"></span> Licenza</a></li>
				</ul>
			</li>
		</ul>
	</nav>
</header>

<a href="#" class="nav-button">Menu</a>
<a href="#" class="nav-close">Close Menu</a>