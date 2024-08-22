<body>
	<div id="container">
    	<div id="header">
        	<h2>Global Wines Admin</h2>
          <div id="topmenu">
            	<ul>
                <?php
                if (! isset($_SESSION['logged_in'])){
                  //login                          
                  ?>
                	  <li class="current"><a href="login.php">Login</a></li>
                  <?php
                } else {
                  //logged in
                  ?>
                	  <li<?php echo (($_GET['section']=='wineries')?" class='current'":"")?>><a href="?section=wineries&page=wineries">Manage Wineries</a></li>
                    <li<?php echo (($_GET['section']=='posmedia')?" class='current'":"")?>><a href="?section=posmedia">Manage POS/Media</a></li>
                    <li><a href="?action=logout">Logout</a></li>
                  <?php
                }
                ?>
              </ul>
          </div>
      </div>             
      <?php
      if ((isset($_SESSION['logged_in'])) && ($_GET['section']=='wineries')){
      ?>
      <div id="top-panel">
          <div id="panel">
              <ul>
                  <li><a href="?section=wineries&page=wineries">Wineries</a></li>
                  <li><a href="?section=wineries&page=lines">Lines</a></li>
                  <li><a href="?section=wineries&page=wines">Wines</a></li>
              </ul>
          </div>
      </div>
      <?php } ?>
      <div id="wrapper">
          <div id="content">