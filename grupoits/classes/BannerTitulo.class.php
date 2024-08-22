<?php
class BannerTitulo extends KwikObject{
  protected $titulo;
  protected $imagen;
  protected $objects = array(
    'componente' => array('class_name' => 'Componente', 'object' => null)
  );

  function __construct($id = 0){
    $this->table = "banners_titulo";       
    array_push($this->fields, "titulo", "imagen", "componente");
    array_push($this->persistent, "titulo", "imagen", "componente");
    array_push($this->editable, "titulo", "imagen");
    array_push($this->mandatory, "titulo", "imagen", "componente");
    $this->field_types["titulo"] = "string";
    $this->field_types["imagen"] = "banner_titulo";
    $this->field_types["componente"] = "object";
    $this->validation["titulo"] = "string";
    $this->validation["imagen"] = "banner_titulo";
    $this->validation["componente"] = "componente";
    parent::__construct($id);
  }
  
  public function toString(){
	return "Banner Titulo #". $this->id;
  }
  
  public function getHTML(){
	$html = '<img src="uploads/banner_titulo/'.$this->imagen.'" />
		<div id="header-interno">
			<h1>'.$this->titulo.'</h1>
		</div>';
	return $html;
  }
}
?>