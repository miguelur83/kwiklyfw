<?php
class Country extends KwikObject{ 
  protected $name;

  function __construct($id = 0){
    $this->table = "countries";       
    array_push($this->fields, "name");
    array_push($this->persistent, "name");
    array_push($this->editable, "name");
    array_push($this->mandatory, "name");
    $this->field_types["name"] = "string";
    $this->validation["name"] = "string";
    parent::__construct($id);
  }
  
  public function toString(){
    return $this->name;
  }
}
?>