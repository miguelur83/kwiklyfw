<?php
  include ("inc/head.php");
  $GLOBALS['interna'] = true;
  include ("inc/header.php");
  
  if(isset($_GET['buscar'])) $_POST['buscar'] = $_GET['buscar']; 
  if(isset($_GET['cat'])) $_POST['cat'] = $_GET['cat']; 
  $seccion = $_GET['seccion'];
  
  //Cant. resultados por filtro
  $cantidad = array();
  if ($seccion == 'libros') {
  		$select = "SELECT COUNT(`libros`.id) as cant_libros FROM `libros` WHERE libros.titulo LIKE '%".$_POST['buscar']."%' AND publicar=1 ORDER BY libros.titulo ASC";
		$temp = $GLOBALS['db']->execute($select);
		$arr = mysql_fetch_array($temp);
		$cantidad['titulo'] = $arr['cant_libros'];
		
  		$select = "SELECT COUNT(`libros`.id) as cant_libros FROM `libros` INNER JOIN personas ON libros.autor = personas.id WHERE personas.nombre LIKE '%".$_POST['buscar']."%' AND libros.publicar=1 ORDER BY libros.titulo ASC";
		$temp = $GLOBALS['db']->execute($select);
		$arr = mysql_fetch_array($temp);
		$cantidad['autor'] = $arr['cant_libros'];
		
  		$select = "SELECT COUNT(`libros`.id) as cant_libros FROM `libros` WHERE libros.anio LIKE '%".$_POST['buscar']."%' AND publicar=1 ORDER BY libros.titulo ASC";
		$temp = $GLOBALS['db']->execute($select);
		$arr = mysql_fetch_array($temp);
		$cantidad['anio'] = $arr['cant_libros'];
  		
  } else {
		$select = "SELECT COUNT(criticas.id) as cant_criticas FROM criticas INNER JOIN peliculas ON criticas.pelicula = peliculas.id WHERE peliculas.titulo LIKE '%".$_POST['buscar']."%' AND criticas.publicar=1 ORDER BY peliculas.titulo ASC";
		$temp = $GLOBALS['db']->execute($select);
		$arr = mysql_fetch_array($temp);
		$cantidad['titulo'] = $arr['cant_criticas'];
		
		$select = "SELECT COUNT(criticas.id) as cant_criticas FROM criticas INNER JOIN personas ON criticas.critico = personas.id INNER JOIN peliculas ON criticas.pelicula = peliculas.id WHERE personas.nombre LIKE '%".$_POST['buscar']."%' AND criticas.publicar=1 ORDER BY personas.nombre ASC";
		$temp = $GLOBALS['db']->execute($select);
		$arr = mysql_fetch_array($temp);
		$cantidad['critico'] = $arr['cant_criticas'];
		
		$select = "SELECT COUNT(criticas.id) as cant_criticas FROM criticas INNER JOIN peliculas ON criticas.pelicula = peliculas.id INNER JOIN elenco ON peliculas.id = elenco.pelicula INNER JOIN personas ON elenco.actor = personas.id WHERE personas.nombre LIKE '%".$_POST['buscar']."%' AND criticas.publicar=1 ORDER BY personas.nombre ASC";
		$temp = $GLOBALS['db']->execute($select);
		$arr = mysql_fetch_array($temp);
		$cantidad['actor'] = $arr['cant_criticas'];
		
		$select = "SELECT COUNT(criticas.id) as cant_criticas FROM criticas INNER JOIN peliculas ON criticas.pelicula = peliculas.id INNER JOIN personas ON peliculas.director = personas.id WHERE personas.nombre LIKE '%".$_POST['buscar']."%' AND criticas.publicar=1 ORDER BY personas.nombre ASC";
		$temp = $GLOBALS['db']->execute($select);
		$arr = mysql_fetch_array($temp);
		$cantidad['director'] = $arr['cant_criticas'];
  }  
  
  $resultados = $cantidad[$_POST['cat']];
  
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
	
	
  if(isset($_POST['buscar'])){
    switch($_POST['cat']){
        case 'titulo':
			if ($seccion == 'libros'){
				$select = "SELECT `libros`.id as libro FROM `libros` WHERE libros.titulo LIKE '%".$_POST['buscar']."%' AND publicar=1 ORDER BY libros.titulo ASC".' LIMIT '.$offset.', '.$limit;
			} else {
            	$select = "SELECT criticas.id as critica, peliculas.id as pelicula FROM criticas INNER JOIN peliculas ON criticas.pelicula = peliculas.id WHERE peliculas.titulo LIKE '%".$_POST['buscar']."%' AND criticas.publicar=1 ORDER BY peliculas.titulo ASC".' LIMIT '.$offset.', '.$limit;
			}
        break;
        case 'critico':
            $select = "SELECT criticas.id as critica, peliculas.id as pelicula FROM criticas INNER JOIN personas ON criticas.critico = personas.id INNER JOIN peliculas ON criticas.pelicula = peliculas.id WHERE personas.nombre LIKE '%".$_POST['buscar']."%' AND criticas.publicar=1 ORDER BY personas.nombre ASC".' LIMIT '.$offset.', '.$limit;
        break;
        case 'actor':                                
            $select = "SELECT criticas.id as critica, peliculas.id as pelicula FROM criticas INNER JOIN peliculas ON criticas.pelicula = peliculas.id INNER JOIN elenco ON peliculas.id = elenco.pelicula INNER JOIN personas ON elenco.actor = personas.id WHERE personas.nombre LIKE '%".$_POST['buscar']."%' AND criticas.publicar=1 ORDER BY personas.nombre ASC".' LIMIT '.$offset.', '.$limit;
        break;
        case 'director':                                                      
            $select = "SELECT criticas.id as critica, peliculas.id as pelicula FROM criticas INNER JOIN peliculas ON criticas.pelicula = peliculas.id INNER JOIN personas ON peliculas.director = personas.id WHERE personas.nombre LIKE '%".$_POST['buscar']."%' AND criticas.publicar=1 ORDER BY personas.nombre ASC".' LIMIT '.$offset.', '.$limit;
        break; 
        case 'autor': 
			$select = "SELECT `libros`.id as libro FROM `libros` INNER JOIN personas ON libros.autor = personas.id WHERE personas.nombre LIKE '%".$_POST['buscar']."%' AND libros.publicar=1 ORDER BY libros.titulo ASC".' LIMIT '.$offset.', '.$limit;
        break; 
        case 'anio': 
			$select = "SELECT `libros`.id as libro FROM `libros` WHERE libros.anio LIKE '%".$_POST['buscar']."%' AND publicar=1 ORDER BY libros.titulo ASC".' LIMIT '.$offset.', '.$limit;
        break; 
    }
  } else {
    die();
  }   
  
  if ($seccion == 'libros'){
  	$libros_results = $GLOBALS['db']->execute($select);
  } else {
  	$criticas_results = $GLOBALS['db']->execute($select);
  }
?>    
    <div id="centro" class="resultados">
      <div id="resultados">
        <div class="barra_titulo">
          <span></span>
          <h1>Resultados</h1>
          <span class="tail"></span>
        </div>
        <p class="search_term">'<?= $_POST['buscar']?>'</p>
        <div class="search_cats_results">
          <p>BUSCAR POR</p>
          <ul class="search_cats">
          	<?php if ($seccion == 'libros'){ ?>
            	<li class="top<?=($_POST['cat']=='titulo'?' activo':'')?>"><a href="?buscar=<?=$_POST['buscar']?>&cat=titulo&seccion=libros">T&iacute;tulo (<?=$cantidad['titulo']?>)</a></li>     
                <li<?=($_POST['cat']=='autor'?' class="activo"':'')?>><a href="?buscar=<?=$_POST['buscar']?>&cat=autor&seccion=libros">Autor (<?=$cantidad['autor']?>)</a></li>
                <li class="bottom<?=($_POST['cat']=='anio'?' activo':'')?>"><a href="?buscar=<?=$_POST['buscar']?>&cat=anio&seccion=libros">A&ntilde;o (<?=$cantidad['anio']?>)</a></li>
            <?php } else { ?>
                <li class="top<?=($_POST['cat']=='titulo'?' activo':'')?>"><a href="?buscar=<?=$_POST['buscar']?>&cat=titulo">T&iacute;tulo (<?=$cantidad['titulo']?>)</a></li>     
                <li<?=($_POST['cat']=='critico'?' class="activo"':'')?>><a href="?buscar=<?=$_POST['buscar']?>&cat=critico">Cr&iacute;tico (<?=$cantidad['critico']?>)</a></li>
                <li<?=($_POST['cat']=='actor'?' class="activo"':'')?>><a href="?buscar=<?=$_POST['buscar']?>&cat=actor">Actor (<?=$cantidad['actor']?>)</a></li>
                <li class="bottom<?=($_POST['cat']=='director'?' activo':'')?>"><a href="?buscar=<?=$_POST['buscar']?>&cat=director">Director (<?=$cantidad['director']?>)</a></li>
            <?php } ?>
          </ul>
        </div>
        <div class="search_results">
        	<?php
				if($resultados == 0){
					echo "<p>No se encontraron resultados para ese t&eacute;rmino de b&uacute;squeda</p>";
				}
            ?>
          <div id="results_container">
            <?php 
			if ($seccion == 'libros') {
				// MOSTRAR RESULTADOS DE LIBROS
				while ($row = mysql_fetch_array($libros_results)){
					$libro = new Libro($row['libro']);
					
					$tapa = '';
					if ($libro->getField('tapa') != ''){
						$tapa = "uploads/tapa_libro/inner/".$libro->getField('tapa');
					} else {
						$tapa = "img/no_disponible_chico.png";
					}
				?>
				<div class="result_item">
				  <a href="libro.php?libro_id=<?=$libro->getField('id')?>"><img src="<?=$tapa?>" alt="" class="result_image" /></a>
				  <a href="libro.php?libro_id=<?=$libro->getField('id')?>"><h2><?=$libro->getField('titulo').' ('.$libro->getField('anio').')'?></h2></a>
				  <p class="info">
					<?php
						$mostrar = strip_tags($libro->getField('sinopsis'), "<b><i><strong>"); 
						if (strlen($mostrar) > 200){ 
							$mostrar = substr($mostrar, 0, 200)."...";
						} 
						echo $mostrar;
					?><br />
					<strong>Autor:</strong> <?=$libro->getObject('autor')->toString();?><br />
				  </p>
				</div>
				<?php 
				} // end while
			} else {
				// MOSTRAR RESULTADOS DE CRITICAS
				while ($row = mysql_fetch_array($criticas_results)){
					$critica = new Critica($row['critica']);
					$pelicula = new Pelicula($row['pelicula']); 
					
					$afiche = '';
					if ($pelicula->getField('afiche') != ''){
						$afiche = "uploads/afiche_pelicula/inner/".$pelicula->getField('afiche');
					} else {
						$afiche = "img/no_disponible_chico.png";
					}
				?>
				<div class="result_item">
				  <a href="critica.php?critica_id=<?=$critica->getField('id')?>"><img src="<?=$afiche?>" alt="" class="result_image" /></a>
				  <a href="critica.php?critica_id=<?=$critica->getField('id')?>"><h2><?=$pelicula->getField('titulo').' ('.$pelicula->getField('anio').')'?></h2></a>
				  <p class="info">
					<strong>Calificaci&oacute;n: <?=$critica->getField('calificacion')?> / Cr&iacute;tico: <?=$critica->getObject('critico')->toString()?></strong><br />
					<?php
						$mostrar = strip_tags($critica->getField('contenido'), "<b><i><strong>"); 
						if (strlen($mostrar) > 400){ 
							$mostrar = substr($mostrar, 0, 400)."...";
						} 
						echo $mostrar;
					?><br />
					<strong>Reparto:</strong> <?=$pelicula->getElencoString();?><br />
					<strong>Director:</strong> <?=$pelicula->getObject('director')->toString()?>
				  </p>
				</div>
				<?php 
				} // end while
			} // end if
			?>
          </div>
          <div class="pagination">
            <p class="resultados">Mostrando resultados <?=$page_from?> - <?=$page_to?> de <?= $resultados ?></p>
            <a href="<?=(($prev_page != 0)?"?page=".$prev_page:"#").'&buscar='.$_POST['buscar'].((isset($_POST['cat']))?'&cat='.$_POST['cat']:"").((isset($_GET['seccion']))?'&seccion='.$_GET['seccion']:"")?>">Prev</a>
            <p class="current_page"><?=$page?></p>
            <a href="<?=(($next_page != 0)?"?page=".$next_page:"#").'&buscar='.$_POST['buscar'].((isset($_POST['cat']))?'&cat='.$_POST['cat']:"").((isset($_GET['seccion']))?'&seccion='.$_GET['seccion']:"")?>">Next</a>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php
  include("inc/footer.php");
?>