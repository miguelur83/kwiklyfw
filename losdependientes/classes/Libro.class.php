<?php
  class Libro extends KwikObject{
    protected $titulo;
    protected $anio;
    protected $tapa;
    protected $archivo_PDF;
    protected $publicar;
    protected $ordernum;
    protected $sinopsis;       
    protected $objects = array(
      'autor' => array('class_name' => 'Persona', 'object' => null),
      'genero' => array('class_name' => 'Genero', 'object' => null)
    );
    
    function __construct($id = 0){      
      $this->table = "libros";
      array_push($this->fields, 'titulo', 'autor', 'genero', 'anio', 'tapa', 'archivo_PDF', 'ordernum', 'sinopsis', 'publicar');
      array_push($this->persistent, 'titulo', 'autor', 'genero', 'anio', 'tapa', 'archivo_PDF', 'ordernum', 'sinopsis', 'publicar');
      array_push($this->editable, 'titulo', 'autor', 'genero', 'anio', 'tapa', 'archivo_PDF', 'ordernum', 'sinopsis', 'publicar');
      array_push($this->mandatory, 'titulo', 'autor', 'archivo_PDF', 'sinopsis', 'publicar');
      
      $this->field_types['titulo'] = 'string';
      $this->field_types['autor'] = 'persona';
      $this->field_types['genero'] = 'genero';
      $this->field_types['anio'] = 'int';
      $this->field_types['tapa'] = 'tapa_libro';
      $this->field_types['archivo_PDF'] = 'pdf';
      $this->field_types['ordernum'] = 'order';
      $this->field_types['sinopsis'] = 'richtext';
      $this->field_types['publicar'] = 'boolean';
      
      $this->validation['titulo'] = 'string';
      $this->validation['autor'] = 'persona';
      $this->validation['genero'] = 'genero';
      $this->validation['anio'] = 'int';
      $this->validation['tapa'] = 'tapa_libro';
      $this->validation['archivo_PDF'] = 'pdf';
      $this->validation['ordernum'] = 'int';
      $this->validation['sinopsis'] = 'richtext';
      $this->validation['publicar'] = 'boolean';
      
      $this->field_help['tapa'] = '(Opcional) Imagen de tapa del libro. Dimensiones: 150 x 215 px.';
      $this->field_help['archivo_PDF'] = 'Archivo PDF del libro, para descargar.';
      $this->field_help['sinopsis'] = 'Sinopsis del libro. Puede utilizar formatos. Si pega el texto desde una fuente externa, utilice la herramienta \'Limpiar C&oacute;digo Basura\' (escobilla).';
      $this->field_help['publicar'] = 'Marque si desea publicar el art&iacute;culo. Puede hacerlo m&aacute;s tarde.';
                      
	  $this->filter_field = 'titulo';
	                         
      parent::__construct($id);
    }
  }
?>