	<div id="middle1">
		<div id="nav">
			<?php
				print_menues();
			?>
			<!--
			<ul>
				<li <?= (($_GET['page']=='home')?'class="active"':'') ?>>
					<a href="index.php">Home</a>
				</li>
				<li <?= (($_GET['page']=='quienes-somos')?'class="active"':'') ?>>
					<a href="quienes-somos.php">Quienes Somos</a>
				</li>
				<li <?= (($_GET['page']=='soluciones')?'class="active"':'') ?>>
					<a href="#">Soluciones</a>
					<ul>
						<li><a href="soluciones-seguridad.php">Seguridad</a></li>
						<li><a href="soluciones-infraestructura.php">Infraestructura</a></li>
					</ul>
				</li>
				<li <?= (($_GET['page']=='alianzas')?'class="active"':'') ?>><a href="alianzas.php">Alianzas</a></li>
				<li <?= (($_GET['page']=='clientes')?'class="active"':'') ?>><a href="clientes.php">Clientes</a></li>
				<!--<li><a href="#">Eventos</a></li>-->
				<!--<li <?= (($_GET['page']=='registrate')?'class="active"':'') ?>><a href="registrate.php">Registrate</a></li>
				<li <?= (($_GET['page']=='contacto')?'class="active last"':'class="last"') ?>><a href="contacto.php">Contacto</a></li>
			</ul>
			-->
		</div>
<?php
	function print_menues($parent = 0, $menu_type='nav'){
		$menu = new Menu();
		$cond = "menu_padre = ".$parent;
		switch ($menu_type){
			case 'nav':
				$cond .= " AND mostrar_en_nav = 1";
			break;
			case 'footer':
				$cond .= " AND mostrar_en_footer = 1";
			break;
		}
		$menues = $menu->getAll('orden', 0, $cond);
		if(count($menues) > 0){
			echo "<ul".((($menu_type == 'footer')&&($parent == 0))?' class="menu-footer"':'').">";
			$last = false;
			foreach($menues as $key => $menu_array){
				$class = '';
				if (($_GET['page']==$menu_array['URL'])&&($menu_array['URL']!='')){ $class .= "active "; }
				if ((($key + 1) == count($menues)) && ($parent == 0)){ $class .= "last"; }
				echo
					"<li ".(($class != '')?'class="'.$class.'"':'').">
						<a href='".(($menu_array['URL']!='')?'pagina.php?page='.$menu_array['URL']:'#')."'>".$menu_array['nombre']."</a>";
					print_menues($menu_array['id']);
				echo "</li>";
			}
			echo "</ul>";
		}
	}
?>