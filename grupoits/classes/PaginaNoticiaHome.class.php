<?php
class PaginaNoticiaHome extends KwikObject{
  protected $menu;
  protected $titulo;
  protected $texto;
  protected $URL;
  protected $noticias_home;

  function __construct($id = 0){
    $this->table = "paginas_noticias_home";       
    array_push($this->fields, 'menu', 'titulo', 'texto', 'URL', 'noticias_home');
    array_push($this->persistent, 'menu', 'titulo', 'texto', 'URL', 'noticias_home');
    array_push($this->editable, 'menu', 'titulo', 'texto', 'URL');
    array_push($this->mandatory, 'menu', 'titulo', 'texto', 'URL', 'noticias_home');
    $this->field_types["menu"] = "string";
    $this->validation["menu"] = "string";
    $this->field_types["titulo"] = "string";
    $this->validation["titulo"] = "string";
    $this->field_types["texto"] = "richtext";
    $this->validation["texto"] = "richtext";
    $this->field_types["URL"] = "string";
    $this->validation["URL"] = "string";
    $this->field_types["noticias_home"] = "collector";
    $this->validation["noticias_home"] = "collector";
	
	$this->collector_field = "noticias_home";
	$this->manage_url = "index.php?section=componentes&page=pagina_noticias";
    parent::__construct($id);
  }
  
  public function toString(){
	return "Pagina Noticias Home #".$this->id;
  }
}
?>