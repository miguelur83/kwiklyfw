<?php
  class DefaultLayoutManager{
    protected $my_object;
    
    function __construct($a_kwikobject){
      //Debería comprobar que el objeto sea un KwikObject
      $this->my_object = $a_kwikobject;
    }
    
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
      
      foreach($editable as $editable_field){
        $form_html .= $this->getInputForField($editable_field, $field_types[$editable_field], in_array($editable_field, $mandatory));
      } 
      
      $form_html .= "<input type='submit' id='frm_update_".get_class($this->my_object)."_submit' name='frm_update_".get_class($this->my_object)."_submit' value='".$GLOBALS['lang']->getString('btn_update')."' />";
      $form_html .= "&nbsp;".$GLOBALS['lang']->getString('txt_or')." <a href='javascript:javascript:history.go(-1)'>".$GLOBALS['lang']->getString('lnk_cancel')."</a>";
      $form_html .= "</form>";
      return $form_html;
    }
	
    public function getEmbeddedForm($id = 0, $prefix = "", $locked){ 
      $fields = $this->my_object->getField('fields');
      $editable = $this->my_object->getField('editable');
      $mandatory = $this->my_object->getField('mandatory');
      $field_types = $this->my_object->getField('field_types');
      
	  $form_html .= "<input type='hidden' id='".$prefix."id' name='".$prefix."id' value='".$this->my_object->getField('id')."' />";
      
      foreach($editable as $editable_field){
        $form_html .= $this->getInputForField($editable_field, $field_types[$editable_field], in_array($editable_field, $mandatory), $locked, $prefix);
      } 
      
      return $form_html;
    }
    
    public function getDeleteForm($action_URL){            
      $fields = $this->my_object->getField('fields');
      $editable = $this->my_object->getField('editable');
      $mandatory = $this->my_object->getField('mandatory');
      $field_types = $this->my_object->getField('field_types');
      
      $form_html = "<p>".$GLOBALS['lang']->getString('msg_delete_object', get_class($this->my_object), $this->my_object->getField("id"))."</p>";
      $form_html .= "<form enctype='multipart/form-data' id='frm_delete_".get_class($this->my_object)."' name='frm_delete_".get_class($this->my_object)."' method='post' action='".$action_URL."'>";
      $form_html .= "<input type='hidden' id='id' name='id' value='".$this->my_object->getField('id')."' />";
      
      foreach($editable as $editable_field){
        $form_html .= $this->getInputForField($editable_field, $field_types[$editable_field], in_array($editable_field, $mandatory), 1);
      } 
      
      $form_html .= "<input type='submit' id='frm_delete_".get_class($this->my_object)."_submit' name='frm_delete_".get_class($this->my_object)."_submit' value='".$GLOBALS['lang']->getString('btn_delete')."' />";
      $form_html .= "&nbsp;".$GLOBALS['lang']->getString('txt_or')." <a href='javascript:javascript:history.go(-1)'>".$GLOBALS['lang']->getString('lnk_cancel')."</a>";
      $form_html .= "</form>";
      return $form_html;
    }
    
    //Returns a table with all objects from this class, with Edit and Delete links
    public function getViewableList($pageURL, $sorted_by = "id", $desc = 0, $filter=''){
		if ($filter != ''){
			$cond = $this->my_object->getFilterField()." LIKE '%".$filter."%'";
		} else {
			$cond = '1';
		}
		
		$fields = $this->my_object->getField('fields');
		$resultados = $this->my_object->getCount($cond);
	  
		$per_page = 10;
		$total_pages = ceil($resultados / $per_page);
		if(! isset($_GET['p'])){
			$page = 1;
		} else {
			$page = $_GET['p'];
		}
		$prev_page = $page - 1;
		if ($resultados > $page * $per_page){ $next_page = $page + 1; } else { $next_page = 0; }
		$page_to = $page * $per_page;
		$page_from = $page_to - $per_page + 1;
		if ($page_to > $resultados){ $page_to = $resultados; } 
		if ($page_from > $resultados){ $page_from = $resultados; } 
		$limit = $per_page;
		$offset = $per_page * ($page - 1);
	  
      $all_items = $this->my_object->getAll($sorted_by, $desc, $cond, $limit, $offset); 
	  $list_html = '';
      $list_html .= "<a class='add_link' href='".$pageURL."&action=create'>".$GLOBALS['lang']->getString('lnk_create_new_object', $this->getTitleFromName(get_class($this->my_object)))."</a>";
      
	  if ($this->my_object->getFilterField() != ''){
	  	$list_html .= "<form id='filter' name='filter' method='post' action='".$pageURL."'><input type='text' name='filtertxt' id='filtertxt' value='".$_GET['filter']."' /><input type='submit' id='filter_submit' name='filter_submit' value='".$GLOBALS['lang']->getString('btn_filter_by_field', ucwords($this->my_object->getFilterField()))."' /></form>";
	  }
	  
	  $list_html .= '<div class="pagination">'.$GLOBALS['lang']->getString('txt_showing_pages_of_total', $page_from, $page_to, $resultados).'&nbsp;<a href="'.($prev_page?$pageURL.'&sortby='.$sorted_by.'&p='.$prev_page:'#').(($_GET['filter'])?"&filter=".$_GET['filter']:"").'">&laquo;</a>&nbsp;'.$GLOBALS['lang']->getString('txt_page_x_of_x', $page, $total_pages).'&nbsp;<a href="'.($next_page?$pageURL.'&sortby='.$sorted_by.'&p='.$next_page:'#').(($_GET['filter'])?"&filter=".$_GET['filter']:"").'">&raquo;</a></div>';
      $list_html .= "<table><tr>";
      foreach ($fields as $field){
	  	if ($field != 'ordernum'){
        	$list_html .= "<th><a href='".$pageURL."&sortby=".$field.(($field==$sorted_by)?(($desc)?"&desc=0":"&desc=1"):"").(($_GET['filter'])?"&filter=".$_GET['filter']:"")."'>".$this->getTitleFromName($field).(($field==$sorted_by)?(($desc)?" &darr;":" &uarr;"):"")."</a></th>"; 
		}
      }
      $list_html .= "<th colspan='2' width='7%'>".$GLOBALS['lang']->getString('txt_actions')."</th>";
      $list_html .= "</tr>";
      
      $field_types = $this->my_object->getField('field_types');
      foreach ($all_items as $an_item){
        $list_html .= "<tr>";                              
        foreach ($fields as $field){
          switch ($field_types[$field]){
            case 'collection':
              $list_html .= "<td>(".$GLOBALS['lang']->getString('txt_collection').")</td>";
            break;
            case 'persona':                        
              $my_object_class = get_class($this->my_object);
              $this->my_object = new $my_object_class($an_item['id']);
              $the_object = $this->my_object->getObject($field);   
              //$list_html .= "<td>".$the_object->toString()."</td>";
              $list_html .= "<td><a href='?section=".$_GET['section']."&page=personas&action=edit&id=".$the_object->getField('id')."'>".$the_object->toString()."</a></td>";
            break;        
            case 'genero':                      
              $my_object_class = get_class($this->my_object);
              $this->my_object = new $my_object_class($an_item['id']);
              $the_object = $this->my_object->getObject($field);   
              //$list_html .= "<td>".$the_object->toString()."</td>";
              $list_html .= "<td><a href='?section=".$_GET['section']."&page=generos&action=edit&id=".$the_object->getField('id')."'>".$the_object->toString()."</a></td>";
            break;    
            case 'evento':                      
              $my_object_class = get_class($this->my_object);
              $this->my_object = new $my_object_class($an_item['id']);
              $the_object = $this->my_object->getObject($field);   
              //$list_html .= "<td>".$the_object->toString()."</td>";
              $list_html .= "<td><a href='?section=".$_GET['section']."&page=eventos&action=edit&id=".$the_object->getField('id')."'>".$the_object->toString()."</a></td>";
            break;   
            case 'embedded_object':                      
              $my_object_class = get_class($this->my_object);
              $this->my_object = new $my_object_class($an_item['id']);
              $the_object = $this->my_object->getObject($field);   
              //$list_html .= "<td>".$the_object->toString()."</td>";
              $list_html .= "<td><a href='?section=".$_GET['section']."&page=peliculas&action=edit&id=".$the_object->getField('id')."'>".$the_object->toString()."</a></td>";
            break;   
            case 'object':
              $my_object_class = get_class($this->my_object);
              $this->my_object = new $my_object_class($an_item['id']);
              $the_object = $this->my_object->getObject($field);
              $list_html .= "<td>".$the_object->toString()."</td>";
            break;
            case 'file':
              $list_html .= "<td><a target='_blank' href='../uploads/".$an_item[$field]."'>".$an_item[$field]."</a></td>";
            break;        
            case 'banner_home':
            case 'logo_home':
            case 'foto_critica':
            case 'afiche_pelicula':
            case 'tapa_libro':
            case 'logo_winery':
            case 'bottle_image':
            case 'flag_image':
				switch ($field_types[$field]){
					case 'banner_home': $folder = 'banner_home/'; break;
					case 'logo_home': $folder = 'logo_home/'; break;
					case 'foto_critica': $folder = 'fotos_criticas/full/'; break;
					case 'afiche_pelicula': $folder = 'afiche_pelicula/home/'; break;
					case 'tapa_libro': $folder = 'tapa_libro/home/'; break;
					case 'logo_winery': $folder = 'logo_winery/'; break;
					case 'bottle_image': $folder = 'bottle_image/'; break;
					case 'flag_image': $folder = 'flag_image/'; break;
				}
				if ($an_item[$field] != ''){
	              $list_html .= "<td><a class='lightbox_link' href='../uploads/".$folder.$an_item[$field]."'><img src='img/iconset/image.png' alt='".$an_item[$field]."'></a></td>";
				} else {
				  $list_html .= "<td></td>";
				}
            break;   
            case 'pdf':
			  if ($an_item[$field] != ''){
				$list_html .= "<td><a class='pdf_link' target='_blank' href='../uploads/".$an_item[$field]."'>".$an_item[$field]."</a></td>";
			  } else {
				$list_html .= "<td></td>";
			  }
            break;
            case 'richtext':
              $list_html .= "<td>".substr(strip_tags($an_item[$field]),0,20)."...</td>";
            break;
            case 'boolean':
              $list_html .= "<td>".(($an_item[$field] == '1')?"Yes":"No")."</td>";
            break;
            case 'tipo_critica':
              $list_html .= "<td>".(($an_item[$field] == '1')?"Rese&ntilde;a":"Cr&iacute;tica")."</td>";
            break;
            case 'tipo_pelicula':
              $list_html .= "<td>".(($an_item[$field] == '1')?"Serie":"Pel&iacute;cula")."</td>";
            break;
            case 'elenco':
			  $peli = new Pelicula($an_item['id']);
			  $elenco_string = $peli->getElencoString();
              $list_html .= "<td>".$elenco_string."</td>";
            break;
            case 'order':
              /*$list_html .= "<td><a href='".$pageURL."&field=".$field."&up=".$an_item['id']."'>Up</a>&nbsp;<a href='".$pageURL."&field=".$field."&down=".$an_item['id']."'>Down</a></td>";*/
            break;
            case 'youtube_video':
              if ($an_item[$field] != ''){                                       
                 $list_html .= "<td><a href='http://www.youtube.com/watch?v=".$an_item[$field]."' title='Ver video' target='_blank'><img src='img/iconset/video.png' alt='Video' /></a></td>";
              } else {
                $list_html .= "<td></td>";
              }
            break;
            default:                                       
              $list_html .= "<td>".$an_item[$field]."</td>";
            break;
          } 
        }
        $list_html .= "<td><a class='edit_link' title='".$GLOBALS['lang']->getString('lbl_edit')."' href='".$pageURL."&action=edit&id=".$an_item['id']."'>".$GLOBALS['lang']->getString('lbl_edit')."</a></td><td><a class='delete_link' title='".$GLOBALS['lang']->getString('lbl_delete')."' href='".$pageURL."&action=delete&id=".$an_item['id']."'>".$GLOBALS['lang']->getString('lbl_delete')."</a></td>";
        $list_html .= "</tr>";
      }
      $list_html .= "</table>";
      return $list_html;
    }
    
    public function getTitleFromName($field_name){
      $title = ucwords(str_replace("_", " ", $field_name));
	  // Custom cases
	  switch ($title){
	  	case 'Anio': $title = "A&ntilde;o"; break;
	  	case 'Titulo': $title = "T&iacute;tulo"; break;
	  	case 'Calificacion': $title = "Calificaci&oacute;n"; break;
	  	case 'Critico': $title = "Cr&iacute;tico"; break;
	  	case 'Pelicula': $title = "Pel&iacute;cula / Serie"; break;
	  	case 'Genero': $title = "G&eacute;nero"; break;
	  	case 'Archivo PDF': $title = "PDF"; break;
	  	case 'Youtube ID': $title = "Trailer"; break;
	  }
	  return $title;
    }
    
    public function getInputForField($field_name, $field_type, $required, $locked = 0, $prefix = '', $hide_field = 0){
      switch ($field_type){
        /*
        case 'string': $db_type = "VARCHAR (255)"; break;
        case 'pos': $db_type = "INT"; break;
        case 'neg': $db_type = "INT"; break;
        case 'int': $db_type = "INT"; break;
        case 'float': $db_type = "FLOAT"; break;
        case 'text': $db_type = "TEXT"; break;
        case 'date': $db_type = "DATE"; break;
        case 'time': $db_type = "TIME"; break;
        case 'datetime': $db_type = "DATETIME"; break;
        case 'boolean': $db_type = "BOOL"; break;*/
        case 'embedded_object':
			$objects = $this->my_object->getField('objects');
			$this_class = $objects[$field_name]['class_name'];
			$new_object = new $this_class($this->my_object->getField($field_name));
			
			$input_html .= "<fieldset ".($locked?"disabled='disabled' ":"")." id='".$field_name."_fields"."'".(($hide_field)?" style='display:none'":"")."><legend>".$this->getTitleFromName($field_name)."</legend>";
			$input_html .= $new_object->getLayoutManager()->getEmbeddedForm(0, $field_name."_", $locked);
			$input_html .= "</fieldset><br /><br />";
		break;
        case 'evento':
          $input_html  = "<label for='".$prefix.$field_name."'>".$this->getTitleFromName($field_name).(($required)?" (*)":"").":</label> ";
          $evento = new Evento($this->my_object->getField($field_name));
          $input_html .= "<input ".($locked?"disabled='disabled' ":"")." type='text' class='autocomplete_field' id='".$prefix.$field_name."' name='".$prefix.$field_name."' value='".$evento->getField("nombre")."' />";
          $field_help = $this->my_object->getField('field_help');
          if ($field_help[$field_name]){
            $input_html .= "<br /><span class='help_text'>".$field_help[$field_name]."</span>";
          }
          $input_html .= "<br /><br />";
          /*
          $object_objects = $this->my_object->getField('objects');
          $autocomplete_class = $object_objects[$field_name]['class_name'];
          */ 
        break;
        case 'persona':
          $input_html  = "<label for='".$prefix.$field_name."'>".$this->getTitleFromName($field_name).(($required)?" (*)":"").":</label> ";
          $persona = new Persona($this->my_object->getField($field_name));
          $input_html .= "<input ".($locked?"disabled='disabled' ":"")." type='text' class='autocomplete_field' id='".$prefix.$field_name."' name='".$prefix.$field_name."' value='".$persona->getField("nombre")."' />";
          $field_help = $this->my_object->getField('field_help');
          if ($field_help[$field_name]){
            $input_html .= "<br /><span class='help_text'>".$field_help[$field_name]."</span>";
          }
          $input_html .= "<br /><br />";
        break;
        case 'titulo_pelicula':
          $input_html  = "<label for='".$prefix.$field_name."'>".$this->getTitleFromName($field_name).(($required)?" (*)":"").":</label> ";
          $pelicula = new Pelicula($this->my_object->getField($field_name));
          $input_html .= "<input ".($locked?"disabled='disabled' ":"")." type='text' class='autocomplete_field_extended' id='".$prefix.$field_name."' name='".$prefix.$field_name."' value='".$this->my_object->getField($field_name)."' />";
		  
          $field_help = $this->my_object->getField('field_help');
          if ($field_help[$field_name]){
            $input_html .= "<br /><span class='help_text'>".$field_help[$field_name]."</span>";
          }
          $input_html .= "<br /><br />";
          /*
          $object_objects = $this->my_object->getField('objects');
          $autocomplete_class = $object_objects[$field_name]['class_name'];
          */ 
        break;
        case 'elenco':
          $input_html  = "<label for='".$prefix.$field_name."'>".$this->getTitleFromName($field_name).(($required)?" (*)":"").":</label> ";
		  $elenco = $this->my_object->getElencoString();
		  
          $input_html .= "<input ".($locked?"disabled='disabled' ":"")." type='text' class='autocomplete_field_multiple' id='".$prefix.$field_name."' name='".$prefix.$field_name."' value='".$elenco."' style='width:600px !important;' />";
          $field_help = $this->my_object->getField('field_help');
          if ($field_help[$field_name]){
            $input_html .= "<br /><span class='help_text'>".$field_help[$field_name]."</span>";
          }
          $input_html .= "<br /><br />";
        break;
        case 'genero':
          $input_html  = "<label for='".$prefix.$field_name."'>".$this->getTitleFromName($field_name).(($required)?" (*)":"").":</label> ";
          $genero = new Genero($this->my_object->getField($field_name));
          $input_html .= "<input ".($locked?"disabled='disabled' ":"")." type='text' class='autocomplete_field' id='".$prefix.$field_name."' name='".$prefix.$field_name."' value='".$genero->getField("nombre")."' />";
          $field_help = $this->my_object->getField('field_help');
          if ($field_help[$field_name]){
            $input_html .= "<br /><span class='help_text'>".$field_help[$field_name]."</span>";
          }
          $input_html .= "<br /><br />";
          /*
          $object_objects = $this->my_object->getField('objects');
          $autocomplete_class = $object_objects[$field_name]['class_name'];
          */ 
        break;
        case 'boolean':   
          $input_html  = "<label for='".$prefix.$field_name."'>".$this->getTitleFromName($field_name).(($required)?" (*)":"").":</label> ";
          $input_html .= "<input ".($locked?"disabled='disabled' ":"")." type='radio' id='".$prefix.$field_name."_critica' name='".$prefix.$field_name."' value='1'".($this->my_object->getField($field_name)?" checked='checked'":"")." /> Yes";
          $input_html .= "&nbsp;<input ".($locked?"disabled='disabled' ":"")." type='radio' id='".$prefix.$field_name."_resenia' name='".$prefix.$field_name."' value='0'".(!$this->my_object->getField($field_name)?" checked='checked'":"")." /> No";
          $field_help = $this->my_object->getField('field_help');
          if ($field_help[$field_name]){
            $input_html .= "<br /><span class='help_text'>".$field_help[$field_name]."</span>";
          }
          $input_html .= "<br /><br />";
        break;
        case 'richtext':
          $input_html  = "<label for='".$prefix.$field_name."'>".$this->getTitleFromName($field_name).(($required)?" (*)":"").":</label> ";
          $field_help = $this->my_object->getField('field_help');
          if ($field_help[$field_name]){
            $input_html .= "<br /><span class='help_text'>".$field_help[$field_name]."</span>";
          }
          $input_html .= "<br /><textarea style='width:100%;height:200px;' ".($locked?"disabled='disabled' ":"")." id='".$prefix.$field_name."' name='".$prefix.$field_name."'>".$this->my_object->getField($field_name)."</textarea><br /><br />";
        break;
		case 'foto_critica':
		case 'banner_home':
		case 'logo_home':
		case 'afiche_pelicula':
		case 'tapa_libro':
		case 'bottle_image':
		case 'flag_image':
		case 'logo_winery':
			switch ($field_type){
				case 'foto_critica': $folder = 'fotos_criticas/full/'; break;
				case 'banner_home': $folder = 'banner_home/'; break;
				case 'logo_home': $folder = 'logo_home/'; break;
				case 'afiche_pelicula': $folder = 'afiche_pelicula/home/'; break;
				case 'tapa_libro': $folder = 'tapa_libro/home/'; break;
				case 'bottle_image': $folder = 'bottle_image/'; break;
				case 'flag_image': $folder = 'flag_image/'; break;
				case 'logo_winery': $folder = 'logo_winery/'; break;
			}
          $input_html  = "<label for='".$prefix.$field_name."'>".$this->getTitleFromName($field_name).(($required)?" (*)":"").":</label> ";
          $input_html .= "<input type='hidden' name='MAX_FILE_SIZE' value='2000000' />";
          $file_name = $this->my_object->getField($field_name);
          if ($file_name != ""){
            $input_html .= "<a target='_blank' class='lightbox_link' href='../uploads/".$folder.$file_name."'>".$file_name."</a>&nbsp;";
          }
          $input_html .= "<input ".($locked?"disabled='disabled' ":"")." name='".$prefix.$field_name."' id='".$prefix.$field_name."' type='file' value='' />";
          $field_help = $this->my_object->getField('field_help');
          if ($field_help[$field_name]){
            $input_html .= "<br /><span class='help_text'>".$field_help[$field_name]."</span>";
          }
          $input_html .= "<br /><br />";
        break;
        case 'file':
        case 'pdf':
          $input_html  = "<label for='".$prefix.$field_name."'>".$this->getTitleFromName($field_name).(($required)?" (*)":"").":</label> ";
          $input_html .= "<input type='hidden' name='MAX_FILE_SIZE' value='2000000' />";
          $file_name = $this->my_object->getField($field_name);
          if ($file_name != ""){
            $input_html .= "<a target='_blank' href='../uploads/".$file_name."'>".$file_name."</a>&nbsp;";
          }
          $input_html .= "<input ".($locked?"disabled='disabled' ":"")." name='".$prefix.$field_name."' id='".$prefix.$field_name."' type='file' value='".$this->my_object->getField($field_name)."' />";
          $field_help = $this->my_object->getField('field_help');
          if ($field_help[$field_name]){
            $input_html .= "<br /><span class='help_text'>".$field_help[$field_name]."</span>";
          }
          $input_html .= "<br /><br />";
        break;
        case 'order':
          //Order fields are not shown
          $input_html .= "";
        break;
        case 'tipo_critica':            
          $input_html  = "<label for='".$prefix.$field_name."'>".$this->getTitleFromName($field_name).(($required)?" (*)":"").":</label> ";
          $input_html .= "<input ".($locked?"disabled='disabled' ":"")." type='radio' id='".$prefix.$field_name."_critica' name='".$prefix.$field_name."' value='0'".(!$this->my_object->getField($field_name)?" checked='checked'":"")." /> Cr&iacute;tica";
          $input_html .= "&nbsp;<input ".($locked?"disabled='disabled' ":"")." type='radio' id='".$prefix.$field_name."_resenia' name='".$prefix.$field_name."' value='1'".($this->my_object->getField($field_name)?" checked='checked'":"")." /> Rese&ntilde;a";
          $field_help = $this->my_object->getField('field_help');
          if ($field_help[$field_name]){
            $input_html .= "<br /><span class='help_text'>".$field_help[$field_name]."</span>";
          }
          $input_html .= "<br /><br />";
        break;
        case 'tipo_pelicula':            
          $input_html  = "<label for='".$prefix.$field_name."'>".$this->getTitleFromName($field_name).(($required)?" (*)":"").":</label> ";
          $input_html .= "<input ".($locked?"disabled='disabled' ":"")." onclick='critica_options(0)' type='radio' id='".$prefix.$field_name."_pelicula' name='".$prefix.$field_name."' value='0'".(!$this->my_object->getField($field_name)?" checked='checked'":"")." /> Pel&iacute;cula";
          $input_html .= "&nbsp;<input ".($locked?"disabled='disabled' ":"")." onclick='critica_options(1)' type='radio' id='".$prefix.$field_name."_serie' name='".$prefix.$field_name."' value='1'".($this->my_object->getField($field_name)?" checked='checked'":"")." /> Serie";
          $field_help = $this->my_object->getField('field_help');
          if ($field_help[$field_name]){
            $input_html .= "<br /><span class='help_text'>".$field_help[$field_name]."</span>";
          }
          $input_html .= "<br /><br />";
        break;
        case 'object':
          $objects = $this->my_object->getField('objects');
          $the_field = $objects[$field_name];
          $classname = $the_field['class_name']; 
          $an_object = new $classname();
          $all_options = $an_object->getAll();
          
          $input_html  = "<label for='".$prefix.$field_name."'>".$this->getTitleFromName($field_name).(($required)?" (*)":"").":</label> ";
          $input_html .= "<select ".($locked?"disabled='disabled' ":"")." name='".$prefix.$field_name."' id='".$prefix.$field_name."'>";
          if (in_array($field, $this->my_object->getField('mandatory'))){
            $input_html .= "<option value='0'></option>";          
          }
          foreach ($all_options as $an_option){
            $an_object = new $classname($an_option['id']);
            $input_html .= "<option ".(($this->my_object->getField($field_name)==$an_option['id'])?"selected='selected' ":"")."value='".$an_object->getField('id')."'>".$an_object->toString()."</option>";
          }
          $input_html .= "</select>";
          $field_help = $this->my_object->getField('field_help');
          if ($field_help[$field_name]){
            $input_html .= "<br /><span class='help_text'>".$field_help[$field_name]."</span>";
          }
          $input_html .= "<br /><br />";
        break;
        case 'tipo_persona':
          $input_html  = "<label for='".$prefix.$field_name."'>".$this->getTitleFromName($field_name).(($required)?" (*)":"").":</label> ";
          $input_html .= "<select ".($locked?"disabled='disabled' ":"")." name='".$prefix.$field_name."' id='".$prefix.$field_name."'>";
		  
		  $input_html .= "<option ".(($this->my_object->getField($field_name)=="actor")?"selected='selected' ":"")."value='actor'>Actor</option>";
		  $input_html .= "<option ".(($this->my_object->getField($field_name)=="autor")?"selected='selected' ":"")."value='autor'>Autor</option>";
		  $input_html .= "<option ".(($this->my_object->getField($field_name)=="critico")?"selected='selected' ":"")."value='critico'>Cr&iacute;tico</option>";
		  $input_html .= "<option ".(($this->my_object->getField($field_name)=="director")?"selected='selected' ":"")."value='director'>Director</option>";
		  
          $input_html .= "</select>";
          $field_help = $this->my_object->getField('field_help');
          if ($field_help[$field_name]){
            $input_html .= "<br /><span class='help_text'>".$field_help[$field_name]."</span>";
          }
          $input_html .= "<br /><br />";
        break;
        case 'string':
        default:
          $input_html  = "<label for='".$prefix.$field_name."'>".$this->getTitleFromName($field_name).(($required)?" (*)":"").":</label> ";
          $input_html .= "<input ".($locked?"disabled='disabled' ":"")."type='text' id='".$prefix.$field_name."' name='".$prefix.$field_name."' value='".$this->my_object->getField($field_name)."' maxlength='255' />";
          $field_help = $this->my_object->getField('field_help');
          if ($field_help[$field_name]){
            $input_html .= "<br /><span class='help_text'>".$field_help[$field_name]."</span>";
          }
          $input_html .= "<br /><br />";
        break;
      }
      return $input_html;
    }
  }
?>