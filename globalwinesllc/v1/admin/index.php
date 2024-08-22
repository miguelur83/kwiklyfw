<?php
  // Session and login control
      session_start();
      if (! isset($_SESSION['logged_in'])){
        header("Location:login.php");
      }
      
      if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
        unset($_SESSION);
        session_destroy();
        header("Location:login.php?action=expired");
      }
      
      $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
      
      if ($_GET['action'] == 'logout'){
        unset($_SESSION);
        session_destroy();
        header("Location:login.php?action=logged_out");
      }
  // END Session and login control
  
  /** 
   * Magic autoload function
   * used to include the appropriate class files when they are needed
   * @param String the name of the class
   */
  function __autoload( $class_name )
  {
    if (file_exists(dirname(__FILE__).'/../classes/' . $class_name.'.class.php')){
  	   require_once(dirname(__FILE__).'/../classes/' . $class_name.'.class.php' );
    }
  }
  
  //DB Connection
  switch ($_SERVER['SERVER_NAME']){
    case 'localhost':                                                                                       
      $GLOBALS['db'] = new Database('localhost', 'root', 'password', 'gwines' );
    break;
    case 'jupish.com.ar':
      $GLOBALS['db'] = new Database('localhost', 'jupishc_gwines', 'gl0balw1n3s', 'jupishc_gwines' );
      error_reporting(0);
    break;
    case 'globalwinesllc.com':
      $GLOBALS['db'] = new Database('localhost', 'uv013037_gwines', 'aPe1RzyMWV', 'gwines' );
      error_reporting(0);
    break;
  }
  
  if (! $_GET['section']) { $_GET['section'] = "wineries"; }
  if ((! $_GET['page']) && ($_GET['section'] == "wineries")) { $_GET['page'] = "wineries"; } 
  
  include ("head.php");
  include ("header.php");
  
  switch($_GET['section']){
    case "wineries":
      switch ($_GET['page']){
        case "wineries":
          $title = "Manage Wineries";
          $_GET['manage_class'] = "Winery";
        break;
        case "lines":         
          $title = "Manage Wineries - Lines";
          $_GET['manage_class'] = "Line";
        break;
        case "wines":               
          $title = "Manage Wineries - Wines";
          $_GET['manage_class'] = "Wine";
        break;
      }
    break;
    case "posmedia":         
      $title = "Manage POS / Media";
      $_GET['manage_class'] = "Media";
    break;
  }
  echo "<h1>".$title."</h1>";
  include ("management.php");
   
  include ("footer.php");
?>