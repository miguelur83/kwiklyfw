<?php include("head.php"); ?>
<?php
    $template_class = "wineries"; 
    include("header.php"); 
?>
       <?php include("navigation.php"); ?>
       <div id="content">
            <div id="content_body">
              <h1>POS / Media page</h1>
                <?php
                  $a_media = new Media();
                  $all_media = $a_media->getAll();
                  echo "<ul>";
                  foreach($all_media as $media){
                    echo "<li><a target='_blank' href='uploads/".$media['file']."'>".$media['title']."</a></li>";
                  }
                  echo "</ul>";
                ?>
            </div>
        </div>
    </div>
</body>
<?php include("footer.php"); ?>