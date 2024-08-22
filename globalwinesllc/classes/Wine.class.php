<?php
class Wine extends KwikObject{ 
  protected $name;
  protected $region;
  protected $varietal;
  protected $description;
  protected $bottle_image;
  protected $ordernum;    
  protected $objects = array(
    'line' => array('class_name' => 'Line', 'object' => null)
  );
  protected $PDF_card_file;

  function __construct($id = 0){
    $this->table = "wines";       
    array_push($this->fields, "name", "region", "varietal", "description", "bottle_image", "ordernum", "line", "PDF_card_file");
    array_push($this->persistent, "name", "region", "varietal", "description", "bottle_image", "ordernum", "line", "PDF_card_file");
    array_push($this->editable, "name", "region", "varietal", "description", "bottle_image", "ordernum", "line", "PDF_card_file");
    array_push($this->mandatory, "name", "region", "varietal", "description", "bottle_image", "line", "PDF_card_file");
    $this->field_types["name"] = "string";
    $this->field_types["region"] = "string";
    $this->field_types["varietal"] = "string";
    $this->field_types["description"] = "richtext";
    $this->field_types["bottle_image"] = "bottle_image";
    $this->field_types["ordernum"] = "order";
    $this->field_types["line"] = "object";    
    $this->field_types["PDF_card_file"] = "pdf";       
    $this->validation["name"] = "string";
    $this->validation["region"] = "string";
    $this->validation["varietal"] = "string";
    $this->validation["description"] = "richtext";
    $this->validation["bottle_image"] = "bottle_image";   
    $this->validation["ordernum"] = "ordernum";
    $this->validation["line"] = "Nto1";
    $this->validation["PDF_card_file"] = "pdf";
    
    $this->field_help["name"] = "Name for this wine.";
    $this->field_help["region"] = "Wine region, for wine card.";
    $this->field_help["varietal"] = "Wine varietal description, for wine card page.";
    $this->field_help["description"] = "Wine description, for wine card page.";
    $this->field_help["bottle_image"] = "Bottle image for the wine. RGB PNG format with transparent background. Dimensions: 74x222px.";
    $this->field_help["PDF_card_file"] = "PDF version of the wine card, for user download.";
	  
	$this->filter_field = 'name';
	  
    parent::__construct($id);
  }
}
?>