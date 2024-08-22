<?php
class ComponentePagina extends KwikObject{
  protected $pagina;
  protected $componente;
  protected $seccion_layout;
  protected $orden;

  function __construct($id = 0){
    $this->table = "componentes_paginas";       
    array_push($this->fields, "pagina", "componente", "seccion_layout", "orden");
    array_push($this->persistent, "pagina", "componente", "seccion_layout", "orden");
    array_push($this->editable, "pagina", "componente", "seccion_layout", "orden");
    array_push($this->mandatory, "pagina", "componente", "seccion_layout", "orden");
    $this->field_types["pagina"] = "int";
    $this->field_types["componente"] = "int";
    $this->field_types["seccion_layout"] = "string";
    $this->field_types["orden"] = "sorter";
    $this->validation["pagina"] = "int";
    $this->validation["componente"] = "int";
    $this->validation["seccion_layout"] = "string";
    $this->validation["orden"] = "int";
	
	$this->sorter_field = "orden";
	
    parent::__construct($id);
  }
}
?>