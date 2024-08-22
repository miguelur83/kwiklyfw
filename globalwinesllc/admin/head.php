<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$site_name;?> <?=$lang->getString('ttl_admin_section');?></title>
<link rel="stylesheet" type="text/css" href="css/theme.css" />
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="css/custom.css" />
<link rel="stylesheet" type="text/css" href="css/jquery.lightbox-0.5.css" />
<script>
   var StyleFile = "theme" + document.cookie.charAt(6) + ".css";
   document.writeln('<link rel="stylesheet" type="text/css" href="css/' + StyleFile + '">');
</script>
<!--[if IE]>
<link rel="stylesheet" type="text/css" href="css/ie-sucks.css" />
<![endif]-->

  <!-- JAVASCRIPT -->
  <script type="text/javascript" src="../js/jquery-1.6.4.min.js"></script>
  <script type="text/javascript" src="../js/jquery.autocomplete-min.js"></script>
  <script type="text/javascript" src="../js/jquery.lightbox-0.5.min.js"></script>
  
  <!-- Create an instance of the JS Autocomplete -->
  <script type="text/javascript">
    $(document).ready(function() {
      var options, a;
      jQuery(function(){
        // a = $('.autocomplete').autocomplete(options);
        $('.autocomplete_field').each( 
          function (index){
            options = {
              serviceUrl:'<?=$site_root?>service/autocomplete.php',
              params:{
                field_name:this.id
              },
              deferRequestBy: 200
            };
            $(this).autocomplete(options);
          } 
        );
        $('.autocomplete_field_multiple').each( 
          function (index){
            options = {
              serviceUrl:'<?=$site_root?>service/autocomplete.php',
              params:{
                field_name:this.id
              },
              deferRequestBy: 200,
			  delimiter: /(,|;)\s*/, // regex or character
            };
            $(this).autocomplete(options);
          } 
        );
		$('.autocomplete_field_extended').each( 
          function (index){
            options = {
              serviceUrl:'<?=$site_root?>service/autocomplete.php',
              params:{
                field_name:this.id
              },
              deferRequestBy: 200,
			  // callback function:
    		  onSelect: function(value, data){
			  	//alert('You selected: ' + value ); 
				// Traer los datos de la peli seleccionada (de data), cargar en los campos.
				$.ajax({
				  url: "<?=$site_root?>service/get_pelicula.php?titulo=" + value,
				  success: function(data){
				  	var response = jQuery.parseJSON(data);
					if (response.data.tipo == 1){
						$('#pelicula_tipo_serie').click();
					} else {
						$('#pelicula_tipo_pelicula').click();
					}
					$('#pelicula_id').val(response.data.id);
					$('#pelicula_director').val(response.data.director);
					$('#pelicula_genero').val(response.data.genero);
					$('#pelicula_anio').val(response.data.anio);
					$('#pelicula_elenco').val(response.data.elenco);
					$('#pelicula_afiche').val(response.data.afiche);
					$('#pelicula_youtube_ID').val(response.data.youtube_ID);
				  }
				});
			  },
            };
            $(this).autocomplete(options);
          } 
        );
      });
    });
  </script> 
  
  <!-- Seleccion de Pelicula / Serie al cargar crítica -->
  <script type="text/javascript">
	function critica_options(show) {
		if (show == 0){
			$('#pelicula_fields legend').text("Película");
		} else {
			$('#pelicula_fields legend').text("Serie");
		}
	}
  </script> 
  
  <!-- TinyMCE -->
  <script type="text/javascript" src="../js/tiny_mce/tiny_mce.js"></script>
  <script type="text/javascript">
  	tinyMCE.init({
  		mode : "textareas",
  		theme : "simple",  
      language : "es"
  	});
  </script>
  <!-- /TinyMCE -->   
  
  <!-- Activar lightboxes -->
  <script type="text/javascript">
    $(function() { 
      $('a.lightbox_link').lightBox(); 
    });
  </script> 
</head>