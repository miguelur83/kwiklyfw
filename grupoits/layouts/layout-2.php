<?php
	//Layout 2: Columna a la izquierda
?>
	<div id="interno">
		<div id="main-container">
			<div id="header-container" style="">
				<?php
					foreach($componentes['top'] as $comp){
						echo $comp->getHTML();
					}
				?>
			</div>
			<div id="sidebar" style="float:left;">
				<?php
					foreach($componentes['left-column'] as $comp){
						echo $comp->getHTML();
					}
				?>
			</div>
			<div id="main-content" style="float:right;">
				<?php
					foreach($componentes['right-content'] as $comp){
						echo $comp->getHTML();
					}
				?>
			</div>
		</div>
	</div>