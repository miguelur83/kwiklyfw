<?php
class Pagina extends KwikObject{
  protected $titulo;
  protected $friendly_url;
  protected $orden;
  protected $objects = array(
    'layout' => array('class_name' => 'Layout', 'object' => null)
  );
  protected $publicacion;

  function __construct($id = 0){
    $this->table = "paginas";       
    array_push($this->fields, "titulo", "friendly_url", "layout", "orden", "publicacion");
    array_push($this->persistent, "titulo", "friendly_url", "layout", "orden", "publicacion");
    array_push($this->editable, "titulo", "friendly_url", "layout", "publicacion");
    array_push($this->mandatory, "titulo", "layout", "publicacion");
    $this->field_types["titulo"] = "string";
    $this->field_types["friendly_url"] = "string";
    $this->field_types["layout"] = "object";
    $this->field_types["orden"] = "sorter";
    $this->validation["titulo"] = "string";
    $this->validation["layout"] = "Nto1";
    $this->validation["orden"] = "int";
    $this->field_types["publicacion"] = "options";
    $this->validation["publicacion"] = "options";
	$this->options['publicacion'] = array(
		1 => "Borrador",
		2 => "Publicado"
	);
	array_push($this->default_values, "publicacion", 1);
	
	$this->sorter_field = 'orden';
    
	parent::__construct($id);
	
    $this->layout_manager = new PaginaLayoutManager($this);
  }
  
  public function toString(){
	return $this->id." - ".$this->titulo;
  }
  
  public function delete(){
      $db = $GLOBALS['db'];
	  $links = new ComponentePagina();
	  $links = $links->getAll('',0,"pagina=".$this->id);
	  foreach($links as $link){
		$db->delete("componentes", "id = '".$link['componente']."'");
		$db->delete("componentes_paginas", "id = '".$link['id']."'");
	  }
	  return parent::delete();
  }
  
  public function saveComponents($components){
	$c = 0;
	$last_section = '';
	foreach($components as $component){
		$component = explode("|", $component);
		$component_id = $component[0];
		$object_id = $component[1];
		$component_type = $component[2];
		$seccion_layout = $component[3];
		
		if($seccion_layout != $last_section){
			$last_section = $seccion_layout;
			$c = 1;
		} else {
			$c++;
		}
		
		$the_comp = new Componente($component_id);
		$the_comp->setField('tipo', $component_type);
		if ($comp_id = $the_comp->save()){
			//echo "Saved comp #".$comp_id."<br />";
			$link = new ComponentePagina();
			$links = $link->getAll('', 0, "componente=".$comp_id." AND pagina=".$this->id);
			if (isset($links[0])){
				$link = $link->getForId($links[0]['id']);
			} 
			$link->setField('pagina', $this->id);
			$link->setField('componente', $comp_id);
			$link->setField('seccion_layout', $seccion_layout);
			$link->setField('orden', $c);
			$link_id = $link->save();
			//echo "Saved link #".$link_id."<br />";
		}
	}
  }
}
?>