<?php
  /** 
   * Magic autoload function
   * used to include the appropriate class files when they are needed
   * @param String the name of the class
   */
  function __autoload( $class_name )
  {
    if (file_exists(dirname(__FILE__).'/classes/' . $class_name.'.class.php')){
  	   require_once(dirname(__FILE__).'/classes/' . $class_name.'.class.php' );
    }
  }  
  
  //DB Connection
  switch ($_SERVER['SERVER_NAME']){
    case 'localhost':                                                                                       
      $GLOBALS['db'] = new Database('localhost', 'root', 'password', 'gwines' );                     
      error_reporting(0);
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="styles/default.css"/>
  <!--[if IE]>
  <link rel="stylesheet" type="text/css" href="styles/explorer.css"/>
  <![endif]-->
  <title>Global Wines - Wine Importer &amp; Distributor</title>
  
  <!-- BEGIN jquery.cycle slideshow --> 
    <!-- include jQuery library -->
    <script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
    
    <!-- include Cycle plugin -->
    <script type="text/javascript" src="js/jquery.cycle.all.min.js"></script>
    
    <!--  initialize the slideshow when the DOM is ready -->
    <script type="text/javascript">
    $(document).ready(function() {
      $('.copa').cycle({
    		fx: 'fade',
        delay: -4000,
        timeout: 5000
    	});
      $('.barriles').cycle({
    		fx: 'fade',
        delay: -3000,
        timeout: 5000
    	});
      $('.parra').cycle({
    		fx: 'fade',
        delay: -2000,
        timeout: 5000
    	});
      $('.campo').cycle({
    		fx: 'fade',
        delay: -1000,
        timeout: 5000
    	});
      $('.uvas').cycle({
    		fx: 'fade',
        delay: 0,
        timeout: 5000
    	});
      $('.page_image').cycle({
    		fx: 'fade'
    	});
    });
    </script>                           
  <!-- END jquery.cycle slideshow -->
                       
    <script type="text/javascript">
    /*
      $(document).ready(function(){
      $('area.state_link').hover(function(){
        var id = $(this).attr('id');
        $('#' + id + '_info').css({ 'display': 'block'});
        $('#instructions').css({ 'display': 'none'});
      });
      $('area.state_link').mouseout(function(){   
        var id = $(this).attr('id');
        $('#' + id + '_info').css({ 'display': 'none'});
        $('#instructions').css({ 'display': 'block'});
      });
    });
    */ 
    $(document).ready(function(){
      $('.state_link').hover(function(){
        var id = $(this).attr('id');
        $('#' + id + '_info').css({'display':'block'});
        $('#instructions').css({'display':'none'});
      },function(){
        var id = $(this).attr('id');
        $('#' + id + '_info').css({'display': 'none'});
        $('#instructions').css({'display': 'block'});
      }
      );
    });
    </script>
</head>