<?php include ("kwikly_bootstrap.php"); 

	if(isset($_GET['page'])){
		$page = new Pagina();
		$page = $page->getAll("",0,"friendly_url='".$_GET['page']."'");
		$page = new Pagina($page[0]['id']);
	}
?>
<!DOCTYPE HTML>
<head>
  <meta charset="utf-8">
  <title><?php if(isset($page)){echo $page->getField('titulo')." - ";}?>Grupo ITS</title>
  <meta name="description" content="Grupo ITS">
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/styles.css">
  <!--[if lt IE 9]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
  
  <script type="text/javascript" src="js/jquery-1.6.4.min.js"></script>
  
  <!-- Slide destacado -->                                      
  <script src="js/jquery.cycle.all.min.js" type="text/javascript"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('div#marquesina').after('<div id="paging" class="paging">').cycle({
    		fx: 'scrollRight', // choose your transition type, ex: fade, scrollUp, shuffle, etc...    
        pager:  '#paging',
        timeout: 7000,
        before: function() { if (window.console) console.log(this.src); }
    	});
    });
  </script>
  
  
  <!-- Custom font with cufon 
	<script src="js/cufon-yui.js" type="text/javascript"></script>
	<script src="js/nutritionraw_700.font.js" type="text/javascript"></script>
	<script src="js/Franklin_Gothic_Heavy_400.font.js" type="text/javascript"></script>
	<script src="js/Helvetica_Neue_LT_Pro_250.font.js" type="text/javascript"></script>
	<script type="text/javascript">
		// Cufon.replace('h1'); // Works without a selector engine
		Cufon.replace('#maintitle', { fontFamily: 'NUTRITIONRAW' });
		Cufon.replace('.helvetica', { fontFamily: 'Helvetica Neue LT Pro' });
		Cufon.replace('.franklin', { fontFamily: 'Franklin Gothic Heavy' });
	</script>
	-->
	
	<?php if ($_GET['page']=='contacto') { ?>
		<script src="js/gen_validatorv4.js" type="text/javascript"></script>		
	<? } ?>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#tab-titles li a').click(function(e) {
				e.stopPropagation();
				e.preventDefault();
				var page = $(this).attr("href");
				$('#tabs .tab-content').css('display','none');
				$('#'+page).css('display','block');
				$('#tab-titles li.active').removeClass('active');
				$(this).parent().addClass('active');
			});
		});
	</script>
</head>
<body>
	<div id="top">
		<div id="header">
			<div id="logo">Grupo ITS - 10 a&ntilde;os haci&eacute;ndonos compa&ntilde;&iacute;a</div>
			<div id="sociallinks">
				<div id="twitter">
					<a href="https://twitter.com/ITSGrupo" class="twitter-follow-button" data-show-count="false" data-lang="es" data-size="large" data-show-screen-name="false">Seguir a @ITSGrupo</a>
					<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
				</div>
				<div id="facebook">
					<script src="//platform.linkedin.com/in.js" type="text/javascript"></script>
					<script type="IN/FollowCompany" data-id="2076989" data-counter="right"></script>
				</div>
			</div>
		</div>
	</div>