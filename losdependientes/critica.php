<?php       
  $opengraph['tipo'] = 'critica';
  $opengraph['id'] = $_GET['critica_id'];
  
  include ("inc/head.php");
  $GLOBALS['interna'] = true;
  include ("inc/header.php");
    
  $critica = null;
  $pelicula = null;
  if (isset($_GET['critica_id'])){
    $critica = new Critica($_GET['critica_id']);
    $pelicula = $critica->getObject('pelicula');
    
    //Sumar popularidad
    $critica->setField('popularidad', $critica->getField('popularidad') + 1);
    $critica->save();
  } else {
    die();
  }
?>
    <div id="centro" class="critica_interna">
      <div id="izquierda">
        <div id="pestanas">
          <a href="#" class="critica"><?=($critica->getField('tipo')==0?"Cr&iacute;tica":"Rese&ntilde;a")?></a>
          <a href="#" class="ficha">Ficha</a>
            <?php
                if (strlen($pelicula->getField('youtube_ID')) == 11){
                    echo '<a href="#" class="trailer">Trailer</a>';
                }
            ?>
            <?php
                if (($critica->getField('foto_1')) || ($critica->getField('foto_2')) || ($critica->getField('foto_3'))) {
                    echo '<a href="#" class="fotos">Fotos</a>';
                }
            ?>
        </div>
        <h1 class="titulo_pelicula"><?php echo $pelicula->getField('titulo')." (".$pelicula->getField('anio').")"; ?></h1>
        <div class="critica">
          <p class="calificacion">Calificaci&oacute;n / <?= $critica->getField('calificacion');?></p>
          <?= $critica->getField('contenido');?>
        </div>
        <div class="ficha">
            <?php
                $afiche = '';
                if ($pelicula->getField('afiche') != ''){
                    $afiche = "uploads/afiche_pelicula/home/".$pelicula->getField('afiche');
                } else {
                    $afiche = "img/no_disponible_grande.jpg";
                }
            ?>
          <img src="<?= $afiche; ?>" class="afiche_pelicula" alt="<?php echo $pelicula->getField('titulo');?>" />
          <div class="info_ficha">
            <h2>T&iacute;tulo:</h2>
            <p><?= $pelicula->getField('titulo');?></p>
            <h2>Reparto:</h2>
            <p><?= $pelicula->getElencoString();?></p>
            <h2>Director:</h2>
            <p><?= $pelicula->getObject('director')->toString();?></p>
            <!--<h2>Gui&oacute;n:</h2>
            <p>Renaissance Pictures</p>-->
            <h2>G&eacute;nero:</h2>
            <p><?= $pelicula->getObject('genero')->toString();?></p>
            <!--<h2>Duraci&oacute;n:</h2>
            <p>85 min</p>-->
            <h2>A&ntilde;o:</h2>
            <p><?= $pelicula->getField('anio');?></p>
            <?php if ($critica->getObject('evento')->getField('nombre') != ''){ ?>
            <h2>Evento:</h2>
            <p><?= $critica->getObject('evento')->getField('nombre');?></p>
            <?php } ?>
            <!--<h2>Sinopsis:</h2>
            <p>El bueno de Ash se dispone a pasar un fin de semana en el bosque 
            con su novia. Pero todo se va al traste cuando repoducen una cinta 
            en la que un profesor hab&iacute;a grabado varios pasajes del 
            Necronomicom, el Libro de los Muertos. El hechizo convoca a una 
            fuerza demoniaca que convierte a la compa&ntilde;era de Ash en un 
            monstruo &aacute;vido de carne. Ahora &eacute;l y varios 
            compa&ntilde;eros se disponen a pasar una noche en una caba&ntilde;a 
            en medio del bosque, con un demonio en casa.</p>-->
          </div>
        </div>
        <div class="trailer">
          <iframe width="640" height="360" src="http://www.youtube.com/embed/<?= $pelicula->getField('youtube_ID');?>" frameborder="0" allowfullscreen anotations='0'></iframe>
        </div>
        <div class="fotos">
            <?php if($critica->getField('foto_1')!=''){?>
                <a href="uploads/fotos_criticas/full/<?= $critica->getField('foto_1') ?>"><img src="uploads/fotos_criticas/thumb/<?= $critica->getField('foto_1') ?>" alt="foto peli" /></a>
            <?php } ?>
            <?php if($critica->getField('foto_2')!=''){?>
                <a href="uploads/fotos_criticas/full/<?= $critica->getField('foto_2') ?>"><img src="uploads/fotos_criticas/thumb/<?= $critica->getField('foto_2') ?>" alt="foto peli" /></a>
            <?php } ?>
            <?php if($critica->getField('foto_3')!=''){?>
                <a href="uploads/fotos_criticas/full/<?= $critica->getField('foto_3') ?>"><img src="uploads/fotos_criticas/thumb/<?= $critica->getField('foto_3') ?>" alt="foto peli" /></a>
            <?php } ?>
        </div>
        <div style="margin-top:60px;" class="fb-comments" data-href="<?=$site_root?>critica.php?critica_id=<?=$critica->getField('id')?>" data-num-posts="10" data-width="756" data-colorscheme="dark"></div>
      </div>
      <div id="banners">
      	<div style="margin-bottom:20px;" class="fb-like" data-href="<?=$site_root?>critica.php?critica_id=<?=$critica->getField('id')?>" data-send="false" data-layout="box_count" data-width="200" data-show-faces="true" data-colorscheme="dark"></div>
        <?php include("inc/banners.php"); ?> 
      </div>
    </div>
  </div>
<?php
  include("inc/footer.php");
?>