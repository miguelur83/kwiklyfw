<?php
class CodigoHTML extends KwikObject{
  protected $contenido;
  protected $objects = array(
    'componente' => array('class_name' => 'Componente', 'object' => null)
  );

  function __construct($id = 0){
    $this->table = "codigos_html";       
    array_push($this->fields, "componente", "contenido");
    array_push($this->persistent, "componente", "contenido");
    array_push($this->editable, "contenido");
    array_push($this->mandatory, "componente", "contenido");
    $this->field_types["contenido"] = "text";
    $this->validation["contenido"] = "text";
    $this->field_types["componente"] = "object";
    $this->validation["componente"] = "componente";
    parent::__construct($id);
  }
  
  public function toString(){
	return "Codigo HTML #".$this->id;
  }
  
  public function getHTML(){
	return stripslashes($this->contenido);
  }
}
?>