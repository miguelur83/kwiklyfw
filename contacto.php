<?php
  //Mail Settings
  $send_to = "fgutierrez@grupoits.com.ar"; 
  $site_name = "Grupo ITS";  
  
  function check_email($email){
    if(eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)) { 
      return true; 
    } else { 
      return false; 
    } 
  }
  if ($_POST){
    $nombre = trim($_POST['nombre']);
    $empresa = trim($_POST['empresa']);
    $email = trim($_POST['email']);
    $asunto = trim($_POST['asunto']);
    $mensaje = trim($_POST['mensaje']);
    if (check_email($email)){
      if (($nombre != "") && ($email != "") && ($mensaje != "")){
        //email
        if (
          mail ( 
            $send_to, 
            "Mensaje recibido desde ".$site_name, 
            "Se ha recibido un e-mail de Contacto desde el sitio:
            
            Nombre: ".$nombre."
            Empresa: ".$empresa."
            E-Mail: ".$email."
            Asunto: ".$asunto."
            Mensaje: ".$mensaje."
            
            No se olvide de responderlo lo antes posible!",
			'From: info@grupoits.com.ar' . "\r\n" .
			'Reply-To: ' . $email . "\r\n" .
			'X-Mailer: PHP/' . phpversion()
          )
        ){ 
          $message = "Gracias por contactarnos. Le responderemos a la brevedad.";
          unset($_POST);
        } else {
          $error = 1;
          $message = "Desafortunadamente hubo un error y su mensaje no pudo ser enviado.<br />
          Por favor, int&eacute;ntelo de nuevo en unos minutos o intente contactarnos por e-mail.";        
        }
      } else {   
        $error = 1;
        $message = "Por favor llene todos los campos requeridos y vuelva a enviar el formulario.";
      }
    } else {
      $error = 1;
      $message = "La direcci&oacute;n de e-mail que ingres&oacute; no parece ser v&aacute;lida.";
    }
  }
?>
<?php 
	$_GET['page'] ="contacto";
	include ("inc/header.php");
	include ("inc/nav.php"); 
?>
	</div>
	<div id="interno">
		<div id="main-container">
			<div id="header-container">
				<img src="images/inner-banner.jpg" />
				<div id="header-interno">
					<h1>Contacto</h1>
				</div>
			</div>
			<div id="main-content" class="contact">
				<?php if($error){ ?>
					<p class="error"><?=$message;?></p>
				<?php } elseif($message) { ?>
					<p class="success"><?=$message;?></p>
				<?php } else { ?>
					<p>P&oacute;ngase en contacto.</p>
				<?php } ?>
				<form id="contact" name="contact" action="pagina.php?page=contacto" method="post">
					<p>
						<label for="nombre">Nombre:</label><br/>
						<input type="text" name="nombre" id="nombre" value="<?=$_POST['nombre'];?>" />
					</p>
					<p>
						<label for="empresa">Empresa:</label><br/>
						<input type="text" name="empresa" id="empresa" value="<?=$_POST['empresa'];?>" />
					</p>
					<p>
						<label for="email">E-mail:</label><br/>
						<input type="text" name="email" id="email" value="<?=$_POST['email'];?>" />
					</p>
					<p>
						<label for="asunto">Asunto (Opcional):</label><br/>
						<input type="text" name="asunto" id="asunto" value="<?=$_POST['asunto'];?>" />
					</p>
					<p>
					<label for="mensaje">Mensaje:</label><br/>
					<textarea name="mensaje" id="mensaje"><?=$_POST['mensaje'];?></textarea>
					</p>
					<p>
					<input type="submit" id="enviarcontacto" name="enviarcontacto" value="Enviar mensaje" />
					</p>
				</form>
				<script type="text/javascript">
					var frmvalidator  = new Validator("contact");
					frmvalidator.addValidation("nombre","req","Por favor, ingrese su nombre");
					frmvalidator.addValidation("email","req","Por favor, ingrese su dirección de e-mail");
					frmvalidator.addValidation("email","email","Por favor, ingrese una dirección de e-mail válida");
					frmvalidator.addValidation("mensaje","req","Por favor, ingrese un mensaje");
				</script>
			</div>
			<div id="sidebar">
				<h2>Datos de contacto</h2>
				<p>Ayacucho 2337<br/>
				San Martin, Provincia de Buenos Aires<br/>
				CP B1650BUA</p>
				<p><a href="tel:+541147133808">Tel: +54 (11) 4713 3808</a></p>
				<p><a href="mailto:info@grupoits.com.ar">info@grupoits.com.ar</a><br/><a href="http://www.grupoits.com.ar">www.grupoits.com.ar</a></p>
				<p>&nbsp;</p>
				<p>
					<a href="http://qr.afip.gob.ar/?qr=g03nm8ZpJLPEH_JmK3SNUg,," target="_F960AFIPInfo"><img src="http://www.afip.gob.ar/images/f960/DATAWEB.jpg" border="0"></a>
				</p>
			</div>
		</div>
	</div>
<?php include ("inc/footer.php"); ?>