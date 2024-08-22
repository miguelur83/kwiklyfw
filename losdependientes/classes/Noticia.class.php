<?php
  class Noticia extends KwikObject{
	protected $fecha;    
    protected $objects = array(
      'pais' => array('class_name' => 'Pais', 'object' => null)
    );
    protected $titulo;
	protected $texto;
    protected $imagen;
    protected $video_ID;   
	protected $publicar;
    
    function __construct($id = 0){   
      $this->table = "noticias";
      array_push($this->fields, 'fecha', 'pais', 'titulo', 'texto', 'imagen', 'video_ID', 'publicar');
      array_push($this->persistent, 'fecha', 'pais', 'titulo', 'texto', 'imagen', 'video_ID', 'publicar');
      array_push($this->editable, 'fecha', 'pais', 'titulo', 'texto', 'imagen', 'video_ID', 'publicar');
      array_push($this->mandatory, 'fecha', 'pais', 'titulo', 'texto');
      
      $this->field_types['fecha'] = 'date';
      $this->field_types['pais'] = 'pais';
      $this->field_types['titulo'] = 'string';
      $this->field_types['texto'] = 'richtext';
      $this->field_types['imagen'] = 'imagen_noticia';
      $this->field_types['video_ID'] = 'youtube_video';
      $this->field_types['publicar'] = 'boolean';
      
      $this->validation['fecha'] = 'date';
      $this->validation['pais'] = 'pais';
      $this->validation['titulo'] = 'string';
      $this->validation['texto'] = 'richtext';
      $this->validation['imagen'] = 'imagen_noticia';
      $this->validation['video_ID'] = 'youtube_video';
      $this->validation['publicar'] = 'boolean';
      
	  $this->field_help['fecha'] = 'Fecha en formato AAAA-MM-DD. Utilice el selector para llenar este campo.';
	  $this->field_help['imagen'] = '(Opcional) Imagen ilustrativa.';
      $this->field_help['video_ID'] = '(Opcional) ID del video en Youtube. Son los &uacute;ltimos 11 caracteres de la URL.';
      $this->field_help['publicar'] = 'Marque si desea publicar el art&iacute;culo. Puede hacerlo m&aacute;s tarde.';
	  
	  $this->filter_field = 'titulo';
              
      parent::__construct($id);
    }     
    
    public function toString(){
      return $this->fecha." - ".$this->titulo;
    }
  }
?>