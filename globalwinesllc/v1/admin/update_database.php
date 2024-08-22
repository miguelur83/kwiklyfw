<?php
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
  
  //Model Objects
  try{ 
    $objects = array(
      new Winery(),
      new Line(),
      new Wine(),
      new Media(),
      new Country()
    );
  } catch (Exception $error) {
    echo "Objects could not be instanciated.<br />"; die ($error->getMessage());
  }
  
  //DB Connection   
  switch ($_SERVER['SERVER_NAME']){
    case 'localhost':
      $db_server = 'localhost';
      $db_user = 'root';
      $db_pass = 'password';
      $db_name = 'gwines';
    break;
    case 'jupish.com.ar': 
      $db_server = 'localhost';
      $db_user = 'jupishc_gwines';
      $db_pass = 'gl0balw1n3s';
      $db_name = 'jupishc_gwines';
      error_reporting (0);
    break;  
    case 'globalwinesllc.com':    
      $db_server = 'localhost';
      $db_user = 'uv013037_gwines';
      $db_pass = 'aPe1RzyMWV';
      $db_name = 'gwines';
      error_reporting (0);
    break;
  }                                                                                    
  
  if(! $db = new Database($db_server, $db_user, $db_pass, $db_name )){
    echo "Connection to database failed.<br />"; die(mysql_error());
  } else {
    $db_ok = 1;
  }
  
  foreach ($objects as $object){
    if ($db->table_exists($object->getField('table'))){
      echo "Table '".$object->getField('table')."' for ".get_class($object)." already exists.<br />";
      if($object->updateTable()){
        echo "Table '".$object->getField('table')."' for ".get_class($object)." has been updated.<br />";
      } else {
        echo "Table '".$object->getField('table')."' for ".get_class($object)." could not be updated.<br />";
      }
    } else {
      if($object->createTable()){
        echo "Table '".$object->getField('table')."' for ".get_class($object)." has been created.<br />";
      } else {
        echo "Table '".$object->getField('table')."' for ".get_class($object)." could not be created.<br />";
      }
    }
  }
?>