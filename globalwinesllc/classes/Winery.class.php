<?php
class Winery extends KwikObject{
  protected $name;
  protected $logo;
  protected $description;
  protected $florida_distributor;
  protected $national_importer;
  protected $objects = array(
    'country' => array('class_name' => 'Country', 'object' => null)
  );
  protected $collections = array(
    'lines' => array ('class_name' => 'Line', 'objects' => array())
  );

  function __construct($id = 0){
    $this->table = "wineries";       
    array_push($this->fields, "name", "logo", "description", "country", 'florida_distributor', 'national_importer');
    array_push($this->persistent, "name", "logo", "description", "country", 'florida_distributor', 'national_importer');
    array_push($this->editable, "name", "logo", "description", "country", 'florida_distributor', 'national_importer');
    array_push($this->mandatory, "name", "logo", "description", "country", 'florida_distributor', 'national_importer');
    $this->field_types["name"] = "string";
    $this->field_types["lines"] = "collection";
    $this->field_types["logo"] = "logo_winery";
    $this->field_types["description"] = "richtext";
    $this->field_types["country"] = "object";
    $this->field_types["florida_distributor"] = "boolean";
    $this->field_types["national_importer"] = "boolean";
    $this->validation["name"] = "string";
    $this->validation["logo"] = "logo_winery";
    $this->validation["description"] = "richtext";
    $this->validation["country"] = "Nto1";
    $this->validation["florida_distributor"] = "boolean";
    $this->validation["national_importer"] = "boolean";
    $this->field_help['name'] = "The name of the Winery.";
    $this->field_help['logo'] = "Winery logo. RGB image, 150px width.";
    $this->field_help['description'] = "Text description for the winery.";
    $this->field_help['country'] = "Winery country, for country menus.";
    $this->field_help["florida_distributor"] = "Show for Florida Distributor?";
    $this->field_help["national_importer"] = "Show for National Importer?";
	  
    $this->default_values["florida_distributor"] = "1";
    $this->default_values["national_importer"] = "1";
	
	  $this->filter_field = 'name';
	  
    parent::__construct($id);
  }
  
  public function toString(){
    return $this->name;
  }
}
?>