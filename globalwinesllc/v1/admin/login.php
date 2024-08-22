<?php
  session_start();
  if (isset($_SESSION['logged_in'])){
    header("Location:index.php");
  }
  if ($_POST['login_submit']){
    if (($_POST['username'] == 'admin') && ($_POST['password'] == 'Gl0b@lW1n3s')){
      $_SESSION['logged_in'] = true;
      header("Location:index.php");
    } else {
      $login_error = 1;
    }
  }

  include ("head.php");
  include ("header.php");
  
  if ($_GET['action'] == "expired"){
    echo "<p><b>For safety reasons, your session expired after 30 minutes of inactivity. Please log in again.</b></p>";
  }
  if ($_GET['action'] == "logged_out"){
    echo "<p><b>You've logged out.</b></p>";
  }
  if ($login_error){
    echo "<p><b>Wrong username and/or password!</b></p>";
  }
?>
  <form id="login" name="login" action="?" method="post">
    <label for="username">Username:</label>
    <input type="text" name="username" id="username" value="" /> <br /> <br />
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" value="" /> <br /> <br />
    <input type="submit" name="login_submit" id="login_submit" value="Log in" />
  </form>
<?php
  include ("footer.php");
?>