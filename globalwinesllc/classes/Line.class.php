<?php
class Line extends KwikObject{
  protected $menu_name;
  protected $body_name;
  protected $ordernum;
  protected $objects = array(
    'winery' => array('class_name' => 'Winery', 'object' => null)
  );
  protected $collections = array(
    'wines' => array ('class_name' => 'Wine', 'objects' => array())
  );

  function __construct($id = 0){
    $this->table = "winelines";       
    array_push($this->fields, "menu_name", "body_name", "ordernum", "winery");
    array_push($this->persistent, "menu_name", "body_name", "ordernum", "winery");
    array_push($this->editable, "menu_name", "body_name", "ordernum", "winery");
    array_push($this->mandatory, "menu_name", "body_name", "winery");
    $this->field_types["menu_name"] = "string";
    $this->field_types["body_name"] = "string";
    $this->field_types["ordernum"] = "order";
    $this->field_types["winery"] = "object";
    $this->validation["menu_name"] = "string";
    $this->validation["body_name"] = "string";
    $this->validation["ordernum"] = "ordernum";
    $this->validation["winery"] = "Nto1";
    $this->field_help["menu_name"] = "Line name, as it will appear on menus.";
    $this->field_help["body_name"] = "Line name, as it will appear on the pages body.";
    $this->field_help["ordernum"] = "You can use this field to force a sorting order for Lines.";
    parent::__construct($id);
	  
	  $this->filter_field = 'menu_name';
  } 
  
  public function toString(){
    return $this->menu_name;
  }
}
?>