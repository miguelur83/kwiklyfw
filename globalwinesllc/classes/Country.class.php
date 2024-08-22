<?php
class Country extends KwikObject{ 
  protected $name;
  protected $flag_image;

  function __construct($id = 0){
    $this->table = "countries";       
    array_push($this->fields, "name", "flag_image");
    array_push($this->persistent, "name", "flag_image");
    array_push($this->editable, "name", "flag_image");
    array_push($this->mandatory, "name", "flag_image");
    $this->field_types["name"] = "string";
    $this->validation["name"] = "string";
    $this->field_types["flag_image"] = "flag_image";
    $this->validation["flag_image"] = "flag_image";
    parent::__construct($id);
  }
  
  public function toString(){
    return $this->name;
  }
}
?>