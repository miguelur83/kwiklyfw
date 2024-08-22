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
  <script type="text/javascript" src="../js/jquery-1.10.1.min.js"></script>
  <script type="text/javascript" src="../js/jquery.autocomplete-min.js"></script>
  <script type="text/javascript" src="../js/jquery.lightbox-0.5.min.js"></script>
  <script type="text/javascript" src="../js/jquery-ui-1.10.3.custom.min.js"></script>
  
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
  		theme : "advanced",  
      language : "es",
	  editor_deselector : "mceNoEditor",
	  theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom"
  	});
  </script>
  <!-- /TinyMCE -->   
  
  <!-- Activar lightboxes -->
  <script type="text/javascript">
    $(function() { 
      $('a.lightbox_link').lightBox(); 
    });
  </script> 
  
	<?php
	if (($_GET['page']=="paginas") || (isset($_GET['backpage']))){
		?>
		  <script>
		  $(function() {
			$( ".draggable" ).draggable({
				cursor:'pointer',
				revert:true,
				revertDuration: 0,
				addClasses: false
			});
			$( ".droppable" ).droppable({
				activeClass:"drop-active",
				hoverClass:"drop-hover",
				accept:".draggable",
				drop: function( event, ui ) {
					var thecomponent = ui.draggable.clone();
					thecomponent.appendTo($(this));
					thecomponent.css("position", "relative");
					thecomponent.css("left",0);
					thecomponent.css("top",0);
					thecomponent.removeClass("ui-draggable-dragging");
					thecomponent.removeClass("draggable");
					//thecomponent.append("<a class='deletelink' href='#'>Delete</a><a class='editlink' href='#'>Edit</a>");
					var href = thecomponent.find('a.editlink').prop("href");
					
					var component_id = thecomponent.find('span.component_id').html();
					var object_id = thecomponent.find('span.object_id').html();
					var component_type = thecomponent.find('span.component_type').html();
					var seccion_layout = $(this).find("span.section").html();
					var hidden_field = '<input type="hidden" name="components[]" value="' + component_id + "|" + object_id + "|" + component_type + "|" + seccion_layout + '" />';
					$("fieldset#page_components").append(hidden_field);
					
					thecomponent.find('a.editlink').prop("href", href + seccion_layout);
					thecomponent.find('a.deletelink').addClass("new");
					
					checklinks();
				}
			  }
			);
			$(".droppable").sortable();
		  });
		  
		  //Submit when layout changed
		  $(function() {
				$('#layout').change(function() {
					//$('input[type="submit"]').click();
					this.form.submit();
				});
			});
			
		  //Avoid editing or deleting components when the page is not saved
		  function checklinks() {
				$('.editlink').unbind('click');
				$('.deletelink').unbind('click');
				$('.editlink').click(function(e) {
					if ($('#id').val() == undefined){
						alert("Debe guardar la página antes de poder editar los componentes.");
						e.stopPropagation();
						e.preventDefault();
					}
				});
				$('.deletelink').click(function(e) {
					if($(this).hasClass('new')){
						e.stopPropagation();
						e.preventDefault();
						$(this).closest('div').remove();
						//remove the hidden field
					}
				});
			};
			
			$(document).ready(function() {
			  checklinks();
			  
			  var warnMessage = "Los cambios hechos a la Página no fueron guardados!";
				$('input:submit').click(function(e) {
					warnMessage = null;
				});
				$('#layout').change(function() {
					warnMessage = null;
				});
				$('input:not(:button,:submit),textarea,select').change(function () {
					window.onbeforeunload = function () {
						if (warnMessage != null) return warnMessage;
					}
				});

			});
			
		  </script>
		<?php
	}
	?>
</head>