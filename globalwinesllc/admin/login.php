<?php
  session_start();
  if (isset($_SESSION['logged_in'])){
    header("Location:index.php");
  }
  
  include ("../inc/kwikly_bootstrap.php");
  
  if ($_POST['login_submit']){
    if (($_POST['username'] == $admin_user) && ($_POST['password'] == $admin_pass)){
      $_SESSION['logged_in'] = true;
      header("Location:index.php");
    } else {
      $login_error = 1;
    }
  }
  
  include ("head.php");
  include ("header.php");
  
  if ($_GET['action'] == "expired"){
    echo "<p><b>".$lang->getString('msg_session_expired')."</b></p>";
  }
  if ($_GET['action'] == "logged_out"){
    echo "<p><b>".$lang->getString('msg_logged_out')."</b></p>";
  }
  if ($login_error){
    echo "<p><b>".$lang->getString('msg_login_error')."</b></p>";
  }
?>
  <form id="login" name="login" action="?" method="post">
    <label for="username"><?=$lang->getString('lbl_username');?>:</label>
    <input type="text" name="username" id="username" value="" /> <br /> <br />
    <label for="password"><?=$lang->getString('lbl_password');?>:</label>
    <input type="password" name="password" id="password" value="" /> <br /> <br />
    <input type="submit" name="login_submit" id="login_submit" value="<?=$lang->getString('btn_login');?>" />
  </form>
<?php
  include ("footer.php");
?>