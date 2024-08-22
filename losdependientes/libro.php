<?php
  $opengraph['tipo'] = 'libro';
  $opengraph['id'] = $_GET['libro_id'];   
  
  include ("inc/head.php");
  $GLOBALS['interna'] = true;
  $seccion_libros = true;
  include ("inc/header.php");  
   
  $libro = null;
  if (isset($_GET['libro_id'])){
    $libro = new Libro($_GET['libro_id']);
  } else {
    die();
  }
?>    
    <div id="centro" class="ficha_libro">
      <div id="izquierda">
        <div id="ficha_libro">
          <div class="barra_titulo">
            <span></span>
            <h1>Ficha Libro</h1>
            <span class="tail"></span>
          </div>
          <h1 class="titulo_libro"><?= $libro->getField('titulo').' ('.$libro->getField('anio').')'?></h1>
          <div class="ficha">                                                            
          <?php
            $tapa = '';
            if ($libro->getField('tapa') != ''){
                $tapa = "uploads/tapa_libro/home/".$libro->getField('tapa');
            } else {
                $tapa = "img/no_disponible_grande.jpg";
            }
            ?>                             
            <img src="<?= $tapa ?>" class="afiche_pelicula" alt="Evil Dead 2" />
            <div class="info_ficha">
              <h2>T&iacute;tulo:</h2>
              <p><?= $libro->getField('titulo')?></p>
              <h2>Autor:</h2>
              <p><?= $libro->getObject('autor')->toString()?></p>
              <h2>G&eacute;nero:</h2>
              <p><?= $libro->getObject('genero')->toString()?></p>
              <h2>A&ntilde;o:</h2>
              <p><?= $libro->getField('anio')?></p>
              <h2>Sinopsis:</h2>
              <?= $libro->getField('sinopsis')?>
              <a href="uploads/<?= $libro->getField('archivo_PDF')?>" target='_blank' class="libro_link">Leer</a>
            </div>
          </div>
        </div>
        
        <div style="margin-top:60px;" class="fb-comments" data-href="<?=$site_root?>libro.php?libro_id=<?=$libro->getField('id')?>" data-num-posts="10" data-width="756" data-colorscheme="dark"></div>
      </div>
      <div id="banners">
      	<div style="margin-bottom:20px;" class="fb-like" data-href="<?=$site_root?>libro.php?libro_id=<?=$libro->getField('id')?>" data-send="false" data-layout="box_count" data-width="200" data-show-faces="true" data-colorscheme="dark"></div>
        <?php include("inc/banners.php"); ?> 
      </div>
    </div>
  </div>
<?php
  include("inc/footer.php");
?>