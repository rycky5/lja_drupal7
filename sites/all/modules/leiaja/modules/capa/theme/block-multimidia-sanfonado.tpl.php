<?php
/**
 * Arquivo que conterá o template do bloco views_imagens_com 6 noticias
 * 
 * @author Weydson Fraga
 */ 
?>

<div class="wgd4 hgd8 boxSanfonado">
 <ul>
    <?php foreach ($arrObjNodes as $key=>$node):
      $node = filtrarCampos($node);?>
   <li class="wgd4 hgd2">
     <h1><a href="<?php echo $node['link'];?>"><?php print $node['titulo']; ?> </a></h1>
     <p><a href="<?php echo $node['link']; if($key==0){echo 'class="firstLinkSanfonado"';}?>" style="display:none"><?php print retiraHash($node['conteudo']); ?> </a></p>
   </li>
       <?php endforeach; ?>  
 </ul>
</div>