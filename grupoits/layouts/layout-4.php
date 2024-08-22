<?php
	//Layout 4: Home
?>
		<div id="marquesina-container">
			<?php
				foreach($componentes['top'] as $comp){
					echo $comp->getHTML();
				}
			?>
		</div>
	</div>
	<div id="middle2">
		<div id="tabs-container">
			<div id="twitter-stream">
				<a class="twitter-timeline" href="https://twitter.com/ITSGrupo" data-widget-id="319895607315664896">Tweets por @ITSGrupo</a>
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
			</div>
			<?php
				foreach($componentes['right-column'] as $comp){
					echo $comp->getHTML();
				}
			?>
		</div>
	</div>
	<div id="middle3">
		<div id="banners">
			<?php
				foreach($componentes['one-column'] as $comp){
					echo $comp->getHTML();
				}
			?>
		</div>
	</div>