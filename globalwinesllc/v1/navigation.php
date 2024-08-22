      <div id="navigation">	
        	<ul class="menu">
                <li><a href="about_us.php" class="about_us">About Us</a></li>
                <li><a href="florida_distributor.php" class="florida_distributor">Florida Distributor</a></li>
                <li><a href="national_importer.php" class="national_importer">National Importer</a></li>
                <li class="wineries">
                	<a href="wineries.php" class="wineries">Wineries</a>
                    <ul class="submenu1">
                    	<li>
                        	<a href="florida_distributor.php">Florida Distributor</a>
                        	<ul class="submenu2">
                            	<li><a href="wineries.php?country_id=1" class="flag_link"><img src="images/flag_argentina.jpg" alt="Argentina" /></a></li>
                            	<li><a href="wineries.php?country_id=2" class="flag_link"><img src="images/flag_chile.jpg" alt="Chile" /></a></li>
                            	<li><a href="wineries.php?country_id=3" class="flag_link"><img src="images/flag_espana.jpg" alt="Spain" /></a></li>
                            	<li><a href="wineries.php?country_id=4" class="flag_link"><img src="images/flag_italy.jpg" alt="Italy" /></a></li>
                            	<li><a href="wineries.php?country_id=5" class="flag_link"><img src="images/flag_usa.jpg" alt="USA" /></a></li>
                            </ul>
                        </li>
                    	<li>
                        	<a href="national_importer.php">National Importer</a>
                        	<ul class="submenu2">
                            	<li><a href="wineries.php?country_id=1" class="flag_link"><img src="images/flag_argentina.jpg" alt="Argentina" /></a></li>
                            	<li><a href="wineries.php?country_id=2" class="flag_link"><img src="images/flag_chile.jpg" alt="Chile" /></a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <!--
                <li class="wines">
                	<a href="wineries.php" class="wines">Wines</a>
                    <ul class="submenu1">
                    <?php
                      $a_winery = new Winery();
                      if ($wineries = $a_winery->getAll()){
                        foreach ($wineries as $winery){
                          echo "<li>";
                          echo "<a href='wineries.php?winery_id=".$winery['id']."'>".$winery['menu_name']."</a>";
                          echo "<ul class='submenu2'>";
                          $a_line = new Line();
                          if ($lines = $a_line->getAll("ordernum", 0, "winery = ".$winery['id'])){
                            foreach ($lines as $line){
                              echo "<li>";
                              echo "<a href='wineries_lines.php?line_id=".$line['id']."'>".$line['menu_name']."</a>";
                              echo "<ul class='submenu3'>";
                              $a_wine = new Wine();
                              if ($wines = $a_wine->getAll("ordernum", 0, "line = ".$line['id'])){
                                foreach ($wines as $wine){
                                  echo "<li><a href='wines_card.php?wine_id=".$wine['id']."'>".$wine['name']."</a></li>";
                                }
                              }
                              echo "</ul></li>";
                            }
                          }
                          echo "</ul></li>";
                        }
                      } 
                    ?>
                    </ul>
                </li>
                -->
                <li><a href="coming_soon.php" class="pos_media">POS / Media</a></li>
                <li><a href="contact_us.php" class="contact_us">Contact US</a></li>
            </ul>
        </div>