<?php
class Layout extends KwikObject{
  protected $nombre;
  protected $objects = array(
    ///////////////////
  );
  //For collections
	// An array of 'collection_name' => array('ClassName', array());
	protected $collections = array(
		'secciones' => array(
			'Seccion', 
			array()
		)
	);

  function __construct($id = 0){
    $this->table = "layouts";       
    array_push($this->fields, "nombre");
    array_push($this->persistent, "nombre");
    array_push($this->editable, "nombre");
    array_push($this->mandatory, "nombre");
    $this->field_types["nombre"] = "string";
    $this->validation["nombre"] = "string";
    parent::__construct($id);
  }
  
  public function toString(){
	return $this->id." - ".$this->nombre;
  }
}
?>