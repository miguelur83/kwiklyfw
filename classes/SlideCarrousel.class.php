<?php
class SlideCarrousel extends KwikObject{
  protected $titulo;
  protected $texto;
  protected $imagen;
  protected $link;
  protected $sorter;
  protected $carrousel;

  function __construct($id = 0){
    $this->table = "slides_carrousel";       
    array_push($this->fields, 'carrousel', 'titulo', 'texto', 'imagen', 'link', 'sorter');
    array_push($this->persistent, 'carrousel', 'titulo', 'texto', 'imagen', 'link', 'sorter');
    array_push($this->editable, 'titulo', 'texto', 'imagen', 'link', 'sorter');
    array_push($this->mandatory, 'carrousel', 'titulo', 'imagen', 'link', 'sorter');
    $this->field_types["carrousel"] = 'collector';
    $this->field_types["titulo"] = 'string';
    $this->field_types["texto"] = 'string';
    $this->field_types["imagen"] = 'imagen_marquesina';
    $this->field_types["link"] = 'string';
    $this->field_types["sorter"] = 'int';
    $this->validation["carrousel"] = 'collector';
    $this->validation["titulo"] = 'string';
    $this->validation["imagen"] = 'imagen_marquesina';
    $this->validation["link"] = 'string';
    $this->validation["sorter"] = 'int';
	
	$this->collector_field = "carrousel";
	$this->manage_url = "index.php?section=componentes&page=slides";
    parent::__construct($id);
  }
  
  public function toString(){
	return "Slide carrousel #".$this->id;
  }
}
?>