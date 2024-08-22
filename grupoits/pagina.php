<?php 
	if($_GET['page'] == 'contacto'){include("contacto.php");die();}
	include ("inc/header.php");
	include ("inc/nav.php"); 
	if(! isset($page)){ die();}
?>
</div>
<?php
	$links = new ComponentePagina();
	$links = $links->getAll("orden",0,"pagina=".$page->getField('id'));
	$componentes = array();
	foreach($links as $link){
		$comp = new Componente($link['componente']);
		$comp = $comp->getComponente();
		if (! is_null($comp)){
			$componentes[$link['seccion_layout']][] = $comp;
		}
	}		
	include ("layouts/layout-".$page->getField('layout').".php");
?>
<?php include ("inc/footer.php"); ?>