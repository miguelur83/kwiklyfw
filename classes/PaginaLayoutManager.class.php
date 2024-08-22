<?php
  class PaginaLayoutManager extends DefaultLayoutManager{    
	
	public function getCreateForm($action_URL){
      $fields = $this->my_object->getField('fields');
      $editable = $this->my_object->getField('editable');
      $mandatory = $this->my_object->getField('mandatory');
      $field_types = $this->my_object->getField('field_types');
      
      $form_html = "<p>".$GLOBALS['lang']->getString('msg_input_info_for_new_object',get_class($this->my_object))."</p>";
      $form_html .= "<form enctype='multipart/form-data' id='frm_create_".get_class($this->my_object)."' name='frm_create_".get_class($this->my_object)."' method='post' action='".$action_URL."'>";
      
      foreach($editable as $editable_field){
        $form_html .= $this->getInputForField($editable_field, $field_types[$editable_field], in_array($editable_field, $mandatory));
      } 
	  
	  //The Page editor shows the layout and available components
	  $form_html .= $this->getPageEditor($this->my_object->getField('layout'));
      $form_html .= "<input name='continue' type='checkbox' value='1' checked='checked'>&nbsp;&nbsp;Continuar editando</input><br /><br />";
      
      $form_html .= "<input type='submit' id='frm_create_".get_class($this->my_object)."_submit' name='frm_create_".get_class($this->my_object)."_submit' value='".$GLOBALS['lang']->getString('btn_create')."' />";
      $form_html .= "&nbsp;".$GLOBALS['lang']->getString('txt_or')." <a href='javascript:javascript:history.go(-1)'>".$GLOBALS['lang']->getString('lnk_cancel')."</a>";
      $form_html .= "</form>";
      return $form_html;
    }
	
	public function getUpdateForm($action_URL){
      echo "<p>".$GLOBALS['lang']->getString('msg_editing_object', get_class($this->my_object), $this->my_object->getField("id"))."</p>"; 
      $fields = $this->my_object->getField('fields');
      $editable = $this->my_object->getField('editable');
      $mandatory = $this->my_object->getField('mandatory');
      $field_types = $this->my_object->getField('field_types');
      
      $form_html = "<p>".$GLOBALS['lang']->getString('msg_update_info_for_object', get_class($this->my_object))."</p>";
      $form_html .= "<form enctype='multipart/form-data' id='frm_update_".get_class($this->my_object)."' name='frm_update_".get_class($this->my_object)."' method='post' action='".$action_URL."'>";
      $form_html .= "<input type='hidden' id='id' name='id' value='".$this->my_object->getField('id')."' />";
      
		if($_GET['collector']){
			$form_html .= "<input type='hidden' id='".$this->my_object->getField('collector_field')."' name='".$this->my_object->getField('collector_field')."' value='".$_GET['collector_id']."' />";
		} 
		
      foreach($editable as $editable_field){
        $form_html .= $this->getInputForField($editable_field, $field_types[$editable_field], in_array($editable_field, $mandatory));
      } 
	  
	  //The Page editor shows the layout and available components
	  $form_html .= $this->getPageEditor($this->my_object->getField('layout'));
      $form_html .= "<input name='continue' type='checkbox' value='1' checked='checked'>&nbsp;&nbsp;Continuar editando</input><br /><br />";
	 
      $form_html .= "<input type='submit' id='frm_update_".get_class($this->my_object)."_submit' name='frm_update_".get_class($this->my_object)."_submit' value='".$GLOBALS['lang']->getString('btn_update')."' />";
      $form_html .= "&nbsp;".$GLOBALS['lang']->getString('txt_or')." <a href='javascript:javascript:history.go(-1)'>".$GLOBALS['lang']->getString('lnk_cancel')."</a>";
      $form_html .= "</form>";
      return $form_html;
    }
	
	public function getPageEditor($layout = 0){
		if ($layout == 0){
			$layout = 1;
		}
	
		//The Page editor shows the layout and available components
		$form_html = '
	  <div class="page-editor">
		<p>Arrastre y suelte componentes en las secciones del layout para construir la p&aacute;gina</p>
		<div class="layout-container">';
		
		if($_POST){
			//echo "<pre>".print_r($_POST, 1)."</pre>";
		}
		
		$components = array();
		foreach($_POST['components'] as $component){
			$component = explode("|", $component);
			$component_id = $component[0];
			$object_id = $component[1];
			$component_type = $component[2];
			$seccion_layout = $component[3];
			$components[$seccion_layout][]= array('id' => $component_id, 'object_id' => $object_id, 'type' => $component_type);
		} 
		if ((! isset($_POST['components'])) && ($this->my_object->getField('id') != 0)){
			$link = new ComponentePagina();
			$links = $link->getAll('', 0, "pagina=".$this->my_object->getField('id'));
			foreach ($links as $link_array){
				$componente = new Componente($link_array['componente']);
				$components[$link_array['seccion_layout']][] = array('id' => $link_array['componente'], 'object_id' => $componente->getField('id'), 'type' => $componente->getField('tipo'));
				$_POST['components'][]=$link_array['componente']."|".$componente->getField('id')."|".$componente->getField('tipo')."|".$link_array['seccion_layout'];
			}
		}
		//echo "<pre>".print_r( $components, 1)."</pre>";
		
		switch($layout){
			case 1: //right column
				$form_html .= '
					<div class="top droppable">
						<span class="section">top</span>';
						foreach($components['top'] as $comp){
							$form_html .= $this->getComponentHTML($comp['type'], $comp['id'], 0, 0, 'top');
						}
						$form_html .= '
					</div>
					<div class="left-content droppable">
						<span class="section">left-content</span>';
						foreach($components['left-content'] as $comp){
							$form_html .= $this->getComponentHTML($comp['type'], $comp['id'], 0, 0, 'left-content');
						}
						$form_html .= '
					</div>
					<div class="right-column droppable"> 
						<span class="section">right-column</span>';
						foreach($components['right-column'] as $comp){
							$form_html .= $this->getComponentHTML($comp['type'], $comp['id'], 0, 0, 'right-column');
						}
						$form_html .= '
					</div>';
			break;
			case 2: //left column
				$form_html .= '
					<div class="top droppable">
						<span class="section">top</span>';
						foreach($components['top'] as $comp){
							$form_html .= $this->getComponentHTML($comp['type'], $comp['id'], 0, 0, 'top');
						}
						$form_html .= '
					</div>
					<div class="left-column droppable">
						<span class="section">left-column</span>';
						foreach($components['left-column'] as $comp){
							$form_html .= $this->getComponentHTML($comp['type'], $comp['id'], 0, 0, 'left-column');
						}
						$form_html .= '
					</div>
					<div class="right-content droppable"> 
						<span class="section">right-content</span>';
						foreach($components['right-content'] as $comp){
							$form_html .= $this->getComponentHTML($comp['type'], $comp['id'], 0, 0, 'right-content');
						}
						$form_html .= '
					</div>';
			break;
			case 3: //one column
				$form_html .= '
					<div class="top droppable">
						<span class="section">top</span>';
						foreach($components['top'] as $comp){
							$form_html .= $this->getComponentHTML($comp['type'], $comp['id'], 0, 0, 'top');
						}
						$form_html .= '
					</div>
					<div class="one-column droppable">
						<span class="section">one-column</span>';
						foreach($components['one-column'] as $comp){
							$form_html .= $this->getComponentHTML($comp['type'], $comp['id'], 0, 0, 'one-column');
						}
						$form_html .= '
					</div>';
			break;
			case 4: //home
				$form_html .= '
					<div class="top droppable">
						<span class="section">top</span>';
						foreach($components['top'] as $comp){
							$form_html .= $this->getComponentHTML($comp['type'], $comp['id'], 0, 0, 'top');
						}
						$form_html .= '
					</div>
					<div class="left-column middle droppable">
						<span class="section">left-column</span>';
						foreach($components['left-column'] as $comp){
							$form_html .= $this->getComponentHTML($comp['type'], $comp['id'], 0, 0, 'one-column');
						}
						$form_html .= '
					</div>
					<div class="right-column middle droppable">
						<span class="section">right-column</span>';
						foreach($components['right-column'] as $comp){
							$form_html .= $this->getComponentHTML($comp['type'], $comp['id'], 0, 0, 'one-column');
						}
						$form_html .= '
					</div>
					<div class="one-column middle droppable">
						<span class="section">one-column</span>';
						foreach($components['one-column'] as $comp){
							$form_html .= $this->getComponentHTML($comp['type'], $comp['id'], 0, 0, 'one-column');
						}
						$form_html .= '
					</div>';
			break;
		}
		
		$form_html .= '
			</div>
			<div class="components">
				<p>Componentes</p>'.
				$this->getComponentHTML("Carrousel", 0, 1).
				$this->getComponentHTML("TextoConFormato", 0, 1).
				$this->getComponentHTML("CodigoHTML", 0, 1).
				$this->getComponentHTML("BannerHome", 0, 1).
				$this->getComponentHTML("NoticiasHome", 0, 1).
				$this->getComponentHTML("BannerTitulo", 0, 1).
			'</div>
		</div>';
		$form_html .= "<fieldset id='page_components' name='page_components' style='display:none;'>";
		foreach($_POST['components'] as $component){
			$form_html .= '<input type="hidden" name="components[]" value="'.$component.'" />';
		}
		$form_html .= "</fieldset>";
	  return $form_html;
	}
	
	function getComponentHTML($type, $id=0, $draggable=0, $object_id=0, $layout_section=''){
		switch ($type){
			case 'Carrousel':
				return '<div class="component'.(($draggable)?' draggable':'').'">Marquesina
					<a class="deletelink" href="index.php?section=componentes&page=marquesinas&action=delete'.(($id!=0)?'&componente_id='.$id:'').'&backpage='.$this->my_object->getField('id').'">Delete</a>
					<a class="editlink" href="index.php?section=componentes&page=marquesinas&action=edit'.(($id!=0)?'&componente_id='.$id:'').'&backpage='.$this->my_object->getField('id').'&layout_section='.$layout_section.'">Edit</a>
					<span class="component_type">Carrousel</span>
					<span class="component_id">'.$id.'</span>
					<span class="object_id">'.$object_id.'</span>
				</div>';
			break;
			case 'TextoConFormato':
				return '<div class="component'.(($draggable)?' draggable':'').'">Texto con formato
					<a class="deletelink" href="index.php?section=componentes&page=textos&action=delete'.(($id!=0)?'&componente_id='.$id:'').'&backpage='.$this->my_object->getField('id').'">Delete</a>
					<a class="editlink" href="index.php?section=componentes&page=textos&action=edit'.(($id!=0)?'&componente_id='.$id:'').'&backpage='.$this->my_object->getField('id').'&layout_section='.$layout_section.'">Edit</a>
					<span class="component_type">TextoConFormato</span>
					<span class="component_id">'.$id.'</span>
					<span class="object_id">'.$object_id.'</span>
				</div>';
			break;
			case 'CodigoHTML':
				return '<div class="component'.(($draggable)?' draggable':'').'">C&oacute;digo HTML
					<a class="deletelink" href="index.php?section=componentes&page=codigo_html&action=delete'.(($id!=0)?'&componente_id='.$id:'').'&backpage='.$this->my_object->getField('id').'">Delete</a>
					<a class="editlink" href="index.php?section=componentes&page=codigo_html&action=edit'.(($id!=0)?'&componente_id='.$id:'').'&backpage='.$this->my_object->getField('id').'&layout_section='.$layout_section.'">Edit</a>
					<span class="component_type">CodigoHTML</span>
					<span class="component_id">'.$id.'</span>
					<span class="object_id">'.$object_id.'</span>
				</div>';
			break;
			case 'BannerHome':
				return '<div class="component'.(($draggable)?' draggable':'').'">Banner Home
					<a class="deletelink" href="index.php?section=componentes&page=banners_home&action=delete'.(($id!=0)?'&componente_id='.$id:'').'&backpage='.$this->my_object->getField('id').'">Delete</a>
					<a class="editlink" href="index.php?section=componentes&page=banners_home&action=edit'.(($id!=0)?'&componente_id='.$id:'').'&backpage='.$this->my_object->getField('id').'&layout_section='.$layout_section.'">Edit</a>
					<span class="component_type">BannerHome</span>
					<span class="component_id">'.$id.'</span>
					<span class="object_id">'.$object_id.'</span>
				</div>';
			break;
			case 'NoticiasHome':
				return '<div class="component'.(($draggable)?' draggable':'').'">Noticias Home
					<a class="deletelink" href="index.php?section=componentes&page=noticias_home&action=delete'.(($id!=0)?'&componente_id='.$id:'').'&backpage='.$this->my_object->getField('id').'">Delete</a>
					<a class="editlink" href="index.php?section=componentes&page=noticias_home&action=edit'.(($id!=0)?'&componente_id='.$id:'').'&backpage='.$this->my_object->getField('id').'&layout_section='.$layout_section.'">Edit</a>
					<span class="component_type">NoticiasHome</span>
					<span class="component_id">'.$id.'</span>
					<span class="object_id">'.$object_id.'</span>
				</div>';
			break;
			case 'BannerTitulo':
				return '<div class="component'.(($draggable)?' draggable':'').'">Banner T&iacute;tulo
					<a class="deletelink" href="index.php?section=componentes&page=banners_titulo&action=delete'.(($id!=0)?'&componente_id='.$id:'').'&backpage='.$this->my_object->getField('id').'">Delete</a>
					<a class="editlink" href="index.php?section=componentes&page=banners_titulo&action=edit'.(($id!=0)?'&componente_id='.$id:'').'&backpage='.$this->my_object->getField('id').'&layout_section='.$layout_section.'">Edit</a>
					<span class="component_type">BannerTitulo</span>
					<span class="component_id">'.$id.'</span>
					<span class="object_id">'.$object_id.'</span>
				</div>';
			break;
		}
	}
  }
?>