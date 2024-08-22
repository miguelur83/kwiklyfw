<body>
	<div id="container">
    	<div id="header">
        <h2><?=$site_name;?> - <?=$lang->getString('ttl_admin_section');?></h2>
          <div id="topmenu">
            	<ul>
                <?php
                if (! isset($_SESSION['logged_in'])){
                  //login                          
                  ?>
                	  <li class="current"><a href="login.php"><?=$lang->getString('lnk_login');?></a></li>
                  <?php
                } else {
                  //logged in
					foreach ($admin_sections as $section_name => $section){
						$first_page = key($section['pages']);
						$menu = $section['menu'];
						if(! $section['hide']){
							echo "<li".(($_GET['section']==$section_name)?" class='current'":"")."><a href='?section=".$section_name."&page=".$first_page."'>".$menu."</a></li>";
						}
					}
                  ?>
                    <li><a href="?action=logout"><?=$lang->getString('lnk_logout');?></a></li>
                  <?php
                }
                ?>
              </ul>
          </div>
      </div>             
      <?php
      if (isset($_SESSION['logged_in'])){
		$section_data = $admin_sections[$_GET['section']];
		
		echo '<div id="top-panel"><div id="panel"><ul>';
		foreach($section_data['pages'] as $page_name => $page){
			if(! $section_data['hide']){
				echo '<li><a href="?section='.$_GET['section'].'&page='.$page_name.'">'.$page['menu'].'</a></li>';
			}
		}
		echo '</ul></div></div>';
	  }
	  ?>
      <div id="wrapper">
          <div id="content">