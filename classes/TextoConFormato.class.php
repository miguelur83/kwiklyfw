<?php
class TextoConFormato extends KwikObject{
  protected $texto;
  protected $objects = array(
    'componente' => array('class_name' => 'Componente', 'object' => null)
  );

  function __construct($id = 0){
    $this->table = "textos_con_formato";       
    array_push($this->fields, "componente", "texto");
    array_push($this->persistent, "componente", "texto");
    array_push($this->editable, "texto");
    array_push($this->mandatory, "componente", "texto");
    $this->field_types["texto"] = "richtext";
    $this->validation["texto"] = "richtext";
    $this->field_types["componente"] = "object";
    $this->validation["componente"] = "componente";
    parent::__construct($id);
  }
  
  public function toString(){
	return "Texto con formato #".$this->id;
  }
  
  public function getHTML(){
	return $this->texto;
  }
}
?>