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
      new Media()
    );
  } catch (Exception $error) {
    echo "Objects could not be instanciated.<br />"; die ($error->getMessage());
  }
  
  //DB Connection   
  switch ($_SERVER['SERVER_NAME']){
    case 'localhost':   
      if(! $db = new Database('localhost', 'root', 'password', 'gwines' )){
        echo "Connection to database failed.<br />"; die(mysql_error());
      }
    break;
    case 'jupish.com.ar':
      if(! $db = new Database('localhost', 'jupishc_gwines', 'gl0balw1n3s', 'jupishc_gwines' )){
        echo "Connection to database failed.<br />"; die(mysql_error());
      }
    break;
  }                                                                                    
  
  
  foreach ($objects as $object){
    if ($db->table_exists($object->getField('table'))){
      if ($_GET['drop_table_if_exists']){
        if($db->execute('DROP TABLE '.$object->getField('table'))){
          echo "Table '".$object->getField('table')."' for ".get_class($object)." has been deleted and will be regenerated.<br />";
          $create = 1;
        } else {
          echo "Table '".$object->getField('table')."' for ".get_class($object)." could not be deleted.<br />".mysql_error()."<br />";
        }
      } else {
        echo "Table '".$object->getField('table')."' for ".get_class($object)." already exists.<br />";
      }
    } else {
      $create = 1;
    }
    if ($create){
      if($object->createTable()){
        echo "Table '".$object->getField('table')."' for ".get_class($object)." has been created.<br />";
      } else {
        echo "Table '".$object->getField('table')."' for ".get_class($object)." could not be created.<br />";
      }
    }
  }
?>