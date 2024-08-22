<?php	
  include ("inc/head.php");
  $GLOBALS['interna'] = true;
  include ("inc/header.php");
?>  
    <div id="centro" class="noticias">
      <div id="izquierda">
		<?php
		$dias = array("Domingo","Lunes","Martes","Mi&eacute;rcoles","Jueves","Viernes","S&aacute;bado");
		$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
				$noticia = new Noticia();
				$month = '';
				if(! isset($_GET['mes'])){
					if($noticias = $noticia->getAll("fecha", 1, "publicar='1'", 1)){ //la ultima noticia
						$date = explode("-", $noticias[0]['fecha']);
						$month = $date[0]."-".$date[1];
						//echo $month."<br/>";
						
						
						/*
						$timestamp = strtotime($month);
						echo $dias[date('w', $timestamp)]." ".date('d', $timestamp)." de ".$meses[date('n', $timestamp)-1]. " ".date('Y', $timestamp)."<br/>";
						echo strtoupper($meses[date('n', $timestamp)-1]. " ".date('Y', $timestamp)."<br/>");
						*/
					} else {
						$month = date('Y-n');
					}
				} else {
					$month = $_GET['mes'];
				}
				if (! $noticias = $noticia->getAll("fecha", 1, "fecha LIKE '".$month."%' AND publicar='1'")){ //las noticias del mes
					$no_news = 1;
				}
				//echo "<pre>".print_r($noticias,true)."</pre>";
				
				
			?>
        <div id="noticias">
          <div class="barra_titulo">
            <span></span>
            <h1>Noticias</h1>
            <span class="tail"></span>
          </div>
          <div id="noticias_header">
			<p class="month"><?php $timestamp = strtotime($month); echo strtoupper($meses[date('n', $timestamp)-1]. " ".date('Y', $timestamp)); ?></p>
		</div>
          <div id="listado_noticias">
			<?php
				if ($no_news){
					echo "<p>No hay noticias cargadas.</p>";
				}
				foreach($noticias as $noticia){
					$timestamp = strtotime($noticia['fecha']);
					$fecha_str = $dias[date('w', $timestamp)]." ".date('d', $timestamp)." de ".$meses[date('n', $timestamp)-1]. " ".date('Y', $timestamp);
					$pais = new Pais($noticia['pais']);
					echo '<div class="noticia_blurb">
						<p class="fecha_lugar">'.$fecha_str.' - '.$pais->getField('nombre').'</p>
						<a href="noticia.php?id='.$noticia['id'].'">
							<h2 class="noticia_titulo">'.$noticia['titulo'].'</h2>
						</a>
					</div>';
				}
			?>
          </div>
        </div>
      </div>
      <div id="banners">              
        <?php include("inc/archivo_noticias.php"); ?>
        <?php include("inc/banners.php"); ?>
      </div>
    </div>
    <div class="push"></div>
  </div>
<?php
  include("inc/footer.php");
?>