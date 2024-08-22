<?php
  //Mail Settings
  $send_to = "info@globalwinesllc.com";
  
  function check_email($email){
    if(eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)) { 
      return true; 
    } else { 
      return false; 
    } 
  }
  if ($_POST){
    $name = trim($_POST['name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $tel1 = trim($_POST['tel1']);
    $tel2 = trim($_POST['tel2']);
    $comments = trim($_POST['comments']);
    if (check_email($email)){
      if (($name != "") && ($last_name != "") && ($tel1 != "") && ($tel2 != "")){
        //email
        if (
          mail ( 
            $send_to, 
            "Contact message from GWines site", 
            "The following contact information has been sent from the GWines site contact form:
            
            Name: ".$name." ".$last_name."
            E-Mail: ".$email."
            Phone number: ".$tel1."-".$tel2."
            Comments: ".$comments."
            
            Get in touch with this person as soon as possible!" 
          )
        ){ 
          $message = "Thanks for contacting us! We'll get back to you very shortly.";
          unset($_POST);
        } else {
          $error = 1;
          $message = "Oops! Something went wrong and we couldn't send your contact information :(<br />
          Could you please try again in a few minutes?";        
        }
      } else {   
        $error = 1;
        $message = "Please enter information for all fields and re-submit.";
      }
    } else {
      $error = 1;
      $message = "The email address you entered does not appear to be valid. 
      Please correct it and re-submit.";
    }
  }
?>
<?php include("head.php"); ?>
<?php
    $template_class = "contact_us"; 
    include("header.php"); 
?>
        <?php include("navigation.php"); ?>
        <div id="content">
            <div id="content_body">
            	<form id="contact_us" name="contact_us" action="?" method="post">
            		<div id="contact_us_title">Contact Us</div>
                	<div id="labels">
                        <p>Name</p>
                        <p>Last Name</p>
                        <p>E-mail</p>
                        <p>Tel</p>
                        <p>Comments</p>
                    </div>
                    <div id="form_fields">
                        <input type="text" value="<?php echo $_POST['name']; ?>" id="name" name="name" />
                        <input type="text" value="<?php echo $_POST['last_name']; ?>" id="last_name" name="last_name" />
                        <input type="text" value="<?php echo $_POST['email']; ?>" id="email" name="email" />
                        <input type="text" value="<?php echo $_POST['tel1']; ?>" id="tel1" name="tel1" />
                        <input type="text" value="<?php echo $_POST['tel2']; ?>" id="tel2" name="tel2" />
                        <textarea id="comments" name="comments"><?php echo $_POST['comments']; ?></textarea>
                    </div>
                    <input type="submit" id="send" name="send" value="Send" />
                </form>                                                     
                <?php
                  if ($message){
                    echo '<p class="message">'.$message.'</p>';
                  }
                ?>
            </div>
        </div>
    </div>
</body>
<?php include("footer.php"); ?>