<?php
  class Pelicula extends KwikObject{
	protected $tipo;
    protected $titulo;
    protected $anio;
	protected $elenco;
    protected $afiche;
    protected $youtube_ID;       
    protected $objects = array(
      'director' => array('class_name' => 'Persona', 'object' => null),
      'genero' => array('class_name' => 'Genero', 'object' => null)
    );
    
    function __construct($id = 0){   
      $this->table = "peliculas";
      array_push($this->fields, 'tipo', 'titulo', 'director', 'genero', 'anio', 'elenco', 'afiche', 'youtube_ID');
      array_push($this->persistent, 'tipo', 'titulo', 'director', 'genero', 'anio', 'afiche', 'youtube_ID');
      array_push($this->editable, 'tipo', 'titulo', 'director', 'genero', 'anio', 'elenco', 'afiche', 'youtube_ID');
      array_push($this->mandatory, 'tipo', 'titulo');
      
      $this->field_types['tipo'] = 'tipo_pelicula';
      $this->field_types['titulo'] = 'titulo_pelicula';
      $this->field_types['director'] = 'persona';
      $this->field_types['genero'] = 'genero';
      $this->field_types['anio'] = 'int';
      $this->field_types['elenco'] = 'elenco';
      $this->field_types['afiche'] = 'afiche_pelicula';
      $this->field_types['youtube_ID'] = 'youtube_video';
      
      $this->validation['tipo'] = 'boolean';
      $this->validation['titulo'] = 'string';
      $this->validation['director'] = 'persona';
      $this->validation['genero'] = 'genero';
      $this->validation['anio'] = 'int';
      $this->validation['elenco'] = 'elenco';
      $this->validation['afiche'] = 'afiche_pelicula';
      
      $this->field_help['titulo'] = 'T&iacute;tulo de la Pel&iacute;cula o Serie.';
      $this->field_help['elenco'] = 'Elenco de la Pel&iacute;cula o Serie. Separe los nombres con comas o punto y coma.';
      $this->field_help['afiche'] = '(Opcional) Imagen de afiche o p&oacute;ster. Dimensiones: 150 x 215 px.';
      $this->field_help['youtube_ID'] = 'ID del trailer en Youtube. Son los &uacute;ltimos 11 caracteres de la URL.';
	  
	  $this->filter_field = 'titulo';
              
      parent::__construct($id);
    }     
    
    public function toString(){
      return $this->titulo;
    }
	
	public function getField($field_name){
      if ($field_name == 'elenco'){
	  	if (! isset($this->elenco)) {
			$this->elenco = array();
			$new_elenco = new Elenco();
			$results = $new_elenco->getAll('id', 0, "pelicula = '".$this->id."'");
			foreach($results as $actor){
				$this->elenco[] = new Persona($actor['actor']);
			}
		}
		return $this->elenco;
      } else {
        return parent::getField($field_name);
      }
    }
	
	public function getElencoString(){
 	  $elenco = $this->getField('elenco');
	  $elenco_value = "";
	  $first = 1;
	  foreach ($elenco as $actor){
		if($first){
			$first = 0;
		} else {
			$elenco_value .= ", ";
		}
		$elenco_value .= $actor->getField('nombre');
	  }
	  return $elenco_value;
	}
	
	public function save(){
		$db = $GLOBALS['db'];
		// Create field array
		$field_data = array();
		$result = 0;
		foreach($this->persistent as $field){
			if ($field != 'id'){
			  $field_data[$field] = $this->{$field};
			}
		}
		if ($this->id == 0){
			if($result_id = $db->insert($this->table, $field_data)){
			  $this->id = $result_id;
			  $result = 1;
			} else {
			  $result = 0;
			}
		} else {
			if($db->update($this->table, "id = '".$this->id."'", $field_data)){
			  $result = 1;
			} else {
			  $result = 0;
			}
		}
		if ($result){
			$un_elenco = new Elenco();
			$results = $un_elenco->getAll('id', 0, "pelicula = '".$this->id."'");
			foreach($results as $row){
				$un_elenco = new Elenco($row['id']);
				$un_elenco->delete();
			}
			
			//Guardar elenco
			foreach($this->elenco as $actor){
				$new_elenco = new Elenco();
				$new_elenco->setField("pelicula", $this->id);
				$new_elenco->setField("actor", $actor->getField('id'));
				$new_elenco->save();
			}
			return $this->id;
		} else {
			return false;
		}
	}
  }
?>