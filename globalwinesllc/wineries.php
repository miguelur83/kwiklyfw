<?php include("inc/head.php"); ?>
<?php
    $template_class = "wineries"; 
    include("inc/header.php"); 
?>
        <?php include("inc/navigation.php"); ?>
        <div id="content">
            <div id="content_body">
                <p id="page_title" class="wineries">Our Wineries</p>
                <?php 
				
				// If there's a country id we'll use this, unless we load a winery later
				$show_country = 0;
				if ($_GET['country_id']){
					$show_country = $_GET['country_id'];
				}
				
				// If there's a winery id, we load it and we save the country id
				$winery = null;
				$a_winery = new Winery();
                if(isset($_GET['winery_id'])){
					$winery = $a_winery->getForId($_GET['winery_id']);
					$show_country = $winery->getField('country');
				} 
				
				// Load the country, its wineries and, if there's a filter (florida / national), use it.
				$a_country = new Country();
				$country = $a_country->getForId($show_country);
				$wineries = $a_winery->getAll('id', 0, "country = '".$show_country.((isset($_GET['filter']))?"' AND ".$_GET['filter']." = 1":""));
				
				// Country flag
				echo "<img class='country_flag' src='uploads/flag_image/".$country->getField('flag_image')."' title='".$country->getField('name')."' alt='".$country->getField('name')."' />";
				
				// Wineries list
                  $num_wineries = count($wineries);
                  $left_count = (int)($num_wineries / 2);
                  $c = 0;
                  
                  echo "<div id='wineries_list'>";
                  echo "<ul class='left_column'>";
                  foreach ($wineries as $a_winery){
                    echo "<li><a href='wineries.php?winery_id=".$a_winery['id']."&filter=".$_GET['filter']."'>".$a_winery['name']."</a></li>";
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
					if (! is_null($winery)){
					  $logo = new SimpleImage();
					  if(! file_exists("uploads/logo_winery/small/".$winery->getField('logo'))){
						$logo->load('uploads/logo_winery/'.$winery->getField('logo'));
						$logo->resizeToWidth(128);
						  if( $logo->getHeight() > 83 ){
							$logo->resizeToHeight(83);
						  }         
						$logo->save('uploads/logo_winery/small/'.$winery->getField('logo'));
					  }
					  $logo->load("uploads/logo_winery/small/".$winery->getField('logo'));
					  ?>
						<div id="card_top">
						  <div id="logo_container">
						   <img width="<?php echo $logo->getWidth(); ?>px" height="<?php echo $logo->getHeight(); ?>px" src="uploads/logo_winery/small/<?php echo $winery->getField('logo'); ?>" alt="<?php echo $winery->getField('name'); ?>" class="winery_logo" width="<?php echo $logo->getWidth(); ?>px" height="<?php echo $logo->getHeight(); ?>px" />
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
								echo '<img src="uploads/bottle_image/'.$bottle['bottle_image'].'" height="103px" />';
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
					<?php 
					} else {
						// echo "No wineries";
					}
				?>
            </div>
        </div>
    </div>
</body>
<?php include("inc/footer.php"); ?>