<?php
class Winery extends KwikObject{
  protected $name;
  protected $menu_name;
  protected $logo;
  protected $description;
  protected $objects = array(
    'country' => array('class_name' => 'Country', 'object' => null)
  );
  protected $collections = array(
    'lines' => array ('class_name' => 'Line', 'objects' => array())
  );

  function __construct($id = 0){
    $this->table = "wineries";       
    array_push($this->fields, "name", "menu_name", "logo", "description", "country");
    array_push($this->persistent, "name", "menu_name", "logo", "description", "country");
    array_push($this->editable, "name", "menu_name", "logo", "description", "country");
    array_push($this->mandatory, "name", "menu_name", "logo", "description", "country");
    $this->field_types["name"] = "string";
    $this->field_types["menu_name"] = "string";
    $this->field_types["lines"] = "collection";
    $this->field_types["logo"] = "file";
    $this->field_types["description"] = "richtext";
    $this->field_types["country"] = "object";
    $this->validation["name"] = "string";
    $this->validation["menu_name"] = "string";
    $this->validation["logo"] = "file";
    $this->validation["description"] = "richtext";
    $this->validation["country"] = "Nto1";
    $this->field_help['name'] = "The name of the Winery.";
    $this->field_help['menu_name'] = "The name of the Winery as it will appear on menus.";
    $this->field_help['logo'] = "Winery logo. RGB image, 150px width.";
    $this->field_help['description'] = "Text description for the winery.";
    $this->field_help['country'] = "Winery country, for country menus.";
    parent::__construct($id);
  }
  
  public function toString(){
    return $this->name;
  }
}
?>