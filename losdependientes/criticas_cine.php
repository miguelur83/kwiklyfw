<?php
  include ("inc/head.php");
  $GLOBALS['interna'] = true;
  include ("inc/header.php");
  
  $una_critica = new Critica();
  $order_by = "criticas.id DESC";
  
  if(isset($_GET['orden'])){
    $orden = $_GET['orden'];
    switch ($orden){
        case "populares":
            $order_by = "criticas.popularidad DESC";
        break;
        case "mejores_calificadas":                  
            $order_by = "criticas.calificacion DESC";
        break;
        case "por_critico":                   
            $order_by = "personas.nombre ASC";
        break;
    }
  }
  $criticas_count = $GLOBALS['db']->execute('SELECT COUNT(`criticas`.id) as criticas_count FROM `criticas` INNER JOIN `peliculas` ON `criticas`.pelicula = `peliculas`.id INNER JOIN personas ON criticas.critico = personas.id WHERE `peliculas`.tipo = 0 AND publicar=1 ORDER BY '.$order_by);
  $arr = mysql_fetch_array($criticas_count);
  $resultados = $arr['criticas_count'];
  
  	$per_page = 5;
  	if(! isset($_GET['page'])){
  		$page = 1;
	} else {
  		$page = $_GET['page'];
	}
	$prev_page = $page - 1;
	if ($resultados > $page * $per_page){ $next_page = $page + 1; } else { $next_page = 0; }
	$page_to = $page * $per_page;
	$page_from = $page_to - $per_page + 1;
	if ($page_to > $resultados){ $page_to = $resultados; } 
	if ($page_from > $resultados){ $page_from = $resultados; } 
	$limit = $per_page;
	$offset = $per_page * ($page - 1);
  
  $criticas_results = $GLOBALS['db']->execute('SELECT `criticas`.id as critica, peliculas.id as pelicula FROM `criticas` INNER JOIN `peliculas` ON `criticas`.pelicula = `peliculas`.id INNER JOIN personas ON criticas.critico = personas.id WHERE `peliculas`.tipo = 0 AND publicar=1 ORDER BY '.$order_by.' LIMIT '.$offset.', '.$limit);
?>
<div id="centro" class="criticas_cine">
      <div id="criticas_cine">
        <div class="barra_titulo">
          <span></span>
          <h1>Cr&iacute;ticas de Cine</h1>
          <span class="tail"></span>
          <div class="filtros">
            <a id="populares" href="?orden=populares">Populares</a>
            <a id="mejores_calificadas" href="?orden=mejores_calificadas">Mejores Calificadas</a>
            <a id="critico" href="?orden=por_critico">Por Cr&iacute;tico</a>
          </div>
        </div>
        <div class="search_results">   
          <div class="pagination">
            <p class="resultados">Mostrando resultados <?=$page_from?> - <?=$page_to?> de <?= $resultados ?></p>
            <a href="<?=(($prev_page != 0)?"?page=".$prev_page:"#").((isset($orden))?'&orden='.$orden:"")?>">Prev</a>
            <p class="current_page"><?=$page?></p>
            <a href="<?=(($next_page != 0)?"?page=".$next_page:"#").((isset($orden))?'&orden='.$orden:"")?>">Next</a>
          </div>
          <div id="results_container">
            <div class="results_header">
              <p class="info">Pel&iacute;cula</p>
              <p class="calificacion">Calificaci&oacute;n</p>
              <p class="critico">Cr&iacute;tico</p>
              <p class="genero">G&eacute;nero</p>
              <p class="director">Director</p>
              <p class="anio">A&ntilde;o</p>
            </div>
            <?php 
            $odd = 1;
            while ($row = mysql_fetch_array($criticas_results)){
                $critica = new Critica($row['critica']);
                $pelicula = new Pelicula($row['pelicula']); 
            ?>
            <div class="result_item <?=($odd?"odd":"even")?>">
                <?php if ($odd){$odd = 0;}else{$odd=1;} ?>                                                
              <?php
                $afiche = '';
                if ($pelicula->getField('afiche') != ''){
                    $afiche = "uploads/afiche_pelicula/inner/".$pelicula->getField('afiche');
                } else {
                    $afiche = "img/no_disponible_chico.png";
                }
                ?>
                <a href="critica.php?critica_id=<?= $critica->getField('id')?>"><img src="<?= $afiche ?>" alt="" class="result_image" /></a>
              <div class="info">                            
                <a href="critica.php?critica_id=<?= $critica->getField('id')?>"><h2><?= $pelicula->getField('titulo') ?></h2></a>
                <p class="sinopsis">
                  <?php
                    $mostrar = strip_tags($critica->getField('contenido'), "<b><i><strong>"); 
                    if (strlen($mostrar) > 180){ 
                        $mostrar = substr($mostrar, 0, 180)."...";
                    } 
                    echo $mostrar;
                    ?><br />
                  <span><strong>Reparto:</strong> <?= $pelicula->getElencoString()?><br /></span>
                </p>
              </div>
              <p class="calificacion">
                <?= $critica->getField('calificacion')?>
              </p>
              <p class="critico">
                <?= $critica->getObject('critico')->toString()?>
              </p>
              <p class="genero">
                <?= $pelicula->getObject('genero')->toString()?>
              </p>
              <p class="director">
                <?= $pelicula->getObject('director')->toString()?>
              </p>
              <p class="anio">
                <?= $pelicula->getField('anio')?>
              </p>
            </div>
            <?php } ?>
            
          </div>
          <div class="pagination">
            <p class="resultados">Mostrando resultados <?=$page_from?> - <?=$page_to?> de <?= $resultados ?></p>
            <a href="<?=(($prev_page != 0)?"?page=".$prev_page:"#").((isset($orden))?'&orden='.$orden:"")?>">Prev</a>
            <p class="current_page"><?=$page?></p>
            <a href="<?=(($next_page != 0)?"?page=".$next_page:"#").((isset($orden))?'&orden='.$orden:"")?>">Next</a>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php
  include("inc/footer.php");
?>