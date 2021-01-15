<?php
/**
 * Arquivo que conterá o template do bloco views_imagens_destaque_II
 * 
 * @author Weydson Fraga
 */ 
?>

<?php

foreach ($arrObjNodes as $key=>$node):
    $node->image_style = "multimidia_img_ii";
    $node = filtrarCampos($node);
    ?>
<!-- box - Bloco Multimidia Imagens Destaque II -->
    <div class="wgd4 hgd8 boxPimg1">
      <?php if($node['chapeu']):?>
        <div class="wgd4 hgd1">
          <h1 class="titulo video">
            <a href="<?php echo $node['linkChapeu'];?>">
              <?php echo $node['chapeu'];?>
            </a>
          </h1>
        </div>
      <?php endif;?>
      <div class="wgd4 hgd6"><a href="<?php echo $node['link']; ?>">
          <img width="300" height="220" alt="<?php print $node['titulo']; ?>" title="<?php print $node['titulo']; ?>" src="<?php echo $node['urlImg']; ?>" />
        </a>
      </div>
      <div class="wgd4 hgd2"><p><a href="<?php echo $node['link'];?>"><?php print $node['titulo']; ?> </a></p></div>
    </div>
<!-- /box -->

<?php endforeach; ?>