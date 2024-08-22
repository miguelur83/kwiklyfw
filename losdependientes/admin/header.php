<body>
	<div id="container">
    	<div id="header">
        	<h2>Secci&oacute;n Administrativa</h2>
          <div id="topmenu">
            	<ul>
                <?php
                if (! isset($_SESSION['logged_in'])){
                  //login                          
                  ?>
                	  <li class="current"><a href="login.php">Acceso</a></li>
                  <?php
                } else {
                  //logged in
                  ?>
                	  <li<?php echo (($_GET['section']=='criticas')?" class='current'":"")?>><a href="?section=criticas&page=criticas">Editar Criticas</a></li>
                    <li<?php echo (($_GET['section']=='libros')?" class='current'":"")?>><a href="?section=libros&page=libros">Editar Libros</a></li>
                    <li<?php echo (($_GET['section']=='noticias')?" class='current'":"")?>><a href="?section=noticias&page=noticias">Editar Noticias</a></li>
                    <li><a href="?action=logout">Salir</a></li>
                  <?php
                }
                ?>
              </ul>
          </div>
      </div>             
      <?php
      if ((isset($_SESSION['logged_in'])) && ($_GET['section']=='criticas')){
      ?>
      <div id="top-panel">
          <div id="panel">
              <ul>
                  <li><a href="?section=criticas&page=criticas">Criticas</a></li>
                  <li><a href="?section=criticas&page=peliculas">Peliculas / Series</a></li>
                  <!--<li><a href="?section=criticas&page=eventos">Eventos</a></li>-->
                  <li><a href="?section=criticas&page=generos">Generos</a></li>
                  <li><a href="?section=criticas&page=personas">Personas</a></li>
              </ul>
          </div>
      </div>
      <?php } ?>         
      <?php
      if ((isset($_SESSION['logged_in'])) && ($_GET['section']=='libros')){
      ?>
      <div id="top-panel">
          <div id="panel">
              <ul>                                
                  <li><a href="?section=libros&page=libros">Libros</a></li>
                  <li><a href="?section=libros&page=generos">Generos</a></li>
                  <li><a href="?section=libros&page=personas">Personas</a></li>
              </ul>
          </div>
      </div>
      <?php } ?>
      <?php
      if ((isset($_SESSION['logged_in'])) && ($_GET['section']=='noticias')){
      ?>
      <div id="top-panel">
          <div id="panel">
              <ul>                                
                  <li><a href="?section=noticias&page=noticias">Noticias</a></li>
              </ul>
          </div>
      </div>
      <?php } ?>
      <div id="wrapper">
          <div id="content">