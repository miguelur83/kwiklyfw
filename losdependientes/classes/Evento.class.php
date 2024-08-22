<?php
  class Evento extends KwikObject{
    protected $nombre;
    protected $fecha_inicio;
    protected $fecha_fin;
    protected $logo;
    
    function __construct($id = 0){  
      $this->table = "eventos";
      array_push($this->fields, 'nombre', 'fecha_inicio', 'fecha_fin', 'logo');
      array_push($this->persistent, 'nombre', 'fecha_inicio', 'fecha_fin', 'logo');
      array_push($this->editable, 'nombre', 'fecha_inicio', 'fecha_fin', 'logo');
      array_push($this->mandatory, 'nombre');
      
      $this->field_types['nombre'] = 'string';
      $this->field_types['fecha_inicio'] = 'date';
      $this->field_types['fecha_fin'] = 'date';
      $this->field_types['logo'] = 'file';
      
      $this->validation['nombre'] = 'string';
      $this->validation['fecha_inicio'] = 'date';
      $this->validation['fecha_fin'] = 'date';
      $this->validation['logo'] = 'file';
                                                       
      parent::__construct($id);
    }
    
    public function toString(){
      return $this->nombre;
    }
  }
?>