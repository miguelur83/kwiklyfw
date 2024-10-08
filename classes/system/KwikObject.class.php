<?php
  /**
   * KwikObject
   * An abstract class (can't be instantiated) that, given the fields, automatically
   * loads them from database.
   * This class is the base class for all the classes in the system, it allows
   * for the automatization of persistance and editable classes.      
   * 
   * Un objeto tiene una serie de atributos
   * De esos atributos, algunos son persistentes
   * De ellos, algunos son editables               
   **/
              
  abstract class KwikObject{
    protected $id;
    
    protected static $table_exists;
    
    //Name of the object's table in the database
    protected $table;
    //List of object fields - this might no be necessary
    protected $fields = array ('id');
    //List of fields that will be saved on the database
    protected $persistent = array ('id');
    //List of fields editable by CMS
    protected $editable = array ();
    //List of mandatory editable fields
    protected $mandatory = array ('id');
    //Field types for this object, as an array of 'field' => 'type'
    protected $field_types = array(
      'id' => "int"
    );
    //Default field values for this object, as an array of 'field' => 'value'
    protected $default_values = array();
    //Field validation settings for this object, as an array of 'field' => 'validation_type'
    protected $validation = array();
    //Help text for editable fields 'field' => 'help text'
    protected $field_help = array(
      'id' => "This is the object's id in the database - not editable."
    );
    
    protected $validationErrors;
    
    //For relationships
    // An array of 'field_name' => array('class_name' => 'ClassName', 'object' => KwikObject)    
    protected $objects = array();
    
    //For collections
    // An array of 'collection_name' => array('class_name' => 'ClassName','objects' =>  array());
    protected $collections = array();
        
    //Layout Manager manages how the object is seen in the user interface
    protected static $layout_manager;
	
	protected static $filter_field;
	protected static $sorter_field;
	protected static $sorter_max = 0; //Aid to save the max value for sorter field
    
    function __construct($id = 0){
      $this->layout_manager = new DefaultLayoutManager($this);
      
      $db = $GLOBALS['db'];
      
      //Default values
      foreach($this->fields as $field){
        if (array_key_exists($field, $this->default_values)){
          $this->{$field} = $this->default_values[$field];   
        }
      }
      
	  //Sets the sorter_max value for the class if it isn't
	  if (isset($this->sorter_field)){
		  if ($this->sorter_max == 0){
			$result = $db->select("MAX(".$this->sorter_field.") as 'sorter_max'", $this->table);
			$the_row = mysql_fetch_array($result);
		
			$this->sorter_max = $the_row['sorter_max'];
		  }
	  }
	  
      // Instantiates an object from the database table, or if it doesn't exist,
      // creates a new one.
      if ($id != 0){              
        $this->id = $id;
        $db->select("*", $this->table, "id = '".$this->id."'");
        if ($row = $db->getRow()){
          foreach($this->persistent as $field){
            $this->{$field} = $row[$field];
            if ($this->field_types[$field] == "richtext"){
              $this->{$field} = stripslashes($row[$field]);
            }
            if (array_key_exists($field, $this->objects)){
              $the_class = $this->objects[$field]['class_name'];
              $this->objects[$field]['object'] = new $the_class($row[$field]);
            }  
          }
        }
      }
    }  
    
    public function getForId($id){
      $class = get_class($this);
      return new $class($id);
    }  
    
    public function getFilterField(){
		return $this->filter_field;
    }  
    
    public function getSorterField(){
		return $this->sorter_field;
    }  
	
	public function moveUp(){
		$current_value = $this->getField($this->sorter_field);
		
		if ($other_object = $this->getFirst($this->sorter_field."=".($current_value - 1))){
			$other_object->setField($this->sorter_field, ($current_value));
			$this->setField($this->sorter_field, ($current_value - 1));
			$other_object->save();
			$this->save();
			return true;
		} else {
			return false;
		}
	}
	
	public function moveDown(){
		$current_value = $this->getField($this->sorter_field);
		
		if ($other_object = $this->getFirst($this->sorter_field."=".($current_value + 1))){
			$other_object->setField($this->sorter_field, ($current_value));
			$this->setField($this->sorter_field, ($current_value + 1));
			$other_object->save();
			$this->save();
			return true;
		} else {
			return false;
		}
	}
    
    public function getFirst($conditions = '1'){
      $db = $GLOBALS['db'];
	  $orderby = '';
	  if ($this->sorter_field != ''){
		$orderby = $this->sorter_field;
	  }
      $db->select("*", $this->table, $conditions, "1", $orderby);
      if ($row = $db->getRow()){
        return $this->getForId($row['id']);
      } else {
        return false;
      }
    } 
	
	public function getCount($conditions = "1"){
		$db = $GLOBALS['db'];
		$db->select("COUNT(id) as '".$this->table."_count'", $this->table, $conditions);
		if ($row = $db->getRow()){
			return $row[$this->table."_count"];
		} else {
			return false;
		}
	}
    
    public function setFields($field_data){
      foreach($field_data as $field => $value){
        if (in_array($field, $this->fields)){
          $this->{$field} = $value;
        }
      }
    }
    
    public function validate(){
      $result = true;
      $this->validationErrors = "";
      foreach ($this->validation as $field => $validation){
        switch ($validation){
          case 'int':
		  case 'sorter':
            if (! is_int( 0+$this->{$field} )){
              $this->validationErrors .= "- '".$this->getLayoutManager()->getTitleFromName($field)."' debe ser entero.<br />";
              $result = false;
            }
          break;
		  case 'collector':
            if ((is_int(0+$this->{$field})) && (0+$this->{$field} > 0)){
              $result = true;
            } else {
              $result = false;
              $this->validationErrors .= "- '".$this->getLayoutManager()->getTitleFromName($field)."' debe ser una referencia v&aacute;lida (".(0+$this->{$field}).").<br />";
			}
          break;
          case 'richtext':
			$this->{$field} = strip_tags($this->{$field}, '<b><i><u><em><strong><span><ul><ol><li><p><h1><h2><h3><br>');
		  break;
          case 'text':
			//$this->{$field} = strip_tags($this->{$field}, '<b><i><u><em><strong><span><ul><ol><li>');
		  break;
		  case 'componente':
			if($this->{$field}==0){
				$classname = $this->objects[$field]['class_name'];
				$componente = new $classname();
				$componente->setField("tipo", get_class($this));
				$componente->save();
				$this->setField("componente", $componente->getField('id'));
			}
			$result=true;
		  break;
          case 'Nto1':
            if ($this->{$field} > 0){
              $classname = $this->objects[$field]['class_name'];
              $object_id = $this->{$field};
              $an_object = new $classname($object_id);
              if ((! is_object($an_object)) || (is_null($an_object))){
                $this->validationErrors .= "- '".$this->getLayoutManager()->getTitleFromName($field)."' debe tener un valor.<br />";       
                $result = false;
              }
            } else {
              $result = false;
              $this->validationErrors .= "- '".$this->getLayoutManager()->getTitleFromName($field)."' debe tener un valor.<br />";       
            }
          break;
          case 'file':
            if (! isset($this->{$field})){
              $this->validationErrors .= "- '".$this->getLayoutManager()->getTitleFromName($field)."' es obligatorio.<br />";
              $result = false;
            }
          break;
          case 'imagen_marquesina':
		  	// Is there a file?
            if ($this->{$field} != ''){
			  // Is it an allowed extension?
			  $pos = strrpos($this->{$field}, ".");
              $ext = substr($this->{$field}, $pos + 1);
			  $allowed_exts = array('jpg', 'jpeg', 'png');
              if (! in_array(strtolower($ext), $allowed_exts)){
                 $this->validationErrors .= "- '".$this->getLayoutManager()->getTitleFromName($field)."' debe ser un archivo JPG o PNG. (Se encontr&oacute; un ".strtoupper($ext).").<br />";
                 $result = false;
              } else {
			  	$image = new SimpleImage();
			    $image->load('../uploads/'.$this->{$field});
	   			$image->resize(380, 241);
	   			$image->save('../uploads/imagen_marquesina/'.$this->{$field});
				unlink('../uploads/'.$this->{$field});
			  }
			} else {
			  if (($this->getField($field) == '') && ($this->mandatory['$field'])){
              	  $this->validationErrors .= "- '".$this->getLayoutManager()->getTitleFromName($field)."' es obligatorio.<br />";
	              $result = false;
			  }
			}
          break;
          case 'banner_home':
		  	// Is there a file?
            if ($this->{$field} != ''){
			  // Is it an allowed extension?
			  $pos = strrpos($this->{$field}, ".");
              $ext = substr($this->{$field}, $pos + 1);
			  $allowed_exts = array('jpg', 'jpeg', 'png');
              if (! in_array(strtolower($ext), $allowed_exts)){
                 $this->validationErrors .= "- '".$this->getLayoutManager()->getTitleFromName($field)."' debe ser un archivo JPG o PNG. (Se encontr&oacute; un ".strtoupper($ext).").<br />";
                 $result = false;
              } else {
			  	$image = new SimpleImage();
			    $image->load('../uploads/'.$this->{$field});
	   			$image->resize(479, 224);
	   			$image->save('../uploads/banner_home/'.$this->{$field});
				unlink('../uploads/'.$this->{$field});
			  }
			} else {
			  if (($this->getField($field) == '') && ($this->mandatory['$field'])){
              	  $this->validationErrors .= "- '".$this->getLayoutManager()->getTitleFromName($field)."' es obligatorio.<br />";
	              $result = false;
			  }
			}
          break;
          case 'banner_titulo':
		  	// Is there a file?
            if ($this->{$field} != ''){
			  // Is it an allowed extension?
			  $pos = strrpos($this->{$field}, ".");
              $ext = substr($this->{$field}, $pos + 1);
			  $allowed_exts = array('jpg', 'jpeg', 'png');
              if (! in_array(strtolower($ext), $allowed_exts)){
                 $this->validationErrors .= "- '".$this->getLayoutManager()->getTitleFromName($field)."' debe ser un archivo JPG o PNG. (Se encontr&oacute; un ".strtoupper($ext).").<br />";
                 $result = false;
              } else {
			  	$image = new SimpleImage();
			    $image->load('../uploads/'.$this->{$field});
	   			$image->resize(980, 176);
	   			$image->save('../uploads/banner_titulo/'.$this->{$field});
				unlink('../uploads/'.$this->{$field});
			  }
			} else {
			  if (($this->getField($field) == '') && ($this->mandatory['$field'])){
              	  $this->validationErrors .= "- '".$this->getLayoutManager()->getTitleFromName($field)."' es obligatorio.<br />";
	              $result = false;
			  }
			}
          break;
          case 'logo_home':
		  	// Is there a file?
            if ($this->{$field} != ''){
			  // Is it an allowed extension?
			  $pos = strrpos($this->{$field}, ".");
              $ext = substr($this->{$field}, $pos + 1);
			  $allowed_exts = array('jpg', 'jpeg', 'png');
              if (! in_array(strtolower($ext), $allowed_exts)){
                 $this->validationErrors .= "- '".$this->getLayoutManager()->getTitleFromName($field)."' debe ser un archivo JPG o PNG. (Se encontr&oacute; un ".strtoupper($ext).").<br />";
                 $result = false;
              } else {
			  	$image = new SimpleImage();
			    $image->load('../uploads/'.$this->{$field});
	   			$image->resizeToHeight(37);
	   			$image->save('../uploads/logo_home/'.$this->{$field}, IMAGETYPE_PNG);
				unlink('../uploads/'.$this->{$field});
			  }
			} else {
			  if (($this->getField($field) == '') && ($this->mandatory['$field'])){
              	  $this->validationErrors .= "- '".$this->getLayoutManager()->getTitleFromName($field)."' es obligatorio.<br />";
	              $result = false;
			  }
			}
          break;
          case 'afiche_pelicula':
		  	// Is there a file?
            if ($this->{$field} != ''){
			  // Is it an allowed extension?
			  $pos = strrpos($this->{$field}, ".");
              $ext = substr($this->{$field}, $pos + 1);
			  $allowed_exts = array('jpg', 'jpeg', 'png');
              if (! in_array(strtolower($ext), $allowed_exts)){
                 $this->validationErrors .= "- '".$this->getLayoutManager()->getTitleFromName($field)."' debe ser un archivo JPG o PNG. (Se encontr&oacute; un ".strtoupper($ext).").<br />";
                 $result = false;
              } else {
			  	$image = new SimpleImage();
			    $image->load('../uploads/'.$this->{$field});
	   			$image->resize(150, 215);
	   			$image->save('../uploads/afiche_pelicula/home/'.$this->{$field});
	   			$image->resize(80, 115);
	   			$image->save('../uploads/afiche_pelicula/inner/'.$this->{$field});
				unlink('../uploads/'.$this->{$field});
			  }
			} else {
			  if (($this->getField($field) == '') && ($this->mandatory['$field'])){
              	  $this->validationErrors .= "- '".$this->getLayoutManager()->getTitleFromName($field)."' es obligatorio.<br />";
	              $result = false;
			  }
			}
          break;
          case 'foto_critica':
		  	// Is there a file?
            if ($this->{$field} != ''){
			  // Is it an allowed extension?
			  $pos = strrpos($this->{$field}, ".");
              $ext = substr($this->{$field}, $pos + 1);
			  $allowed_exts = array('jpg', 'jpeg', 'png');
              if (! in_array(strtolower($ext), $allowed_exts)){
                 $this->validationErrors .= "- '".$this->getLayoutManager()->getTitleFromName($field)."' debe ser un archivo JPG o PNG. (Se encontr&oacute; un ".strtoupper($ext).").<br />";
                 $result = false;
              } else {
			  	$image = new SimpleImage();
			    $image->load('../uploads/'.$this->{$field});
				if ($image->getHeight() > 650){
	   				$image->resizeToHeight(650);
				}
	   			$image->save('../uploads/fotos_criticas/full/'.$this->{$field});
   				$image->resizeToHeight(136);
	   			$image->save('../uploads/fotos_criticas/thumb/'.$this->{$field});
				unlink('../uploads/'.$this->{$field});
			  }
			} else {
			  if (($this->getField($field) == '') && ($this->mandatory['$field'])){
              	  $this->validationErrors .= "- '".$this->getLayoutManager()->getTitleFromName($field)."' es obligatorio.<br />";
	              $result = false;
			  }
			}
          break;
          case 'tapa_libro':
		  	// Is there a file?
            if ($this->{$field} != ''){
			  // Is it an allowed extension?
			  $pos = strrpos($this->{$field}, ".");
              $ext = substr($this->{$field}, $pos + 1);
			  $allowed_exts = array('jpg', 'jpeg', 'png');
              if (! in_array(strtolower($ext), $allowed_exts)){
                 $this->validationErrors .= "- '".$this->getLayoutManager()->getTitleFromName($field)."' debe ser un archivo JPG o PNG. (Se encontr&oacute; un ".strtoupper($ext).").<br />";
                 $result = false;
              } else {
			  	$image = new SimpleImage();
			    $image->load('../uploads/'.$this->{$field});
	   			$image->resize(150, 215);
	   			$image->save('../uploads/tapa_libro/home/'.$this->{$field});
	   			$image->resize(80, 115);
	   			$image->save('../uploads/tapa_libro/inner/'.$this->{$field});
				unlink('../uploads/'.$this->{$field});
			  }
			} else {
			  if (($this->getField($field) == '') && ($this->mandatory['$field'])){
              	  $this->validationErrors .= "- '".$this->getLayoutManager()->getTitleFromName($field)."' es obligatorio.<br />";
	              $result = false;
			  }
			}
          break;
          case 'bottle_image':
		  	// Is there a file?
            if ($this->{$field} != ''){
			  // Is it an allowed extension?
			  $pos = strrpos($this->{$field}, ".");
              $ext = substr($this->{$field}, $pos + 1);
			  $allowed_exts = array('png');
              if (! in_array(strtolower($ext), $allowed_exts)){
                 $this->validationErrors .= "- '".$this->getLayoutManager()->getTitleFromName($field)."' debe ser un archivo PNG. (Se encontr&oacute; un ".strtoupper($ext).").<br />";
                 $result = false;
              } else {
			  	$image = new SimpleImage();
			    $image->load('../uploads/'.$this->{$field});
	   			$image->resize(74, 222);
	   			$image->save('../uploads/bottle_image/'.$this->{$field});
				unlink('../uploads/'.$this->{$field});
			  }
			} else {
			  if (($this->getField($field) == '') && ($this->mandatory['$field'])){
              	  $this->validationErrors .= "- '".$this->getLayoutManager()->getTitleFromName($field)."' es obligatorio.<br />";
	              $result = false;
			  }
			}
          break;
          case 'flag_image':
		  	// Is there a file?
            if ($this->{$field} != ''){
			  // Is it an allowed extension?
			  $pos = strrpos($this->{$field}, ".");
              $ext = substr($this->{$field}, $pos + 1);
			  $allowed_exts = array('png', 'jpg', 'jpeg');
              if (! in_array(strtolower($ext), $allowed_exts)){
                 $this->validationErrors .= "- '".$this->getLayoutManager()->getTitleFromName($field)."' debe ser un archivo JPG o PNG. (Se encontr&oacute; un ".strtoupper($ext).").<br />";
                 $result = false;
              } else {
			  	$image = new SimpleImage();
			    $image->load('../uploads/'.$this->{$field});
	   			$image->resize(30, 21);
	   			$image->save('../uploads/flag_image/'.$this->{$field});
				unlink('../uploads/'.$this->{$field});
			  }
			} else {
			  if (($this->getField($field) == '') && ($this->mandatory['$field'])){
              	  $this->validationErrors .= "- '".$this->getLayoutManager()->getTitleFromName($field)."' es obligatorio.<br />";
	              $result = false;
			  }
			}
          break;
          case 'logo_winery':
		  	// Is there a file?
            if ($this->{$field} != ''){
			  // Is it an allowed extension?
			  $pos = strrpos($this->{$field}, ".");
              $ext = substr($this->{$field}, $pos + 1);
			  $allowed_exts = array('jpg', 'jpeg', 'png');
              if (! in_array(strtolower($ext), $allowed_exts)){
                 $this->validationErrors .= "- '".$this->getLayoutManager()->getTitleFromName($field)."' debe ser un archivo JPG o PNG. (Se encontr&oacute; un ".strtoupper($ext).").<br />";
                 $result = false;
              } else {
			  	$image = new SimpleImage();
			    $image->load('../uploads/'.$this->{$field});
	   			$image->resizeToWidth(150);
	   			$image->save('../uploads/logo_winery/'.$this->{$field});
	   			$image->resizeToWidth(128);
				  if( $image->getHeight() > 83 ){
					$image->resizeToHeight(83);
				  }         
	   			$image->save('../uploads/logo_winery/small/'.$this->{$field});
				unlink('../uploads/'.$this->{$field});
			  }
			} else {
			  if (($this->getField($field) == '') && ($this->mandatory['$field'])){
              	  $this->validationErrors .= "- '".$this->getLayoutManager()->getTitleFromName($field)."' es obligatorio.<br />";
	              $result = false;
			  }
			}
          break;
          case 'pdf':
		  	// Is there a file?
            if ($this->{$field} != ''){
			  // Is it an allowed extension?
			  $pos = strrpos($this->{$field}, ".");
              $ext = substr($this->{$field}, $pos + 1);
			  $allowed_exts = array('pdf');
              if (! in_array(strtolower($ext), $allowed_exts)){
                 $this->validationErrors .= "- '".$this->getLayoutManager()->getTitleFromName($field)."' debe ser un archivo PDF. (Se encontr&oacute; un ".strtoupper($ext).").<br />";
                 $result = false;
              }
			} else {
			  if (($this->getField($field) == '') && ($this->mandatory['$field'])){
              	  $this->validationErrors .= "- '".$this->getLayoutManager()->getTitleFromName($field)."' es obligatorio.<br />";
	              $result = false;
			  }
			}
          break;
          case 'persona':
            $nombre = $this->{$field};
            $tipo = $field;
            $persona = new Persona();
      			if (trim($nombre) != ""){
      				$results = $persona->getAll('id', 0, "nombre LIKE '".$nombre."' AND tipo LIKE '".$tipo."'");
      				if (isset($results[0])){
      				  $this->{$field} = $results[0]['id'];
      				} else {
      				  $persona->setField("nombre", $nombre);
      				  $persona->setField("tipo", $tipo);
      				  $persona->save();
      				  $this->{$field} = $persona->getField("id");
      				}
      			} else { 
              $this->validationErrors .= "- '".$this->getLayoutManager()->getTitleFromName($field)."' debe tener un valor.<br />";
              $result = false;
            }
          break;
          case 'elenco':
			$new_elenco = array();
			$elenco_ids = array();
			$actores_validos = 0;
	
			$elenco = $this->{$field};
			$actores = preg_split ("/(,|;)\s*/", $elenco);
	
			foreach($actores as $actor){
				$persona = new Persona();
				if (trim($actor) != ""){
					$actores_validos++;
					$results = $persona->getAll('id', 0, "nombre LIKE '".$actor."' AND tipo LIKE 'actor'");
					if (isset($results[0])){
						$elenco_ids[] = $results[0]['id'];
						$persona = new Persona($results[0]['id']);
						$new_elenco[] = $persona;
					} else {
						$persona->setField("nombre", $actor);
						$persona->setField("tipo", 'actor');
						$persona->save();
						$elenco_ids[] = $persona->getField("id");
						$new_elenco[] = $persona;
					}
				} 
			} 
			$this->setField('elenco', $new_elenco);
			//echo "<pre>".print_r($this->elenco, 1)."</pre>";
          break;
          case 'evento':
				$nombre = $this->{$field};
				$evento = new Evento();
				if (trim($nombre) != ""){
					$results = $evento->getAll('id', 0, "nombre LIKE '".$nombre."'");
					if (isset($results[0])){
					  $this->{$field} = $results[0]['id'];
					} else {
					  $evento->setField("nombre", $nombre);
					  $evento->save();
					  $this->{$field} = $evento->getField("id");
					}
				} /*else { 
					$this->validationErrors .= "- '".$this->getLayoutManager()->getTitleFromName($field)."' debe tener un valor.<br />";
					$result = false;
				} */ //(no obligatorio)
          break;
          case 'genero':
            $nombre = $this->{$field};
            $genero = new Genero();
      			if (trim($nombre) != ""){
      				$results = $genero->getAll('id', 0, "nombre LIKE '".$nombre."'");
      				if (isset($results[0])){
      				  $this->{$field} = $results[0]['id'];
      				} else {
      				  $genero->setField("nombre", $nombre);
      				  $genero->save();
      				  $this->{$field} = $genero->getField("id");
      				}
      			} else { 
              $this->validationErrors .= "- '".$this->getLayoutManager()->getTitleFromName($field)."' debe tener un valor.<br />";
              $result = false;
            }
          break;
          case 'boolean':
		  	if($this->{$field}){
				$this->{$field} = 1;
			} else {
				$this->{$field} = 0;		
			}
          break;
          case 'string':
          default:
            if (! strlen(trim( $this->{$field} ))){
              $this->validationErrors .= "- '".$this->getLayoutManager()->getTitleFromName($field)."' no puede ser un texto vac&iacute;o.<br />";
              $result = false;
            }
          break;
        } 
      }
      return $result;
    }
    
    public function getValidationErrors(){
      return $this->validationErrors;
    }
            
    public function createTable(){
      if (isset($this->table)){
        $db = $GLOBALS['db'];
        if($db->createTable(
          $this->table,
          $this->persistent,
          $this->mandatory,
          $this->field_types,
          $this->default_values
        )){
          return true;
        } else {
          return false;
        }
      } else {
        return false;
      }
    }
            
    public function updateTable(){
      if (isset($this->table)){
        $db = $GLOBALS['db'];
        if($db->updateTable(
          $this->table,
          $this->persistent,
          $this->mandatory,
          $this->field_types,
          $this->default_values
        )){
          return true;
        } else {
          return false;
        }
      } else {
        return false;
      }
    }
    
    public function save(){
      $db = $GLOBALS['db'];
	  
	  if ($this->sorter_field != ''){
		if ($this->{$this->sorter_field} == 0 ){
			$this->{$this->sorter_field} = $this->sorter_max + 1;
			$this->sorter_max = $this->sorter_max + 1;
		}
	  }
	  
      // Create field array
      $field_data = array();
      foreach($this->persistent as $field){
        if ($field != 'id'){
          $field_data[$field] = $this->{$field};
        }
      }
      if ($this->id == 0){
        if($result_id = $db->insert($this->table, $field_data)){
          $this->id = $result_id;
          return $this->id;
        } else {
          return false;
        }
      } else {
        if($db->update($this->table, "id = '".$this->id."'", $field_data)){
          return $this->id;
        } else {
          return false;
        }
      }
    }
    
    public function delete(){
      $db = $GLOBALS['db'];
      return $db->delete($this->table, "id = '".$this->id."'");
    }
    
    public function getAll($sorted_by = '', $desc = 0, $conditions = "1", $limit=0, $offset=0){
		if ($sorted_by == ''){
			if ($this->sorter_field != ''){
				$sorted_by = $this->sorter_field;
			} else {
				$sorted_by = 'id';
			}
		}
      $db = $GLOBALS['db'];
      $result = $db->select("*", $this->table, $conditions." ORDER BY ".$sorted_by."".(($desc)?" DESC":"").(($limit!=0)?" LIMIT $offset, $limit":""));
      $all_items = array();
      while ($one_item = mysql_fetch_array($result)){
        $all_items[] = $one_item;
      } 
      return $all_items;
    }
    
    public function getLayoutManager(){
      return $this->layout_manager;
    }
    
    public function getField($field_name){
      if (isset($this->{$field_name})){
        return $this->{$field_name};
      } else {
        return null;
      }
    }
    
    public function getObject($field_name){
      if (isset($this->objects[$field_name])){
        return $this->objects[$field_name]['object'];
      } else {
        $classname = $this->objects[$field_name]['class_name'];
        $the_object = new $classname($this->{$field_name});
        $this->objects[$field_name]['object'] = $the_object;
        return $the_object; 
      }
    }
    
    public function setField($field_name, $value){
      $this->{$field_name} = $value;
    }
    
    public function toString(){
      return get_class($this)." ".$this->id;
    }
	
	  function sanitizeFileName($dangerous_filename){
		$dangerous_characters = array(" ", '"', "'", "&", "/", "\\", "?", "#", "�", "�", "�", "�",
									  "�", "�", "�", "�", "�", "�", "�", "�");
		// every forbidden character is replaced by an underscore
		return str_replace($dangerous_characters, '_', $dangerous_filename);
	  }
  }
?>