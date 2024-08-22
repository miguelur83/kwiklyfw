<?php
	//Layout 1: Columna a la derecha
?>
	<div id="interno">
		<div id="main-container">
			<div id="header-container">
				<?php
					foreach($componentes['top'] as $comp){
						echo $comp->getHTML();
					}
				?>
			</div>
			<div id="main-content" style="">
				<?php
					foreach($componentes['left-content'] as $comp){
						echo $comp->getHTML();
					}
				?>
			</div>
			<div id="sidebar">
				<?php
					foreach($componentes['right-column'] as $comp){
						echo $comp->getHTML();
					}
				?>
			</div>
		</div>
	</div>