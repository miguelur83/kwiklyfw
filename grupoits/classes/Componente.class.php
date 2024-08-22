<?php
class Componente extends KwikObject{
  protected $tipo;
  /*protected $object_id;*/

  function __construct($id = 0){
    $this->table = "componentes";       
    array_push($this->fields, "tipo"/*, "object_id"*/);
    array_push($this->persistent, "tipo"/*, "object_id"*/);
    $this->field_types["tipo"] = "string";
    /*$this->field_types["object_id"] = "int";*/
    parent::__construct($id);
  }
  
  public function toString(){
	return "Componente #".$this->id;
  }
  
  public function getComponente(){
	$class = $this->tipo;
	//die($this->id."-".$class);
	$comp = new $class();
	$comp = $comp->getAll(0, '', "componente=".$this->id);
	if(isset($comp[0])){
		$comp = new $class($comp[0]['id']);
		return $comp;
	} else {
		return null;
	}
  }
}
?>