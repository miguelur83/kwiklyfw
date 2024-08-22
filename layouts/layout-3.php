<?php
	//Layout 3: Una Columna
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
			<div id="main-content" style="width:980px;">
				<?php
					foreach($componentes['one-column'] as $comp){
						echo $comp->getHTML();
					}
				?>
				<p>&nbsp;</p>
			</div>
		</div>
	</div>