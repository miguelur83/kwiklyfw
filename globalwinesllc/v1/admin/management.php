<?php
  $manage_class = $_GET['manage_class'];
  $page_URL = "index.php?section=".$_GET['section']."&page=".$_GET['page'].(($_GET['action'])?"&action=".$_GET['action']:""); 
  // previously: $page_URL = substr($_SERVER["REQUEST_URI"], strrpos($_SERVER["REQUEST_URI"], "/") + 1);
  
  if( isset($_GET['id'] )){
    $object_id = $_GET['id']; 
  } else {
    $object_id = 0;
  }
  
  switch ($manage_class){
    case "Winery":
      $an_object = new Winery($object_id);
    break;
    case "Line":                
      $an_object = new Line($object_id);
    break;
    case "Wine":           
      $an_object = new Wine($object_id);
    break;
    case "Media":           
      $an_object = new Media($object_id);
    break;
  }                
  
  if(! isset($_GET['sortby'])){ $_GET['sortby']="id";}             
  
  switch ($_GET['action']){
    case "create":
      if ($_POST['frm_create_'.$manage_class.'_submit']){
        unset($_POST['frm_create_'.$manage_class.'_submit']);
        if (isset($_FILES)){
          save_uploaded_files();
          unset($_POST['MAX_FILE_SIZE']);
        }
        $an_object->setFields($_POST);
        if($an_object->validate()){
          $new_id = $an_object->save();
          if ($new_id){
            echo "<p>".$manage_class." #".$new_id." has been successfully created.</p>";
            $page_URL = "index.php?section=".$_GET['section']."&page=".$_GET['page'];
            echo $an_object->getLayoutManager()->getViewableList($page_URL, $_GET['sortby'], $_GET['desc']);
          } else {                                                                      
            echo "<p>New ".$manage_class." could not be created.</p>";
          }
        } else {
          $validation_errors = $an_object->getValidationErrors(); 
          echo "<p>Please make sure you enter all required fields:<br />".$validation_errors."</p>";
          echo $an_object->getLayoutManager()->getCreateForm($pageURL);
        }
      } else {
        echo $an_object->getLayoutManager()->getCreateForm($pageURL);
      }
    break;
    case "edit":
      if ($_POST['frm_update_'.$manage_class.'_submit']){
        unset($_POST['frm_update_'.$manage_class.'_submit']);
        if (isset($_FILES)){
          save_uploaded_files();
          unset($_POST['MAX_FILE_SIZE']);
        }
        $an_object->setFields($_POST);
        if($an_object->validate()){
          $existing_id = $an_object->save();
          if ($existing_id){
            echo "<p>".$manage_class." #".$existing_id." has been successfully updated.</p>";
            $page_URL = "index.php?section=".$_GET['section']."&page=".$_GET['page'];
            echo $an_object->getLayoutManager()->getViewableList($page_URL, $_GET['sortby'], $_GET['desc']);
          } else {                                                                      
            echo "<p>".$manage_class." could not be updated.</p>";
          }
        } else {
          $validation_errors = $an_object->getValidationErrors(); 
          echo "<p>Please make sure you enter all required fields:<br />".$validation_errors."</p>";
          echo $an_object->getLayoutManager()->getUpdateForm($pageURL);
        }
      } else {
        echo $an_object->getLayoutManager()->getUpdateForm($pageURL);
      }
    break;
    case "delete":
      if ($_POST['frm_delete_'.$manage_class.'_submit']){
        if ($an_object->delete()){
          echo "<p>".$manage_class." #".$object_id." has been successfully deleted.</p>";
          $page_URL = "index.php?section=".$_GET['section']."&page=".$_GET['page'];
          echo $an_object->getLayoutManager()->getViewableList($page_URL, $_GET['sortby'], $_GET['desc']);
        }
      } else {     
        echo $an_object->getLayoutManager()->getDeleteForm($pageURL);
      }
    break;
    default:
      $page_URL = "index.php?section=".$_GET['section']."&page=".$_GET['page'];
      echo $an_object->getLayoutManager()->getViewableList($page_URL, $_GET['sortby'], $_GET['desc']);
    break;
  }
  
  function save_uploaded_files(){
    if (isset($_FILES)){
      foreach($_FILES as $uploadedfile => $a_file){
        $target_path = "../uploads/".sanitizeFileName(basename( $a_file['name'] ));
        if(move_uploaded_file($a_file['tmp_name'], $target_path)) {
          if (chmod($target_path, 0777)){
            $_POST[$uploadedfile] = sanitizeFileName(basename( $a_file['name'] ));
          }
        } 
      }
    }
  }
  
  function sanitizeFileName($dangerous_filename){
    $dangerous_characters = array(" ", '"', "'", "&", "/", "\\", "?", "#", "á", "Á", "é", "É",
                                  "í", "Í", "ó", "Ó", "ú", "Ú", "ñ", "Ñ");
    // every forbidden character is replaced by an underscore
    return str_replace($dangerous_characters, '_', $dangerous_filename);
  }
?>