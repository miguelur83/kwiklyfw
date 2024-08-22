<?php
  class Critica extends KwikObject{
    protected $tipo;
    protected $calificacion;
    protected $contenido;
    protected $publicar;
    protected $ordernum;     
    protected $objects = array(
      'critico' => array('class_name' => 'Persona', 'object' => null),
      'evento' => array('class_name' => 'Evento', 'object' => null),
      'pelicula' => array('class_name' => 'Pelicula', 'object' => null)
    );
	protected $foto_1;
	protected $foto_2;
	protected $foto_3;
	protected $destacada;
	protected $banner_home;
	protected $logo_home;
    protected $popularidad;
    
    function __construct($id = 0){         
      $this->table = "criticas";
      array_push($this->fields, 'tipo', 'critico', 'calificacion', 'evento', 'contenido', 'ordernum', 'pelicula', 'foto_1', 'foto_2', 'foto_3', 'destacada', 'banner_home', 'logo_home', 'publicar', 'popularidad');
      array_push($this->persistent, 'tipo', 'critico', 'calificacion', 'evento', 'contenido', 'ordernum', 'pelicula', 'foto_1', 'foto_2', 'foto_3', 'destacada', 'banner_home', 'logo_home', 'publicar', 'popularidad');
      array_push($this->editable, 'tipo', 'critico', 'calificacion', 'evento', 'contenido', 'ordernum', 'pelicula', 'foto_1', 'foto_2', 'foto_3', 'destacada', 'banner_home', 'logo_home', 'publicar');
      array_push($this->mandatory, 'tipo', 'critico', 'calificacion', 'contenido', 'ordernum', 'pelicula', 'publicar');
      
      $this->field_types['tipo'] = 'tipo_critica';
      $this->field_types['critico'] = 'persona';
      $this->field_types['calificacion'] = 'float';
      $this->field_types['evento'] = 'evento';
      $this->field_types['contenido'] = 'richtext';
      $this->field_types['ordernum'] = 'order';
      $this->field_types['pelicula'] = 'embedded_object';
      $this->field_types['foto_1'] = 'foto_critica';
      $this->field_types['foto_2'] = 'foto_critica';
      $this->field_types['foto_3'] = 'foto_critica';
      $this->field_types['publicar'] = 'boolean';
      $this->field_types['destacada'] = 'boolean';
      $this->field_types['banner_home'] = 'banner_home';
      $this->field_types['logo_home'] = 'logo_home';
      $this->field_types['popularidad'] = 'int';
      
      $this->validation['tipo'] = 'boolean';
      $this->validation['critico'] = 'persona';
      $this->validation['calificacion'] = 'float';
      $this->validation['evento'] = 'evento';
      $this->validation['contenido'] = 'richtext';
      $this->validation['ordernum'] = 'int';     
      $this->validation['pelicula'] = 'Nto1';   
      $this->validation['foto_1'] = 'foto_critica';
      $this->validation['foto_2'] = 'foto_critica';
      $this->validation['foto_3'] = 'foto_critica';
      $this->validation['publicar'] = 'boolean';
      $this->validation['destacada'] = 'boolean';
      $this->validation['banner_home'] = 'banner_home';
      $this->validation['logo_home'] = 'logo_home';
	  
      $this->field_help['critico'] = 'Autor del art&iacute;culo.';
      $this->field_help['calificacion'] = 'Del 1 al 10.';
      $this->field_help['evento'] = '(Opcional) Evento relacionado.';
      $this->field_help['contenido'] = 'Texto del art&iacute;culo. Puede utilizar formatos. Si pega el texto desde una fuente externa, utilice la herramienta \'Limpiar C&oacute;digo Basura\' (escobilla).';
      $this->field_help['foto_1'] = '(Opcional) Dimensiones: 650px alto max. El ancho se dimensionar&aacute; autom&aacute;ticamente.';
      $this->field_help['foto_2'] = '(Opcional) Dimensiones: 650px alto max. El ancho se dimensionar&aacute; autom&aacute;ticamente.';
      $this->field_help['foto_3'] = '(Opcional) Dimensiones: 650px alto max. El ancho se dimensionar&aacute; autom&aacute;ticamente.';
      $this->field_help['publicar'] = 'Marque si desea publicar el art&iacute;culo. Puede hacerlo m&aacute;s tarde.';
      $this->field_help['destacada'] = 'Marque si desea destacar el art&iacute;culo en la p&aacute;gina principal. Debe ingresar una imagen de banner y logo.';
      $this->field_help['banner_home'] = 'Imagen de banner para la p&aacute;gina principal. Dimensiones: 671px ancho x 186px alto.';
	  $this->field_help['logo_home'] = 'Imagen de logo para la p&aacute;gina principal. PNG transparente. Dimensiones: 37px alto (ancho 230px max.)';
      
      $this->default_values['popularidad'] = '0';
	  
	  $this->filter_field = 'contenido';
	  
      parent::__construct($id);
	  //$this->layout_manager = new CriticaLayoutManager($this);
    }
  }
?>