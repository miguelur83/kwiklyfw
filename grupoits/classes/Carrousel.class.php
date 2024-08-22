<?php
class Carrousel extends KwikObject{
  protected $animacion;
  protected $objects = array(
    'componente' => array('class_name' => 'Componente', 'object' => null)
  );
  protected $collections = array(
	'slides' => array('class_name' => 'SlideCarrousel', 'objects' => array())
  );

  function __construct($id = 0){
    $this->table = "carrousels";       
    array_push($this->fields, "componente", "animacion", "slides");
    array_push($this->persistent, "componente", "animacion");
    array_push($this->editable, "animacion", "slides");
    array_push($this->mandatory, "componente", "animacion");
    $this->field_types["animacion"] = "options";
	$this->options['animacion'] = array(
		1 => "Hacia la derecha",
		2 => "Hacia la izquierda",
		3 => "Disolver"
	);
    $this->validation["animacion"] = "options";
    $this->field_types["componente"] = "object";
    $this->validation["componente"] = "componente";
    $this->field_types["slides"] = "collection";
	$this->manage_url = "index.php?section=componentes&page=marquesinas";
    parent::__construct($id);
  }
  
  public function toString(){
	return "Carrousel #".$this->id;
  }
  
  public function getHTML(){
	$html = '<div id="marquesina">';
	$slides = new SlideCarrousel();
	$slides = $slides->getAll('', 0 , "carrousel=".$this->id);
	foreach($slides as $slide){
		$html .= '<div class="slide">
					<img class="foto-slide" src="uploads/imagen_marquesina/'.$slide['imagen'].'" />
					<h1>'.$slide['titulo'].'</h1>
					<h2>'.$slide['texto'].'</h2>
					<a href="pagina.php?page='.$slide['link'].'">Conoce m&aacute;s</a>
				</div>';
	}
	$html .= '</div>';
	return $html;
  }
}
?>