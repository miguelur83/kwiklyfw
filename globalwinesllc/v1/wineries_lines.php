<?php include("head.php"); ?>
<?php
    $template_class = "wineries_lines"; 
    include("header.php"); 
?>
       <?php include("navigation.php"); ?>
       <div id="content">
            <div id="content_body">
                <?php
                  $a_line = new Line();
                  if(isset($_GET['line_id'])){
                    $line = $a_line->getForId($_GET['line_id']);
                  } else {
                    $line = $a_line->getFirst();
                  }
                  $winery = $line->getObject("winery");
                  
                  $logo = new SimpleImage();
                  $logo->load("uploads/".$winery->getField('logo') );
                  $logo->resizeToWidth(150);
                  $logo->save("uploads/".$winery->getField('logo')."_150px");
                ?>               
                <div id="left_column">
                  <p class="backlink"><a href="javascript:javascript:history.go(-1)">&lt;&lt; Back</a></p> 
                  <img id="winery_logo" src="uploads/<?php echo $winery->getField('logo'); ?>">
                  <p class="winery_line"><?php echo $line->getField('menu_name'); ?></p>
                </div>
                <div id="right_column">
                  <ul class="line_wines">
                      <?php
                        $wines = $a_wine->getAll("ordernum", 0, "line=".$line->getField('id'));
                        foreach ($wines as $wine){
                          echo "<li>";    
                          echo "<a href='wines_card.php?wine_id=".$wine['id']."'><img class='wine_bottle' src='uploads/".$wine['bottle_image']."' height='150px' /></a>";
                          echo "<p class='wine_name'>".$wine['name']."</p>";
                          echo "</li>";
                        }
                      ?>
                  </ul>
                </div>
            </div>
            <div id="wineries_lines_footer"></div>
        </div>
    </div>
</body>
<?php include("footer.php"); ?>