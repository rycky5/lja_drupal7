<?php
/**
 * Arquivo que conterá o template do bloco views_imagens_titulos_III
 * 
 * @author Weydson Fraga
 */ 
?>
<div class="wgd4 hgd8 boxNotList1">
  <ul>
    <?php
    foreach ($arrObjNodes as $key=>$node):
    $node->image_style = "multimidia_miniatura";
    $node = filtrarCampos($node);
    ?>
    <li class="wgd4 hgd2">
      <img width="73" height="55" alt="<?php print $node['titulo']; ?>" title="<?php print $node['titulo']; ?>" src="<?php echo $node['urlImg']; ?>" />
      <h1><a href="<?php echo $node['link'];?>"><?php print $node['titulo']; ?> </a></h1>
      <span class="video"><a href="<?php echo $node['linkChapeu'];?>"><?php echo $node['chapeu'];?></a></span>
    </li>  
    <?php endforeach; ?>
  </ul>
</div>