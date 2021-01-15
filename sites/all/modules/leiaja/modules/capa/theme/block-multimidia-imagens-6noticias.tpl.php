<?php
/**
 * Arquivo que conterá o template do bloco views_imagens_com 6 noticias
 * 
 * @author Weydson Fraga
 */ 
?>
<div class="wgd12 hgd12 boxNotListHor">
  <ul>
    <?php foreach ($arrObjNodes as $key=>$node):
      $node->image_style = "thumbnail";
      $node = filtrarCampos($node);?>
      <li class="wgd4 hgd3">
        <h1 class="video"><a href="<?php echo $node['linkChapeu'];?>"><?php echo $node['chapeu'];?></a></h1>
        <a href="<?php echo $node['link'];?>"><img width="100" height="77" alt="<?php print $node['titulo']; ?>" title="<?php print $node['titulo']; ?>" src="<?php echo $node['urlImg']; ?>" /></a>
        <p><a href="<?php echo $node['link'];?>"><?php print $node['titulo']; ?> </a></p>
      </li>    
    <?php endforeach; ?>  
  </ul>
</div> 