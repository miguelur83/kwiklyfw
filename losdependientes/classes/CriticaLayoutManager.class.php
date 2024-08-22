<?php
  class CriticaLayoutManager extends DefaultLayoutManager{
  
    function __construct($a_kwikobject){
	  parent::__construct($a_kwikobject);
    }
	
	public function getCreateForm($action_URL){
      $fields = $this->my_object->getField('fields');
      $editable = $this->my_object->getField('editable');
      $mandatory = $this->my_object->getField('mandatory');
      $field_types = $this->my_object->getField('field_types');
      
      $form_html = "<p>Input information for a new ".get_class($this->my_object)." and click the Create button. (*) Mandatory fields.</p>";
      $form_html .= "<form enctype='multipart/form-data' id='frm_create_".get_class($this->my_object)."' name='frm_create_".get_class($this->my_object)."' method='post' action='".$action_URL."'>";
      
	  $inserted_options = 0;
      foreach($editable as $editable_field){
	  	if (($editable_field != 'pelicula') && ($editable_field != 'serie')){
	        $form_html .= $this->getInputForField($editable_field, $field_types[$editable_field], in_array($editable_field, $mandatory));
		} else {
			if (! $inserted_options){    
				$form_html .= "<label for='pelicula_serie'>Material rese&ntilde;ado:</label> ";
				$form_html .= "<input onclick='critica_options(0)' type='radio' id='pelicula_serie_1' name='pelicula_serie' value='pelicula' checked='checked' /> Pel&iacute;cula";
				$form_html .= "&nbsp;<input onclick='critica_options(1)' type='radio' id='pelicula_serie_2' name='pelicula_serie' value='serie' /> Serie";
				$form_html .= "<br /><br />";
			}
			
			$form_html .= $this->getInputForField($editable_field, $field_types[$editable_field], in_array($editable_field, $mandatory), 0, '', $inserted_options);
			
			if ($inserted_options){$form_html .= "<br /><br />";}
			
			$inserted_options = 1;
		}
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
	  	if (($editable_field != 'pelicula') && ($editable_field != 'serie')){
	        $form_html .= $this->getInputForField($editable_field, $field_types[$editable_field], in_array($editable_field, $mandatory));
		} else {
			if (! $inserted_options){    
				$form_html .= "<label for='pelicula_serie'>Material rese&ntilde;ado:</label> ";
				$form_html .= "<input onclick='critica_options(0)' type='radio' id='pelicula_serie_1' name='pelicula_serie' value='pelicula' checked='checked' /> Pel&iacute;cula";
				$form_html .= "&nbsp;<input onclick='critica_options(1)' type='radio' id='pelicula_serie_2' name='pelicula_serie' value='serie' /> Serie";
				$form_html .= "<br /><br />";
			}
			
			$form_html .= $this->getInputForField($editable_field, $field_types[$editable_field], in_array($editable_field, $mandatory), 0, '', $inserted_options);
			
			if ($inserted_options){$form_html .= "<br /><br />";}
			
			$inserted_options = 1;
		}
      } 
      
      $form_html .= "<input type='submit' id='frm_update_".get_class($this->my_object)."_submit' name='frm_update_".get_class($this->my_object)."_submit' value='Update' />";
      $form_html .= "&nbsp;or <a href='javascript:javascript:history.go(-1)'>Cancel</a>";
      $form_html .= "</form>";
      return $form_html;
    }
    
    public function getDeleteForm($action_URL){            
      $fields = $this->my_object->getField('fields');
      $editable = $this->my_object->getField('editable');
      $mandatory = $this->my_object->getField('mandatory');
      $field_types = $this->my_object->getField('field_types');
      
      $form_html = "<p>You're about to delete ".get_class($this->my_object)." #".$this->my_object->getField("id").". Are you sure you want to continue?</p>";
      $form_html .= "<form enctype='multipart/form-data' id='frm_delete_".get_class($this->my_object)."' name='frm_delete_".get_class($this->my_object)."' method='post' action='".$action_URL."'>";
      $form_html .= "<input type='hidden' id='id' name='id' value='".$this->my_object->getField('id')."' />";
      
      foreach($editable as $editable_field){
	  	if (($editable_field != 'pelicula') && ($editable_field != 'serie')){
	        $form_html .= $this->getInputForField($editable_field, $field_types[$editable_field], in_array($editable_field, $mandatory));
		} else {
			if (! $inserted_options){    
				$form_html .= "<label for='pelicula_serie'>Material rese&ntilde;ado:</label> ";
				$form_html .= "<input onclick='critica_options(0)' type='radio' id='pelicula_serie_1' name='pelicula_serie' value='pelicula' checked='checked' /> Pel&iacute;cula";
				$form_html .= "&nbsp;<input onclick='critica_options(1)' type='radio' id='pelicula_serie_2' name='pelicula_serie' value='serie' /> Serie";
				$form_html .= "<br /><br />";
			}
			
			$form_html .= $this->getInputForField($editable_field, $field_types[$editable_field], in_array($editable_field, $mandatory), 0, '', $inserted_options);
			
			if ($inserted_options){$form_html .= "<br /><br />";}
			
			$inserted_options = 1;
		}
      } 
      
      $form_html .= "<input type='submit' id='frm_delete_".get_class($this->my_object)."_submit' name='frm_delete_".get_class($this->my_object)."_submit' value='Delete' />";
      $form_html .= "&nbsp;or <a href='javascript:javascript:history.go(-1)'>Cancel</a>";
      $form_html .= "</form>";
      return $form_html;
    }
  }
?>