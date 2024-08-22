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
      
      $form_html = "<p>Input information for a new ".get_class($this->my_object)." and click the Create button. (*) Mandatory fields.</p>";
      $form_html .= "<form enctype='multipart/form-data' id='frm_create_".get_class($this->my_object)."' name='frm_create_".get_class($this->my_object)."' method='post' action='".$action_URL."'>";
      
      foreach($editable as $editable_field){
        $form_html .= $this->getInputForField($editable_field, $field_types[$editable_field], in_array($editable_field, $mandatory));
      } 
      
      $form_html .= "<input type='submit' id='frm_create_".get_class($this->my_object)."_submit' name='frm_create_".get_class($this->my_object)."_submit' value='Create' />";
      $form_html .= "&nbsp;or <a href='javascript:javascript:history.go(-1)'>Cancel</a>";
      $form_html .= "</form>";
      return $form_html;
    }
    
    public function getUpdateForm($action_URL){
      echo "<p>Editing ".get_class($this->my_object)." #".$this->my_object->getField("id")."</p>"; 
      $fields = $this->my_object->getField('fields');
      $editable = $this->my_object->getField('editable');
      $mandatory = $this->my_object->getField('mandatory');
      $field_types = $this->my_object->getField('field_types');
      
      $form_html = "<p>Update information for ".get_class($this->my_object)." and click the Update button. (*) Mandatory fields.</p>";
      $form_html .= "<form enctype='multipart/form-data' id='frm_update_".get_class($this->my_object)."' name='frm_update_".get_class($this->my_object)."' method='post' action='".$action_URL."'>";
      $form_html .= "<input type='hidden' id='id' name='id' value='".$this->my_object->getField('id')."' />";
      
      foreach($editable as $editable_field){
        $form_html .= $this->getInputForField($editable_field, $field_types[$editable_field], in_array($editable_field, $mandatory));
      } 
      
      $form_html .= "<input type='submit' id='frm_update_".get_class($this->my_object)."_submit' name='frm_update_".get_class($this->my_object)."_submit' value='Update' />";
      $form_html .= "&nbsp;or <a href='javascript:javascript:history.go(-1)'>Cancel</a>";
      $form_html .= "</form>";
      return $form_html;
    }
    
    public function getDeleteForm(){            
      $fields = $this->my_object->getField('fields');
      $editable = $this->my_object->getField('editable');
      $mandatory = $this->my_object->getField('mandatory');
      $field_types = $this->my_object->getField('field_types');
      
      $form_html = "<p>You're about to delete ".get_class($this->my_object)." #".$this->my_object->getField("id").". Are you sure you want to continue?</p>";
      $form_html .= "<form enctype='multipart/form-data' id='frm_delete_".get_class($this->my_object)."' name='frm_delete_".get_class($this->my_object)."' method='post' action='".$action_URL."'>";
      $form_html .= "<input type='hidden' id='id' name='id' value='".$this->my_object->getField('id')."' />";
      
      foreach($editable as $editable_field){
        $form_html .= $this->getInputForField($editable_field, $field_types[$editable_field], in_array($editable_field, $mandatory), 1);
      } 
      
      $form_html .= "<input type='submit' id='frm_delete_".get_class($this->my_object)."_submit' name='frm_delete_".get_class($this->my_object)."_submit' value='Delete' />";
      $form_html .= "&nbsp;or <a href='javascript:javascript:history.go(-1)'>Cancel</a>";
      $form_html .= "</form>";
      return $form_html;
    }
    
    //Returns a table with all objects from this class, with Edit and Delete links
    public function getViewableList($pageURL, $sorted_by = "id", $desc = 0){
      $fields = $this->my_object->getField('fields');
      $all_items = $this->my_object->getAll($sorted_by, $desc); 
      $list_html = "<a href='".$pageURL."&action=create'>Create new ".get_class($this->my_object)."</a>";
      $list_html .= "<table><tr>";
      foreach ($fields as $field){
        $list_html .= "<th><a href='".$pageURL."&sortby=".$field.(($field==$sorted_by)?(($desc)?"&desc=0":"&desc=1"):"")."'>".$this->getTitleFromName($field).(($field==$sorted_by)?(($desc)?" &darr;":" &uarr;"):"")."</a></th>"; 
      }
      $list_html .= "<th colspan='2'>Actions</th>";
      $list_html .= "</tr>";
      
      $field_types = $this->my_object->getField('field_types');
      foreach ($all_items as $an_item){
        $list_html .= "<tr>";                              
        foreach ($fields as $field){
          switch ($field_types[$field]){
            case 'collection':
              $list_html .= "<td>(Collection)</td>";
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
            case 'richtext':
              $list_html .= "<td>".substr($an_item[$field],0,20)."...</td>";
            break;
            default:                                       
              $list_html .= "<td>".$an_item[$field]."</td>";
            break;
          } 
        }
        $list_html .= "<td><a href='".$pageURL."&action=edit&id=".$an_item['id']."'>Edit</a></td><td><a href='".$pageURL."&action=delete&id=".$an_item['id']."'>Delete</a></td>";
        $list_html .= "</tr>";
      }
      $list_html .= "</table>";
      return $list_html;
    }
    
    public function getTitleFromName($field_name){
      return ucwords(str_replace("_", " ", $field_name));
    }
    
    public function getInputForField($field_name, $field_type, $required, $locked = 0){
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
        case 'richtext':
          $input_html  = "<label for='".$field_name."'>".$this->getTitleFromName($field_name).(($required)?" (*)":"").":</label> ";
          $field_help = $this->my_object->getField('field_help');
          if ($field_help[$field_name]){
            $input_html .= "<br /><span class='help_text'>".$field_help[$field_name]."</span>";
          }
          $input_html .= "<br /><textarea style='width:100%;height:200px;' id='".$field_name."' name='".$field_name."'>".$this->my_object->getField($field_name)."</textarea><br /><br />";
        break;
        case 'file':
          $input_html  = "<label for='".$field_name."'>".$this->getTitleFromName($field_name).(($required)?" (*)":"").":</label> ";
          $input_html .= "<input type='hidden' name='MAX_FILE_SIZE' value='2000000' />";
          $file_name = $this->my_object->getField($field_name);
          if ($file_name != ""){
            $input_html .= "<a target='_blank' href='../uploads/".$file_name."'>".$file_name."</a>&nbsp;";
          }
          $input_html .= "<input name='".$field_name."' id='".$field_name."' type='file' value='".$this->my_object->getField($field_name)."' />";
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
          
          $input_html  = "<label for='".$field_name."'>".$this->getTitleFromName($field_name).(($required)?" (*)":"").":</label> ";
          $input_html .= "<select name='".$field_name."' id='".$field_name."'>";
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
        case 'string':
        default:
          $input_html  = "<label for='".$field_name."'>".$this->getTitleFromName($field_name).(($required)?" (*)":"").":</label> ";
          $input_html .= "<input ".($locked?"disabled='disabled' ":"")."type='text' id='".$field_name."' name='".$field_name."' value='".$this->my_object->getField($field_name)."' maxlength='255' />";
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