<?php
  include("inc/head.php");
  include("inc/header.php");
?>
<div id="marquesina">
      <div id="logo_ojo">los dependientes logo</div>
      <div id="slider_destacado">
      	<?php
			$una_critica = new Critica();
			$criticas = $una_critica->getAll("id", 1, "publicar = '1' AND destacada = '1'");
			$c = 0;
			foreach($criticas as $critica_arr){ 
				$critica = new Critica($critica_arr['id']);
				$pelicula = new Pelicula($critica_arr['pelicula']);
				?>
                <div class="contenido_destacado">
                  <div class="informacion">                                                           
                    <img src="uploads/banner_home/<?php echo $critica_arr['banner_home']; ?>" class="imagen_destacado" alt="" />
                    <img src="uploads/logo_home/<?php echo $critica_arr['logo_home']; ?>" class="titulo_destacado" alt="<?php echo $pelicula->getField('titulo'); ?>" title="<?php echo $pelicula->getField('titulo'); ?>" />
                    <div class="sinopsis">
                      <?php
                        $mostrar = strip_tags($critica->getField('contenido'), "<b><i><strong>"); 
                        if (strlen($mostrar) > 200){ 
                            $mostrar = substr($mostrar, 0, 200)."...";
                        } 
                        echo $mostrar;
                      ?>
                    </div>
                    <a class="vermaslink" href="critica.php?critica_id=<?php echo $critica_arr['id']; ?>">ver +</a>
                  </div>                          
                </div>
	    	    <? 
				$c++;
				if ($c == 4){ break; }
			} ?>
      </div>
      <div id="facebook_link"><a href="https://www.facebook.com/profile.php?id=100002183936353" target="_blank">Facebook</a></div>
    </div>
    <div id="centro">
      <div id="izquierda">
        <div id="criticas_recientes">
          <div class="barra_titulo">
            <span></span>
            <h1>Cr&iacute;ticas Agregadas Recientemente</h1>
          </div>
          <?php
			$una_critica = new Critica();
			$criticas = $una_critica->getAll("id", 1, "publicar = '1' AND destacada = '0'");
			$c = 0;
			foreach($criticas as $critica_arr){ 
				$c++;
				$critica = new Critica($critica_arr['id']);
				$critico = new Persona($critica_arr['critico']);
				$pelicula = new Pelicula($critica_arr['pelicula']);
				?>
                  <div class="critica_box<?php if($c == 4){echo " ultima";} ?>">
                  	<?php
						$afiche = '';
						if ($pelicula->getField('afiche') != ''){
							$afiche = "uploads/afiche_pelicula/home/".$pelicula->getField('afiche');
						} else {
							$afiche = "img/no_disponible_grande.jpg";
						}
					?>
                    <a href="critica.php?critica_id=<?php echo $critica_arr['id']; ?>"><img src="<?=$afiche?>" class="critica_afiche" width="150px" height="215px" /></a>
                    <h2><a href="critica.php?critica_id=<?php echo $critica_arr['id']; ?>"><strong><?php echo $pelicula->getField('titulo'); ?></strong></a></h2>
                    <p><strong>Por: <?php echo $critico->getField('nombre'); ?></strong></p>
                    <p>
                    <?php
                        if (strlen($critica->getField('contenido')) > 180){ 
                            echo substr($critica->getField('contenido'), 0, 180)."...";
                        } else {
                            echo $critica->getField('contenido');
                        } 
                    ?>
                    </p>
                  </div>
				<? 
				if ($c == 4){ break; }
			} ?>
        </div>
        <div id="entrevista_destacada">
          <div class="barra_titulo">
            <span></span>
            <h1><a href="entrevistas.php">Entrevista / FRANCISCO FORBES</a></h1>
          </div>
          <a href="entrevistas.php"><img src="uploads/entre02.jpg" alt="Francisco Forbes" /></a>
          <p>Forbes reflexiona <i>&quot;Leyendo bien los diarios de Caicedo, uno siente que gran parte de su locura proven&iacute;a de confundir realidad con ficci&oacute;n. Al final &eacute;l casi termina viviendo su vida como si fuese una pel&iacute;cula&quot;</i>. A treinta y cuatro a&ntilde;os de la muerte de Caicedo, una entrevista sobre el documental que reflexiona sobre el mito y el fantasma que vuela sobre las tierras de nuestro continente. </p>
        </div>
        <div id="libros_electronicos">
          <div class="barra_titulo">
            <span></span>
            <h1><a href="libros.php">Libros Electr&oacute;nicos</a></h1>
          </div>
          <?php
		  	$un_libro = new Libro();
			$libros_arr = $un_libro->getAll("id", 1, "publicar = '1'");
			$c = 0;
			foreach ($libros_arr as $libro_arr){
				$c++;
				$libro = new Libro ($libro_arr['id']);
				?>
                  <div class="libro">
                    <h2 class="libro_titulo"><a href="libro.php?libro_id=<?php echo $libro->getField('id'); ?>"><?php echo $libro->getField('titulo'); ?></a></h2>
                    <p class="libro_descripcion">
                      	<?php
							if (strlen($libro->getField('sinopsis')) > 180){ 
								echo substr($libro->getField('sinopsis'), 0, 180)."...";
							} else {
								echo $libro->getField('sinopsis');
							} 
						?>
                    </p>
                  </div>
                <?php
				if ($c == 3){ break; }
			}
		  ?>
        </div>
      </div>
      <div id="banners">              
        <?php include("inc/banners.php"); ?>
      </div>
    </div>
  </div>
<?php
  include("inc/footer.php");
?>