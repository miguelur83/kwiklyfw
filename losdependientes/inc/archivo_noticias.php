<div id="archivo">
  <h2>Archivo de Noticias</h2>
	<?php
		$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		$prev_year = '';
		$prev_month = '';
		unset($month);
		$first = 1;
		$noticia = new Noticia();
		if($noticias = $noticia->getAll("fecha", 1, "publicar='1'", 100)){ //las 100 ultimas noticias
			//echo "<pre>".print_r($noticias,true)."</pre>";
			foreach($noticias as $noticia){
				$date = explode("-", $noticia['fecha']);
				$year = $date[0];
				$month = $date[1];
				$month_str = $date[0]."-".$date[1];
				//echo $month_str."<br/>";
				
				if($year != $prev_year){
					if (! $first){
						echo '<p>&nbsp;</p>';
					} else {
						$first = 0;
					}
					echo '<h3>'.$year.'</h3>';
					$prev_year = $year;
				}
				if($month != $prev_month){
					echo '<p><a href="noticias.php?mes='.$month_str.'">- '.$meses[$month-1].'</a></p>';
					$prev_month = $month;
				}
				
				/*
				$timestamp = strtotime($month);
				echo $dias[date('w', $timestamp)]." ".date('d', $timestamp)." de ".$meses[date('n', $timestamp)-1]. " ".date('Y', $timestamp)."<br/>";
				echo strtoupper($meses[date('n', $timestamp)-1]. " ".date('Y', $timestamp)."<br/>");
				*/
			}
		} else {
			echo "<h3>No hay noticias cargadas.</h3>";
		}
	?>
</div>