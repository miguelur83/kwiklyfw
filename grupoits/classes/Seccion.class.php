<?php
class Seccion extends KwikObject{
  protected $nombre;
  protected $objects = array(
    'layout' => array('class_name' => 'Layout', 'object' => null)
  );

  function __construct($id = 0){
    $this->table = "secciones";       
    array_push($this->fields, "nombre", "layout");
    array_push($this->persistent, "nombre", "layout");
    array_push($this->editable, "nombre", "layout");
    array_push($this->mandatory, "nombre", "layout");
    $this->field_types["nombre"] = "string";
    $this->validation["nombre"] = "string";
    $this->field_types["layout"] = "object";
    $this->validation["layout"] = "Nto1";
    parent::__construct($id);
  }
  
  public function toString(){
	return $this->id." - ".$this->nombre;
  }
}
?>