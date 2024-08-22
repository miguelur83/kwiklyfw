<?php
class Media extends KwikObject{
  protected $title;
  protected $file;

  function __construct($id = 0){
    $this->table = "media_files";       
    array_push($this->fields, "title", "file");
    array_push($this->persistent, "title", "file");
    array_push($this->editable, "title", "file");
    array_push($this->mandatory, "title", "file");
    $this->field_types["title"] = "string";
    $this->field_types["file"] = "file";
    $this->validation["title"] = "string";
    $this->validation["file"] = "file";
    parent::__construct($id);
  }
}
?>