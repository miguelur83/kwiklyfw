<?php include ("kwikly_bootstrap.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="Revisit" content="15 days">
	<meta name="robots" content="index,follow,all">
	<meta name="distribution" content="Global">
	<meta name="copyright" content="los dependientes">
	<meta name="revisit-after" content="30 days">
	<meta http-equiv="Pragma" content="no-cache">
	<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
	<meta name="GOOGLEBOT" content="index,follow,all">
	<meta name="DC.Language" scheme="RFC1766" content="Spanish">
	<meta name="AUTHOR" content="los dependientes">
	<meta name="Author Metatags" content="los dependientes">
	<meta name="Resource-type" content="Document">
  <?php
		if (isset($opengraph)){
			switch ($opengraph['tipo']){
				case 'critica':
					$critica = new Critica($opengraph['id']);
					$pelicula = $critica->getObject('pelicula');
					
					echo '<meta name="title" content="'.$pelicula->getField('titulo').' - los dependientes">
					<meta http-equiv="title" content="'.$pelicula->getField('titulo').' - los dependientes">
					<meta name="description" content="'.strip_tags(substr($critica->getField('contenido'), 0, 180)).'...">
					<meta http-equiv="DC.Description" content="'.strip_tags(substr($critica->getField('contenido'), 0, 180)).'...">';
				break;
				case 'libro':
					$libro = new Libro($opengraph['id']);
					
					echo '<meta name="title" content="'.$libro->getField('titulo').' - los dependientes">
					<meta http-equiv="title" content="'.$libro->getField('titulo').' - los dependientes">
					<meta name="description" content="'.strip_tags(substr($libro->getField('sinopsis'), 0, 180)).'...">
					<meta http-equiv="DC.Description" content="'.strip_tags(substr($libro->getField('sinopsis'), 0, 180)).'...">';
				break;
			}
		} else {
			echo '<meta name="title" content="los dependientes">
			<meta http-equiv="title" content="Los dependientes productora audiovisual, revista digital de cine, critica cinematográfica, critica de cine, reseña, comentario, análisis, monografia, ensayo, entrevistas, arte, literatura, artes plasticas, libros online, cine de género, cine de autor, cine experimental, series de televisión, estrenos, cine clásico, terror, western, melodrama, policial, cine negro, thriller, ciencia ficción, suspenso, documental, video arte, comedia, romantica, cine de acciòn, aventura, drama, bélico, gore, cine B, neorrealismo italiano, nouevelle vague, surrealismo, dadaismo, impresionismo, expresionismo aleman, vanguardia rusa, musical, cine mudo, animación, 3D, cine independientes, cine argentino, nuevo cine argentino, cine latinoamericano, cortometraje, festivales de cine, concurso de largometraje, concurso de guiòn.">
			<meta name="description" content="Los dependientes productora audiovisual, revista digital de cine, critica cinematográfica, critica de cine, reseña, comentario, análisis, monografia, ensayo, entrevistas, arte, literatura, artes plasticas, libros online, cine de género, cine de autor, cine experimental, series de televisión, estrenos, cine clásico, terror, western, melodrama, policial, cine negro, thriller, ciencia ficción, suspenso, documental, video arte, comedia, romantica, cine de acciòn, aventura, drama, bélico, gore, cine B, neorrealismo italiano, nouevelle vague, surrealismo, dadaismo, impresionismo, expresionismo aleman, vanguardia rusa, musical, cine mudo, animación, 3D, cine independientes, cine argentino, nuevo cine argentino, cine latinoamericano, cortometraje, festivales de cine, concurso de largometraje, concurso de guiòn.">
			<meta http-equiv="DC.Description" content="Los dependientes productora audiovisual, revista digital de cine, critica cinematográfica, critica de cine, reseña, comentario, análisis, monografia, ensayo, entrevistas, arte, literatura, artes plasticas, libros online, cine de género, cine de autor, cine experimental, series de televisión, estrenos, cine clásico, terror, western, melodrama, policial, cine negro, thriller, ciencia ficción, suspenso, documental, video arte, comedia, romantica, cine de acciòn, aventura, drama, bélico, gore, cine B, neorrealismo italiano, nouevelle vague, surrealismo, dadaismo, impresionismo, expresionismo aleman, vanguardia rusa, musical, cine mudo, animación, 3D, cine independientes, cine argentino, nuevo cine argentino, cine latinoamericano, cortometraje, festivales de cine, concurso de largometraje, concurso de guiòn.">';		
		}
	?>
	<meta name="keywords" content="Los dependientes productora audiovisual, revista digital de cine, critica cinematográfica, critica de cine, reseña, comentario, análisis, monografia, ensayo, entrevistas, arte, literatura, artes plasticas, libros online, cine de género, cine de autor, cine experimental, series de televisión, estrenos, cine clásico, terror, western, melodrama, policial, cine negro, thriller, ciencia ficción, suspenso, documental, video arte, comedia, romantica, cine de acciòn, aventura, drama, bélico, gore, cine B, neorrealismo italiano, nouevelle vague, surrealismo, dadaismo, impresionismo, expresionismo aleman, vanguardia rusa, musical, cine mudo, animación, 3D, cine independientes, cine argentino, nuevo cine argentino, cine latinoamericano, cortometraje, festivales de cine, concurso de largometraje, concurso de guiòn.">
	<meta http-equiv="DC.Keywords" content="Los dependientes productora audiovisual, revista digital de cine, critica cinematográfica, critica de cine, reseña, comentario, análisis, monografia, ensayo, entrevistas, arte, literatura, artes plasticas, libros online, cine de género, cine de autor, cine experimental, series de televisión, estrenos, cine clásico, terror, western, melodrama, policial, cine negro, thriller, ciencia ficción, suspenso, documental, video arte, comedia, romantica, cine de acciòn, aventura, drama, bélico, gore, cine B, neorrealismo italiano, nouevelle vague, surrealismo, dadaismo, impresionismo, expresionismo aleman, vanguardia rusa, musical, cine mudo, animación, 3D, cine independientes, cine argentino, nuevo cine argentino, cine latinoamericano, cortometraje, festivales de cine, concurso de largometraje, concurso de guiòn.">	

	<!-- Open Graph tags for Facebook shares -->
  <?php
  	if (isset($opengraph)){
		switch ($opengraph['tipo']){
			case 'critica':
				$critica = new Critica($opengraph['id']);
				$pelicula = $critica->getObject('pelicula');
				echo '<meta property="og:title" content="'.$pelicula->getField('titulo').'"/>';
				echo '<meta property="og:type" content="movie"/>';
				$afiche = '';
				if ($pelicula->getField('afiche') != ''){
					$afiche = "uploads/afiche_pelicula/inner/".$pelicula->getField('afiche');
				} else {
					$afiche = "img/no_disponible_grande.jpg";
				}
				echo '<meta property="og:image" content="'.$site_root.$afiche.'"/>';
				echo '<meta property="og:url" content="'.$site_root.'critica.php?critica_id='.$critica->getField('id').'"/>';
				echo '<meta property="og:description" content="'.strip_tags(substr($critica->getField('contenido'), 0, 180)).'..." />';
			break;
			case 'libro':
				$libro = new Libro($opengraph['id']);
				echo '<meta property="og:title" content="'.$libro->getField('titulo').'"/>';
				echo '<meta property="og:type" content="book"/>';
				$tapa = '';
				if ($libro->getField('tapa') != ''){
					$tapa = "uploads/tapa_libro/inner/".$libro->getField('tapa');
				} else {
					$tapa = "img/no_disponible_grande.jpg";
				}
				echo '<meta property="og:image" content="'.$site_root.$tapa.'"/>';
				echo '<meta property="og:url" content="'.$site_root.'libro.php?libro_id='.$libro->getField('id').'"/>';
				echo '<meta property="og:description" content="'.strip_tags(substr($libro->getField('sinopsis'), 0, 180)).'..." />';
			break;
		}
		echo '<meta property="og:site_name" content="Los Dependientes"/>';
		/*
		echo '<meta property="og:admins" content="miguelur"/>';
		echo '<meta property="og:app_id" content="187425831344504"/>';*/
	}
  ?>
  <!-- END Open Graph tags for Facebook shares -->
	
  <title>los dependientes</title>
  
  <!-- STYLESHEETS -->
  <link rel="stylesheet" type="text/css" href="styles/default.css"/>
  <!--[if IE]>
  <link rel="stylesheet" type="text/css" href="styles/explorer.css"/>
  <![endif]-->
  <link rel="stylesheet" type="text/css" href="styles/jquery.lightbox-0.5.css"/>
  
  <!-- JAVASCRIPT -->
  <script type="text/javascript" src="js/jquery-1.6.4.min.js"></script>
  <script type="text/javascript" src="js/jquery.lightbox-0.5.min.js"></script>
  <script type="text/javascript">
    function selSearch() {
    	var el = document.getElementById("searchTypes");
    	if (el.className == "hide") {
    		el.className = "";
    		//var buspos = $(".search_bar").offset();
    		//$(el).css("top",buspos.top).css("left",buspos.left);
    	} else {
    		el.className = "hide";
    	}
    }
    function changeSearch(id,text) {
    	$("#search_cat").text(text);
    	$("#cat").attr("value",id);
    	selSearch();
    	$("#buscar").focus();
    }
  </script>
  
  <!-- Cholla Font -->
  <script src="js/cufon-yui.js" type="text/javascript"></script>
	<script src="js/ChollaSlab.font.js" type="text/javascript"></script>
  <script type="text/javascript">
		Cufon.replace('#nav_bar #nav_menu li a'); 
		Cufon.replace('.barra_titulo h1');           
		Cufon.replace('div#archivo h2'); 
    Cufon.replace('#resultados ul.search_cats li');
    Cufon.replace('div#pestanas a');          
		Cufon.replace('p.calificacion');       
		Cufon.replace('div.integrantes_staff h3');
		Cufon.replace('div.integrantes_staff h4'); 
		Cufon.replace('div#noticias_home h2.noticia_titulo'); 
		Cufon.replace('div#noticias div#noticias_header p.month'); 
		Cufon.replace('div#listado_noticias div.noticia_blurb h2.noticia_titulo'); 
		Cufon.replace('div#texto_noticia div.noticia_blurb h2.noticia_titulo'); 
	</script>
  
  <!-- Slide destacado -->                                      
  <script src="js/jquery.cycle.all.min.js" type="text/javascript"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('div#slider_destacado').before('<div id="nav" class="nav">').cycle({
    		fx: 'scrollLeft', // choose your transition type, ex: fade, scrollUp, shuffle, etc...    
        pager:  '#nav',
        timeout: 7000,
        before: function() { if (window.console) console.log(this.src); }
    	});
    });
  </script>        
  
  <!-- Slide entrevista -->                                      
  <script src="js/jquery.cycle.all.min.js" type="text/javascript"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('div#header_slider').cycle({
    		fx: 'scrollLeft', // choose your transition type, ex: fade, scrollUp, shuffle, etc...
        timeout: 7000,
    	});
    });
  </script>
  
  <!-- Activar lightboxes -->
  <script type="text/javascript">
    $(function() {
    	$('#fotos_entrevista a').lightBox();    
      $('#centro.critica_interna div.fotos a').lightBox(); 
    });
  </script>        
  
  <!-- Tabs crítica (ficha) -->
  <script type="text/javascript">
    $(document).ready(function(){
    $('a.ficha').click(
      function(){
        $('div.ficha').show();
        $('div.critica').hide();
        $('div.trailer').hide();
        $('div.fotos').hide();
      }
    );
    $('a.critica').click(
      function(){
        $('div.ficha').hide();
        $('div.critica').show();
        $('div.trailer').hide();
        $('div.fotos').hide();
      }
    );
    $('a.trailer').click(
      function(){
        $('div.ficha').hide();
        $('div.critica').hide();
        $('div.trailer').show();
        $('div.fotos').hide();
      }
    );
    $('a.fotos').click(
      function(){
        $('div.ficha').hide();
        $('div.critica').hide();
        $('div.trailer').hide();
        $('div.fotos').show();
      }
    );
    });
  </script>
  
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-30171848-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>