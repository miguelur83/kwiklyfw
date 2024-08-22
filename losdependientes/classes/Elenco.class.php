<?php
  class Elenco extends KwikObject{
    protected $pelicula;
    protected $actor;
    
    function __construct($id = 0){  
      $this->table = "elenco";
      array_push($this->fields, 'pelicula', 'actor');
      array_push($this->persistent, 'pelicula', 'actor');
      array_push($this->mandatory, 'pelicula', 'actor');
      
      $this->field_types['pelicula'] = 'int';
      $this->field_types['actor'] = 'int';
      
      $this->validation['pelicula'] = 'int';
      $this->validation['actor'] = 'int';
                                                       
      parent::__construct($id);
    }
  }
?>