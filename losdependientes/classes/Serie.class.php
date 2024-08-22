<?php
  class Serie extends KwikObject{
    protected $titulo;
    protected $anio;
    protected $afiche;
    protected $youtube_ID;       
    protected $objects = array(
      'director' => array('class_name' => 'Persona', 'object' => null),
      'genero' => array('class_name' => 'Genero', 'object' => null)
    );
    
    function __construct($id = 0){  
      $this->table = "series";
      array_push($this->fields, 'titulo', 'director', 'genero', 'anio', 'afiche', 'youtube_ID');
      array_push($this->persistent, 'titulo', 'director', 'genero', 'anio', 'afiche', 'youtube_ID');
      array_push($this->editable, 'titulo', 'director', 'genero', 'anio', 'afiche', 'youtube_ID');
      array_push($this->mandatory, 'titulo');
      
      $this->field_types['titulo'] = 'string';
      $this->field_types['director'] = 'persona';
      $this->field_types['genero'] = 'genero';
      $this->field_types['anio'] = 'int';
      $this->field_types['afiche'] = 'file';
      $this->field_types['youtube_ID'] = 'string';
      
      $this->validation['titulo'] = 'string';
      $this->validation['director'] = 'persona';
      $this->validation['genero'] = 'genero';
      $this->validation['anio'] = 'int';           
      parent::__construct($id);
    }
    
    public function toString(){
      return $this->titulo;
    }
  }
?>