<?php
  include ("inc/head.php");
  $GLOBALS['interna'] = true;
  $seccion_libros = true;
  include ("inc/header.php");
  
  $un_libro = new Libro();
  $order_by = "libros.id DESC";
  /*if(isset($orden)){
    switch ($orden){
        case "populares":
            $order_by = "criticas.calificacion DESC";
        break;
        case "mejores_calificadas":                  
            $order_by = "criticas.calificacion DESC";
        break;
        case "por_critico":                   
            $order_by = "personas.nombre ASC";
        break;
    }
  } */
  $libros_count = $GLOBALS['db']->execute('SELECT COUNT(`libros`.id) as libros_count FROM `libros` WHERE publicar=1 ORDER BY '.$order_by);
  $arr = mysql_fetch_array($libros_count);
  $resultados = $arr['libros_count'];
  
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
  
  $libros_results = $GLOBALS['db']->execute('SELECT `libros`.id as libro FROM `libros` WHERE publicar=1 ORDER BY '.$order_by.' LIMIT '.$offset.', '.$limit);
?>
    <div id="centro" class="libros">
      <div id="libros">
        <div class="barra_titulo">
          <span></span>
          <h1>Libros</h1>
          <span class="tail"></span>
          <!--<div class="filtros">
            <a id="populares" href="#">Populares</a>
            <a id="mejores_calificadas" href="#">Mejores Calificadas</a>
            <a id="critico" href="#">Por Cr&iacute;tico</a>
          </div>-->
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
              <p class="info">Libro</p>
              <!--<p class="calificacion">Calificaci&oacute;n</p>--> 
              <p class="director">Autor</p>
              <p class="genero">G&eacute;nero</p>
              <p class="anio">A&ntilde;o</p>
            </div>       
            <?php 
            $odd = 1;
            while ($row = mysql_fetch_array($libros_results)){
                $libro = new Libro($row['libro']); 
            ?>
            <div class="result_item <?=($odd?"odd":"even")?>">
                <?php if ($odd){$odd = 0;}else{$odd=1;} ?>                                                    
                  <?php
                    $tapa = '';
                    if ($libro->getField('tapa') != ''){
                        $tapa = "uploads/tapa_libro/inner/".$libro->getField('tapa');
                    } else {
                        $tapa = "img/no_disponible_chico.png";
                    }
                    ?>                                                
              <a href="libro.php?libro_id=<?= $libro->getField('id')?>">
                <img src="<?= $tapa ?>" alt="" class="result_image" />
              </a>
              <div class="info">                            
                <a href="libro.php?libro_id=<?= $libro->getField('id')?>">
                <h2><?= $libro->getField('titulo')?></h2>
                </a>
                <p class="sinopsis">
                  <?php
                    $mostrar = strip_tags($libro->getField('sinopsis'), "<b><i><strong>"); 
                    if (strlen($mostrar) > 180){ 
                        $mostrar = substr($mostrar, 0, 180)."...";
                    } 
                    echo $mostrar;
                    ?>
                </p>
              </div>
              <!--<p class="calificacion">
                10
              </p>-->
              <p class="director">
                <?= $libro->getObject('autor')->toString()?>
              </p>         
              <p class="genero">
                <?= $libro->getObject('genero')->toString()?>
              </p>
              <p class="anio">               
                <?= $libro->getField('anio')?>
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