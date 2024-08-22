<?php include("head.php"); ?>
<body class="homepage">
	<div id="main_container" class="homepage">
        <img id="logo" src="images/gwines_logo_big.jpg" alt="Global Wines - Wine Importer &amp; Distributor" />
        <div id="access_links">
            <!--<a href="coming_soon.php" class="espanol">Entrar</a>-->
            <a href="about_us.php" class="english">Enter</a>
        </div>
        <div id="home_images">
            <div id="copa" class="copa">
              <img src="images/vinos_home_1.jpg" width="48px" height="355px">
              <img src="images/vinos_home_2.jpg" width="48px" height="355px">
            </div>
            <div id="barriles" class="barriles">
              <img src="images/barriles_home_1.jpg" width="187px" height="422px">
              <img src="images/barriles_home_2.jpg" width="187px" height="422px">
            </div>
            <div id="parra" class="parra">
              <img src="images/parras_home_1.jpg" width="61px" height="381px">
              <img src="images/parras_home_2.jpg" width="61px" height="381px">
            </div>
            <div id="campo" class="campo">
              <img src="images/campo_home_1.jpg" width="28px" height="318px">
              <img src="images/campo_home_2.jpg" width="28px" height="318px">
            </div>
            <div id="uvas" class="uvas">
              <img src="images/uvas_home_1.jpg" width="116px" height="345px">
              <img src="images/uvas_home_2.jpg" width="116px" height="345px">
            </div>
        </div>
    </div>
    <div id="musicplayer">
      <object type="application/x-shockwave-flash" data="music/player_mp3_mini.swf" width="200" height="20">
           <param name="movie" value="music/player_mp3_mini.swf" />
           <param name="bgcolor" value="#fff" />
           <param name="FlashVars" value="mp3=music/park_bench.mp3&amp;autoplay=1" />
      </object>
    </div>
</body>
<?php include("footer.php"); ?>