<?php
  class DefaultPersistenceManager{
    protected $my_object;
    
    function __construct($a_kwikobject){
      //Debería comprobar que el objeto sea un KwikObject
      $this->my_object = $a_kwikobject;
    }
    
    public function getFirst($conditions = '1'){
      $db = $GLOBALS['db'];
      $db->select("*", $this->my_object->getField(table), $conditions, "1");
      if ($row = $db->getRow()){
        return $this->getForId($row['id']);
      } else {
        return false;
      }
    }
  }
?>