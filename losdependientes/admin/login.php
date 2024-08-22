<?php
  session_start();
  if (isset($_SESSION['logged_in'])){
    header("Location:index.php");
  }
  if ($_POST['login_submit']){
    if (($_POST['username'] == 'admin') && ($_POST['password'] == 'l0sd3p3nd13nt3s')){
      $_SESSION['logged_in'] = true;
      header("Location:index.php");
    } else {
      $login_error = 1;
    }
  }

  include ("head.php");
  include ("header.php");
  
  if ($_GET['action'] == "expired"){
    echo "<p><b>Por razones de seguridad, su sesi&oacute;n ha sido cerrada autom&aacute;ticamente luego de 30 minutos de inactividad. Por favor, ingrese nuevamente.</b></p>";
  }
  if ($_GET['action'] == "logged_out"){
    echo "<p><b>Ha cerrado sesi&oacute;n.</b></p>";
  }
  if ($login_error){
    echo "<p><b>El usuario o la contrase&ntilde;a son incorrectos.</b></p>";
  }
?>
  <form id="login" name="login" action="?" method="post">
    <label for="username">Usuario:</label>
    <input type="text" name="username" id="username" value="" /> <br /> <br />
    <label for="password">Clave:</label>
    <input type="password" name="password" id="password" value="" /> <br /> <br />
    <input type="submit" name="login_submit" id="login_submit" value="Ingresar" />
  </form>
<?php
  include ("footer.php");
?>