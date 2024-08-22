<?php
  /**
   * KwikObject
   * An abstract class (can't be instantiated) that, given the fields, automatically
   * loads them from database.
   * This class is the base class for all the classes in the system, it allows
   * for the automatization of persistance and editable classes.      
   * 
   * Un objeto tiene una serie de atributos
   * De esos atributos, algunos son persistentes
   * De ellos, algunos son editables               
   **/
              
  abstract class KwikObject{
    protected $id;
    
    protected static $table_exists;
    
    //Name of the object's table in the database
    protected $table;
    //List of object fields - this might no be necessary
    protected $fields = array ('id');
    //List of fields that will be saved on the database
    protected $persistent = array ('id');
    //List of fields editable by CMS
    protected $editable = array ();
    //List of mandatory editable fields
    protected $mandatory = array ('id');
    //Field types for this object, as an array of 'field' => 'type'
    protected $field_types = array(
      'id' => "int"
    );
    //Default field values for this object, as an array of 'field' => 'value'
    protected $default_values = array();
    //Field validation settings for this object, as an array of 'field' => 'validation_type'
    protected $validation = array();
    //Help text for editable fields 'field' => 'help text'
    protected $field_help = array(
      'id' => "This is the object's id in the database - not editable."
    );
    
    protected $validationErrors;
    
    //For relationships
    // An array of 'field_name' => array('class_name' => 'ClassName', 'object' => KwikObject)    
    protected $objects = array();
    
    //For collections
    // An array of 'collection_name' => array('ClassName', array());
    protected $collections = array();
        
    //Layout Manager manages how the object is seen in the user interface
    protected static $layout_manager;
    
    function __construct($id = 0){
      $this->layout_manager = new DefaultLayoutManager($this);
      
      $db = $GLOBALS['db'];
      
      //Default values
      foreach($this->fields as $field){
        if (array_key_exists($field, $this->default_values)){
          $this->{$field} = $this->default_values[$field];   
        }
      }
      
      // Instantiates an object from the database table, or if it doesn't exist,
      // creates a new one.
      if ($id != 0){              
        $this->id = $id;
        $db->select("*", $this->table, "id = '".$this->id."'");
        if ($row = $db->getRow()){
          foreach($this->persistent as $field){
            $this->{$field} = $row[$field];
            if ($this->field_types[$field] == "richtext"){
              $this->{$field} = stripslashes($row[$field]);
            }
            if (array_key_exists($field, $this->objects)){
              $the_class = $this->objects[$field]['class_name'];
              $this->objects[$field]['object'] = new $the_class($row[$field]);
            }  
          }
        }
      }
    }  
    
    public function getForId($id){
      $class = get_class($this);
      return new $class($id);
    }  
    
    public function getFirst($conditions = '1'){
      $db = $GLOBALS['db'];
      $db->select("*", $this->table, $conditions, "1");
      if ($row = $db->getRow()){
        return $this->getForId($row['id']);
      } else {
        return false;
      }
    } 
    
    public function setFields($field_data){
      foreach($field_data as $field => $value){
        if (in_array($field, $this->editable)){
          $this->{$field} = $value;
        }
      }
    }
    
    public function validate(){
      $result = true;
      $this->validationErrors = "";
      foreach ($this->validation as $field => $validation){
        switch ($validation){
          case 'int':
            if (! is_int( $this->{$field} )){
              $this->validationErrors .= "- '".$this->getLayoutManager()->getTitleFromName($field)."' must be an integer.<br />";
              $result = false;
            }
          break;
          case 'Nto1':
            $classname = $this->objects[$field]['class_name'];
            $object_id = $this->{$field};
            $an_object = new $classname($object_id);
            if ((! is_object($an_object)) || (is_null($an_object))){
              $this->validationErrors .= "- '".$this->getLayoutManager()->getTitleFromName($field)."' must have a value.<br />";       
              $result = false;
            }
          break;
          case 'file':
            if (! isset($_FILES[$field])){
              $this->validationErrors .= "- '".$this->getLayoutManager()->getTitleFromName($field)."' is mandatory.<br />";
              $result = false;
            }
          break;
          case 'string':
          default:
            if (! strlen(trim( $this->{$field} ))){
              $this->validationErrors .= "- '".$this->getLayoutManager()->getTitleFromName($field)."' can't be an empty string.<br />";
              $result = false;
            }
          break;
        } 
      }
      return $result;
    }
    
    public function getValidationErrors(){
      return $this->validationErrors;
    }
            
    public function createTable(){
      if (isset($this->table)){
        $db = $GLOBALS['db'];
        if($db->createTable(
          $this->table,
          $this->persistent,
          $this->mandatory,
          $this->field_types,
          $this->default_values
        )){
          return true;
        } else {
          return false;
        }
      } else {
        return false;
      }
    }
            
    public function updateTable(){
      if (isset($this->table)){
        $db = $GLOBALS['db'];
        if($db->updateTable(
          $this->table,
          $this->persistent,
          $this->mandatory,
          $this->field_types,
          $this->default_values
        )){
          return true;
        } else {
          return false;
        }
      } else {
        return false;
      }
    }
    
    public function save(){
      $db = $GLOBALS['db'];
      // Create field array
      $field_data = array();
      foreach($this->persistent as $field){
        if ($field != 'id'){
          $field_data[$field] = $this->{$field};
        }
      }
      if ($this->id == 0){
        if($result_id = $db->insert($this->table, $field_data)){
          $this->id = $result_id;
          return $this->id;
        } else {
          return false;
        }
      } else {
        if($db->update($this->table, "id = '".$this->id."'", $field_data)){
          return $this->id;
        } else {
          return false;
        }
      }
    }
    
    public function delete(){
      $db = $GLOBALS['db'];
      return $db->delete($this->table, "id = '".$this->id."'");
    }
    
    public function getAll($sorted_by = "id", $desc = 0, $conditions = "1"){
      $db = $GLOBALS['db'];
      $result = $db->select("*", $this->table, $conditions." ORDER BY ".$sorted_by."".(($desc)?" DESC":""));
      $all_items = array();
      while ($one_item = mysql_fetch_array($result)){
        $all_items[] = $one_item;
      } 
      return $all_items;
    }
    
    public function getLayoutManager(){
      return $this->layout_manager;
    }
    
    public function getField($field_name){
      if (isset($this->{$field_name})){
        return $this->{$field_name};
      } else {
        return null;
      }
    }
    
    public function getObject($field_name){
      if (isset($this->objects[$field_name])){
        return $this->objects[$field_name]['object'];
      } else {
        $classname = $this->objects[$field_name]['class_name'];
        $the_object = new $classname($this->{$field_name});
        $this->objects[$field_name]['object'] = $the_object;
        return $the_object; 
      }
    }
    
    public function setField($field_name, $value){
      $this->{$field_name} = $value;
    }
    
    public function toString(){
      return get_class($this)." ".$this->id;
    }
  }
?>