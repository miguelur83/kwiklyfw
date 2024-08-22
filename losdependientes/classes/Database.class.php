<?php
class Database{
  private $conn;
  private $last;
    
  function __construct($db_server, $db_user, $db_password, $db_name){
    if ($this->conn = mysql_connect($db_server, $db_user, $db_password)){
      if (mysql_select_db($db_name, $this->conn)){
        return $this;
      } else {
        return null;
      }
    } else {
      return null;
    }    
  }         
  
  public function close(){
    return mysql_close($this->conn);
  }             
  
  public function createTable($tblName, $fields, $mandatory, $field_types, $default_values){ 
    $sql = "CREATE TABLE IF NOT EXISTS ".$tblName." (";
    $first = 1;
    foreach ($fields as $column_name){
      if ($first){
        $first = 0;
      } else {
        $sql .= ", ";
      } 
      $sql .= "".$column_name." ".$this->getDBType($field_types[$column_name]);
      if (in_array($column_name, $mandatory)){
        $sql .= " NOT NULL";
      } else {                                
        $sql .= " NULL";
      }
      if (array_key_exists($column_name, $default_values)){
        $sql .= " DEFAULT ".$default_values[$column_name];
      }
      if ($column_name == 'id'){
        $sql .= " AUTO_INCREMENT PRIMARY KEY";
      }
    }
    $sql .= ")";
    if ($this->execute($sql)){
      return true;
    } else {
      return false;
    }
  }        
  
  public function updateTable($tblName, $fields, $mandatory, $field_types, $default_values){
    $sql = "SHOW COLUMNS IN ".$tblName;
    $this->execute($sql);
    $table_fields = array();
    while ($row = $this->getRow()){
      $table_fields[] = $row['Field']; 
    }
    
    $sql = "ALTER TABLE ".$tblName." ";                
    $first = 1;
    foreach ($fields as $field){
      if($field != 'id'){ 
        if(! in_array($field, $table_fields)){     
          if ($first){
            $first = 0;
          } else {
            $sql .= ", ";
          } 
          $sql .= "ADD COLUMN ".$field." ";
        } else {     
          if ($first){
            $first = 0;
          } else {
            $sql .= ", ";
          } 
          $sql .= "MODIFY COLUMN ".$field." ";
        }
        $sql .= "".$this->getDBType($field_types[$field]);
        if (in_array($field, $mandatory)){
          $sql .= " NOT NULL";
        } else {                                
          $sql .= " NULL";
        }
        if (array_key_exists($field, $default_values)){
          $sql .= " DEFAULT '".$default_values[$field]."'";
        }
        if ($field == 'id'){
          $sql .= " AUTO_INCREMENT PRIMARY KEY";
        }
      }
    }
    foreach ($table_fields as $table_field){
      if(! in_array($table_field, $fields)){      
        if ($first){
          $first = 0;
        } else {
          $sql .= ", ";
        } 
        $sql .= "DROP COLUMN ".$table_field;
      }
    }
      
    if ($this->execute($sql)){
      return true;
    } else {
      return false;
    }
  }              
  
  public function insert($table, $data){
    $sql = "INSERT INTO ".$table." SET ";
    $first = 1;
    foreach ($data as $field => $value){
      if ($first){
        $first = 0;
        $sql .= $field." = '".$this->sanitize($value)."'";
      } else {
        $sql .= ", ".$field." = '".$this->sanitize($value)."'";
      }
    }
    if ($this->execute($sql)){
      return mysql_insert_id($this->conn);
    } else {
      return 0;
    }
  }     
  
  public function update($table, $condition, $data){
    $sql = "UPDATE ".$table." SET ";             
    $first = 1;
    foreach ($data as $field=>$value){
      if ($first){
        $first = 0;
        $sql .= $field." = '".$this->sanitize($value)."'";
      } else {
        $sql .= ", ".$field." = '".$this->sanitize($value)."'";
      }
    }
    $sql .= " WHERE ".$condition;     
    if ($this->execute($sql)){
      return true;
    } else {
      return false;               
    }
  }  
  
  public function delete($table, $condition){
    $sql = "DELETE FROM ".$this->sanitize($table)." WHERE ".$condition;     
    if ($this->execute($sql)){
      return true;
    } else {
      return false;
    }
  }
  
  public function select($fields, $table, $conditions="", $limit=''){
    $sql = "SELECT ".$fields." FROM ".$table;
    if ($conditions != ''){
      $sql .= " WHERE ".$conditions;
    }
    if ($limit != ''){
      $sql .= " LIMIT ".$limit;
    }
    $this->execute($sql);
    if (mysql_num_rows($this->last) > 0){
      return $this->last;
    } else {
      return false;
    }
  }
  
  public function resultCount(){
    return mysql_num_rows($this->last);
  }
  
  //Translates system types to supported DB types
  protected function getDBType($type){
    switch ($type){
      case 'pos': $db_type = "INT"; break;
      case 'neg': $db_type = "INT"; break;
      case 'int': $db_type = "INT"; break;
      case 'float': $db_type = "FLOAT"; break;
      case 'date': $db_type = "DATE"; break;
      case 'time': $db_type = "TIME"; break;
      case 'datetime': $db_type = "DATETIME"; break;
      case 'string': $db_type = "VARCHAR (255)"; break;
      case 'text': $db_type = "TEXT"; break;
      case 'boolean': $db_type = "BOOL"; break;
      case 'object': $db_type = "INT"; break;
      case 'file': $db_type = "VARCHAR (255)"; break;
      case 'richtext': $db_type = "TEXT"; break;
	  // Some custom types
      case 'tipo_pelicula': $db_type = "BOOL"; break;
      case 'titulo_pelicula': $db_type = "VARCHAR (255)"; break;
      case 'tipo_critica': $db_type = "BOOL"; break;
      case 'tipo_persona': $db_type = "VARCHAR (255)"; break;
      case 'persona': $db_type = "INT"; break;
      case 'genero': $db_type = "INT"; break;
      case 'evento': $db_type = "INT"; break;
      case 'embedded_object': $db_type = "INT"; break;
      case 'order': $db_type = "INT"; break;
      case 'youtube_video': $db_type = "VARCHAR (11)"; break;
      case 'pdf': $db_type = "VARCHAR (255)"; break;
      case 'foto_critica': $db_type = "VARCHAR (255)"; break;
      case 'banner_home': $db_type = "VARCHAR (255)"; break;
      case 'logo_home': $db_type = "VARCHAR (255)"; break;
      case 'afiche_pelicula': $db_type = "VARCHAR (255)"; break;
      case 'tapa_libro': $db_type = "VARCHAR (255)"; break;
      case 'imagen_noticia': $db_type = "VARCHAR (255)"; break;
      case 'pais': $db_type = "INT"; break;
	  
      default: return false; 
    }
    return $db_type;
  }
    
  public function execute( $sql ) { 
	//echo "<p>".$sql."</p>";
  	if ($this->last = mysql_query($sql, $this->conn)){
      return $this->last;
    } else {
      echo "SQL execute failed - SQL String: ".$sql."<br />";
      return false;
    }
  }
  
  public function sanitize( $data ){
  	return mysql_real_escape_string( $data );
  }
  
  public function getRow(){
    return mysql_fetch_array($this->last);
  }
  
  public function table_exists($table_name){
    $res = $this->execute("Show tables like '".$table_name."'");
    if ($this->getRow()){
      return true;
    } else {
      return false;
    }
  }
} 
?>