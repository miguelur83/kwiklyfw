<?php
class BannerHome extends KwikObject{
  protected $titulo;
  protected $texto;
  protected $URL;
  protected $imagen;
  protected $objects = array(
    'componente' => array('class_name' => 'Componente', 'object' => null)
  );

  function __construct($id = 0){
    $this->table = "banners_home";       
    array_push($this->fields, "titulo", "texto", "URL", "imagen", "componente");
    array_push($this->persistent, "titulo", "texto", "URL", "imagen", "componente");
    array_push($this->editable, "titulo", "texto", "URL", "imagen");
    array_push($this->mandatory, "titulo", "texto", "URL", "imagen", "componente");
    $this->field_types["titulo"] = "string";
    $this->validation["titulo"] = "string";
    $this->field_types["texto"] = "richtext";
    $this->validation["texto"] = "richtext";
    $this->field_types["URL"] = "string";
    $this->validation["URL"] = "string";
    $this->field_types["imagen"] = "banner_home";
    $this->validation["imagen"] = "banner_home";
    $this->field_types["componente"] = "object";
    $this->validation["componente"] = "componente";
    parent::__construct($id);
  }
  
  public function toString(){
	return "Banner Home #".$this->id;
  }
  
  public function getHTML(){
	$html = '<div class="banner-container">
				<img src="uploads/banner_home/'.$this->imagen.'" />
				<div class="banner-home">
					<h3>'.$this->titulo.'</h3>
					<p>'.$this->texto.'</p>
					'.(($this->URL != '')?'<a href="pagina.php?page='.$this->URL.'">+ INFO</a>':'').'
				</div>
			</div>';
	return $html;
  }
}
?>