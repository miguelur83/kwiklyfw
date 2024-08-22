<body>
	<!--<div id="body_bkg"></div>-->
	<!-- Required for facebook comments plugin -->
    <div id="fb-root"></div>
	<script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) {return;}
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/es_LA/all.js#xfbml=1&appId=187425831344504";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
    <!-- END Required for facebook comments plugin -->
  <div id="main_container">
    <div id="nav_bar">             
      <?php
	  	if (isset($GLOBALS['interna'])){
			if($GLOBALS['interna']){
			  echo '<div id="facebook_link" class="inner"><a href="https://www.facebook.com/profile.php?id=100002183936353" target="_blank">Facebook</a></div>';
			}
		}
      ?>
      <ul id="nav_menu">
        <li><a href="criticas_cine.php">Cr&iacute;ticas de Cine</a></li>
        <li><a href="criticas_series.php">Cr&iacute;ticas de Series</a></li>
        <li><a href="arteliteratura.php">Arte &amp; Literatura</a></li>
        <li><a href="entrevistas.php">Entrevistas</a></li>
        <li><a href="links.php">Links</a></li>
        <li><a href="libros.php">Libros</a></li>
        <li><a href="noticias.php">Noticias</a></li>
        <!--<li><a href="staff.php">Staff</a></li>-->
      </ul>
    </div>
    <div id="home_header">
      <a id="logo" href="index.php">los dependientes</a>
      <div class="search_bar">
        <div id="search_cat" onClick="selSearch()">
          Por t&iacute;tulo
        </div>
        <div id="form_container">
        	<?php if($_GET['seccion']=='libros'){ $seccion_libros = true; } ?>
          <form id="search_form" name="search_form" action="resultados.php<?=($seccion_libros?"?seccion=libros":"")?>" method="post">
            <input type="text" name="buscar" id="buscar" value="Buscar" onFocus="if(this.value=='Buscar'){this.value=''}" onBlur="if(this.value==''){this.value='Buscar'}" />
            <input type="hidden" id="cat" name="cat" value="titulo" />
          </form>                                                       
        </div>
        <div id="searchTypes" class="hide">
          <ul>
            <li><span>Buscar por</span></li>
            <li><a href="#" onClick="changeSearch('titulo','Por t&iacute;tulo');return false">Por t&iacute;tulo</a></li>
        	<?php if($seccion_libros){ ?>
                <li><a href="#" onClick="changeSearch('autor','Por autor');return false">Por autor</a></li>
                <li><a href="#" onClick="changeSearch('anio','Por a&ntilde;o');return false">Por a&ntilde;o</a></li>
            <?php }else{ ?>
                <li><a href="#" onClick="changeSearch('critico','Por cr&iacute;tico');return false">Por cr&iacute;tico</a></li>
                <li><a href="#" onClick="changeSearch('director','Por director');return false">Por director</a></li>
                <li><a href="#" onClick="changeSearch('actor','Por actor');return false">Por actor</a></li>
            <?php } ?>
          </ul>
        </div>
      </div>
    </div> 