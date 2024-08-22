<?php
class Menu extends KwikObject{
  protected $nombre;
  protected $URL;
  protected $mostrar_en_nav;
  protected $mostrar_en_footer;
  protected $objects = array(
    'menu_padre' => array('class_name' => 'Menu', 'object' => null)
  );
  protected $orden;

  function __construct($id = 0){
    $this->table = "menues";       
    array_push($this->fields, "nombre", "URL", "mostrar_en_nav", "mostrar_en_footer", "menu_padre", "orden");
    array_push($this->persistent, "nombre", "URL", "mostrar_en_nav", "mostrar_en_footer", "menu_padre", "orden");
    array_push($this->editable, "nombre", "URL", "mostrar_en_nav", "mostrar_en_footer", "menu_padre");
    array_push($this->mandatory, "nombre", "orden");
    $this->field_types["nombre"] = "string";
    $this->field_types["URL"] = "string";
    $this->field_types["mostrar_en_nav"] = "boolean";
    $this->field_types["mostrar_en_footer"] = "boolean";
    $this->field_types["menu_padre"] = "object";
    $this->field_types["orden"] = "sorter";
    $this->validation["nombre"] = "string";
	$this->default_values['mostrar_en_nav'] = "1";
	$this->default_values['mostrar_en_footer'] = "1";
	$this->default_values['menu_padre'] = "0";
	
	$this->sorter_field = "orden";
	
    parent::__construct($id);
	
	$this->layout_manager = new MenuLayoutManager($this);
  }
  
  public function toString(){
	return $this->id." - ".$this->nombre;
  }
}
?>