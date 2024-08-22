<?php
  include("../inc/kwikly_bootstrap.php");
  
  $db = $GLOBALS['db'];
  
  //Model objects - collects an instance of each Business Model class declared in kwikly_bootstrap
  $objects = array();
  //die("<pre>".print_r($model_classes, true)."</pre>");
  foreach ($model_classes as $class){
	try{
		$objects[] = new $class;
	} catch (Exception $error){
		echo $lang->getString('msg_objects_cannot_be_instanciated')."<br />"; die ($error->getMessage());
	}
  }
  //die("<pre>".print_r($objects, true)."</pre>");
    
  foreach ($objects as $object){
    if ($db->table_exists($object->getField('table'))){
		echo $lang->getString('msg_table_already_exists', $object->getField('table'), get_class($object))."<br />";
      if($object->updateTable()){
		echo $lang->getString('msg_table_has_been_updated', $object->getField('table'), get_class($object))."<br />";
      } else {
		echo $lang->getString('msg_table_could_not_be_updated', $object->getField('table'), get_class($object))."<br />";
      }
    } else {
      if($object->createTable()){
		echo $lang->getString('msg_table_has_been_created', $object->getField('table'), get_class($object))."<br />";
      } else {
		echo $lang->getString('msg_table_could_not_be_created', $object->getField('table'), get_class($object))."<br />";
      }
    }
  }
?>