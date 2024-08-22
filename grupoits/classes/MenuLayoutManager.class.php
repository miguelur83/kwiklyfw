<?php
  class MenuLayoutManager extends DefaultLayoutManager{
  
  
	
    //Returns a table with all objects from this class, with Edit and Delete links
    public function getViewableList($pageURL, $sorted_by = "id", $desc = 0, $filter=''){
		if ($sorted_by == ''){
			if ($this->my_object->getField('sorter_field') != ''){
				$sorted_by = $this->my_object->getField('sorter_field');
			} else {
				$sorted_by = 'id';
			}
		}
		
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
	  
	  // Sólo agarro los menues de nivel superior
	  $cond .= " AND menu_padre = 0";
	  
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
        
		$list_html .= $this->getListHtml($an_item, $fields, $field_types, 0, $pageURL);
      }
      $list_html .= "</table>";
      return $list_html;
    }
    
	public function getListHtml($an_item, $fields, $field_types, $level = 0, $pageURL){
		$list_html = "";
		$list_html .= "<tr>";                              
        foreach ($fields as $field){
          switch ($field_types[$field]){
            case 'collection':
              $list_html .= "<td>(".$GLOBALS['lang']->getString('txt_collection').")</td>";
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
			  if ($the_object->getField('id') != 0){
				$list_html .= "<td>".$the_object->toString()."</td>";
			  }else{
				$list_html .= "<td>(null)</td>";
			  }
            break;
            case 'file':
              $list_html .= "<td><a target='_blank' href='../uploads/".$an_item[$field]."'>".$an_item[$field]."</a></td>";
            break;        
            case 'pdf':
			  if ($an_item[$field] != ''){
				$list_html .= "<td><a class='pdf_link' target='_blank' href='../uploads/".$an_item[$field]."'>".$an_item[$field]."</a></td>";
			  } else {
				$list_html .= "<td></td>";
			  }
            break;
            case 'richtext':
              $list_html .= "<td>".substr($an_item[$field],0,20)."...</td>";
            break;
            case 'boolean':
              $list_html .= "<td>".(($an_item[$field] == '1')?$GLOBALS['lang']->getString('txt_bool_yes'):$GLOBALS['lang']->getString('txt_bool_no'))."</td>";
            break;
            case 'order':
              /*$list_html .= "<td><a href='".$pageURL."&field=".$field."&up=".$an_item['id']."'>Up</a>&nbsp;<a href='".$pageURL."&field=".$field."&down=".$an_item['id']."'>Down</a></td>";*/
            break;
            case 'sorter':
				$the_value = $an_item[$field];
				$the_max = $this->my_object->getField('sorter_max');
				
				$list_html .= "<td>".
					(($the_value > 1)?"<a class='sorter_up' href='".$pageURL."&up=".$an_item['id']."'>Up</a>&nbsp;":"").
					(($the_value < $the_max)?"<a class='sorter_down' href='".$pageURL."&down=".$an_item['id']."'>Down</a>":"").
				"</td>";
            break;
            case 'youtube_video':
              if ($an_item[$field] != ''){                                       
                 $list_html .= "<td><a href='http://www.youtube.com/watch?v=".$an_item[$field]."' title='Ver video' target='_blank'><img src='img/iconset/video.png' alt='Video' /></a></td>";
              } else {
                $list_html .= "<td></td>";
              }
            break;
            default:   
				$list_html .= "<td>".($field == "nombre"?str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;", $level-1).($level>0?"<img src='img/icons/arrow_right.gif'/>&nbsp;&nbsp;":""):"").$an_item[$field]."</td>";
            break;
          } 
        }
        $list_html .= "<td><a class='edit_link' title='".$GLOBALS['lang']->getString('lbl_edit')."' href='".$pageURL."&action=edit&id=".$an_item['id']."'>".$GLOBALS['lang']->getString('lbl_edit')."</a></td><td><a class='delete_link' title='".$GLOBALS['lang']->getString('lbl_delete')."' href='".$pageURL."&action=delete&id=".$an_item['id']."'>".$GLOBALS['lang']->getString('lbl_delete')."</a></td>";
        $list_html .= "</tr>";
		
		//Ver si tiene menues hijos e imprimirlos tambien
		$children = $this->my_object->getAll("id", 0, "menu_padre = ".$an_item['id'], "", "");
		foreach ($children as $child){
			$list_html .= $this->getListHtml($child, $fields, $field_types, $level+1);
		}
		
		return $list_html;
	}
  }
?>