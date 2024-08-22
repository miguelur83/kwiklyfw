<?php
  class Genero extends KwikObject{
    protected $nombre;
    
    function __construct($id = 0){   
      $this->table = "generos";
      $this->fields[] = "nombre";
      $this->persistent[] = "nombre";
      $this->editable[] = "nombre";
      $this->mandatory[] = "nombre";
	  
      $this->field_types['nombre'] = 'string';
      $this->validation['nombre'] = 'string';           
	  
	  $this->filter_field = 'nombre';
	  
      parent::__construct($id);
    }
    
    public function toString(){
      return $this->nombre;
    }
  }
?>