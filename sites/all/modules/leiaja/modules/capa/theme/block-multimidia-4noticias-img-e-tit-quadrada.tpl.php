<?php
/**
 * Arquivo que conterá o template do bloco views_imagens_com 4 noticias
 * 
 * @author Weydson Fraga
 */ 
?>

<div class="wgd4 hgd8 boxNotImgP">
 <ul>
   <?php foreach ($arrObjNodes as $key=>$node):
     //setando o image_style antes de entrar na função de tratamento
      $node->image_style = "multimidia_quadrada";
      $node = filtrarCampos($node);?>
   <li class="wgd2 hgd4">
      <img width="140" height="140" alt="<?php print $node['titulo']; ?>" title="<?php print $node['titulo']; ?>" src="<?php print $node['urlImg']; ?>" />
      <a href="<?php echo $node['link'];?>" style="display:none;"><span><?php print $node['titulo']; ?></span></a>
   </li>
     <?php endforeach; ?>  
 </ul>
</div>