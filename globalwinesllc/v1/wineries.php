<?php include("head.php"); ?>
<?php
    $template_class = "wineries"; 
    include("header.php"); 
?>
        <?php include("navigation.php"); ?>
        <div id="content">
            <div id="content_body">
                <p id="page_title" class="wineries">Our Wineries</p>
                <?php 
                  if ($_GET['country_id']){
                    $show_country_flag = $_GET['country_id'];
                  }
                  if ($_GET['country_id']){
                    $show_country_flag = $_GET['country_id'];
                  }
                ?> 
                <?php
                  $a_winery = new Winery();
                  if(isset($_GET['winery_id'])){
                    $winery = $a_winery->getForId($_GET['winery_id']);
                    $show_country_flag = $winery->getField('country');
                  } else {
                    $winery = $a_winery->getFirst((($_GET['country_id'])?"country = '".$_GET['country_id']."'":"1"));
                  }
                ?>
                <?php
                  switch ($show_country_flag){
                    case 1:
                      echo "<img class='country_flag' src='images/flag_argentina.jpg' title='Argentina' alt='Argentina' />";
                    break;
                    case 2:
                      echo "<img class='country_flag' src='images/flag_chile.jpg' title='Chile' alt='Chile' />";
                    break;
                    case 3:
                      echo "<img class='country_flag' src='images/flag_espana.jpg' title='Spain' alt='Spain' />"; 
                    break;
                    case 4:
                      echo "<img class='country_flag' src='images/flag_italy.jpg' title='Italy' alt='Italy' />";
                    break;
                    case 5:
                      echo "<img class='country_flag' src='images/flag_usa.jpg' title='USA' alt='USA' />";
                    break;
                  }
                ?>
                <?php
                  $a_winery = new Winery();
                  if ($_GET['country_id']){
                    $wineries = $a_winery->getAll("name", 0, "country=".$_GET['country_id']);
                  } else {
                    $wineries = $a_winery->getAll("name", 0);
                  }
                  $num_wineries = count($wineries);
                  $left_count = (int)($num_wineries / 2);
                  $c = 0;
                  
                  echo "<div id='wineries_list'>";
                  echo "<ul class='left_column'>";
                  foreach ($wineries as $a_winery){
                    echo "<li><a href='wineries.php?winery_id=".$a_winery['id']."&country_id=".$a_winery['country']."'>".$a_winery['name']."</a></li>";
                    $c++;
                    if ($c == $left_count){
                      echo "</ul><ul class='right_column'>";
                    }
                  }
                  echo "</ul></div>";
                ?>
            </div>
            <div id="winery_card">
                <?php
                  $logo = new SimpleImage();
                  $logo->load("uploads/".$winery->getField('logo') );
                  $logo->resizeToWidth(128);
                  if( $logo->getHeight() > 83 ){
                    $logo->resizeToHeight(83);
                  }         
                  $logo->save("uploads/".$winery->getField('logo')."_128px");
                ?>
                <div id="card_top">
                  <div id="logo_container">
              	   <img width="<?php echo $logo->getWidth(); ?>px" height="<?php echo $logo->getHeight(); ?>px" src="uploads/<?php echo $winery->getField('logo')."_128px"; ?>" alt="<?php echo $winery->getField('name'); ?>" class="winery_logo" width="<?php echo $logo->getWidth(); ?>px" height="<?php echo $logo->getHeight(); ?>px" />
                  </div>                       
                  <?php
                    $a_line = new Line();
                    $lines = $a_line->getAll("ordernum", 0, "winery=".$winery->getField('id'));
                              
                    /* This one chooses the first three wines found, in the first line with as much available.                     
                    $three_wines = array();
                    $c = 0;                   
                    foreach($lines as $line){    
                      $a_wine = new Wine();   
                      $wines = $a_wine->getAll("ordernum", 0, "line=".$line['id']);   
                      foreach($wines as $wine){
                        array_push($three_wines, $wine);
                        $c++;              
                        if($c >= 3){ break; }
                      }
                      if($c >= 3){ break; }
                    } 
                    */        
                    /* this one chooses a wine from each line, whenever there is */                
                    $three_wines = array();
                    $c = 0;  
                    $wines = array();            
                    foreach($lines as $line){    
                      $a_wine = new Wine();   
                      $wines[$line['id']] = $a_wine->getAll("ordernum", 0, "line=".$line['id']);
                    }                       
                    $check_position = 0;
                    $no_more = 0;
                    while( ($c < 3) && (! $no_more) ){
                      $no_more = 1;
                      foreach($wines as $line_id => $line_wines){
                        if(isset($line_wines[$check_position])){
                          $three_wines[$c] = $line_wines[$check_position];
                          $c++;
                          $no_more = 0;
                        }
                        if($c >= 3){ break; }
                      }
                      $check_position++;                            
                    }
                  ?>
                  <div id="bottle_images">
                    <?php
                      foreach ($three_wines as $bottle){
                        echo '<img src="uploads/'.$bottle['bottle_image'].'" height="103px" />';
                      }
                    ?>
                  </div>
                </div>
                <div id="card_bottom">
                  <p class="winery_description">
                  	<?php echo $winery->getField('description'); ?>
                  </p>                
                  <ul class="wines_list">
                    <?php
                      foreach ($lines as $line){
                        echo "<li><a href='wineries_lines.php?line_id=".$line['id']."'>".$line['body_name']."</a></li>";
                      } 
                    ?>
                  </ul>
                </div>
            </div>
        </div>
    </div>
</body>
<?php include("footer.php"); ?>