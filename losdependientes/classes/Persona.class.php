<?php
  class Persona extends KwikObject{
    protected $nombre;
    protected $tipo;
    
    function __construct($id = 0){ 
      $this->table = "personas";
      array_push($this->fields, 'nombre', 'tipo');
      array_push($this->persistent, 'nombre', 'tipo');
      array_push($this->editable, 'nombre', 'tipo');
      array_push($this->mandatory, 'nombre', 'tipo');
      
      $this->field_types['nombre'] = 'string';
      $this->field_types['tipo'] = 'tipo_persona';
      
      $this->validation['nombre'] = 'string';
      $this->validation['tipo'] = 'string';            
	  
	  $this->filter_field = 'nombre';
	  
      parent::__construct($id);
    }
    
    public function toString(){
      return $this->nombre;
    }
  }
?>