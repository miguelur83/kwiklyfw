<?php include("inc/head.php"); ?>
<?php
    $template_class = "wine_card"; 
    include("inc/header.php"); 
?>
       <?php include("inc/navigation.php"); ?>
       <div id="content">
            <div id="content_body">
              <div id="wine_card_body">
                <?php
                  $a_wine = new Wine();
                  if(isset($_GET['wine_id'])){
                    $wine = $a_wine->getForId($_GET['wine_id']);
                  } else {
                    $wine = $a_wine->getFirst();
                  }
                  $line = $wine->getObject("line");
                  $winery = $line->getObject("winery");
                ?>  
                <div id="left">                                                                                                              
                  <img src="uploads/bottle_image/<?php echo $wine->getField('bottle_image'); ?>" class="wine_image" width="74px" height="222px" alt="<?php echo $wine->getField('name'); ?>" />
				  <?php if($wine->getField('PDF_card_file') != ''){ ?>
                  <p class="download_link"><a href="uploads/<?php echo $wine->getField('PDF_card_file'); ?>">Download PDF file</a></p>
				  <?php } ?>
                </div>
                <div id="center"> 
                  <p class="wine_name"><?php echo $wine->getField("name"); ?></p>                                                                    
                  <p class="varietal"><b>Varietal:</b> <?php echo $wine->getField('varietal'); ?></p>
                  <p class="region"><b>Region:</b> <?php echo $wine->getField('region'); ?></p>
                </div>
                <div id="right">
                  <p class="wine_description">
                    <?php echo $wine->getField('description'); ?>
                  </p>
                  <p class="producer">
                    Produced and bottled by <?php echo $winery->getField("name"); ?>
                  </p>
                </div>
              </div>
            </div>
        </div>
    </div>
</body>
<?php include("inc/footer.php"); ?>