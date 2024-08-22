<?php
class Media extends KwikObject{
  protected $title;
  protected $file;
  protected $objects = array(
    'section' => array('class_name' => 'MediaSection', 'object' => null)
  );

  function __construct($id = 0){
    $this->table = "media_files";       
    array_push($this->fields, "title", "section", "file");
    array_push($this->persistent, "title", "section", "file");
    array_push($this->editable, "title", "section", "file");
    array_push($this->mandatory, "title", "section", "file");
    $this->field_types["title"] = "string";
    $this->field_types["file"] = "pdf";
    $this->field_types["section"] = "object";
    $this->validation["title"] = "string";
    $this->validation["file"] = "pdf";
    $this->validation["section"] = "Nto1";
    parent::__construct($id);
  }
}
?>