<?php
  include ("inc/head.php");
  $GLOBALS['interna'] = true;
  include ("inc/header.php");
?>
    <div id="centro" class="links">
      <div id="izquierda">
        <div id="links">
          <div class="barra_titulo">
            <span></span>
            <h1>Links</h1>
            <span class="tail"></span>
          </div>
          <div id="links_container">
            <div class="link">
              <a href="http://www.criticascine.com/" target="_blank">
                <img src="img/links/criticas_decine01.jpg" alt="" class="normal" />
                <img src="img/links/criticas_decine02.jpg" alt="" class="hover" />
              </a>
              <p class="link_name"><a href="http://www.criticascine.com/" target="_blank">criticas de cine</a></p>
            </div>
            <div class="link">
              <a href="http://www.big-sur.com.ar/" target="_blank">
                <img src="img/links/big_sur01.jpg" alt="" class="normal" />
                <img src="img/links/big_sur02.jpg" alt="" class="hover" />              </a>
              <p class="link_name"><a href="http://www.big-sur.com.ar/" target="_blank">big sur</a></p>
            </div>
            <div class="link wrap">
              <a href="http://cinemarama.wordpress.com/" target="_blank">
                <img src="img/links/cinemarama01.jpg" alt="" class="normal" />
                <img src="img/links/cinemarama02.jpg" alt="" class="hover" />              </a>
              <p class="link_name"><a href="http://cinemarama.wordpress.com/" target="_blank">cinemarama</a></p>
            </div>
            <div class="link">
              <a href="http://servicios.lanacion.com.ar/espectaculos/cartelera-cine" target="_blank">
                <img src="img/links/ln01.jpg" alt="" class="normal" />
                <img src="img/links/ln02.jpg" alt="" class="hover" />              </a>
              <p class="link_name"><a href="http://servicios.lanacion.com.ar/espectaculos/cartelera-cine" target="_blank">cartelera la nación</a></p>
            </div>
            <div class="link">
              <a href="http://www.terrorifilo.com/" target="_blank">
                <img src="img/links/terrorifilo01.jpg" alt="" class="normal" />
                <img src="img/links/terrorifilo02.jpg" alt="" class="hover" />              </a>
              <p class="link_name"><a href="http://www.terrorifilo.com/" target="_blank">terrorifilo</a></p>
            </div>
            <div class="link wrap">
              <a href="http://www.ucine.edu.ar" target="_blank">
                <img src="img/links/ucine01.jpg" alt="" class="normal" />
                <img src="img/links/ucine02.jpg" alt="" class="hover" />
              </a>
              <p class="link_name"><a href="http://www.ucine.edu.ar" target="_blank">UCINE</a></p>
            </div>
            <div class="link">
              <a href="http://www.escribiendocine.com/" target="_blank">
                <img src="img/links/escribiendo_cine01.jpg" alt="" class="normal" />
                <img src="img/links/escribiendo_cine02.jpg" alt="" class="hover" />              </a>
              <p class="link_name"><a href="http://www.escribiendocine.com/" target="_blank">escribiendo cine</a></p>
            </div>
            <div class="link">
              <a href="http://www.todaslascriticas.com/" target="_blank">
                <img src="img/links/todas_las_criticas01.jpg" alt="" class="normal" />
                <img src="img/links/todas_las_criticas02.jpg" alt="" class="hover" />              </a>
              <p class="link_name"><a href="http://www.todaslascriticas.com/" target="_blank">todas las criticas</a></p>
            </div>
          </div>
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