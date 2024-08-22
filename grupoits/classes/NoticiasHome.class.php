<?php
class NoticiasHome extends KwikObject{
  protected $contenido;
  protected $objects = array(
    'componente' => array('class_name' => 'Componente', 'object' => null)
  );
  protected $collections = array(
	'noticias' => array('class_name' => 'PaginaNoticiaHome', 'objects' => array())
  );

  function __construct($id = 0){
    $this->table = "noticias_home";       
    array_push($this->fields, "componente", "noticias");
    array_push($this->persistent, "componente");
    array_push($this->editable, "noticias");
    array_push($this->mandatory, "componente");
    $this->field_types["componente"] = "object";
    $this->field_types["noticias"] = "collection";
    $this->validation["componente"] = "componente";
	$this->manage_url = "index.php?section=componentes&page=noticias_home";
    parent::__construct($id);
  }
  
  public function toString(){
	return "Noticias Home #".$this->id;
  }
  
  public function getHTML(){
	$html = '';
	$paginas = new PaginaNoticiaHome();
	$paginas = $paginas->getAll('',0,"noticias_home=".$this->id);
	$html .= '<div id="tabs">
				<ul id="tab-titles">';
	$first = true;
	$c = 0;
	foreach ($paginas as $pagina){
		$c++;
		$html .= '<li'.(($first)?' class="active"':'').'><a href="page'.$c.'">'.$pagina['menu'].'</a></li>';
		if ($first){$first=false;}
	}
	$html .= '</ul>';
	$first = true;
	$c = 0;
	foreach ($paginas as $pagina){
		$c++;
		$html .= '<div class="tab-content" id="page'.$c.'"'.((! $first)?' style="display:none;"':'').'>
			<h3>'.$pagina['titulo'].'</h3>
			'.$pagina['texto'].(($pagina['URL']!='')?'<a href="'.$pagina['URL'].'">Leer m&aacute;s</a>':'').'
		</div>';
	}
		
	$html .= '</div>';
	return $html;
  }
}
?>