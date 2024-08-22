<?php	
  include ("inc/head.php");
  $GLOBALS['interna'] = true;
  include ("inc/header.php");
?>  
    <div id="centro" class="noticias">
      <div id="izquierda">
        <div id="noticias">
          <div class="barra_titulo">
            <span></span>
            <h1>Noticias</h1>
            <span class="tail"></span>
          </div>
          <div id="noticias_header">
		</div>
          <div id="texto_noticia">
			<?php
				$dias = array("Domingo","Lunes","Martes","Mi&eacute;rcoles","Jueves","Viernes","S&aacute;bado");
				$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
				
				$noticia = new Noticia($_GET['id']);
				if($noticia->getField('publicar')==1){
					$timestamp = strtotime($noticia->getField('fecha'));
					$fecha_str = $dias[date('w', $timestamp)]." ".date('d', $timestamp)." de ".$meses[date('n', $timestamp)-1]. " ".date('Y', $timestamp);
					$pais = new Pais($noticia->getField('pais'));
						
			?>
				<div class="noticia_blurb">
					<p class="fecha_lugar"><?php echo $fecha_str;?> - <?php echo $pais->getField('nombre');?></p>
					<h2 class="noticia_titulo"><?php echo $noticia->getField('titulo');?></h2>
				</div>
				<?php
					if($noticia->getField('imagen') != ''){
						echo '<img src="uploads/imagen_noticia/thumb/'.$noticia->getField('imagen').'" />';
					} ?>
				<?php echo $noticia->getField('texto');?>
				<p>&nbsp;</p>
				<?php if ($noticia->getField('video_ID')){ ?>
					<div style="border:10px solid #101010;width:420px;height:315px;">
						<iframe width="420" height="315" src="http://www.youtube.com/embed/<?php echo $noticia->getField('video_ID');?>" frameborder="0" allowfullscreen anotations='0'></iframe>
					</div>
				<?php } ?>
			<?php } ?>
          </div>
        </div>
      </div>
      <div id="banners">              
        <?php include("inc/banners.php"); ?>
        <?php include("inc/archivo_noticias.php"); ?>
      </div>
    </div>
    <div class="push"></div>
  </div>
<?php
  include("inc/footer.php");
?>